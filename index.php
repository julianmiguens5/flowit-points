<?php 
    
// iniciamos session
session_start ();

require_once 'includes/config.php';
require_once 'includes/conexion.php';
require_once 'includes/esUsuario.php';

// obtengo puntero de conexion con la db
$dbConn = conectar();

require_once 'includes/admin.class.php';

$canje=new canjevoucher;
$resta=new restapuntos;
$restaracum=new restaacum;
$verinfo=new editarinfo;
$editarinfo=new editarinfo;
$ptscount=new cuentap;
$cantacum=new cantacum;
$listavoucher=new vouchers;

$puntosacum=$ptscount->ptscount();

$cantidadacum=$cantacum->cuentaacum();
// Variables especificamente de vouchers

$nombrevoucher='Voucher';

if ( !empty($_POST['canje1']) ) {
	$error5=$canje->canjearvoucher($nvoucher);
	if ($error5 != '') {
		$menscanje = 'El canje de voucher fue exitoso. El voucher N°: '.$error5.' fue enviado a su casilla de correo. Imprima o guarde el mail para presentar en el local. Llame a la sucursal más cercana y coordine la entrega de su canje con 24 horas de anticipación.';
		
	}
	else
	{
		$menscanjerr = 'Error en el canje del voucher, verifique si tiene los puntos necesarios.';
	}
	$error7=$restaracum->restaracum();
	$error6=$resta->restarpuntos();
}

if (!empty($_POST['submitedit']))
    {
        $edit=$editarinfo->editar();
        if ($edit != '')
        {
            $mensedicion = 'Los datos fueron actualizados correctamente.';
        }
    }

// vemos si el usuario quiere desloguar
if ( !empty($_GET['salir']) ) {
	// borramos y destruimos todo tipo de sesion del usuario
	session_unset();
	session_destroy();
}


// verificamos que no este conectado el usuario
if ( !empty( $_SESSION['usuario'] ) && !empty($_SESSION['password']) ) {
	$arrUsuario = esUsuario( $_SESSION['usuario'], $_SESSION['password'], $dbConn );
	$dni = $_SESSION['usuario'];
} 
// verificamos que sea un admin
if ( empty($arrUsuario) ) {
	header( 'Location: login.php' );
	die;
}

$contenido=$verinfo->ver($_SESSION['usuario']);

if ($cantidadacum==0) { $nombrecat='Silver'; }
if ($cantidadacum==1) { $nombrecat='Gold'; }
if ($cantidadacum==2) { $nombrecat='Platinum'; }
?>

<!DOCTYPE html>
<html>

<?php require_once 'header.php'; ?>

<body>
    <!-- Page Content -->
 <section id="usuarios">
    <div class="container-fluid data">
    	<div class="row">
            <div class="col-12">
            	<ul class="nav navbar-nav-secr pull-right">
                	<li>Hola <?php echo $_SESSION['nombre'] ?> <?php echo $_SESSION['apellido'] ?></li>
                    <li>Puntos disponibles: <?php echo $puntosacum ?></li>
                    <li>Categoría: <?php echo $nombrecat ?></li>
                    <li><a href="#movimientos" class="links"><i class="fa fa-user" aria-hidden="true"></i></a></li>
                    <li><a href="#movimientos" class="links"><i class="fa fa-bar-chart" aria-hidden="true"></i></a></li>
                    <li><a href="index.php?salir=true" class="links"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
                </ul>
                               
            </div>
        </div>
        <?php if ((!empty($menscanje)) or (!empty($menscanjerr)) or (!empty($mensedicion))) { 

							if (!empty($menscanje)) { 
							?> <div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i> 
							<?php echo $menscanje;
							}
							?>
                            <?
                            if (!empty($mensedicion)) { 
                            ?> <div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i> 
                            <?php echo $mensedicion;
                            }
                            ?>
                  			<?php 
							if (!empty($menscanjerr)) { ?>
							<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i> 
							<?	echo $menscanjerr;
							}
							?>
                            </div>
          <?php } ?>
    </div>
 </section>
    
               <section id="vouchers">

                 <?php if ($cantidadacum == 1) { ?>

                <?php } ?>
                  <?php if ($cantidadacum == 2) { ?>

                <?php } ?>
                <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                    <h2 class="catalogo">Catálogo de Premios</h2>
                    </div>
					<?php $listavoucher->listarVoucher() ?>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->
