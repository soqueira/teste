<!DOCTYPE html>
<html lang="pt" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
    <style>
    </style>
</head>

<body>
    <?php require_once 'db_connect.php'; ?>
    <form action="cadastrar.php" method="POST" enctype="multipart/form-data">
        nome<br>
        <input type="text" name="nome" required>
        <br>
        email
        <span>Email já cadastrado!</span>
        <br>
        <input type="email" name="email" required>
        <br>
        Senha<br>
        <input type="password" name="senha" required>
        <br>
        <br><input type="submit" name="btn-login" value="Cadastrar" class="but_comando">
    </form>
</body>

</html>
