<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php
			session_start();
			if(!isset($_SESSION['userlog']) && empty($_SESSION['userlog'])) {
				echo "<script type=\"text/javascript\">alert('¡Necesita estar logueado para acceder aquí!');window.location.replace(\"index.php\");</script>";
			}				
		?>
  		<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<title>CineSAR | Cines</title>
		<link rel="stylesheet" href="css/style.css"/>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="js/code.js"></script>
		<div class="rightdiv">
			<?php
				if(isset($_SESSION['userlog']) && !empty($_SESSION['userlog'])) {
					echo '<label id="session" onclick="window.location=\'logout.php\';">Log Out</label> | <label onclick="window.location=\'insertarPelicula.php\';">Insertar película</label>';
				}			
			?>
		</div>
		<h1 onclick="window.location='index.php';"><img src="logo.jpeg" alt="Logo"/> CineSAR</h1>
		<div class="rightdiv">
			<input type="button" id="b1" value="Autores"/>
		</div>
		<div id="autores">
		</div>
		<hr/>
	</head>
	<body>
		<div id="t-movies">
			<h1>Insertar película</h1>
			<p>Aquí podrá introducir una película.</p>
			<hr/>
			<form action="insertarPelicula.php" enctype="multipart/form-data" method="post" onsubmit="validarPelicula();">
				<div>
					<label>Título de la película</label>
				</div>
				<div class="pel">
					<input type="text" id="titulo" name="titulo" size="49"/>
				</div>
				<div>
					<label>Director</label>
				</div>
				<div class="pel">
					<input type="text" id="director" name="director"/>
				</div>
				<div>
					<label>Sinopsis</label>
				</div>
				<div class="pel">
					<textarea name="sinopsis" id="sinopsis" rows="10" cols="50"></textarea>
				</div>
				<div>
					<label>Actores (deben estar separados por ', ')</label>
				</div>
				<div class="pel">
					<textarea name="actores" id="actores" rows="4" cols="50"></textarea>
				</div>
				<div>
					<label>URL del trailer (obligatorio que sea de YouTube)</label>
				</div>
				<div class="pel">
					<input type="text" id="youtube" name="youtube" size="49"/>
				</div>
				<div>
					<label>Imagen caratula (será redimensionada a las dimensiones 268x182)</label>
				</div>
				<div class="pel">
					<input type="file" name="imagen"/>
				</div>
				<div id="submitpel">
					<input type="submit" name="enviar" value="Enviar película"/>
				</div>
			</form>
			<hr/>
			<?php
				include 'serverManager.php';
				if(isset($_POST['enviar']) && !empty($_POST['enviar'])) {
					insertarPeli();
				}
			?>
			<hr/>
		</div>
		<div class="centerdiv">
			<em><label>©SAR-2017</label></em>
		</div>
	</body>
</html>