</section>
                <section id="movimientos">
                <div class="panel-group movmargen">
               <div class="panel panel-default">
                <div class="panel-heading">
                <h4 class="panel-title">
                <a class="collapsed" data-bs-toggle="collapse" href="#collapse1">Movimientos de Cuenta<!--<i class="fa fa-lg fa-plus" aria-hidden="true"></i>--></a>
                </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                <table id="consultas2" class="table table-striped table-bordered" style="width:100%">
                  <thead class="thead-inverse">
                    <tr>
                      <th>Fecha</th>
                      <th>Descripción</th>
                      <th>Puntos</th>
                    </tr>
                  </thead>
                </table>
                </div>
               </div>
              </div>
              </div>
                 <div class="panel-group movmargen">
               <div class="panel panel-default">
                <div class="panel-heading">
                <h4 class="panel-title">
                <a class="collapsed" data-bs-toggle="collapse" href="#collapse2">Historial de Vouchers<!--<i class="fa fa-lg fa-plus" aria-hidden="true"></i>--></a>
                </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                <table id="consultas3" class="table table-striped table-bordered" style="width:100%">
                  <thead class="thead-inverse">
                    <tr>
                      <th>Fecha</th>
                      <th>N° de Voucher</th>
                      <th>Valor</th>
                      <th>Premio</th>
                      <th>Puntos</th>
                      <th>Utilizado</th>
                    </tr>
                  </thead>
                </table>
                </div>
               </div>
              </div>
              </div>
              <div class="panel-group movmargen">
               <div class="panel panel-default">
                <div class="panel-heading">
                <h4 class="panel-title">
                <a class="collapsed" data-bs-toggle="collapse" href="#collapse3">Editar Información Personal<!--<i class="fa fa-lg fa-plus" aria-hidden="true"></i>--></a>
                </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="container">
                        <div class="row">
                                    <form class="form-horizontal margenform" method="post">
                                         <div class="form-group">
                                            <label class="col-sm-2 control-label" for="dni">DNI (Nº de Socio):</label>
                                            <div class="col-sm-3">
                                            <input id="dni" name="dni" type="text" disabled value="<?php echo $contenido['usuario']; ?>" class="form-control input-sm" required>
                                            </div>
                                            <label class="col-sm-2 control-label" for="dni">Contraseña:</label>
                                            <div class="col-sm-3">
                                            <input id="password" name="password" type="text" value="<?php echo $contenido['recup-pass']; ?>" class="form-control input-sm" required>
                                            </div>
                                            <br>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="dni">Apellido:</label>
                                            <div class="col-sm-3">
                                            <input id="apellido" name="apellido" type="text" value="<?php echo $contenido['apellido']; ?>" class="form-control input-sm" required>
                                            </div>
                                            <label class="col-sm-2 control-label" for="dni">Nombre:</label>
                                            <div class="col-sm-3">
                                            <input id="nombre" name="nombre" type="text" value="<?php echo $contenido['nombre']; ?>" class="form-control input-sm" required>
                                            </div>
                                            <br>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="dni">Mail:</label>
                                            <div class="col-sm-3">
                                            <input id="mail" name="mail" type="mail" value="<?php echo $contenido['mail']; ?>" class="form-control input-sm" required>
                                            </div>
                                            <label class="col-sm-2 control-label" for="dni">Fecha de Nacimiento:</label>
                                            <div class="col-sm-3">
                                            <input type="date" name="fechanac" id="fecha" value="<?php echo $contenido['fechanac']; ?>" class="form-control input-sm" required>
                                            </div>
                                            <br>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="dni">Teléfono:</label>
                                            <div class="col-sm-3">
                                            <input id="domicilio" name="domicilio" type="text" value="<?php echo $contenido['domicilio']; ?>" class="form-control input-sm" required>
                                            </div>
                                            <!--<label class="col-sm-2 control-label" for="dni">Ciudad:</label>
                                            <div class="col-sm-3">
                                            <select id="ciudad" name="ciudad" class="form-control input-sm" value="<?php echo $contenido['ciudad']; ?>" > 
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
                                              <!--<input id="ciudad" name="ciudad" type="text" placeholder="Ciudad" class="form-control input-sm" required>-->
                                              <!--</select>
                                            
                                            </div>-->
                                            <br>
                                        </div>
                                        <div class="form-group">
                      
                                          <div class="col-sm-10">
                                            <button id="submitedit" name="submitedit" class="btn btn-success pull-right" value="submitedit">ACTUALIZAR</button>
                                          </div>
                                        </div>
                                        
                                    </form>
                                  </div>
                        </div>
                    </div>
               </div>
              </div>
                </section>

        <!-- Footer -->
        <footer>
          <?php require_once 'footer.php' ?>
        </footer>

    <!-- /.container -->

    <!-- jQuery -->

    <!-- Bootstrap Core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript"> 
	$(document).ready(function() {
    $('#consultas2').dataTable( {
		"processing":true,
		"serverSide":true,
		"ajax":{
						url :"includes/jsonhistorialclientes.php", // json datasource
						type: "post",// method  , by default get
						"data": { dninum: '<?php echo $dni ?>' }
		},
		"Columns": [
                {"data": "fecha"},
                {"data": "descripcion"},
                {"data": "puntos"}
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
		
		"order": [[ 0, 'desc' ]],
		"searching": false,
    } );
	
} );
</script>
    
<script type="text/javascript"> 
	$(document).ready(function() {
    $('#consultas3').dataTable( {
		"processing":true,
		"serverSide":true,
		"ajax":{
						url :"includes/jsonhistorialvouchers.php", // json datasource
						type: "post",// method  , by default get
						"data": { dninum: '<?php echo $dni ?>' }
		},
		"Columns": [
                {"data": "n_voucher"},
                {"data": "fechacanje"},
                {"data": "importe"},
                {"data": "premio"},
                {"data": "puntos"},
				{"data": "descanjeado"}
		],
        "createdRow": function( row, data, dataIndex )
        {
            if ((data[5]) != "No") {
                $(row).css("color","Red");
            }
            else {
                $(row).css("color","Green");
            }
        },
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
		
		"order": [[ 0, 'desc' ]],
		"searching": false,
    } );
	
} );
</script>


</body>

</html>
