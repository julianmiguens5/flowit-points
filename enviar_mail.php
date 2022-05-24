<?php

//Capturamos el usuario de la petición ajax. ojo! petición ajax no del envio de formulario
$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$mensaje = filter_input(INPUT_POST, 'mensaje', FILTER_SANITIZE_SPECIAL_CHARS);

//vars
$subject = 'Consulta Circulo Parmegiano';
$to = "jmiguens@foconetworks.com, info@elparmegiano.com";

//data

$msg = "TIPO DE CONSULTA: "  . $tipo ."<br>\n";
$msg .= "NOMBRE: "  . $nombre ."<br>\n";
$msg .= "EMAIL: "  . $email ."<br>\n";
$msg .= "MENSAJE: "  . $mensaje ."<br>\n";
$msg .= "DNI: "  . $dni ."<br>\n";

//Headers
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: <" .$email. ">";

//send for each mail
mail($to, $subject, $msg, $headers);
	

		
?>