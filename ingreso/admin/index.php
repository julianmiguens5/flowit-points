<?php
// iniciamos session
session_start ();

require('../clases/comercio.class.php');
require('../library/functions.php');

$objComercio=new login;
$obj=new comercio;


// vemos si el usuario quiere desloguar
if ( !empty($_GET['salir']) ) {
	// borramos y destruimos todo tipo de sesion del usuario
	session_unset();
	session_destroy();
}

// verificamos que no este conectado el usuario
if ( !empty( $_SESSION['usuario'] ) && !empty($_SESSION['password']) ) {
	$arr_usuarios = $objComercio->esUsuario($_SESSION['usuario'],$_SESSION['password']);
} 

// verificamos si esta logeado
if (empty($arr_usuarios)) {
	header( 'Location: ../ingresar.php' );
	die;
}
if ($_SESSION['usuario']!='admin') {
	header( 'Location: ../index.php' );
	die;
}

if (empty($_POST['mes'])) {

		$nombre_mes=codificar_mes(date("m"));
		$nombre_ano=date("Y");
		$arr_comercios=$obj->informes(date("m"), date("Y"));

} else {

		$nombre_mes=codificar_mes($_POST['mes']);
		$nombre_ano=$_POST['ano'];
		$arr_comercios=$obj->informes($_POST['mes'], $_POST['ano']);

}

?>
<!DOCTYPE html>
<html lang="es">
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<title>Registro de Cuenta Lanpass</title>
    <link rel="stylesheet" href="../css/grilla.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="../css/page.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="../fuentes/fuente.css" type="text/css" media="screen" charset="utf-8">
    
    <script type="text/javascript" src="../js/CreateHTML5Elements.js"></script>
    <script src="../js/jquery-1.6.4.min.js"></script>
    <script type="text/javascript" src="../js/form-validation.js"></script>
    <script type="text/javascript" src="../js/consultas.js"></script>
    
    <script language="javascript">
	$(document).ready(function() {
		$(".botonExcel").click(function(event) {
			$("#datos_a_enviar").val( $("<div>").append( $("#mostrar_informe").eq(0).clone()).html());
			$("#FormularioExportacion").submit();
	});
	});
	</script>    
  </head>
  
  <body>
	<div id="wrapper" class="wrapper">
    	<header>
        	<img src="../imagenes/aqui-acumulas-kms-lanpass.jpg" width="231" height="89" alt="La Barraca Mall" id="logo_la-barraca">
            <img src="../imagenes/logo_lanpass.png" width="132" height="46" alt="lanpass" id="logo_lanpass"/>  
            <div class="usuario">
            	<p><? echo utf8_encode($_SESSION['usuario']) ?></p>
                <a href="index.php?salir=true">cerrar sesión</a>
            </div>
        </header>

        
        
        
        
        
        <div id="ayuda" class="inner-wrapper">
        
			<hgroup>
                <h1>CENTRAL DE INFORMES</h1>
                <h2>Consultas mensuales por hotel</h2>
            </hgroup>
            
          <div class="ten-col consultas prefix-one">
            				<form id="frm_filtro" method="post" action="index.php" >
                            
                                <select name="mes" tabindex="2">
                                  <option value="">Seleccione un Mes</option>
                                  <option value="01">Enero</option>
                                  <option value="02">Febrero</option>
                                  <option value="03">Marzo</option>
                                  <option value="04">Abril</option>
                                  <option value="05">Mayo</option>
                                  <option value="06">Junio</option>
                                  <option value="07">Julio</option>
                                  <option value="08">Agosto</option>
                                  <option value="09">Septiembre</option>
                                  <option value="10">Octubre</option>
                                  <option value="11">Noviembre</option>
                                  <option value="12">Diciembre</option> 
                                </select>     
								
                                <select name="ano" tabindex="2">
                                  <option value="2013">2013</option>
                                  <option value="2014">2014</option>
                                  <option value="2015">2015</option>
                                  <option value="2016" selected>2016</option> 
                                </select>
                                
                              	<button type="submit" name="submit" class="button">INFORMAR</button>

                            </form>
         		<div style="clear:both"></div>
                
                
                <h3 class="titulo_informes">Canjes acumulados x comercio para el mes de <strong><? echo $nombre_mes ?> de <? echo $nombre_ano ?></strong> <br>
