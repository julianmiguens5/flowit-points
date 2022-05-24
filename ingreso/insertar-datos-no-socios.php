<?php

require('clases/comercio.class.php');

$objComercio=new comercio;

//vars
$NSname = utf8_decode(filter_input(INPUT_POST, 'NSname', FILTER_SANITIZE_SPECIAL_CHARS));
$NSapellido = utf8_decode(filter_input(INPUT_POST, 'NSapellido', FILTER_SANITIZE_SPECIAL_CHARS));
$NSnacionalidad = utf8_decode(filter_input(INPUT_POST, 'NSnacionalidad', FILTER_SANITIZE_SPECIAL_CHARS));
$NSfecha_nac = filter_input(INPUT_POST, 'NSfecha_nac', FILTER_SANITIZE_SPECIAL_CHARS);
$NStipo_documento = filter_input(INPUT_POST, 'NStipo_documento', FILTER_SANITIZE_SPECIAL_CHARS);
$NSnum_documento = filter_input(INPUT_POST, 'NSnum_documento', FILTER_SANITIZE_SPECIAL_CHARS);
$NSpais_documento = utf8_decode(filter_input(INPUT_POST, 'NSpais_documento', FILTER_SANITIZE_SPECIAL_CHARS));
$NSmail = utf8_decode(filter_input(INPUT_POST, 'NSmail', FILTER_SANITIZE_SPECIAL_CHARS));
$NSdireccion = utf8_decode(filter_input(INPUT_POST, 'NSdireccion', FILTER_SANITIZE_SPECIAL_CHARS));
$NSlocalidad = utf8_decode(filter_input(INPUT_POST, 'NSlocalidad', FILTER_SANITIZE_SPECIAL_CHARS));
$NSprovincia = utf8_decode(filter_input(INPUT_POST, 'NSprovincia', FILTER_SANITIZE_SPECIAL_CHARS));
$NSpais = utf8_decode(filter_input(INPUT_POST, 'NSpais', FILTER_SANITIZE_SPECIAL_CHARS));
$NScodigo_postal = filter_input(INPUT_POST, 'NScodigo_postal', FILTER_SANITIZE_SPECIAL_CHARS);
$NSimporte_pesos = filter_input(INPUT_POST, 'NSimporte_pesos', FILTER_SANITIZE_SPECIAL_CHARS);
$NSimporte_cent = filter_input(INPUT_POST, 'NSimporte_cent', FILTER_SANITIZE_SPECIAL_CHARS);
$importe = $NSimporte_pesos.'.'.$NSimporte_cent;

$NScomercio = utf8_decode(filter_input(INPUT_POST, 'NScomercio', FILTER_SANITIZE_SPECIAL_CHARS));

$rg_fecha_canje = date("Y-m-d");

if($comercio!='demo') {
$objComercio->agregar_kms_no_socios($NScomercio, $rg_fecha_canje, $NSname, $NSapellido, $NSnacionalidad, $NSfecha_nac, $NStipo_documento, $NSnum_documento, $NSpais_documento, $NSmail, $NSdireccion, $NSlocalidad, $NSprovincia, $NSpais, $NScodigo_postal, $importe);
}

?>
