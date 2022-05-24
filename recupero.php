<?php



// iniciamos sesiones

session_start ();



// archivos necesarios

require_once 'includes/config.php';

require_once 'includes/conexion.php';



// obtengo puntero de conexion con la db

$dbConn = conectar();

require_once 'includes/admin.class.php';

$recup=new recuperarpass;

if (!empty($_POST['submitrecup2']) ){
    $errorrecup=$recup->recuppass2();
    if ($errorrecup == 1) {
      $mensajerecup_ok = 'Se actualizo la contraseña correctamente.';
    }
    else {
      $mensajerecup_err = 'El link para actualizar la contraseña ha caducado.';
    }
  }

?>


<!DOCTYPE html>
<html lang="en">

<? require_once 'header.php'; ?>

<!-- Abrir el modal apenas entramos a la web. -->

<!--<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>-->

<body>
    <!-- Page Content -->
    
 <section id="login">
    <div class="container">
    	<div class="row">
        
            <div class="col-md-6 vdivide">
            <h4 class="login">¿Que es el Círculo Parmegiano?<hr class="linea"></h4>
            <p class="login">
              Bienvenido al Círculo Parmegiano, El Programa de Recompensas de el Parmegiano. Asociate Gratis, Acumulá 1 punto por cada peso consumido y canjealo por premios y beneficios.
            </p>
            <!--<ul class="login">
            <li>300 puntos de regalo por asociarte</li>
            <li>Copa de espumante de bienvenida, hasta 4 personas (Nivel Gold)</li>
            <li>Upgrade de vinos (Nivel Gold)</li>
            <li>En grupos de 8 personas 1 es invitado (Nivel Platinum)</li>
            <li>Salon Pampa para eventos con capacidad maxima de 80 personas Sin Cargo. Minimo requerido 20 personas (Nivel Platinum)</li>
            <li>Cata de vinos para 6 personas 40% descuento (Nivel Platinum)</li>
            <br>
            </ul>-->
            </div>
            <div class="col-md-6">
            <h4 class="login">LOGIN<hr class="linea"></h4>
            <form action="" method="post" class="form-horizontal login">
            <fieldset>
            
            <!-- Form Name -->
            
            
            
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="fn">N° de Socio:</label>  
              <div class="col-md-4">
              <input id="fn" name="usuario" type="text" class="form-control input-md" autocomplete="off" value="<?php echo $_GET['dni'] ?>" readonly required>
              </div>
            </div>
            
            <!-- Text input-->
            <p>Por favor, ingresa una nueva contraseña</p>
            <div class="form-group">
              <label class="col-md-4 control-label" for="ln">Nueva Contraseña:</label>  
              <div class="col-md-4">
              <input id="ln" name="password" type="password" placeholder="Contraseña" class="form-control input-md" autocomplete="off" required>
              </div>
				<input type="hidden" id="code" name="code" value="<?php echo $_GET['code'] ?>">
                <div class="col-md-4">
               <button id="submit" name="submitrecup2" class="btn btn-success" value="login">CONFIRMAR</button>
              </div>
            </div>
			
            </fieldset>
            </form>
            <div class="errlogin">
             <? if (!empty($errorlogin)) { ?>

					<br>

						<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i> <?= $errorlogin ?>
            </div>
			<? } ?>
            </div>
            <div>
            
                    <? if ((!empty($mensajesoc_ok)) or (!empty($mensajesocerr))) {
                ?>
            <br>
            <?
            if (!empty($mensajesoc_ok)) { ?>       
						<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i><? echo $mensajesoc_ok ?></div>

            <? } 
					  if (!empty($mensajesocerr)) { ?>       
            <div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i><? echo $mensajesocerr ?></div>
              <? } ?>

					<? } ?>
          <div>
            
                    <? if ((!empty($mensajerecup_ok)) or (!empty($mensajerecup_err))) {
                ?>
            <br>
            <?
            if (!empty($mensajerecup_ok)) { ?>       
            <div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i><? echo $mensajerecup_ok ?></div>

            <? } 
            if (!empty($mensajerecup_err)) { ?>       
            <div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i><? echo $mensajerecup_err ?></div>
              <? } ?>

          <? } ?>
            </div>
            </div>
            <div>
            <br>
            <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal">¿No sos Socio? ... Inscribite!</button>
            <button type="button" class="btn btn-success btn-md pull-right" data-toggle="modal" data-target="#myModal2">Recuperar Contraseña</button>
                        <!-- Modal -->
              <div class="modal right fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                    	<div class="container-fluid">
                    		<div class="row">
                            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">YA SOY SOCIO</button>
                            </div>
                        </div>  
                    <form class="form-horizontal" method="post">
                    <fieldset>
                    
                    <!-- Form Name -->
                    <h4 class="text-center">Inscripción de Socios<hr class="linea"></h4>
                    
                    <!--<h4>Datos Obligatorios<hr class="linea"></h4>-->
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="dni">DNI:</label>  
                      <div class="col-md-4">
                      <input id="dni" name="dni" type="text" placeholder="DNI" class="form-control input-md" required>
                      </div>
                      <div class="col-md-4">
                      <label class="control-label">(N° de Socio)</label>
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="apellido">Apellido:</label>  
                      <div class="col-md-4">
                      <input id="apellido" name="apellido" type="text" placeholder="Apellido" class="form-control input-md" required>
                        
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="nombre">Nombre:</label>  
                      <div class="col-md-4">
                      <input id="nombre" name="nombre" type="text" placeholder="Nombre" class="form-control input-md" required>
                        
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="mail">Mail:</label>  
                      <div class="col-md-4">
                      <input id="mail" name="mail" type="mail" placeholder="Mail" class="form-control input-md" required>
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="password">Contraseña:</label>  
                      <div class="col-md-4">
                      <input id="password" name="password" type="password" placeholder="Contraseña" class="form-control input-md" required>
                        
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label" for="fechanac">Fecha de Nacimiento:</label>  
                      <div class="col-md-4">
                      <input type="date" name="fechanac" class="form-control input-md" id="fecha" placeholder="Fecha de Nacimiento">
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="telefono">Teléfono:</label>  
                      <div class="col-md-4">
                      <input id="telefono" name="telefono" type="text" placeholder="Cod. de área y sin 15" class="form-control input-md" required>
                        
                      </div>
                    </div>
                    <!-- Text input-->
                    <!--<div class="form-group">
                      <label class="col-md-4 control-label" for="genero">Género:</label>
                      <div class="col-md-4"> 
                        <label class="radio-inline" for="Training-0">
                          <input type="radio" name="genero" id="Training-0" value="F">
                          F
                        </label> 
                        <label class="radio-inline" for="Training-1">
                          <input type="radio" name="genero" id="Training-1" value="M">
                          M
                        </label>
                      </div>
                    </div>-->
                    <!-- Text input-->
                    <!--<div class="form-group">
                      <label class="col-md-4 control-label" for="domicilio">Domicilio:</label>  
                      <div class="col-md-4">
                      <input id="domicilio" name="domicilio" type="text" placeholder="Domicilio" class="form-control input-md" required>
                        
                      </div>
                    </div>-->
                    <!--<div class="form-group">
                      <label class="col-md-4 control-label" for="ciudad">Provincia:</label>  
                      <div class="col-md-4">
                      <select id="ciudad" name="ciudad" class="form-control input-md">
                      	<option value="CABA">CABA</option>
  						<option value="GBA Norte">GBA Norte</option>
  						<option value="GBA Oeste">GBA Oeste</option>
  						<option value="GBA Sur">GBA Sur</option>
                        <option value="Buenos Aires">Buenos Aires</option>
                        <option value="Catamarca">Catamarca</option>
          				<option value="Chaco">Chaco</option>
          				<option value="Chubut">Chubut</option>
          				<option value="Cordoba">Cordoba</option>
          				<option value="Corrientes">Corrientes</option>
          				<option value="Entre Rios">Entre Rios</option>
                        <option value="Formosa">Formosa</option>
                        <option value="Jujuy">Jujuy</option>
                        <option value="La Pampa">La Pampa</option>
                        <option value="La Rioja">La Rioja</option>
                        <option value="Mendoza">Mendoza</option>
                        <option value="Misiones">Misiones</option>
                        <option value="Neuquen">Neuquen</option>
                        <option value="Rio Negro">Rio Negro</option>
                        <option value="Salta">Salta</option>
                        <option value="San Juan">San Juan</option>
                        <option value="San Luis">San Luis</option>
                        <option value="Santa Cruz">Santa Cruz</option>
                        <option value="Santa Fe">Santa Fe</option>
                        <option value="Sgo. del Estero">Sgo. del Estero</option>
                        <option value="Tierra del Fuego">Tierra del Fuego</option>
                        <option value="Tucuman">Tucuman</option>-->
                      <!--<input id="ciudad" name="ciudad" type="text" placeholder="Ciudad" class="form-control input-md" required>-->
                      <!--</select>  
                      </div>
                    </div>-->
                    
                    <div class="form-group">
                    <label class="col-md-8 control-label" for="terminos-condiciones">
                      <input type="checkbox" name="terms" value="terms" checked> 
                      <!--<a type="button" data-toggle="modal" data-target="#myModal3">-->Acepto términos y condiciones<!--</a>-->
                      
                    </label>
                    </div>  
                    
                    <!-- Button -->
                    <div class="form-group">
                      
                      <div class="col-md-12">
                        <button id="submit" name="submitins" class="btn btn-success pull-right" value="submitins">ACEPTAR</button>
                      </div>
                    </div>
                    </fieldset>
                    </form>
                  </div>
                  
                </div>
              </div>
            </div>
            <div class="modal right fade" id="myModal2" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      
                    <form class="form-horizontal" method="post">
                    <fieldset>
                    
                    <!-- Form Name -->
                    <h4 class="text-center">Recuperar Contraseña<hr class="linea"></h4>
                    
                    <!--<h4>Datos Obligatorios<hr class="linea"></h4>-->
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="dni">DNI:</label>  
                      <div class="col-md-4">
                      <input id="dni" name="dni" type="text" placeholder="DNI" class="form-control input-md" required>
                      </div>
                      <div class="col-md-4">
                      <label class="control-label">(N° de Socio)</label>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="mail">Mail:</label>  
                      <div class="col-md-4">
                      <input id="mail" name="mail" type="mail" placeholder="Mail" class="form-control input-md" required>
                        
                      </div>
                    </div>
                   
                      
                      <div class="col-md-12">
                        <button id="submit" name="submitrecup" class="btn btn-success pull-right" value="submitrecup">ACEPTAR</button>
                      </div>
                    </div>
                    </fieldset>
                    </form>
                  </div>
                  
                </div>
              </div>
            </div>

		</div>
