<?php
  require_once 'db_connect.php';
  session_start();

  $id = $_SESSION['id_usuario'];
  $sql = "SELECT * FROM usuarios WHERE id = '$id'";
  $resultado = mysqli_query($connect, $sql);
  $dados = mysqli_fetch_array($resultado);

  //verificação se está logado
  if(!isset($_SESSION['logado'])):
    header('location: index.php');
  endif;

  if(isset($_POST['enviar_det'])):

  $ano_nascimento = $_POST['ano_nasc'];



  if (!$connect) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql = "UPDATE usuarios SET ano_nasc='$ano_nascimento' WHERE id='$id'";
if (mysqli_query($connect, $sql)) {
  echo "Informações adicionadas com sucesso!";
  header('location: informacoes.php');
} else {
  echo "Erro ao guardar informações: " . mysqli_error($connect);
}
endif;


mysqli_close($connect);
 ?>

 <!DOCTYPE html>
 <html lang="pt" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Informações</title>
   </head>
   <body>
     <form class="" action="informacoes.php" method="POST">
       <input type="date" name="ano_nasc" value="" placeholder="digite o ano em que voce nasceu">
       <button type="submit" name="enviar_det">Atualizar informações</button>
     </form>
     <?php
     //converte a data de nascimento do usuario para padrao PT-BR
      $data = date('d/m/Y', strtotime($dados['ano_nasc']));
      echo $data;
      echo "<br>";

      //mostra a sua idade
      $mes = date("m");
      $ano = date("Y");
      $dia = date("d");

      $data_1  = $data;
      $teste = explode("/", $data_1);
      $dia1  = $teste[0];
      $mes1  = $teste[1];
      $ano1  = $teste[2];

      $anob = $ano - $ano1 ;
      $mesb = $mes - $mes1 ;
      $diab = $dia - $dia1 ;
      echo "você TEM: ".$anob. " ANOS, ".$mesb." MESES E ".$diab." DIAS" ;
      ?>
   </body>
 </html>
