<?php
// iniciamos session
session_start ();

require('clases/comercio.class.php');

$objComercio=new login;
$obj=new comercio;
$arr_paises = $obj->paises();
$arr_paises2 = $obj->paises();
$arr_paises3 = $obj->paises();
$arr_paises4 = $obj->paises();

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
	header( 'Location: ingresar.php' );
	die;
}

if ($_SESSION['usuario']=='admin') {
	header( 'Location: admin/index.php' );
	die;
}

$datos_comercio = $obj->datos($_SESSION['usuario'])

?>
<!DOCTYPE html>
<html lang="es">
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<title>Lanpass Hoteles</title>
    <link rel="stylesheet" href="css/grilla.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/page.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="fuentes/fuente.css" type="text/css" media="screen" charset="utf-8">
    
    <script type="text/javascript" src="js/CreateHTML5Elements.js"></script>
    <script src="js/jquery-1.6.4.min.js"></script>
    <script type="text/javascript" src="js/form-validation.js"></script>
    <script type="text/javascript" src="js/consultas.js"></script>
    
    <script type="text/javascript">
			$(document).ready(function(){
			
				// filtrar por mes
				$("#btnfiltrar").click(function(){ filtrar('<? echo $_SESSION['usuario'] ?>') });
				// filtrar por dni
				$("#btnfiltrardni").click(function(){ filtrar_documento('<? echo $_SESSION['usuario'] ?>') }); 

			});
			
	</script>
        
  </head>
  
  <body>
	<div id="wrapper" class="wrapper">
    	<header>
        	<img src="imagenes/aqui-acumulas-kms-lanpass.jpg" width="231" height="89" alt="La Barraca Mall" id="logo_la-barraca">
            <img src="imagenes/logo_lanpass.png" width="132" height="46" alt="lanpass" id="logo_lanpass"/>  
            <div class="usuario">
            	<p><? echo utf8_encode($_SESSION['nombre-login']) ?></p>
                <a href="index.php?salir=true">cerrar sesión</a>
            </div>
        </header>
        <nav>
       	  <ul id="menu">
            	<li class="three-col active"><a href="#socios"><span>SOCIOS LANPASS</span><img src="imagenes/icono_km.png" width="62" height="60"></a></li>
            	<li class="three-col"><a href="#no_socios"><span>NO SOCIOS</span><img src="imagenes/icono_registro_socios.png" width="62" height="60"></a></li>
       			<li class="three-col"><a href="#consultas"><span>CONSULTAS</span><img src="imagenes/icono_datos.png" width="54" height="60"></a></li>
                <li class="three-col last-col"><a href="#ayuda"><span>AYUDA</span><img src="imagenes/icono_ayuda.png" width="55" height="60"></a></li>
			</ul>
        </nav>
        
        
        <div id="socios" class="inner-wrapper">
        
			<hgroup>
                <h1>CANJE DE KMS. PARA <strong>SOCIOS LANPASS</strong></h1>
                <h2>Complete los siguientes datos:</h2>
            </hgroup>
            
          <div class="seven-col prefix-one">

           	  <form action="" method="post" id="form_carga_km">
              				
                            <div class="bloque-datos"><h3>Datos personales.</h3></div>
                            
                            
							<label for="primer_nombre">Nombre<span id="error_nombre" class="warning"></span></label>
                <input name="primer_nombre" id="primer_nombre" class="largo" type="text" value=""/>
                            
                            <label for="apellido">Apellido<span id="error_apellido" class="warning"></span></label>
                <input name="apellido" id="apellido" class="largo" type="text" value="" />
                            
                            <label for="nacionalidad">Nacionalidad</label>
                          
							<select name="nacionalidad" id="nacionalidad" >
								<? while ($paises = $obj->resultados($arr_paises)){ ?>
                                <option value="<? echo $paises['pa_id']; ?>" <? if ($paises['pa_id']=='ARGENTINA') echo 'selected="selected"'; ?>><? echo utf8_encode($paises['pa_nombre']); ?></option>
                                <? } ?>
							</select>
    
    
                            <label for="num_documento">Número de Documento<span id="error_documento" class="warning"></span></label>
                <input name="num_documento" id="num_documento" class="largo" type="text" value="" />
                            
                            
                            <label for="numero_lanpass">Número de Socio Lanpass <strong>(Opcional)</strong></label>
                <input name="numero_lanpass" id="numero_lanpass" class="largo" type="text" value="" />
                            
                            <div class="bloque-datos"><h3>Datos del canje de KMS.</h3></div>
                            
                            
                            <label for="importe_pesos">Monto consumido (en <?php 
							
							switch ($datos_comercio["moneda_consumo"]) {
								case 'peso':
									echo 'Pesos';
									break;
								case 'dolar':
									echo 'Dólares';
									break;
							}; ?>)<span id="error_importe" class="warning"></span></label>
                <input name="importe_pesos" id="importe_pesos" type="text" value="" maxlength="5" size="5"/>, <input name="importe_cent" id="importe_cent" type="text" value="00" maxlength="2" size="2"/>
                            
                            <input type="hidden" value="<? echo utf8_encode($_SESSION['usuario']) ?>" name="comercio" id="comercio" />
                            <input type="hidden" value="insertar-datos-socios.php" name="send-socios" id="send-socios" />
                            <br><br><br>
                            <p><button type="button" name="submit" id="submit" class="button">ENVIAR</button></p>
                    </form>
					<div id="sent-form-msg"><p class="success"><img src="imagenes/carga-ok.jpg" width="57" height="43" alt="Kms canjeados"> LISTO!!!<br>
