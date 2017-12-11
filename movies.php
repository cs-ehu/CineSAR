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
			<h2>Lista de películas</h2>
			<p>Aquí podrá ver las películas que hay en la página.</p>
			<hr/>
			<?php
				include "serverManager.php";
				getMovies();
			?>
		</div>
		<div class="centerdiv">
			<em><label>©SAR-2017</label></em>
		</div>
	</body>
</html>