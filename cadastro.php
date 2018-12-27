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
	$foto = $_FILES["foto"];

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

		// Se não houver nenhum erro
		if (count($error) == 0) {

			// Pega extensão da imagem
			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

        	// Gera um nome único para a imagem
        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];

        	// Caminho de onde ficará a imagem
        	$caminho_imagem = "fotos/" . $nome_imagem;

			// Faz o upload da imagem para seu respectivo caminho
			move_uploaded_file($foto["tmp_name"], $caminho_imagem);

			// Insere os dados no banco
			$sql = mysqli_query($connect,"INSERT INTO usuarios VALUES ('', '".$nome."', '".$email."', '".$nome_imagem."', '".$senha."')");

			// Se os dados forem inseridos com sucesso
			if ($sql){
				header('location: index.php');
			}
		}

		// Se houver mensagens de erro, exibe-as
		if (count($error) != 0) {
			foreach ($error as $erro) {
				echo $erro . "<br />";
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>cadastro</title>
    <link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/cadastro.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>

<body>
	<div class="container">

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="cadastro">
        <input type="text" name="nome" placeholder="Insira seu nome">

				<input type="email" name="email" placeholder="Insira Seu email">

				<input type="password" name="senha" value="" id="senha" placeholder="Insira sua Senha">
				<!-- <input type="password" name="senha" id="senha" value="" placeholder="Insira sua senha"> -->
				<a id="mostrar-senha" href="#" onclick="mostrarSenha()"><i class="fas fa-eye"></i></a>

				<button type="button" class="btn-cadastro btn-login" name="button">proximo</button>
				<div class="proxima-etapa">
					 <button type="submit" class="btn-login btn-cadastro2 " name="cadastrar">cadastrar</button>

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
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script type="text/javascript">
			$('.btn-cadastro').click(function(){
				$('.proxima-etapa').animate({
					left: '50%'
				}, 1000);
			});
		</script>
		<script type="text/javascript">
		function mostrarSenha() {
				var tipo = document.getElementById('senha');
				if (tipo.type == "password") {
						tipo.type = "text";
				} else {
						tipo.type = "password";
				}
		}
		</script>
		</script>
		<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image-upload-wrap').hide();

                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();

                $('.image-title').html(input.files[0].name);
            };

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUpload();
        }
    }

    function removeUpload() {
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }
    $('.image-upload-wrap').bind('dragover', function() {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function() {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
    </script>
</body>

</html>