<br>
El canje de KMS. fue realizado correctamente.</p><br><br>
                    	<a href="index.php" class="button">NUEVO CANJE</a>
                    </div>
                    

          </div><!-- Fin contenido socios -->
            
	  		<div class="four-col last-col lateral"> 
            	<img src="imagenes/atencion.png" width="48" height="48" alt="Atencion" id="atencion">
           	  	<h3>Soporte Técnico</h3><br>
                <p>Si tenes algún inconveniente en la carga de datos o tenes alguna sugerencia para la plataforma, podes comunicarte con el soporte técnico vía mail a: <strong><a href="mailto:soporte.lanpass@foconetworks.com">soporte.lanpass@foconetworks.com</a></strong>,<br> 
                por vía telefónica al <strong>(011) 4771-3006</strong>,<br> o a traves del siguiente formulario de contacto:</p>
                <div class="contact_form">
                    <form id="contactForm" action="#" method="post" >
                        
                                <label for="nombre">Usuario</label><br />
                                <input name="nombre" id="nombre" type="text" value="<? echo utf8_encode($_SESSION['nombre-login']) ?>" />
    
                                <label for="mail">Mail</label><span id="error" class="warning"></span><br />
                                <input name="mail" id="mail" type="text" value="" />
    
                                <label for="mensaje">Mensaje</label><br />
                                <textarea name="mensaje" id="mensaje" type="text" value=""></textarea>
                            
                            	<!-- send mail configuration -->
                                <input type="hidden" value="mpandelo@foconetworks.com" name="to" id="to" />
                                <input type="hidden" value="Mensaje HOTELES LANPASS - Plataforma Lanpass" name="subject" id="subject" />
                                <input type="hidden" value="send-mail.php" name="sendMailUrl" id="sendMailUrl" />
                                <!-- ENDS send mail configuration -->
                                
                                <div class="btn"><input type="button" value="ENVIAR MAIL" name="submit" id="submit" /></div>
                        </form>
                        <p id="sent-form-mail" class="success">Su consulta fue enviada. A la brevedad responderemos su email.</p>
                    </div>
       	  	</div><!-- Fin lateral -->
            
    	</div><!-- Fin inner-wrapper -->
        
        
        <div id="no_socios" class="inner-wrapper">
            <hgroup>
                <h1>CANJE DE KMS. PARA <strong>NO SOCIOS LANPASS</strong></h1>
                <h2>Complete los siguientes datos:</h2>
            </hgroup>
            
			<div class="seven-col prefix-one">
           	  <form action="" method="post" id="form_carga_km_no_socios">
              
              				<div class="bloque-datos"><h3>Datos personales.</h3></div>
                            
							<label for="NSprimer_nombre">Nombre<span id="error_nombreNS" class="warning"></span></label>
                <input name="NSprimer_nombre" id="NSprimer_nombre" class="largo" type="text" value=""/>
                            
                            <label for="NSapellido">Apellido<span id="error_apellidoNS" class="warning"></span></label>
                <input name="NSapellido" id="NSapellido" class="largo" type="text" value="" />
                            
                            <label for="NSnacionalidad">Nacionalidad</label>
                            <select name="NSnacionalidad" id="NSnacionalidad" >
								<? while ($paises = $obj->resultados($arr_paises2)){ ?>
                                <option value="<? echo $paises['pa_id']; ?>" <? if ($paises['pa_id']=='ARGENTINA') echo 'selected="selected"'; ?>><? echo utf8_encode($paises['pa_nombre']); ?></option>
                                <? } ?>
							</select>
                            
                <label for="NSfecha_nac">Fecha de Nacimiento <strong>(con formato: dd/mm/yyyy)</strong><span id="error_fecha_nacNS" class="warning"></span></label>
                <input name="NSfecha_nac" id="NSfecha_nac" type="text" value="" maxlength="10" size="10" />
							
                            <label for="NStipo_documento">Tipo de Documento</label>
