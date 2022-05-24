<?php

function esAdmin ( $usuarioadmin, $passwordadmin, $conexion ) {
	
	// verifica que esten los dos campos completos.
	if ($usuarioadmin=='' || $passwordadmin=='') return false;
	
	// busqueda de los datos de admin para loguear.
	$query = "SELECT * FROM `administradores` WHERE `usuarioadmin`='$usuarioadmin'";
	$resultado = mysql_query ($query, $conexion);
	$row = mysql_fetch_array ($resultado);
	echo mysql_error();
	$password_from_db = $row ['passwordadmin'];
	unset($query);
			
	// verifica que el pass enviado sea igual al pass de la db.
	if ( $password_from_db == $passwordadmin ) {
		return $row;
	} else return false;
	
	
}

?>