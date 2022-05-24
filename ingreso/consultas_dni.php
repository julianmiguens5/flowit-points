<?php 

require('clases/comercio.class.php');
$objComercio=new comercio;
$arr_registros=$objComercio->filtro_dni($_GET['comercio'], $_POST['documento']);
	
	$datos = array();
	
	while($row = mysql_fetch_array($arr_registros))
	{	
		$datos[] = array(
			'rg_nombre'          	=> utf8_encode($row['rg_nombre']),
			'rg_apellido'     	    => utf8_encode($row['rg_apellido']),
			'rg_numero_documento'   => $row['rg_numero_documento'],
			'rg_importe_pesos'     	=> $row['rg_importe_pesos'],
			'rg_fecha_canje'      	=> $row['rg_fecha_canje'],
			'rg_condicion'  		=> $row['rg_condicion']
		);
	}
	// convertimos el array de datos a formato json
	echo json_encode($datos);


?>