<?php

require('clases/comercio.class.php');

$objComercio=new comercio;

//vars
$name = utf8_decode(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
$apellido = utf8_decode(filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_SPECIAL_CHARS));
$nacionalidad = utf8_decode(filter_input(INPUT_POST, 'nacionalidad', FILTER_SANITIZE_SPECIAL_CHARS));
$num_documento = filter_input(INPUT_POST, 'num_documento', FILTER_SANITIZE_SPECIAL_CHARS);
$numero_lanpass = filter_input(INPUT_POST, 'numero_lanpass', FILTER_SANITIZE_SPECIAL_CHARS);
$importe_pesos = filter_input(INPUT_POST, 'importe_pesos', FILTER_SANITIZE_SPECIAL_CHARS);
$importe_cent = filter_input(INPUT_POST, 'importe_cent', FILTER_SANITIZE_SPECIAL_CHARS);
$importe = $importe_pesos.'.'.$importe_cent;

$comercio = utf8_decode(filter_input(INPUT_POST, 'comercio', FILTER_SANITIZE_SPECIAL_CHARS));

$rg_fecha_canje = date("Y-m-d");

if($comercio!='demo') {
	$objComercio->agregar_kms_socios($comercio, $rg_fecha_canje, $name, $apellido, $nacionalidad, $num_documento, $numero_lanpass, $importe);
}

?>
