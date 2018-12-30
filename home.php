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
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>
<body>

  <div class="menu-hide">
    <button type="button"><i class="menu-tab fas fa-arrow-right"></i></a></button>
    <?php echo "<img class='img_user' src='fotos_sql/".$dados['foto']."'>";
     ?>
     <div class="nome_user">
       <?php echo "<p>".$dados['nome']."</p>"; ?>
     </div>
     <div class="nav_user">
       <a href="logout.php">Sair</a>
       <a href="#">Lorem ipsum</a>
       <a href="#">Lorem ipsum</a>
       <a href="informacoes.php">Editar perfil</a>
       <a href="perfil.php">Perfil</a>

     </div>

  </div>


      <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
      <script type="text/javascript">

      $(document).ready(function(){
        $('.menu-tab').click(function(){
          $('.menu-hide').toggleClass('show');
          $('.menu-tab').toggleClass('active');
        });
      });

      </script>
</body>

</html>
