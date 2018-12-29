<?php
// Conexão com o banco de dados
$serverName = "localhost";
$userName = "root";
$password = "";
$db_name = "test";

$connect = mysqli_connect($serverName, $userName, $password, $db_name);

if(mysqli_connect_error()):
	echo "falha ao conectar no banco de dados ".mysqli_connect_error();
endif;
// Se o usuário clicou no botão cadastrar efetua as ações
if (isset($_POST['cadastrar'])) {

	// Recupera os dados dos campos
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	$senha_cript = base64_encode($senha);
	$foto = $_FILES["foto"];
	if(empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['senha'])):
		echo "<p class='alerta_campos'>Preencha os campos e clique em proximo</p>";
	else:
	// Se a foto estiver sido selecionada
	if (!empty($foto["name"])) {

		// Largura máxima em pixels
		$largura = 1920;
		// Altura máxima em pixels
		$altura = 1080;
		// Tamanho máximo do arquivo em bytes
		$tamanho = 1000000;

		$error = array();

    	// Verifica se o arquivo é uma imagem
    	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
     	   $error[1] = "Isso não é uma imagem.";
   	 	}

		// Pega as dimensões da imagem
		$dimensoes = getimagesize($foto["tmp_name"]);

		// Verifica se a largura da imagem é maior que a largura permitida
		if($dimensoes[0] > $largura) {
			$error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
		}

		// Verifica se a altura da imagem é maior que a altura permitida
		if($dimensoes[1] > $altura) {
			$error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
		}

		// Verifica se o tamanho da imagem é maior que o tamanho permitido
		if($foto["size"] > $tamanho) {
   		 	$error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
		}

		// não deixa email repetir

		$q = "SELECT * FROM usuarios WHERE email='$email'";

		//executa a query
		$r = mysqli_query($connect, $q);

		// exibe erro se o email já estiver cadastrado
		if(mysqli_num_rows($r) >= 1):
			echo "<p class='alerta_campos'>esse email já esta em uso</p>";
		else:

		// Se não houver nenhum erro
		if (count($error) == 0) {

			// Pega extensão da imagem
			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

        	// Gera um nome único para a imagem
        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];

        	// Caminho de onde ficará a imagem
        	$caminho_imagem = "fotos_sql/" . $nome_imagem;

			// Faz o upload da imagem para seu respectivo caminho
			move_uploaded_file($foto["tmp_name"], $caminho_imagem);

			// Insere os dados no banco
			$sql = mysqli_query($connect,"INSERT INTO usuarios VALUES ('', '".$nome."', '".$email."', '".$nome_imagem."', '".$senha_cript."','')");

			// Se os dados forem inseridos com sucesso
			if ($sql){
				header('location: login.php');
			}
		}
	endif;
		// Se houver mensagens de erro, exibe-as
		if (count($error) != 0) {
			foreach ($error as $erro) {
				echo '<p class="alerta_campos">'.$erro.'</p>';
			}
		}
	}else{
		echo "<p class='alerta_campos'>Coloque uma foto de perfil</p>";
	}
endif;
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>cadastro</title>
    <!-- <link rel="stylesheet" href="css/main.css"> -->
    <link rel="stylesheet" href="css/cadastro.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>

<body>
    <div class="container">
        <i class="fas fa-user-circle"></i>
        <p>Cadastro</p>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="cadastro">
            <input type="text" name="nome" placeholder="Insira seu nome">
            <input type="email" name="email" placeholder="Insira Seu email">
            <input type="password" class="myPass" name="senha" value="" id="senha" placeholder="Insira sua Senha">
            <!-- mostrar password -->
            <span id="showPass" class="showPassC">
							<i class="far fa-eye-slash" aria-hidden="true"></i>
					<i class="far fa-eye" aria-hidden="true" style="display:none;"></i>
					</span>
            <button type="button" class="btn-cadastro" name="button"><i class="fas fa-arrow-right"></i></button>
						<a href="login.php" class="f_log">Fazer login</a>
            <div class="proxima-etapa">
							<button type="button" name="button" class="back_div"><i class="fas fa-arrow-left"></i></button>
                <button type="submit" class="btn-login btn-cadastro2 " name="cadastrar">Fazer cadastro</button>
                <div class="file-upload">
                    <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
                    <div class="image-upload-wrap">
                        <input class="file-upload-input" type='file' name="foto" onchange="readURL(this);" accept="image/*" />
                        <div class="drag-text">
                            <h3>Drag and drop a file or select add Image</h3>
                        </div>
                    </div>
                    <div class="file-upload-content">
                        <img class="file-upload-image" src="#" alt="your image" />
                        <div class="image-title-wrap">
                            <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="js/mostrarSenha.js"></script>
    <script src="js/uploadImage.js"></script>
    <script type="text/javascript">
    $('.btn-cadastro').click(function() {
        $('.proxima-etapa').animate({
            left: '50%'
        }, 1000);
    });
		$('.back_div').click(function(){
			$('.proxima-etapa').animate({
				left: '155%'
			}, 1000);
		});
    </script>
</body>

</html>