<select name="NStipo_documento" id="NStipo_documento" >
                                                <option value="DNI" selected="selected" >DNI</option>
                                                <option value="LC">LC</option>
                                                <option value="LE">LE</option>
                                                <option value="PASAPORTE">Pasaporte</option>
                                                <option value="OTRO">Otro</option>
                            </select>
							
                            <label for="NSnum_documento">Numero de Documento<span id="error_documentoNS" class="warning"></span></label>
                <input name="NSnum_documento" id="NSnum_documento" class="largo" type="text" value="<? echo $_POST['num_documento']; ?>" />
                            
                            <label for="NSpais_documento">País del Documento</label>
                            <select name="NSpais_documento" id="NSpais_documento" >
								<? while ($paises = $obj->resultados($arr_paises3)){ ?>
                                <option value="<? echo $paises['pa_id']; ?>" <? if ($paises['pa_id']=='AR') echo 'selected="selected"'; ?>><? echo utf8_encode($paises['pa_nombre']); ?></option>
                                <? } ?>
							</select>
                            
                            <label for="NSmail">Correo Electronico<span id="error_mailNS" class="warning"></span></label>
                <input name="NSmail" id="NSmail" class="largo" type="text" value="" />
                
                            <div class="bloque-datos"><h3>Datos de residencia.</h3></div>
                            
                            <label for="NSdireccion">Dirección<span id="error_direccionNS" class="warning"></span></label>
                <input name="NSdireccion" id="NSdireccion" class="largo" type="text" value="" />
                			
                            <label for="NSlocalidad">Localidad<span id="error_localidadNS" class="warning"></span></label>
                <input name="NSlocalidad" id="NSlocalidad" class="largo" type="text" value="" />
                
                			<label for="NSprovincia">Provincia/Estado<span id="error_provinciaNS" class="warning"></span></label>
                <input name="NSprovincia" id="NSprovincia" class="largo" type="text" value="" />
                
                			<label for="NSpais">País de Residencia</label>
                            <select name="NSpais" id="NSpais" >
								<? while ($paises = $obj->resultados($arr_paises4)){ ?>
                                <option value="<? echo $paises['pa_id']; ?>" <? if ($paises['pa_id']=='AR') echo 'selected="selected"'; ?>><? echo utf8_encode($paises['pa_nombre']); ?></option>
                                <? } ?>
							</select>
                            
                            <label for="NScodigo_postal">Código Postal<span id="error_codigo_postalNS" class="warning"></span></label>
                <input name="NScodigo_postal" id="NScodigo_postal" class="largo" type="text" value="" />
                            
                
                			<div class="bloque-datos"><h3>Datos del canje de KMS.</h3></div>  
    
                            
                            <label for="NSimporte_pesos">Monto consumido (<?php 
							
							switch ($datos_comercio["moneda_consumo"]) {
								case 'peso':
									echo 'Pesos';
									break;
								case 'dolar':
									echo 'Dólares';
									break;
							}; ?>)<span id="error_importeNS" class="warning"></span></label>
                <input name="NSimporte_pesos" id="NSimporte_pesos" type="text" value="" maxlength="5" size="5"/>, <input name="NSimporte_cent" id="NSimporte_cent" type="text" value="00" maxlength="2" size="2"/>
                            
                            <input type="hidden" value="<? echo utf8_encode($_SESSION['usuario']) ?>" name="NScomercio" id="NScomercio" />
                            <input type="hidden" value="insertar-datos-no-socios.php" name="send-no-socios" id="send-no-socios" />
                            <br><br><br>
                            <p><button type="button" name="submit" id="submit" class="button">ENVIAR</button></p>
                    </form>
					<div id="sent-form-msgNS"><p class="success"><img src="imagenes/carga-ok.jpg" width="57" height="43" alt="Kms canjeados"> LISTO!!!<br>
