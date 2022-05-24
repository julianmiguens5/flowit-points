<?php 

function codificar_mes($mes){ 
	switch ($mes) {
			case '01' :
				$nombre_mes = "Enero"; 
				break;
			case '02' :
				$nombre_mes = "Febrero"; 
				break;
			case '03' :
				$nombre_mes = "Marzo"; 
				break;
			case '04' :
				$nombre_mes = "Abril"; 
				break;
			case '05' :
				$nombre_mes = "Mayo"; 
				break;
			case '06' :
				$nombre_mes = "Junio"; 
				break;
			case '07' :
				$nombre_mes = "Julio"; 
				break;
			case '08' :
				$nombre_mes = "Agosto"; 
				break;
			case '09' :
				$nombre_mes = "Septiembre"; 
				break;
			case '10' :
				$nombre_mes = "Octubre"; 
				break;
			case '11' :
				$nombre_mes = "Noviembre"; 
				break;
			case '12' :
				$nombre_mes = "Diciembre"; 
				break;
       }
    return $nombre_mes;
}  


?>