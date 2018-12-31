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
