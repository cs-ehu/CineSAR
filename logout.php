<?php
	session_start();
	session_destroy();
	echo "<script type=\"text/javascript\">alert('¡Deslogueado con éxito!');window.location.replace(\"index.php\");</script>";
?>