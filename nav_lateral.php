<link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

<div class="menu-hide">
  <button type="button"><i class="menu-tab fas fa-arrow-right"></i></a></button>
  <div class="img_userB">
    <?php
    echo "<img class='img_user' src='fotos_sql/".$dados['foto']."'>";
     ?>
  </div>

   <div class="nome_user">
     <?php echo "<p>".$dados['nome']."</p>"; ?>
   </div>
   <div class="nav_user">
     <a href="logout.php">Sair</a>
     <a href="#">Lorem ipsum</a>

     <a href="informacoes.php">Editar perfil</a>
     <a href="perfil.php">Perfil</a>
     <a href="home.php">Inicio</a>

   </div>

</div>