<em style="font-size:16px;">(Cierre de período: 26 de <? echo $nombre_mes ?> de <? echo $nombre_ano ?>)</em></h3>
				<br>
                <form action="../library/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
                    <p>Exportar esta tabla a formato Excel  <img src="../imagenes/export_to_excel.gif" class="botonExcel" /></p>
                <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                </form>
                <br><br><br>
           	  	<table border="0" cellspacing="0" cellpadding="0" id="mostrar_informe" class="tabla">  
                	<tr>
                        <td class="titulo_tabla"></td>
                        <td class="titulo_tabla">COMERCIO</td>
                    	<td class="titulo_tabla">FECHA DE CANJE</td>
                        <td class="titulo_tabla">NOMBRE</td>
                        <td class="titulo_tabla">APELLIDO</td>
                        <td class="titulo_tabla">DOCUMENTO</td>
                        <td class="titulo_tabla" width="140">IMPORTE CANJEADO</td>
                        <td class="titulo_tabla">KM</td>
                    </tr>
                    
                    <? 	
						$cont=0;
						
						while ($comercios = $obj->resultados($arr_comercios)){ 

							
							// CALCULO LOS KILOMETROS A ACUMULAR
							$fecha_operacion = str_replace('/','-',$comercios['rg_fecha_canje']);
							
							$fecha_cotiz = date("Y-m-d", strtotime("$fecha_operacion -1 day")); 
							$cotiz_dolar = $obj->calculo_km($fecha_cotiz);
							$cotiz_dolar = $obj->resultados($cotiz_dolar);
							
							$valor_dolar = $cotiz_dolar['cot_valor'];
							
							$menos=-2;
							
							while (empty($valor_dolar)) {

								$fecha_cotiz = date("Y-m-d", strtotime("$fecha_operacion ".$menos." day")); 
								$cotiz_dolar = $obj->calculo_km($fecha_cotiz);
								$cotiz_dolar = $obj->resultados($cotiz_dolar);
								
								$valor_dolar = $cotiz_dolar['cot_valor'];
								
								$menos-=1;
								
							}
							
		
							$dolarizacion = $comercios['rg_importe_pesos'] / $valor_dolar;						
							$kms = round ($dolarizacion * $comercios['tasa_acum']);
							$kms_acumulados += $kms;
							
							$cont++;
							$total += $comercios['rg_importe_pesos'];
							
							?> 
                            
							<? if ($cambia_comercio!=$comercios['nombre-login'] and !empty($cambia_comercio)) { // TOTALES POR COMERCIO ?>	
                                    <tr class="fila_destacada">
                                        <td class="celda_destacada_negro" colspan="6"><? echo utf8_encode($cambia_comercio); ?></td>
                                    	<td class="celda_destacada_negro">$ <? echo $total_parcial; ?></td>
                                    	<td class="celda_destacada_negro"><? echo $kms_parciales; ?></td>
                                    </tr>
                                    <? 	$total_parcial = 0; 
										$kms_parciales = 0 ?>
                            <? } ?>
                            
                                <tr class="fila">
                                    <td class="celda"><? echo $cont; ?></td>
                                    <td class="celda"><? echo utf8_encode($comercios['nombre-login']); ?></td>
                                    <td class="celda"><? echo $comercios['rg_fecha_canje']; ?></td>
                                    <td class="celda"><? echo utf8_encode($comercios['rg_nombre']); ?></td>
                                    <td class="celda"><? echo utf8_encode($comercios['rg_apellido']); ?></td>
                                    <td class="celda"><? echo $comercios['rg_numero_documento']; ?></td>
                                    <td class="celda"><? echo $comercios['rg_importe_pesos']; ?></td>
                                    <td class="celda"><? echo $kms; ?></td>
                                </tr>
                        	
                            <? 	$cambia_comercio = $comercios['nombre-login']; 
								$total_parcial += $comercios['rg_importe_pesos'];
								$kms_parciales += $kms; ?>
                            
                    	<? } ?><!--FIN WHILE -->
                           			 <tr class="fila_destacada">
                                        <td class="celda_destacada_negro" colspan="6"><? echo utf8_encode($cambia_comercio); ?></td>
                                    	<td class="celda_destacada_negro">$ <? echo $total_parcial; ?></td>
                                    	<td class="celda_destacada_negro"><? echo $kms_parciales; ?></td>
                                    </tr>
                                
                    <tr class="fila">
                    	<td class="celda" colspan="6"></td>
                        <td class="celda_destacada">$ <? echo $total; ?></td>
                        <td class="celda_destacada"><? echo $kms_acumulados; ?></td>
                   	</tr>
                </table>

				<form action="../library/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
                    <p>Exportar esta tabla a formato Excel  <img src="../imagenes/export_to_excel.gif" class="botonExcel" /></p>
                <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                </form>
                <br><br><br>

          </div><!-- Fin contenido socios -->
    	</div><!-- Fin inner-wrapper -->
        
        <footer>
        </footer>
   	</div>
        
  </body>
</html>
