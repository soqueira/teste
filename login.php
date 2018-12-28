
<?php
//login secundario
//depois do cadastro será redirecionado para essa pagina
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
            <button type="submit" class="btn-login" name="btn-login">entrar</button>
            <a id="mostrar-senha" href="#" onclick="mostrarSenha()"><i class="fas fa-eye"></i></a>
            <a class="cadastro" href="cadastro.php">Fazer cadastro</a>
        </form>
    </div>
</body>

</html>
