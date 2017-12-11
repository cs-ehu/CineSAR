<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
  		<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<title>CineSAR | Cines</title>
		<link rel="stylesheet" href="css/style.css"/>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="js/code.js"></script>
		<div class="rightdiv">
			<?php
				session_start();
				if(isset($_SESSION['userlog']) && !empty($_SESSION['userlog'])) {
					echo '<label id="session" onclick="window.location=\'logout.php\';">Log Out</label> | <label onclick="window.location=\'insertarPelicula.php\';">Insertar película</label>';
				} else {
					echo '<label id="session" onclick="window.location=\'login.php\';">Iniciar sesión</label> | <label onclick="window.location=\'register.php\';">Registrarse</label>';
				}				
			?>
		</div>
		<h1 onclick="window.location='index.php';"><img src="logo.jpeg" alt="Logo"/> CineSAR</h1>
		<div class="centerdiv">
			<?php
				if(isset($_SESSION['userlog']) && !empty($_SESSION['userlog'])) {
					echo '¡Bienvenido '.$_SESSION['userlog'].'!';
				}
			?>
		</div>
		<div class="rightdiv">
			<input type="button" id="b1" value="Autores"/>
		</div>
		<div id="autores">
		</div>
		<hr/>
	</head>
	<body>
		<div id="t-movies">
			<?php
				include "serverManager.php";
				getMovie($_GET['idmovie']);
			?>
			<h3>Comentarios</h3>
			<form onsubmit="processComent();" method="post"<?php echo ' action="movie.php?idmovie='.$_GET['idmovie'].'"'; ?>>
				<div>
					<textarea id="comentario" rows="4" name="comentario" cols="100">Escriba su comentario aquí...</textarea>
				</div>
				<div>
					<input type="submit" name="comentar" id="comentar" value="Enviar comentario">
				</div>
			</form>
			<hr>
			<div id='comentarios'>
			<?php
				if(!isset($_SESSION['userlog']) && empty($_SESSION['userlog'])) {
					echo '<script type=\'text/javascript\'>deshabilitarComentario();</script>';
				}

				if(isset($_POST['comentar'])) {
					comentarPeli($_GET['idmovie']);
				}

				getComents($_GET['idmovie']);
			?>
			</div>
			<hr/>
		</div>
		<div class="centerdiv">
			<em><label>©SAR-2017</label></em>
		</div>
	</body>
</html>