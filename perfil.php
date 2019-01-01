<?php
 require_once 'db_connect.php';
 session_start();
 $id = $_SESSION['id_usuario'];
 $sql = "SELECT * FROM usuarios WHERE id = '$id'";
 $resultado = mysqli_query($connect, $sql);
 $dados = mysqli_fetch_array($resultado);
 // verificação se está logado
 if (!isset($_SESSION['logado'])) {
   header('location: index.php');
 }
 if (isset($_POST['enviar_foto'])) {
   if (isset($_FILES['foto'])) {
     $foto = $_FILES['foto'];
     // Verifica se o arquivo é uma imagem
     if (preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])) {
       // Pega as dimensões da imagem
       $dimensoes = getimagesize($foto["tmp_name"]);
       // Se a imagem for selecionada
       if (!empty($dimensoes)) {
         unlink('fotos_sql/' . $dados['foto']);
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
           header('location: perfil.php');
         }
         else {
           echo "Erro ao inserir imagem";
         }
       }
       else {
         echo "<p class='warning'>Erro ao selecionar imagem</p>";
       }
     }
     else {
       echo "<p class='warning'>insira uma imagem</p>";
     }
   }
 }
?>
<?php
  // Trocar capa
  if (isset($_POST['btn_alteracao_2'])) {
    if (isset($_FILES['foto_capa'])) {
      $foto = $_FILES['foto_capa'];
      // Verifica se o arquivo é uma imagem
      if (preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])) {
        // Pega as dimensões da imagem
        $dimensoes = getimagesize($foto["tmp_name"]);
        // Se a imagem for selecionada
        if (!empty($dimensoes)) {
          unlink('fotos_sql/' . $dados['foto_capa']);
          // Pega extensão da imagem
          preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
          // Gera um nome único para a imagem
          $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
          // Caminho de onde ficará a imagem
          $caminho_imagem = "fotos_sql/" . $nome_imagem;
          // Faz o upload da imagem para seu respectivo caminho
          move_uploaded_file($foto["tmp_name"], $caminho_imagem);
          $sql = "UPDATE usuarios SET foto_capa = '$nome_imagem' WHERE id = '$id'";
          // Se os dados forem inseridos com sucesso
          if (mysqli_query($connect, $sql)) {
            header('location: perfil.php');
          }
          else {
            echo "Erro ao inserir imagem";
          }
        }
        else {
          echo "<p class='warning'>Erro ao selecionar imagem</p>";
        }
      }
      else {
         echo "<p class='warning'>Selecione uma imagem</p>";
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

     <div class="capa_user">
       <form action="perfil.php" method="POST" enctype="multipart/form-data">
       <div class="containers_1">
         <div class="imageWrapper_1">
           <img class="image" src="fotos_sql/<?php echo $dados['foto_capa']; ?>">
         </div>
       </div>
       <button class="file-upload_2">
         <input type="file" name="foto_capa" class="file-input"><i class="fas fa-camera"></i>
       </button>
     </div>
     <button type="submit" class="btn_alteracao_2" name="btn_alteracao_2">Alterar capa</button>
   </form>
     <form class="" action="perfil.php" method="POST" enctype="multipart/form-data">

     <div class="row">
  <div class="small-12 large-4 columns">
    <div class="containers">
      <div class="imageWrapper">
        <img class="image" src="fotos_sql/<?php echo $dados['foto']; ?>">
        <button class="file-upload_1">
          <input type="file" name="foto" class="file-input"><i class="fas fa-camera"></i>
        </button>
      </div>
    </div>
  </div>
</div>
  <button type="submit" class="btn_alteracao" name="enviar_foto">Alterar foto</button>

</form>

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
          $('.file-upload_2').css({"opacity": "0", "visibility": "hidden"});
        });
        $('.file-upload_2').click(function(){
          $('.btn_alteracao_2').css({"opacity": "1", "visibility": "visible"});
          $('.file-upload_1').css({"opacity": "0", "visibility": "hidden"});

        });
      </script>
   </body>
 </html>
