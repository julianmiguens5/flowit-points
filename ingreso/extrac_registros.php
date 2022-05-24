<?php

require('clases/comercio.class.php');
require('library/reemplazar_caracteres.php');

$objComercio=new comercio;
$ayer = date("Y-m-d", strtotime("-1 day"));

$extract_registros = $objComercio->extract_registros($ayer);
$arr_registros =$objComercio->resultados($extract_registros);


if(!empty($arr_registros)){
	
			// VARIABLES FIJAS DE LA CABECERA     
			$fecha_actual=date("d-m-Y");
			$nombre_archivo = 'canjes_lanpass-' . $fecha_actual;
			$extension = ".csv";
			
			$ar=fopen("canjes/" . $nombre_archivo . $extension,"w") or
			die("Problemas en la creacion");

			$extract_registros = $objComercio->extract_registros($ayer);
				
			while ($registros = $objComercio->resultados($extract_registros)){ 							
				 $nombre = convertir_especiales_html($registros['rg_nombre']); 
				 $nombre = strtoupper(limpiar_caracteres_especiales($nombre)); 
				 
				 $apellido = convertir_especiales_html($registros['rg_apellido']); 
				 $apellido = strtoupper(limpiar_caracteres_especiales($apellido)); 

				 $fecha_canje = date("Ymd",strtotime($registros['rg_fecha_canje']));
				 
				 fputs($ar,$fecha_canje.";");			 
				 fputs($ar,$nombre.";");
				 fputs($ar,$apellido.";");
				 fputs($ar,$registros['rg_fecha_nacimiento'].";");
				 fputs($ar,$registros['rg_numero_documento'].";");
				 fputs($ar,strtoupper($registros['rg_condicion']).";");
				 fputs($ar,$registros['rg_nacionalidad'].";");
				 fputs($ar,$registros['rg_numero_socio'].";");
				 fputs($ar,$registros['rg_mail'].";");
					 if(!empty($registros['rg_importe_pesos'])) {
						$importe=$registros['rg_importe_pesos'];
					 } else {
						$importe=$registros['rg_importe_dolares'];
					 }
				 fputs($ar,$importe.";");
				 fputs($ar,$registros['rg_comercio']);
				 fputs($ar,chr(13).chr(10));
			}
			
}



?>