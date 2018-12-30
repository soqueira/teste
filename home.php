<?php
  require_once 'db_connect.php';

//inicia a sessao
  session_start();
  //dados
  $id = $_SESSION['id_usuario'];
  $sql = "SELECT * FROM usuarios WHERE id = '$id'";
  $resultado = mysqli_query($connect, $sql);
  $dados = mysqli_fetch_array($resultado);

  //verificação se está logado
  if(!isset($_SESSION['logado'])):
    header('location: index.php');
  endif;
mysqli_close($connect);
 ?>

<!DOCTYPE html>
<html lang="pt" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Home</title>
</head>
<body>

    <?php include 'nav_lateral.php' ?>



    <!-- scripts -->
    <?php include 'javascriptNav.php' ?>

</body>

</html>
