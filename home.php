<?php
  require_once 'db_connect.php';

//inicia a sessao
  session_start();
  //dados
  $id = $_SESSION['id_usuario'];
  $sql = "SELECT * FROM usuarios WHERE id = '$id'";
  $resultado = mysqli_query($connect, $sql);
  $dados = mysqli_fetch_array($resultado);
  mysqli_close($connect);

  //verificação
  if(!isset($_SESSION['logado'])):
    header('location: index.php');
  endif;
?>
<!DOCTYPE html>
<html lang="pt" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>pagina restrita</title>
</head>

<body>
    <?php
    //pega os dados do sql
      echo "Olá ". $dados['nome'];
      echo "<img src='fotos/".$dados['foto']."'>";
    ?>
    <a href="logout.php">Sair</a>
</body>

</html>
