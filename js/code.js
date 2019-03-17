$(document).ready(function () {

	$("#b1").click(function() {
		var autores = "<fieldset id='autorescab' style='background-color:grey; align='right'><legend style='background-color:black;color:white;font-family:verdana;'><strong>Grupo 07</strong></legend><label style='font-family:verdana;'>Alfonso Rodríguez <br> Miguel Ángel Blanco <br> Oier Eguiazabal</label></fieldset>";
		$("#autores").html(autores);
		$("#autorescab").fadeOut(10000);
	});

	$("#comentario").click(function clearContents() {
		if($('#comentario').text() == 'Escriba su comentario aquí...') {
			$('#comentario').text('');
		}
	});	
});


/**
* Procesa el contenido del comentario desde la parte cliente para ver si es correcto.
* @param {String} (interna) comentario El contenido del comentario.
* @returns {boolean} Un booleano que avise de si se ha procesado correctamente el comentario.
*/
function processComent() {
	var comentario = $('#comentario').val();

	if(comentario == "") {
		alert("¡El campo comentario no puede ser vacío!");
		return false;
	} else {
		alert("¡Comentario enviado correctamente!");
		return true;
	}

}

/**
* Valida los datos del formulario de registro desde la parte cliente.
* @param {String} (interna) username El nickname del usuario.
* @param {String} (interna) email El email del usuario.
* @param {String} (interna) pass La password del usuario.
* @returns {boolean} Un booleano que avise de si se ha validado correctamente el registro.
*/
function validarRegistro() {
	var emailExp = new RegExp("^[a-zA-Z]+\\d{3}@(gmail|hotmail|outlook)\.(com|es)$");
	var username = document.getElementById('user').value;
	var email = document.getElementById('email').value;
	var pass = document.getElementById('pass').value;

	if(username != "" && email != "" && pass != "") {
		if(emailExp.test(email)) {
			alert("¡Se ha registrado con éxito!");
			return true;
		}
	}
		
	alert("¡Asegúrese de no dejar ningún campo vacío!");
	return false;
}

/**
* Valida los datos del formulario de login desde la parte cliente.
* @param {String} (interna) email El email del usuario.
* @param {String} (interna) pass La password del usuario.
* @returns {boolean} Un booleano que avise de si se ha validado correctamente el login.
*/
function validarLog() {
	var email = $('#email').val();
	var pass = $('#pass').val();

	if(username != "" && email != "" && pass != "") {
		return true; //El inicio de sesión se controla en php.
	} else {
		alert("¡Asegúrese de no dejar ningún campo vacío!");
		return false;	
	}
		
}

/**
* Se encarga de deshabilitar la parte de comentarios en caso de que el usuario no esté registrado ni logueado.
*/
function deshabilitarComentario() {
	$("#comentar").prop('disabled', true);
	$("#comentario").text("Registrese o inicie sesión para poder realizar comentarios.");
	$("#comentario").prop('disabled', true);
}

/**
* Valida los datos del formulario de insertar películas desde la parte cliente.
* @param {String} (interna) título El título de la película.
* @param {String} (interna) director El director de la película.
* @param {String} (interna) actores Los actores de la película.
* @param {String} (interna) sinopsis La sinopsis de la película.
* @param {String} (interna) trailer El trailer de la película.
* @returns {boolean} Un booleano que avise de si se ha validado correctamente el formulario de insertar películas.
*/
function validarPelicula() {
	var titulo = document.getElementById('titulo').value;
	var director = document.getElementById('director').value;	
	var actores = document.getElementById('actores').value;
	var sinopsis = document.getElementById('sinopsis').value;
	var trailer = document.getElementById('youtube').value;

	if(titulo != "" && director != "" && actores != "" && sinopsis != "" && trailer != "") {
		if(trailer.includes("https://www.youtube.com/watch?v=") || trailer.includes("https://youtu.be/")) {
			alert("¡Película añadida con éxito!");
			return true; //La subida de la película y la caratula se controla en php.
		} else {
			alert("¡El enlace del trailer debe de ser de youtube!");
			return false;	
		}
	} else {
		alert("¡Asegúrese de no dejar ningún campo vacío!");
		return false;	
	}
		
}