<br>
El canje de KMS. fue realizado correctamente.</p><br><br>
                    	<a href="index.php" class="button">NUEVO CANJE</a>
                    </div>
                    
          </div><!-- Fin contenido socios -->
            
	  		<div class="four-col last-col lateral"> 
            	<img src="imagenes/atencion.png" width="48" height="48" alt="Atencion" id="atencion">
           	  	<h3>Soporte Técnico</h3><br>
                <p>Si tenes algún inconveniente en la carga de datos o tenes alguna sugerencia para la plataforma, podes comunicarte con el soporte técnico vía mail a:<strong><a href="mailto:soportelanpass@foconetworks.com">soporte.lanpass@foconetworks.com</a></strong>,<br>
por vía telefónica al <strong>(011) 4771-3006</strong>,<br> o a traves del siguiente formulario de contacto:</p>
                <div class="contact_form">
          <form id="contactForm2" action="#" method="post" >
                        
                                <label for="nombre2">Usuario</label><br />
                                <input name="nombre2" id="nombre2" type="text" value="<? echo utf8_encode($_SESSION['nombre-login']) ?>" />
    
                                <label for="mail2">Mail</label><span id="error2" class="warning"></span><br />
                                <input name="mail2" id="mail2" type="text" value="" />
    
                                <label for="mensaje2">Mensaje</label><br />
                                <textarea name="mensaje2" id="mensaje2" type="text" value=""></textarea>
                            
                            	<!-- send mail configuration -->
                                <input type="hidden" value="mpandelo@foconetworks.com" name="to2" id="to2" />
                                <input type="hidden" value="Mensaje HOTELES LANPASS - Plataforma Lanpass" name="subject2" id="subject2" />
                                <input type="hidden" value="send-mail.php" name="sendMailUrl2" id="sendMailUrl2" />
                                <!-- ENDS send mail configuration -->
                                
                                <div class="btn"><input type="button" value="ENVIAR MAIL" name="submit" id="submit" /></div>
                        </form>
                        <p id="sent-form-mail2" class="success">Su consulta fue enviada. A la brevedad responderemos su email.</p>
                    </div>
       	  	</div><!-- Fin lateral -->
    	</div><!-- Fin inner-wrapper -->
        
        
        
        <div id="consultas" class="inner-wrapper">
        
			<hgroup>
                <h1>CONSULTAS / INFORMES</h1>
                <h2>Aquí podrá consultar sobre datos cargados</h2>
            </hgroup>
            
          <div class="ten-col consultas prefix-one">
            				<form id="frm_filtro" method="post" action="" >
                            
                                <select name="mes" tabindex="2">
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
                                  <option value="2014" <? if (date("Y")==2014) {echo "selected";} ?> >2014</option> 
                                  <option value="2015" <? if (date("Y")==2015) {echo "selected";} ?> >2015</option> 
                                  <option value="2016" <? if (date("Y")==2016) {echo "selected";} ?> >2016</option> 
                                </select>     

                              <button type="button" id="btnfiltrar" class="button">LISTAR X MES</button>

                            </form>​​
                            
                            
                            
                            <form id="frm_filtro_dni" method="post" action="" >
                            
                                <input name="documento" type="text" value=""/>   

                              <button type="button" id="btnfiltrardni" class="button">BUSCAR X DOCUMENTO</button>

                            </form>​​
                                       
                <div style="clear:both;"></div>
                <h2>Los períodos mensuales tienen cierre el día 25 de cada mes, es decir, las cargas entre los días 26 al 31 de cada mes serán computadas para el mes siguiente.<br><br>
</h2>
                     
           	  	<table border="0" cellspacing="0" cellpadding="0" id="mostrar_consultas" class="tabla">
                  
                </table>

                    
          </div><!-- Fin contenido socios -->
            
    	</div><!-- Fin inner-wrapper -->
        
        
        
        <footer>
	    	
        </footer>
   	</div>
    
    	<script src="js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.tabify.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			// <![CDATA[
				
			$(document).ready(function () {
				$('#menu').tabify();
			});
					
			// ]]>
		</script>
        
  </body>
</html>
