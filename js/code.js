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

function deshabilitarComentario() {
	$("#comentar").prop('disabled', true);
	$("#comentario").text("Registrese o inicie sesión para poder realizar comentarios.");
	$("#comentario").prop('disabled', true);
}

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