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
					echo "<script type=\"text/javascript\">alert('¡No puede ir a la página de registro ya logueado!');window.location.replace(\"index.php\");</script>";
				}				
			?>
			<label id="session" onclick="window.location='login.php';">Iniciar sesión</label> | <label onclick="window.location='register.php';">Registrarse</label>
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
		<fieldset id="reg" style="border: 1px solid rgb(0,0,0); width: 400px; margin:auto; padding: 2%;">
			<legend class="regis" style="color: white; background-color: black;">Registrarse</legend>
			<form method="post" style="text-align: center;" onsubmit="validarRegistro();">
				<div>
					<label>Username</label>
				</div>
				<div>
					<input type="text" name="user" id="user"/>
				</div>
				<div>
					<label>Email</label>
				</div>
				<div>
					<input type="text" name="email" id="email"/>
				</div>
				<div>
					<label>Password</label>
				</div>
				<div>
					<input type="password" name="pass" id="pass"/>
				</div>
				<div class="paddbut">
					<input type="submit" name="envio" value="Registrarse"/>
				</div>
			</form>
		</fieldset>
		<div id="pregg" style="border: 1px solid rgb(0,0,0); width: 400px; margin:auto; padding: 2%;">
		<?php
			include "serverManager.php";
			if(isset($_POST['envio'])){
				registrarUsuario();
			} 
		?>
		</div>
		<div class="centerdiv">
			<em><label>©SAR-2017</label></em>
		</div>
		<div class="centerdiv">
			<a target="_blank" class="linkcine" href="https://es.wikipedia.org/wiki/Cine">¿Que es un Cine?</a> | <a target="_blank" class="linkcine" href="https://es.wikipedia.org/wiki/Pelicula">¿Qué es una película?</a>
		</div>
	</body>
</html>