<?php
  require_once 'db_connect.php';
  session_start();

  $id = $_SESSION['id_usuario'];
  $sql = "SELECT * FROM usuarios WHERE id = '$id'";
  $resultado = mysqli_query($connect, $sql);
  $dados = mysqli_fetch_array($resultado);

  //verificação se está logado
  if(!isset($_SESSION['logado'])){
    header('location: index.php');
  }
  // if(isset($_POST['enviar_foto'])){
  //   $sql = mysqli_query($connect, "DELETE FROM usuarios WHERE 'fotos'.'id'='$id'");
  // }


  if(isset($_POST['enviar_foto'])){
    unlink('fotos_sql/'.$dados['foto']);
    $foto = $_FILES['foto'];

        // Largura máxima em pixels
        $largura = 1920;
        // Altura máxima em pixels
        $altura = 1080;
        // Tamanho máximo do arquivo em bytes
        $tamanho = 1000000;

        $error = array();

          // Verifica se o arquivo é uma imagem
          if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
             $error[1] = "Isso não é uma imagem.";
          }

        // Pega as dimensões da imagem
        $dimensoes = getimagesize($foto["tmp_name"]);

        // Verifica se a largura da imagem é maior que a largura permitida
        if($dimensoes[0] > $largura) {
          $error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
        }

        // Verifica se a altura da imagem é maior que a altura permitida
        if($dimensoes[1] > $altura) {
          $error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
        }

        // Verifica se o tamanho da imagem é maior que o tamanho permitido
        if($foto["size"] > $tamanho) {
            $error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
        }
        // Se não houver nenhum erro
        if (count($error) == 0) {

          // Pega extensão da imagem
          preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

              // Gera um nome único para a imagem
              $nome_imagem = md5(uniqid(time())) . "." . $ext[1];

              // Caminho de onde ficará a imagem
              $caminho_imagem = "fotos_sql/" . $nome_imagem;

          // Faz o upload da imagem para seu respectivo caminho
          move_uploaded_file($foto["tmp_name"], $caminho_imagem);


          $sql = "UPDATE usuarios SET foto = '$nome_imagem' WHERE id = '$id'";
          // Se os dados forem inseridos com sucesso
          if (mysqli_query($connect, $sql)) {
            echo "Informações adicionadas com sucesso!";
            header('location: perfil.php');
          }else{
            echo "erro";
          }
        }

}




  mysqli_close($connect);
 ?>
















































 <!DOCTYPE html>
 <html lang="pt" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title><?php echo $dados['nome']; ?></title>
     <link rel="stylesheet" href="css/perfil.css">
   </head>
   <body>
     <?php include 'nav_lateral.php' ?>

     <div class="capa_user bgParallax" data-speed="4" style="background:url('fotos_sql/<?php echo $dados['foto']; ?>');background-size: cover;background-attachment: fixed;background-repeat: repeat;background-position: 50% 0;">

     </div>
     <form class="" action="perfil.php" method="POST" enctype="multipart/form-data">

     <div class="row">
  <div class="small-12 large-4 columns">
    <div class="containers">
      <div class="imageWrapper">
        <img class="image" src="fotos_sql/<?php echo $dados['foto'] ?>">
        <button class="file-upload_1">
          <input type="file" name="foto" class="file-input"><i class="fas fa-camera"></i>
        </button>
      </div>
    </div>
  </div>
</div>
  <button type="submit" class="btn_alteracao" name="enviar_foto">Fazer alteração</button>
</form>
  <!-- <div class="small-12 large-4 columns">
    <div class="containers">
      <div class="imageWrapper">
        <img class="image" src="http://orig09.deviantart.net/2a38/f/2012/272/8/1/swamp_dragon_by_schur-d5g96rw.jpg">
      </div>
    </div>
    <button class="file-upload">
      <input type="file" class="file-input"><i class="fas fa-camera"></i>
    </button>
  </div> -->
</div>

     <!-- <?php
     // echo date('d/m/Y', strtotime($dados['ano_nasc']));
      ?> -->

      <!-- scripts -->
      <?php include 'javascriptNav.php' ?>
      <script>
        $('.bgParallax').each(function(){
      var $obj = $(this);

      $(window).scroll(function() {
          var yPos = -($(window).scrollTop() / $obj.data('speed'));

          var bgpos = '50% '+ yPos + 'px';

          $obj.css('background-position', bgpos );

      });
  });
      </script>
      <script>
      $('.file-input').change(function(){
          var curElement = $(this).parent().parent().find('.image');
          console.log(curElement);
          var reader = new FileReader();

          reader.onload = function (e) {
              // obtem dados carregados e renderizar miniaturas.
              curElement.attr('src', e.target.result);
          };

          //lê o arquivo de imagem como um URL de dados.
          reader.readAsDataURL(this.files[0]);
      });
      </script>

      <script>
        $('.file-upload_1').click(function(){
          $('.btn_alteracao').css({"opacity": "1", "visibility": "visible"});
        });
      </script>
   </body>
 </html>