</div>
</div>
<div class="modal left fade" id="myModal3" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-body">
                            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">CERRAR</button>
                              <div class="col-xs-12">
                            
                                  <h6 class="terms">
                                  A – PARTICIPACION EN EL PROGRAMA:
                                  </h6>
                                  <h6 class="terms">
1.- “LA CABAÑA REWARDS” es un programa de incentivo y beneficios (en adelante, el “Programa”) en el que, sujeto a los términos y condiciones que se establecen en las presentes bases (en adelante “las Bases”), podrán participar aquellas personas físicas clientes de LA CABAÑA que cumplan con la totalidad de los requisitos aquí estipulados. Las presentes Bases tendrán vigencia desde el día 15 de agosto de 2017.</h6>
<h6 class="terms">
2.- Participan en el Programa los Clientes, en adelante “el/os Cliente/s o el/os Participante/s” en forma indistinta, que se inscriban en el Programa por su cuenta o bien que soliciten al personal de La Cabaña, ser inscriptos.</h6>
<h6 class="terms">
3.- Los Clientes podrán acumular puntos (en adelante “el/os Punto/s” según corresponda) para la obtención de los Premios indicados en el punto “D- Premios - Canje de Puntos por Premios“ de éstas Bases.</h6>
<h6 class="terms">
4.- Los Puntos se acumulan por consumos en una única cuenta del socio del Programa, siendo el Número de Socio, el mismo número que el DNI del cliente.</h6>
<h6 class="terms">
5.- El Cliente podrá solicitar su baja del Programa en cualquier momento, debiendo notificar su decisión por un medio fehaciente a LA CABAÑA con una antelación mínima de 30 (treinta) días corridos a la fecha de baja. La solicitud de baja del Programa determinará - en forma automática - la exclusión del Cliente del Programa y la pérdida de la totalidad de los Puntos acumulados.</h6>
<h6 class="terms">
6.- La vigencia del Programa será desde del 15/08/2017 y estará vigente hasta tanto LA CABAÑA comunique su finalización, mediante comunicación efectuada desde el sitio web del Programa.</h6>
<h6 class="terms">
B – CAMBIO DE CONDICIONES PACTADAS:</h6>
<h6 class="terms">
7.- LA CABAÑA podrá en cualquier momento disponer o promover cambios sobre las condiciones establecidas en la presente, como así también podrá determinar a su exclusivo criterio la extinción del Programa.</h6>
<h6 class="terms">
8.- El objeto del Programa podrá ser modificado en la medida que la modificación no lo desnaturalice o altere.</h6>
<h6 class="terms">
C – ACUMULACION Y PÉRDIDA DE PUNTOS:</h6>
<h6 class="terms">
9.- Los Clientes acumularán puntos (en adelante, el/los Punto/s), de acuerdo con las siguientes pautas. La acumulación de Puntos se generará por el consumo de bienes y/o servicios realizados en LA CABAÑA.</h6>
<h6 class="terms">
10.- A cada cliente se les otorgarán 300 puntos de bienvenida al inscribirse en el programa.</h6>
<h6 class="terms">
11.- Luego de ello, se acumularán 1 (un) Punto por cada $ 20 (PESOS VEINTE) correspondiente a consumos efectuados por comidas y bebidas en LA CABAÑA, con excepción de los consumos correspondientes a menúes promocionadas, Alquileres de salones privados, consumos realizados con descuentos especiales (Club La Nación, Restorando, etc).</h6>
<h6 class="terms">
12.- LA CABAÑA podrá deducir cualquier Punto acreditado por error y cualquier Punto relacionado con una contratación que fuera cancelada o dejada sin efecto, así como cualquier Punto obtenido contrariando los Términos y Condiciones del Programa, o cuando el Cliente hubiera obrado con mala fe.</h6>
<h6 class="terms">
13.- Los Puntos no podrán venderse, ni transferirse, ni cederse o de cualquier otra forma negociarse o a favor de terceros ajenos al Programa. Los Puntos no tienen valor monetario alguno y no podrán ser canjeados en ningún caso por dinero.</h6>
<h6 class="terms">
14.- Los puntos obtenidos en el Programa tienen el carácter de Personal e Intransferible.</h6>
<h6 class="terms">
15.- Los Puntos generados por compras/consumos no tendrán vencimiento, mientras exista el PROGRAMA.</h6>
<h6 class="terms">
D – CATEGORÍAS DE SOCIOS:</h6>
<h6 class="terms">
16.- Los socias podrán gozar, de acuerdo a la cantidad de puntos que hayan obtenidos en los últimos 90 dias, de cualquiera de las siguientes categorías: Silver, Gold o Platinum. Una vez alcanzada una categoría, se mantendrán en la misma, sin considerar cuántos puntos sigan acumulando por un plazo de 180 días. Pasado dicho plazo, podrán ser re categorizados, calculando nuevamente, los puntos acumulados en los 90 días precedentes a dicha fecha.</h6>
<h6 class="terms">
17.- Los requisitos para acceder a cada categoría son:</h6>
<h6 class="terms">
Socios Silver: haber acumulado en el termino de 90 dias corridos la cantidad de 300 puntos</h6>
<h6 class="terms">
Socios Gold: haber acumulado en el termino de 90 dias corridos 1500 puntos.</h6>
<h6 class="terms">
Socios Platinum: haber acumulado en el término de 90 días corridos 3000 puntos.</h6>
<h6 class="terms">
18.- Los beneficios que podrán disfrutar los SOCIOS de EL PROGRAMA por pertenecer a las categorías descriptas, serán:</h6>
<h6 class="terms">
SILVER: 300 PUNTOS DE REGALO, BIENVENIDA, POR ASOCIARSE AL PROGRAMA.</h6>
<h6 class="terms">
GOLD: </h6>
<h6 class="terms">
• Copa de espumante de bienvenida, hasta 4 personas
• Upgrade de vinos </h6>
<h6 class="terms">
PLATINUM:</h6>
<h6 class="terms">
• Copa de espumante de bienvenida, hasta 4 personas
• Upgrade de vinos 
• Grupos de 8 personas 1 es invitado
• Salon Pampa para eventos con capacidad maxima de 80 personas Sin Cargo. Minimo requerido 20 personas
• Cata de vinos para 6 personas 40% descuento</h6>
<h6 class="terms">
D – PREMIOS. CANJE DE PUNTOS POR PREMIOS:</h6>
<h6 class="terms">
19.- Los premios (en adelante “el/os Premio/s”) –a criterio de LA CABAÑA- podrán consistir en: certificados/voucher por valor monetario y/o productos o servicios específicos de LA CABAÑA, los cuales conformarán el catálogo de premios (en adelante “el Catalogo”).</h6>
<h6 class="terms">
20.- LA CABAÑA podrá en cualquier momento modificar y/o reemplazar los premios establecidos en el catálogo sin necesidad de preaviso.</h6>
<h6 class="terms">
21.- Los Puntos podrán ser canjeados por Premios, de acuerdo con el valor en Puntos asignados para cada uno de los Premios. Los Premios del Catálogo estarán disponibles en una plataforma web del PROGRAMA a la que podrán acceder los Clientes, a través de la solapa https://www.sorsrewards.com/lacabana/. A tal fin, el Cliente que decidiere efectuar un canje, deberá acceder con su usuario y contraseña y realizar el canje a través del mismo.</h6>
<h6 class="terms">
22.- Cada vez que un Cliente canjee puntos por Premios, los mismos serán descontados automáticamente de su cuenta y de acuerdo a los puntos informados en el catálogo de Premios.</h6>
<h6 class="terms">
23.- Solicitado el canje, LA CABAÑA otorgará al Cliente un código de voucher que identificará el pedido, y tendrá una validez de 15 dias corridos. Luego el cliente deberá realizar la reserva con anticipación informando dicho código.</h6>
<h6 class="terms">
24.- Los Puntos, certificados, vouchers y/o cualquier Premio del presente Programa son personales e intransferibles.</h6>
<h6 class="terms">
E - OTRAS CONDICIONES:</h6>
<h6 class="terms">
25.- La participación por parte de los Clientes, en el Programa implicará su aceptación irrestricta respecto de todos los términos y condiciones aquí establecidas como así también respecto de todas las modificaciones que el LA CABAÑA disponga sobre el Programa, en ejercicio de los derechos acordados a su favor bajo las presentes.

                                  </h6>
                                  </div>
                                  

                      </div>
              </div>
              </div>
 </section>
    



        <!-- Footer -->
        <footer id="footerlogin">
          <? require_once 'footer.php' ?>
        </footer>

    <!-- /.container -->

    <!-- jQuery -->
    
	<!-- <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="locales/bootstrap-datepicker.es.min.js"></script>
    <script type="text/javascript">
				       $('#fecha').datepicker({
						language: "es",
						autoclose: true
						});
	</script>-->
	<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="js/date-euro.js"></script>
    <script type="text/javascript"> 
	$(document).ready(function() {
    $('#voucherspago').dataTable( {
		"aoColumns": [
		null,
		null,
		null,
		null,
		{"sType": "date-euro"},
		null,
		null
		],
		"language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
		},
		
		"order": [[ 0, 'asc' ]]
    } );
	
} );
</script>
<script type="text/javascript"> 
	$(document).ready(function() {
    $('#consultas1').dataTable( {
		"aoColumns": [
		null,
		null,
		null,
		null,
		{"sType": "date-euro"},
		null,
		null,
		null,
		null,
		],
		"language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
		},
		
		"order": [[ 0, 'asc' ]]
    } );
	
} );
</script>
<script type="text/javascript"> 
	$(document).ready(function() {
    $('#consultas2').dataTable( {
		"aoColumns": [
		null,
		null,
		null,
		null,
		{"sType": "date-euro"},
		null,
		null
		],
		"language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
		},
		
		"order": [[ 0, 'asc' ]]
    } );
	
} );
</script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/responsive-tabs.js"></script>
			<script type="text/javascript">
              $( '#myTab a' ).click( function ( e ) {
                e.preventDefault();
                $( this ).tab( 'show' );
              } );
        
              $( '#moreTabs a' ).click( function ( e ) {
                e.preventDefault();
                $( this ).tab( 'show' );
              } );
        
              ( function( $ ) {
                  fakewaffle.responsiveTabs( [ 'xs', 'sm' ] );
              } )( jQuery );
        
            </script>

</body>

</html>
