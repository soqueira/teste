<?php
  //conexao
  require_once 'db_connect.php';
  //sessao
  session_start();

  if(isset($_POST['btn-login'])):
    $erros = array();
    $email = mysqli_escape_string($connect, $_POST['email']);
    $senha = mysqli_escape_string($connect, $_POST['senha']);

    if(empty($email) or empty($senha)):
      $erros[] = "<p class='alerta_campos'> o campo login e senha precisa ser preenchido</p>";
    else:
      $sql = "SELECT email FROM usuarios WHERE email = '$email'";
      $resultado = mysqli_query($connect, $sql);

        if(mysqli_num_rows($resultado) > 0):
          $senha = base64_encode($senha);
          $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
          $resultado = mysqli_query($connect, $sql);
            if(mysqli_num_rows($resultado) == 1):
              $dados = mysqli_fetch_array($resultado);
              mysqli_close($connect);
              $_SESSION['logado'] = true;
              $_SESSION['id_usuario'] = $dados['id'];
              header('Location: home.php');
            else:
              $erros[] = "<p class='alerta_campos'>Dados incorretos</p>";
            endif;
        else:
          $erros[] = "<p class='alerta_campos'>O usuario não existe</p>";
        endif;

    endif;

  endif;
  if(isset($_SESSION['logado'])):
    header('location: home.php');
  endif;
  ?>
<!DOCTYPE html>
<html lang="pt" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>

<body>
    <div class="slide">
        <p class="p_tecla wow fadeInRight"><i class="far fa-keyboard"></i></p>
        <div class="time wow fadeInLeft" data-wow-delay=".8s">
            <span class="hours"></span>
            <span class="colon">:</span>
            <span class="minutes"></span>
            <span class="colon">:</span>
            <span class="seconds"></span>
        </div>
        <div class="date wow fadeInLeft" data-wow-delay=".8s">
            <span class="month"></span>
            <span class="day"></span>,
            <span class="year"></span>
        </div>
    </div>
    <?php
      if(!empty($erros)):
        foreach($erros as $erro):
          echo $erro;
        endforeach;
      endif;
    ?>
    <div class="container">
        <i class="fas fa-user-circle"></i>
        <p>Login</p>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="text" name="email" value="" placeholder="Insira seu Email">
            <input type="password" name="senha" value="" id="senha" placeholder="Insira sua Senha">
            <button type="submit" class="btn-login" name="btn-login">Fazer login</button>
            <a id="mostrar-senha" href="#" onclick="mostrarSenha()"><i class="fas fa-eye"></i></a>
            <a class="cadastro" href="cadastro.php">Fazer cadastro</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="js/hora.js"></script>
    <!-- Inicia wow.js e animate.css -->
    <script src="js/wow.js"></script>
    <script>
    new WOW().init();
    </script>
    <script>
    function mostrarSenha() {
        var tipo = document.getElementById('senha');
        if (tipo.type == "password") {
            tipo.type = "text";
        } else {
            tipo.type = "password";
        }
    }
    </script>
    <script>
    $(document).keyup(function(event) {
        if (event.keyCode === 13) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 65) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 66) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 67) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 68) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 69) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 70) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 71) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 72) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 73) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 74) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 75) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 76) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 77) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 78) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 79) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 80) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 81) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 82) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 83) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 84) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 85) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 86) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 87) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 88) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 89) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 90) {
            $('.slide').fadeOut('300');
        } else if (event.keyCode === 32) {
            $('.slide').fadeOut('300');
        } else if(event.keycode === 9){
            $('.slide').fadeOut('300');
        }
    });
    </script>
</body>

</html>
