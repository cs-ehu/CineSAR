<?php
	
	/**
	*	Se encarga de registrar un usuario a través de los datos del formulario.
	*
	*	@author Miguel Ángel Blanco <mblanco040@ikasle.ehu.eus>
	*
	*	@param (interna) string $user el nick del usuario que se quiere registrar.
	*	@param (interna) string $email el email del usuario que se quiere registrar.
	*	@param (interna) string $pass la contraseña del usuario que se quiere registrar.
	*
	*	@return string $operationMsg informando de se ha realizado correctamente el registro o ha fallado.	
	*
	*/
	function registrarUsuario() {
		include "config.php";

		$conn = new mysqli($serversql, $usersql, $passsql, $database);

		if ($conn->connect_error) {
			trigger_error("Database connection failed: " . $conn->connect_error, E_USER_ERROR);
		}

		$operationMsg = "";
		$operationOK = true;

		if(isset($_POST['user']) && !empty($_POST['user'])) {
			if(!existsUser($_POST['user'], $conn)) {
				$user = $_POST['user'];
			} else {
				$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">El nombre de usuario que ha introducido ya fue utilizado.</div>';
				$operationOK = false;
			}
		} else {
			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">El campo usuario no puede ser vacio.</div>';
			$operationOK = false;
		}

		if(isset($_POST['email']) && !empty($_POST['email'])) {
			if(validEmail($_POST['email'])) {
				if(!existsEmail($_POST['email'], $conn)) {
					$email = $_POST['email'];
				} else {
					$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
					El email que ha introducido ya ha sido utilizado en esta página.
					</div>';
					$operationOK = false;
				}
			} else {
				$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
					El campo email no cumple el formato, escriba de nuevo el campo. Ej: Correo123@outlook.es, Correo123@hotmail.com, Correo123@gmail.com.
					</div>';
				$operationOK = false;
			}
		} else {
			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
				El campo email no puede estar vacio.
				</div>';
			$operationOK = false;
		}

		if(isset($_POST['pass']) && !empty($_POST['pass'])) {
			$pass = password_hash(hash("sha256", $_POST['pass']), PASSWORD_DEFAULT);
		} else {
			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
				El campo contraseña no puede estar vacio.
				</div>';
			$operationOK = false;
		}

		if($operationOK) {
			$sql = "INSERT INTO `usuarios` (`username`, `email`, `password`) VALUES ('$user', '$email', '$pass')";

			if(!$result = $conn->query($sql)) {
				$operationMsg .= "<script type=\"text/javascript\">alert(\"Ha ocurrido un error con la base de datos, por favor, inténtelo de nuevo.\");</script>"; 
			} else {
				error_reporting(0); //Para omitir un avise que no afecta al funcionamiento.
				session_start();
				$_SESSION['userlog'] = $user;
				$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: green;">
				Se ha registrado con éxito.
				</div>';
				$operationMsg .= "<script type=\"text/javascript\">window.location.replace(\"index.php\");</script>";
			}

			$conn->close();

		}

		echo $operationMsg;

	}


	/**
	*	Se encarga de loguear un usuario a través de los datos del formulario.
	*
	*	@author Miguel Ángel Blanco <mblanco040@ikasle.ehu.eus>
	*
	*	@param (interna) string $email el email del usuario que se quiere loguear.
	*	@param (interna) string $pass la contraseña del usuario que se quiere loguear.
	*
	*	@return string $operationMsg informando de se ha realizado correctamente el logueo o ha fallado.
	*
	*/
	function logearUsuario() {
		include "config.php";

		$conn = new mysqli($serversql, $usersql, $passsql, $database);

		if ($conn->connect_error) {
			trigger_error("Database connection failed: " . $conn->connect_error, E_USER_ERROR);
		}

		$operationMsg = "";
		$operationOK = true;

		if(isset($_POST['emaill']) && !empty($_POST['emaill'])) {
			$email = $_POST['emaill'];
		} else {
			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
				El campo email no puede estar vacio.
				</div>';
			$operationOK = false;
		}

		if(isset($_POST['passl']) && !empty($_POST['passl'])) {
			$pass = $_POST['passl'];
		} else {
			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
				El campo contraseña no puede estar vacio.
				</div>';
			$operationOK = false;
		}

		if($operationOK) {

			$result = $conn->query("SELECT * FROM usuarios WHERE email = \"$email\"");
			$passwordHash = $result->fetch_assoc();

			if(password_verify(hash("sha256", $pass), $passwordHash["password"]) && existsEmail($email, $conn)) {
				error_reporting(0); //Para omitir un avise que no afecta al funcionamiento.
				session_start();
				$_SESSION['userlog'] = $passwordHash["username"];
				$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: green;">
				Se ha logueado con éxito.
				</div>';
				$operationMsg .= "<script type=\"text/javascript\">alert(\"¡Ha realizado el login con éxito!\");window.location.replace(\"index.php\");</script>"; 
			} else {
				$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
				Log In incorrecto, revise la contraseña y el email introducido.
				</div>';
				$operationMsg .= "<script type=\"text/javascript\">alert(\"¡Vaya! la contraseña o el email es incorrecto. Inténtelo de nuevo.\");</script>";
			}

			$conn->close();

		}

		echo $operationMsg;

	}

	/**
	*	Valida el email de un usuario con un patrón.
	*
	*	@author Miguel Ángel Blanco <mblanco040@ikasle.ehu.eus>
	*
	*	@param string $email el email del usuario que se va a validar
	*
	*	@return boolean $emailIsOk indica si el email es correcto según el patrón o no
	*
	*/
	function validEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^[a-zA-Z]+\\d{3}@(gmail|hotmail|outlook)\.(com|es)$/', $email);
	}


	/**
	*	Comprueba si un email dado ya existe en la base de datos.
	*
	*	@author Miguel Ángel Blanco <mblanco040@ikasle.ehu.eus>
	*
	*	@param string $email el email del usuario que se va a comprobar si ya existe en la base de datos.
	*	@param string $conn cadena de caracteres que conecta con la base de datos para comprobar si existe o no el email dado.
	*
	*	@return boolean $emailExist indica si el email ya existe.
	*
	*/
	function existsEmail($email, $conn) {
		$query = mysqli_query($conn, "SELECT * FROM usuarios WHERE email = \"$email\"");

		if (!$query) {
			echo "Error: " . mysqli_error($conn);
		}

		return mysqli_num_rows($query) > 0;
	}

	/**
	*	Comprueba si un usuario dado ya existe en la base de datos.
	*
	*	@author Miguel Ángel Blanco <mblanco040@ikasle.ehu.eus>
	*
	*	@param string $user el nick del usuario que se va a comprobar si ya existe en la base de datos.
	*	@param string $conn cadena de caracteres que conecta con la base de datos para comprobar si existe o no el usuario dado.
	*
	*	@return boolean $userExist indica si el usuario ya existe.
	*
	*/
	function existsUser($user, $conn) {
		$query = mysqli_query($conn, "SELECT * FROM usuarios WHERE username = \"$user\"");

		if (!$query) {
			echo "Error: " . mysqli_error($conn);
		}

		return mysqli_num_rows($query) > 0;
	}

	/**
	*	Inserta los datos de una película en su correspondiente fichero xml.
	*
	*	@author Miguel Ángel Blanco <mblanco040@ikasle.ehu.eus>
	*
	*	@param (interna) string $title el título de la película que se va a insertar en su fichero xml.
	*	@param (interna) string $director el director de la película que se va a insertar en su fichero xml.
	*	@param (interna) string $synopsis la sinopsis de la película que se va a insertar en su fichero xml.
	*	@param (interna) string $actors los actores de la película que se van a insertar en su fichero xml.
	*	@param (interna) string $trailer la URL del trailer de la película que se va a insertar en su fichero xml.
	*	@param (interna) file $moviecover la carátula de la película que se va a insertar en su fichero xml.
	*
	*	@return boolean $operationMsg indica si ĺa inserción de la película ha ido correctamente.
	*
	*/
	function insertarPeli() {
		$src = "imgs/moviesimgs/";
		$movies = simplexml_load_file("xml/movies.xml");

		$operationMsg = "";
		$operationOK = true;

		if(isset($_POST['titulo']) && !empty($_POST['titulo'])) {
			$titulo = $_POST['titulo'];
		} else {
			$operationOK = false;
			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
				El campo título no puede estar vacío.
				</div>';
		}

		if(isset($_POST['director']) && !empty($_POST['director'])) {
			$director = $_POST['director'];
		} else {
			$operationOK = false;
			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
				El campo director no puede estar vacío.
				</div>';
		}

		if(isset($_POST['sinopsis']) && !empty($_POST['sinopsis'])) {
			$sinopsis = $_POST['sinopsis'];
		} else {
			$operationOK = false;
			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
				El campo sinopsis no puede estar vacío.
				</div>';
		}

		if(isset($_POST['actores']) && !empty($_POST['actores'])) {
			$actores = $_POST['actores'];
		} else {
			$operationOK = false;
			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
				El campo actores no puede estar vacío.
				</div>';
		}

		if(isset($_POST['youtube']) && !empty($_POST['youtube'])) {
			if(strpos($_POST['youtube'], 'https://www.youtube.com/watch?v=') == 0 || strpos($_POST['youtube'], 'https://youtu.be/') == 0) {
				$trailer = $_POST['youtube'];
			} else {
				$operationOK = false;
				$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
					La url del trailer debe pertenecer a youtube.
					</div>';
			}

		} else {
			$operationOK = false;
			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
				El campo trailer no puede estar vacío.
				</div>';
		}

		$containsImage = false;

		switch ($_FILES['imagen']['error']) {
			case UPLOAD_ERR_OK:
			$containsImage = true;
		}

		if($containsImage && $operationOK) {
			if ($_FILES['imagen']['size'] > 1000000) {
				$operationOK = false;
				$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
					La imagen no puede ser tan grande.
					</div>';
			}
		
			$finfo = new finfo(FILEINFO_MIME_TYPE);

			if (false === $ext = array_search(
				$finfo->file($_FILES['imagen']['tmp_name']),
				array(
					'jpg' => 'image/jpeg',
					'png' => 'image/png',
					'gif' => 'image/gif',
				),
				true
			)) {
				$operationOK = false;
				$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
					Formato de imagen inválido.</div>';
			}

			$sha1Name = sha1_file($_FILES['imagen']['tmp_name']);

			if (!move_uploaded_file(
				$_FILES['imagen']['tmp_name'],
				sprintf('%s%s.%s',
					$src,
					$sha1Name,
					$ext
				)
				)) {
					$operationOK = false;
					$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
						Fallo al mover el archivo.</div>';
			}

			$imagenCaratula = sprintf("%s%s.%s", $src, $sha1Name, $ext);
		} else {
			$operationOK = false;
			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: red;">
				Debe haber una caratula para la película.
				</div>';
		}

		if($operationOK) {
			$movies['ultid'] = $movies['ultid'] + 1;
			$ultid = $movies['ultid'];

			$nuevo = $movies->addChild('movie');
			$nuevo->addAttribute('id', $ultid);
			$nuevo->addAttribute('nombre', $titulo);
			$nuevo->addAttribute('imagencar', $sha1Name.'.'.$ext);

			if(strpos($trailer, 'https://www.youtube.com/watch?v=') == 0) {
				$trailer = str_replace("https://www.youtube.com/watch?v=","", $trailer);
			} else if(strpos($trailer, 'https://youtu.be/') == 0) {
				$trailer = str_replace("https://youtu.be/","", $trailer);
			}

			$trailer = 'https://www.youtube.com/embed/'.$trailer;

			$nuevo->addAttribute('urlt', $trailer);
			$nuevo->addChild('director', $director);

			$actores = explode(', ', $actores, -1);

			$actoresxml = $nuevo->addChild('actores');
			foreach ($actores as $actor) {
				$actoresxml->addChild('actor', $actor);
			}

			$nuevo->addChild('sinopsis', $sinopsis);

			$movies->asXML("xml/movies.xml");

			formatoXML("xml/movies.xml");

			$operationMsg .= '<div style="border: 2px solid rgb(0,0,0); background-color: green;">
				¡Película subida correctamente! Mírela subida <a target="_blank" href="movie.php?idmovie='.$ultid.'">aquí</a></div>';	
		}

		echo $operationMsg;
	}

	/**
	*	Inserta un comentario para una película concreta en su correspondiente fichero xml.
	*
	*	@author Miguel Ángel Blanco <mblanco040@ikasle.ehu.eus>
	*
	*	@param int $idmovie la id de la película a la que se quiere añadir un comentario.
	*	@param string $coment el contenido del comentario que se quiere añadir a la película por medio de un fichero xml.
	*
	*
	*/
	function comentarPeli($idmovie) {
		if(isset($_POST['comentario']) && !empty($_POST['comentario'])) {
			date_default_timezone_set('Europe/Madrid');
			$comentario = $_POST['comentario'];
			$idmovie = $idmovie;
			$hoy = date("d/m/Y H:i:s");

			$coments = simplexml_load_file("xml/coments.xml");
			$coments['ultid'] = $coments['ultid'] + 1;
			$ultid = $coments['ultid'];

			$nuevo = $coments->addChild('comentario');
			$nuevo->addAttribute('id', $ultid);
			$nuevo->addAttribute('usuario', $_SESSION['userlog']);
			$nuevo->addAttribute('idpel', $idmovie);
			$nuevo->addAttribute('fechahora', $hoy);
			$nuevo->addChild('contenido', $comentario);
			$coments->asXML("xml/coments.xml");

			formatoXML("xml/coments.xml");	
		}

	}

	/**
	*	Formatea un fichero xml dado su ruta de fichero.
	*
	*	@param string $path la ruta del xml que se quiere formatear.
	*
	*
	*/
	function formatoXML($path) {
		$dom = new DOMDocument("1.0", "UTF-8");
		$dom->preserveWhiteSpace = false;		
		$dom->formatOutput = true;
		$dom->load($path);
		$dom->save($path);
	}

	/**
	*	Devuelve todos los datos de los cines del fichero xml con un formato html.
	*
	*	@author Miguel Ángel Blanco <mblanco040@ikasle.ehu.eus>
	*
	*	@return string $cines_html los datos de los cines en html.
	*
	*
	*/
	function getCines() {
		$cines_html = "";
		$cinemas = simplexml_load_file("xml/cinemas.xml");
		foreach ($cinemas->cinema as $cinema) {
			$cines_html .= "<div>";
			$cines_html .= "<h3><img src='popcorn.png' style='width: 25px; height: 25px;' alt='Palomitas' />".$cinema['nombre']."</h3>";
			$cines_html .= "<h4> Localidad </h4>";
			$cines_html .= "<p>".$cinema->localidad."</p>";
			$cines_html .= "<h4> Ubicación </h4>";
			$cines_html .= "<p>".$cinema->ubicacion."</p>";
			$cines_html .= "<h4> Teléfono </h4>";
			$cines_html .= "<p>".$cinema->tlf."</p>";
			$cines_html .= "<h4> Descripción del lugar </h4>";
			$cines_html .= "<p>".$cinema->descripcion."</p>";
			$cines_html .= "<h4> Lugar en el mapa e información adicional </h4>";
			$cines_html .= '<iframe src="https://www.google.com/maps/embed?pb='.$cinema->lugar.'" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>';
			$cines_html .= "</div>";
			$cines_html .= "<hr/>";
		}

		echo $cines_html;
	}

	/**
	*	Devuelve todos los títulos de la películas del fichero xml con un formato html con sus respectivos enlaces de información.
	*
	*	@return string $movies_html los títulos de las películas en html con su enlace referenciado.
	*
	*
	*/
	function getMovies() {
		$movies_html = "";
		$movies = simplexml_load_file("xml/movies.xml");

		foreach ($movies->movie as $movie) {
			$movies_html .= "<div><a class='linkmov' href='movie.php?idmovie=".$movie['id']."'>".$movie['id'].". ".$movie['nombre']."</a></div>";
		}

		$movies_html .= "<hr/>";

		echo $movies_html;
	}

	/**
	*	Devuelve los datos de una película concreta a través de su id por medio de su fichero xml con un formato html.
	*
	*	@author Miguel Ángel Blanco <mblanco040@ikasle.ehu.eus>
	*
	*	@param int $id la id de la película de la que se quiere los datos.
	*
	*	@return string $movies_html la información de la película con su formato html.
	*
	*
	*/
	function getMovie($id) {
		$movies_html = "";

		$src = "imgs/moviesimgs/";
		$movies = simplexml_load_file("xml/movies.xml");

		foreach ($movies->movie as $movie) {
			if($movie['id'] == $id) {
				$movieres = $movie;
				break;
			}
		}

		$movies_html .= "<div><h2><img src='film.png' width='30px' height='30px' alt='Plaqueta' />".$movieres['nombre']."</h2></div>";
		$movies_html .= "<div><img src='".$src.$movieres['imagencar']."' height='268' width='182' alt='Caratula'/></div>";
		$movies_html .= "<div><h3>Sinopsis</h3></div>";
		$movies_html .= "<div><p>".$movieres->sinopsis."</p></div>";
		$movies_html .= "<div><h3>Director</h3></div>";
		$movies_html .= "<div><p>".$movieres->director."</p></div>";
		$movies_html .= "<div><h3>Actores</h3></div>";
		$actores = "";

		foreach ($movieres->actores->actor as $actor) {
			$actores .= $actor.", ";
		}

		$movies_html .= "<div style='padding-right:50%;'><p>".str_replace(", ".$actor.", ", " y ".$actor.".", $actores)."</p></div>";

		$movies_html .= "<div><h3>Trailer</h3></div>";

		$movies_html .= "<div><iframe width='560' height='315' src='".$movieres['urlt']."'
						 frameborder='0' gesture='media' allow='encrypted-media' allowfullscreen></iframe></div>";

		$movies_html .= "<hr/>";

		echo $movies_html;
	}

	/**
	*	Devuelve los datos de los comentarios de una película concreta a través de su id por medio de su fichero xml con un formato html.
	*
	*	@author Miguel Ángel Blanco <mblanco040@ikasle.ehu.eus>
	*
	*	@param int $id la id de la película de la que se quiere los datos de los comentarios.
	*
	*	@return string $coments_html los comentarios de la película con formato html.
	*
	*
	*/
	function getComents($id) {
		$coments_html = "";
		$coments = simplexml_load_file("xml/coments.xml");

		$n = (int) $coments['ultid'];

		for($i = $n; $i >= 0; $i--) {
			$coment = $coments->comentario[$i];
			if($coment['idpel'] == $id) {
				$coments_html .= "<div class='comentario'>";
				$coments_html .= "<div class='cabezacom'>".$coment['usuario']." - ".$coment['fechahora']."</div>";
				$coments_html .= "<div class='cuerpocom'><p>".$coment->contenido."</p></div>";
				$coments_html .= "</div>";
				$coments_html .= "<div style='padding:5px;'></div>";
			}
		}

		echo $coments_html;
	}
?>