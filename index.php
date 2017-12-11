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
		<div style="background:black">
			<table style="width:100%">
				<tr>
					<th id="cine">
						<div class="container" onclick="window.location='cinemas.php';">
							<img src="cines.jpg" class="cine" alt="Cines"/> 
							<div class="overlay">
   								 <div class="text">
   								 	Cines de San Sebastián
   								 </div>
  							</div>
  						</div>
					</th>
					<th>
						<div class="container" onclick="window.location='movies.php';">
							<img src="movies.jpg" class="movie" alt="Peliculas"/> 
							<div class="overlay">
   								 <div class="text">
   								 	Películas
   								 </div>
  							</div>
  						</div>
					</th>
				</tr>
			</table>
		</div>
		<div class="centerdiv">
			<em><label>©SAR-2017</label></em>
		</div>
		<div class="centerdiv">
			<a target="_blank" class="linkcine" href="https://es.wikipedia.org/wiki/Cine">¿Que es un Cine?</a> | <a target="_blank" class="linkcine" href="https://es.wikipedia.org/wiki/Pelicula">¿Qué es una película?</a>
		</div>
	</body>
</html>