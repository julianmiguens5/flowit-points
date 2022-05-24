<?php 
    
// iniciamos session
session_start ();

require_once '../includes/config.php';
require_once '../includes/conexion.php';
require_once '../includes/esAdmin.php';

// obtengo puntero de conexion con la db
$dbConn = conectar();

require_once '../includes/admin.class.php';

$obj=new inscripcion;
$acum=new acumulacion;
//$sumap=new sumapuntos;
$aceptarvoucher=new aceptarvou;
$sumaimp=new sumaimportes;
$sumacanj=new sumacanjeado;
$modalv=new modalvou;
$ventasucursal=new sumasucursal;
$cumples=new cumples;
$top5=new top5;
$editvou=new editarvoucher;

$error4=$sumaimp->sumarimportes($row["total"]);
$error5=$sumacanj->sumarcanjeado($row["total"]);

$ventasuc=$ventasucursal->sumarsucursales();

// Variables según programa de beneficios

$programa='Administrador Circulo Parmegiano';
$usuarioadmin='parmegiano';

// si se envio el formulario
if ( !empty($_POST['submitins']) ) {
	$error=$obj->Verificar();
	if ($error == 1) {
		$mensaje = 'El registro fue exitoso';
	}
	else
	{
		$mensaje = 'El DNI ya está registrado en el programa. Puede proceder a la acumulación.';
	}
	//$mensins="El registro fue exitoso";
}



if ( !empty($_POST['submitacum']) ) {
	$error2=$acum->acumpuntos();
	if ($error2 == 1) {
	header( 'Location: index.php?mensacum=exito' );
	}
	else {
		header( 'Location: index.php?mensacum=error' );
	}
	//$error3=$sumap->sumarpuntos();

}
if (($_GET['mensacum']) == 'exito') {
		$mensacum="La acumulación de puntos fue exitosa";
		} 

if (($_GET['mensacum']) == 'error') {
		$mensacum="";
		$mensacumerr="No se han podido cargar los puntos. Verifique que el DNI este asociado al programa.";
		} 

if ( !empty($_POST['submitvou']) ) {
	$error6=$aceptarvoucher->aceptarvoucher();
  $error10=$modalv->modalvoucher($row["dni"]);
}
if (isset($_GET['panel']) && ($_GET['panel']=='insc' or $_GET['panel']=='acum' or $_GET['panel']=='canj' or $_GET['panel']=='cons')) {
	$panel=$_GET['panel'];
} else {
  if (($_SESSION['usuarioadmin']) == $usuarioadmin) {
	$panel='acum';
  }
  else {
    $panel='acum';
  }
}

if ( !empty($_POST['vouedit'])) {
	$erroredit=$editvou->guardarVoucher();
	if ($erroredit == 1) {
		$mensajeedit = 'El voucher fue actualizado';
	}
	else
	{
		$mensajeedit = 'Error al actualizar el voucher.';
	}
	$panel='edit';
}

$cumpleanos=$cumples->cumpleanos();

$topcinco=$top5->topcinco();

// vemos si el usuario quiere desloguar
if ( !empty($_GET['salir']) ) {
	// borramos y destruimos todo tipo de sesion del usuario
	session_unset();
	session_destroy();
}


// verificamos que no este conectado el usuario
if ( !empty( $_SESSION['usuarioadmin'] ) && !empty($_SESSION['passwordadmin']) ) {
	$arrAdmin = esAdmin( $_SESSION['usuarioadmin'], $_SESSION['passwordadmin'], $dbConn );
} 
// verificamos que sea un admin
if ( empty($arrAdmin) ) {
	header( 'Location: ../index.php' );
	die;
}
?>

<!DOCTYPE html>
<html lang="en">

<? require_once 'header.php'; ?>

<body>

    <!-- Page Content -->
 <section id="administrador">
    <div class="container">
    	<div class="row">
              <div class="col-xs-12">
            	    <ul class="nav navbar-nav-secr">
                	<li><? echo $programa; ?></li>
                    <!--<li><i class="fa fa-user" aria-hidden="true"></i></li>-->
                    <!--<li><a href="#consultas"><i class="fa fa-bar-chart" aria-hidden="true"></i></a></li>-->
                    <li><a href="index.php?salir=true" class="links"><i class="fas fa-sign-out-alt" aria-hidden="true"></i></a></li>
                </ul>
				  <p><? /* */ ?></p>
            </div>
        	<ul class="nav nav-tabs responsive" id="myTab">
            <?php
    if (($_SESSION['usuarioadmin']) != '')
    {
				switch ($panel) {
	    		case 'insc':
	    			echo '<li class="active"><a href="#home">Inscripción de Socios</a></li>
                  <li><a href="#puntos">Acumulación de Puntos</a></li>
                  <li><a href="#messages">Validación de Vouchers</a></li>
                  <li><a href="#consultas">Consultas</a></li>
				  <li><a href="#edit">Editar Vouchers</a></li>';
	    			break;
				case 'acum':
	    			echo '<li><a href="#home">Inscripción de Socios</a></li>
                  <li class="active"><a href="#puntos">Acumulación de Puntos</a></li>
                  <li><a href="#messages">Validación de Vouchers</a></li>
                  <li><a href="#consultas">Consultas</a></li>
				  <li><a href="#edit">Editar Vouchers</a></li>';
	    			break;
				case 'canj':
	    			echo '<li><a href="#home">Inscripción de Socios</a></li>
                  <li><a href="#puntos">Acumulación de Puntos</a></li>
                  <li class="active"><a href="#messages">Validación de Vouchers</a></li>
                  <li><a href="#consultas">Consultas</a></li>
				  <li><a href="#edit">Editar Vouchers</a></li>';
	    			break;
				case 'cons':
	    			echo '<li><a href="#home">Inscripción de Socios</a></li>
                  <li><a href="#puntos">Acumulación de Puntos</a></li>
                  <li><a href="#messages">Validación de Vouchers</a></li>
                  <li class="active"><a href="#consultas">Consultas</a></li>
				  <li><a href="#edit">Editar Vouchers</a></li>';
	    			break;
				case 'edit':
	    			echo '<li><a href="#home">Inscripción de Socios</a></li>
                  <li><a href="#puntos">Acumulación de Puntos</a></li>
                  <li><a href="#messages">Validación de Vouchers</a></li>
                  <li><a href="#consultas">Consultas</a></li>
				  <li class="active"><a href="#edit">Editar Vouchers</a></li>';
	    			break;
	    		
	    		default:
	    			echo '<li><a href="#home">Inscripción de Socios</a></li>
                  <li class="active"><a href="#puntos">Acumulación de Puntos</a></li>
                  <li><a href="#messages">Validación de Vouchers</a></li>
                  <li><a href="#consultas">Consultas</a></li>
				  <li><a href="#edit">Editar Vouchers</a></li>';
	    			break;
	    	}
      }
			?>
            </ul>

            <div class="tab-content responsive">
              <div class="tab-pane <?php if($panel=='insc') echo 'active'; ?>" id="home">
              <form class="form-horizontal" method="post">
                    <fieldset>
                    
                    <!-- Form Name -->
                    <legend class="text-center">Inscripción de Socios<hr class="linea"></legend>
                    
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="dni">DNI:</label>  
                      <div class="col-md-4">
                      <input id="dni" name="dni" type="text" placeholder="DNI" class="form-control input-md" required>
                      </div>
                       <div class="col-md-4">
                        <i class="fa fa-asterisk pull-left" aria-hidden="true"></i>
                      
                      <!--<div class="col-md-4">
                       <button id="submit" name="submitdni" class="btn btn-primary">BUSCAR</button>
                      </div>-->
                      
                      <label class="control-label">(N° de Socio)</label>
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="apellido">Apellido:</label>  
                      <div class="col-md-4">
                      <input id="apellido" name="apellido" type="text" placeholder="Apellido" class="form-control input-md" required>
                        
                      </div>
                       <div class="col-md-4">
                        <i class="fa fa-asterisk pull-left" aria-hidden="true"></i>
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="nombre">Nombre:</label>  
                      <div class="col-md-4">
                      <input id="nombre" name="nombre" type="text" placeholder="Nombre" class="form-control input-md" required>
                        
                      </div>
                       <div class="col-md-4">
                        <i class="fa fa-asterisk pull-left" aria-hidden="true"></i>
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="mail">Mail:</label>  
                      <div class="col-md-4">
                      <input id="mail" name="mail" type="text" placeholder="Mail" class="form-control input-md" required>
                        
                      </div>
                       <div class="col-md-4">
                        <i class="fa fa-asterisk pull-left" aria-hidden="true"></i>
                      </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="fechanac">Fecha de Nacimiento:</label>  
                      <div class="col-md-4">
                      <input type="date" name="fechanac" class="form-control input-md" id="fecha" placeholder="Fecha de Nacimiento" required>
                        
                      </div>
                      <div class="col-md-4">
                        <i class="fa fa-asterisk pull-left" aria-hidden="true"></i>
                      </div>
                    </div>
                    
                   <div class="form-group">
                      <label class="col-md-4 control-label" for="telefono">Teléfono:</label>  
                      <div class="col-md-4">
                      <input id="telefono" name="telefono" type="text" placeholder="Cod. de área y sin 15" class="form-control input-md" required>
                        
                      </div>
                      <div class="col-md-4">
                        <i class="fa fa-asterisk pull-left" aria-hidden="true"></i>
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
                    
                    
                    <!-- Button -->
                    <div class="form-group">
                      <div class="col-md-2 col-md-offset-4">
                      <p>
                        <i class="fa fa-asterisk"></i> Datos obligatorios.
                      </p>
                      </div>
                      <div class="col-md-2">
                      
                        <button id="submit" name="submitins" class="btn btn-success pull-right" value="submitins">ACEPTAR</button>
                      
                    </div>
                    </fieldset>
                    </form>
                    
                    </div>

                                  <div class="tab-pane <?php if($panel=='acum') echo 'active'; ?>" id="puntos">
                                  <form class="form-horizontal" method="post">
                                  <fieldset>
                                  <legend class="text-center">Acumulación de Puntos<hr class="linea"></legend>
                                 
                                  <div class="form-group">
                                      <label class="col-md-4 control-label" for="ln">DNI:</label>  
                                      <div class="col-md-4">
                                      <input id="ln" name="dniacum" type="text" placeholder="DNI" class="form-control input-md" autocomplete="off" required>
                                        
                                      </div>
                                       <div class="col-md-4">
                                        <i class="fa fa-asterisk pull-left" aria-hidden="true"></i>
                                        <label class="control-label">(N° de Socio)</label>
                                      </div>
                                    </div>
                                     <div class="form-group">
                                      <label class="col-md-4 control-label" for="ln">N° del Ticket/Factura:</label>  
                                      <div class="col-md-4">
                                      <input id="ln" name="ticket" type="text" placeholder="N° de Ticket" class="form-control input-md" autocomplete="off">
                                        
                                      </div>

                                    </div>
                                    
                                    <!-- Text input-->
                                    <div class="form-group">
                                      <label class="col-md-4 control-label" for="cmpny">Importe del Ticket/Factura:</label>  
                                      <div class="col-md-4">
                                      <input onkeyup="obtenerSuma();" id="sumando1" type="number" size="7" maxlength="7" class="form-control" placeholder="Importe del Ticket" name="monto" autocomplete="off" required>

                                        
                                      </div>
                                      <div class="col-md-1">
                                        <i class="fa fa-asterisk pull-left" aria-hidden="true"></i>
                                      </div>
                                   

                                      <div class="col-md-1">
                                      <label class="control-label pull-right" for="puntos">Puntos:</label>
                                      </div>
                                      <div class="col-md-2">
                                      <input id="resultado" type="number" size="7" maxlength="7" class="form-control" name="puntos" readonly>
                                      </div>
                                    </div>
									<div class="form-group">
									  <label class="col-md-4 control-label" for="Sucursal">Sucursal:</label>  
									  <div class="col-md-4">
									  <input id="sucursal" name="sucursal" type="text" value="<? echo $_SESSION['sucursaladmin'] ?>" class="form-control input-md" readonly>

									  </div>
									</div>
									  <? $unique_id = uniqid(microtime(),1); ?>
									  <input type="hidden" name="unique_id" value="<?php echo $unique_id; ?>">
                                    <div class="form-group">
                                    <div class="col-md-2 col-md-offset-4">
                                        <p>
                                          <i class="fa fa-asterisk"></i> Datos obligatorios. <? echo $exito; ?>
                                        </p>
                                        
                                      </div>
                      <div class="col-md-6">
                        <p id="submitacummodal" class="btn btn-success pull-right pre-modal-acum">ACEPTAR</p>
						 
                      </div>
                    </div>
              </fieldset>
              </form>
					
			 <!-- MODAL CONFIRMACION ACUMULACION -->
									  
			  <!-- Modal -->
  <div class="modal fade" id="ModalAcum" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Confirmar Acumulación de puntos</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" method="post">
            <div class="form-group">
              <label for="dni">DNI</label>
              <input type="text" class="form-control" id="dniconf" name="dni" readonly>
            </div>
            <div class="form-group">
              <label for="puntos">PUNTOS</label>
              <input type="text" class="form-control" id="puntosconf" name="puntos" readonly>
		      <input type="hidden" id="sucursalconf" name="sucursal" readonly>
		      <input type="hidden" id="ticketconf" name="ticket" readonly>
		      <input type="hidden" id="montoconf" name="monto" readonly>
		      <input type="hidden" id="uniqueidconf" name="unique_id" readonly>
            </div>
              <input type="submit" value="ACEPTAR" name="submitacum" class="btn btn-success pull-right" id="submitacum">
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
        </div>
      </div>
      
    </div>
  </div> 
									  
									  
              <div>
              <h4><?		
							if (!empty($mensacum)) { ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle alerta"></i> <?
								echo $mensacum;
							}
							if (!empty($mensaje)) { ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle alerta"></i> <?
								echo $mensaje;
							}
                   
							if (!empty($mensacumerr)) { ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle alerta"></i> <?
								echo $mensacumerr;
							}
							if ((stripos($error6,"validado")) == true ) { ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle alerta"></i> <?
									echo $error6;
								}
							if ($error6 == 'El voucher ya se ha utilizado.') {	?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle alerta"></i> <?
									echo $error6;
								}
							if ($error6 == 'Voucher no encontrado') {	?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle alerta"></i> <?
									echo $error6;
								}
							?>
                            
							</h4>
              </div>
        </div>
              <div class="tab-pane <?php if($panel=='canj') echo 'active'; ?>" id="messages">
              <form class="form-horizontal" method="post">
                                  <fieldset>
                                  <legend class="text-center">Validación de Vouchers<hr class="linea"></legend>
              						 <div class="form-group">
                                      <label class="col-md-4 control-label" for="ln">N° del Voucher:</label>  
                                      <div class="col-md-4">
                                      <input id="voucher" name="voucher" type="text" placeholder="N° del Voucher" class="form-control input-md" autocomplete="off" required>
                                        
                                      </div>
                                    </div>
              						<div class="form-group">
                      					<label class="col-md-4 control-label" for="submit"></label>
                      					<div class="col-md-4">
                                        <button id="submit" name="submitvou" class="btn btn-success pull-right" value="submitvou">VALIDAR</button>
                                      </div>
                                    </div>
              					  </fieldset>
               </form>
              	<h4><?php 
								if ($error6 == 'El voucher se ha validado con éxito.') { ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle"></i> <?
									echo $error6;
								}
								if ($error6 == 'Error en los datos. El voucher ya se ha utilizado.') {	?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle"></i> <?
									echo $error6;
								}
								if ($error6 == 'Voucher no encontrado') {	?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle"></i> <?
									echo $error6;
								}
				/* if (isset($str_result)) { ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle"></i> <?= $str_result ?></div>
                <?php } */ ?></h4>
                                
              	
			</div>
									
			<div class="tab-pane <?php if($panel=='edit') echo 'active'; ?>" id="edit">
              <form class="form-horizontal" method="post">
				  <?php if (($_SESSION['usuarioadmin']) == 'admingeneral') { ?>
                     <?php $editvou->editVoucher() ?>
				  <h4><?php if(!empty($mensajeedit)){
					if ((stripos($mensajeedit,"actualizado")) == true ) {
						echo '<div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle"></i>'.$mensajeedit.'</div>'; } else {
							'<div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-exclamation-triangle"></i>'.$mensajeedit.'</div>';
					} 
			} ?></h4><?php } else { ?>
				  <h4>Panel no disponible</h4>
				  <?php } ?>
			</div>
 <div class="tab-pane <?php if($panel=='cons') echo 'active'; ?>" id="consultas">
	 
<div class="row">
<div class="col-sm-6 m-b-md">
<div id="piechart" style="display: inline-block"></div>
<div id="piechart2" style="display: inline-block"></div>
</div>
<!--<div class="col-xs-12 col-md-6">
<legend class="text-center">Dashboard</legend>

  <div class="col-md-6 m-b-md">
    <div class="w-lg m-x-auto">
      <canvas
        class="ex-graph"
        data-chart="doughnut"
        data-value="[{ value: <? echo $ventasuc[1][1]; ?>, color: '#FFFC0D', label: '<? echo $ventasuc[1][0]; ?>' }, { value: <? echo $ventasuc[2][1]; ?>, color: '#1bc98e', label: '<? echo $ventasuc[2][0]; ?>' }, { value: <? echo $ventasuc[3][1]; ?>, color: '#700CE8', label: '<? echo $ventasuc[3][0]; ?> <? echo $ventasuc[4][1]; ?> <? echo $ventasuc[4][0]; ?>' }]"
        data-segment-stroke-color="#252830">
      </canvas>
	    <h4 class="text-muted text-center">Rendimiento de sucursales</h4>
    </div>

  </div>
    <div class="col-md-6 m-b-md">
	  
    <div class="w-lg m-x-auto"><? if ($error5 == '') { $error5 = 1; } if ($error4 == '') { $error4 = 1; } ?>
      <canvas
        class="ex-graph"
        data-chart="doughnut"
        data-value="[{ value: <? echo $error5; ?>, color: '#1ca8dd', label: 'Canjeados' }, { value: <? echo $error4; ?>, color: '#1bc98e', label: 'Pendientes' }]"
        data-segment-stroke-color="#252830">
      </canvas>
	    <h4 class="text-muted text-center">Canjeados vs Pendientes</h4>
    </div>

  </div>	
</div>-->
  <div class="col-sm-4 m-b-md">
<? 
   $porcentaje2 = number_format((($topcinco[1]["puntos"]*100)/$topcinco[0]["puntos"]));
   $porcentaje3 = number_format((($topcinco[2]["puntos"]*100)/$topcinco[0]["puntos"]));
   $porcentaje4 = number_format((($topcinco[3]["puntos"]*100)/$topcinco[0]["puntos"]));
   $porcentaje5 = number_format((($topcinco[4]["puntos"]*100)/$topcinco[0]["puntos"]));
?>
	  <h5 class="text-center"><strong>Top Clientes</strong></h5>
	  <ul class="chart">
  <li>
    <span style="height:100%" title="<? echo $topcinco[0]["nombre"]." ".$topcinco[0]["apellido"] ?>"></span>
  </li>
  <li>
    <span style="height:<? echo $porcentaje2."%" ?>" title="<? echo $topcinco[1]["nombre"]." ".$topcinco[1]["apellido"] ?>"></span>
  </li>
  <li>
    <span style="height:<? echo $porcentaje3."%" ?>" title="<? echo $topcinco[2]["nombre"]." ".$topcinco[2]["apellido"] ?>"></span>
  </li>
  <li>
    <span style="height:<? echo $porcentaje4."%" ?>" title="<? echo $topcinco[3]["nombre"]." ".$topcinco[3]["apellido"] ?>"></span>
  </li>
  <li>
    <span style="height:<? echo $porcentaje5."%" ?>" title="<? echo $topcinco[4]["nombre"]." ".$topcinco[4]["apellido"] ?>"></span>
  </li>
</ul>  
  </div>

  <div class="col-sm-2">
	  <h5><strong>Cumpleaños de hoy</strong></h5>
	  <!--<legend><i class="fas fa-birthday-cake"></i></legend>-->
	  <?  
	  $cant = count($cumpleanos);
	  if ($cant > 0) {    
	   $i=0;
        while($i < $cant) {
		
        echo "<div class='brdr bgc-fff pad-10 box-shad btm-mrg-20 property-listing'>
                        <div class='media'>
                           

                            <div class='media-body fnt-smaller'>
                                <a href='#'' target='_parent'></a>
								<p>
                                  ".strtoupper(utf8_encode($cumpleanos[$i]["nombre"]))." ".strtoupper(utf8_encode($cumpleanos[$i]["apellido"]))." <br> DNI: ".utf8_encode($cumpleanos[$i]["usuario"])."</p>
                                
                                   

                                
                                

                                 




                                
                            </div>
                        </div>
                    </div>";
	   $i++;
    }
echo "</table>";
} else {
    echo "No hay cumpleaños hoy.";
} ?>
	  
</div>
	 </div>
	<div class="col-xs-12">
 			<form class="form-horizontal">
              <fieldset>
              <legend class="text-center">Consultas<hr class="linea"></legend>

              <div class="panel-group">
               <div class="panel panel-default">
                <div class="panel-heading">
                <h4 class="panel-title">
                <a data-toggle="collapse" class="collapsed" href="#collapse3">Consulta de Vouchers Pendientes</a>
                </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
				<table id="consultas3" class="table table-striped table-bordered" style="width:100%;">
                  <thead class="thead-inverse">
                    <tr>
                      <th># de Voucher</th>
                      <th>DNI</th>
                      <th>Apellido</th>
                      <th>Nombre</th>
                      <th>Fecha de canje</th>
                      <th>Valor</th>
                      <th>Premio</th>
                    </tr>
                  </thead>
                  
                </table>
                <p class="totalimp">Importe total pendiente: $ <? echo $error4; ?></p>
                </div>
                
               </div>
              </div>
              <div><br></div>
              <div class="panel-group">
               <div class="panel panel-default">
                <div class="panel-heading">
                <h4 class="panel-title">
                <a data-toggle="collapse" class="collapsed" href="#collapse2">Consulta de Vouchers Utilizados</a>
                </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
				<table id="consultas2" class="table table-striped table-bordered" style="width:100%;">
                  <thead class="thead-inverse">
                    <tr>
                      <th># de Voucher</th>
                      <th>DNI</th>
                      <th>Apellido</th>
                      <th>Nombre</th>
                      <th>Fecha de canje</th>
                      <th>Valor</th>
                      <th>Premio</th>
                      <th>Sucursal</th>
                    </tr>
                  </thead>
                  
                </table>
                <p class="totalimp">Importe total canjeado: $ <? echo $error5; ?></p>
                </div>
                
               </div>
              </div>

              <div><br></div>
              <div class="panel-group">
               <div class="panel panel-default">
                <div class="panel-heading">
                <h4 class="panel-title">
                <a data-toggle="collapse" class="collapsed" href="#collapse1">Consulta de Socios y Puntos</a>
                </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
        <table id="consultas1" class="table table-striped table-bordered" style="width:100%">
                  <thead class="thead-inverse">
                    <tr>
                      <th>DNI</th>
                      <th>Apellido</th>
                      <th>Nombre</th>
                      <th>Mail</th>
                      <th>Fecha de Nacimiento</th>
                      <th>Teléfono</th>
                      <!--<th>Género</th>
                      <th>Domicilio</th>
                      <th>Ciudad</th>-->
                      <th>Puntos</th>
                    </tr>
                  </thead>
                </table>
                </div>
               </div>
              </div>
              <div><br></div>
              <div class="panel-group">
               <div class="panel panel-default">
                <div class="panel-heading">
                <h4 class="panel-title">
                <a data-toggle="collapse" class="collapsed" href="#collapse4">Historial de Acumulación</a>
                </h4>
                </div>
                <div id="collapse4" class="panel-collapse collapse">
                <div class="panel-body">
        <table id="consultas4" class="table table-striped table-bordered" style="width:100%;">
                  <thead class="thead-inverse">
                    <tr>
                      <th>Fecha</th>
                      <th>DNI</th>
                      <th>Apellido</th>
                      <th>Nombre</th>
                      <th>Monto</th>
                      <th>Puntos</th>
                      <th>Descripción</th>
                      <th>Sucursal</th>
                    </tr>
                  </thead>
                  
                </table>
                </div>
                
               </div>
              </div>

              </fieldset>
              </form>
    </div>
  </div>
</section>
    



        <!-- Footer -->
        <footer>
          <? require_once '../footer.php' ?>
        </footer>

    <!-- /.container -->

    <!-- jQuery -->
    
	<!--<script src="../js/bootstrap-datepicker.min.js"></script>
    <script src="../locales/bootstrap-datepicker.es.min.js"></script>
    <script type="text/javascript">
				       $('#fecha').datepicker({
						language: "es",
						autoclose: true
						});
	</script>-->
	<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
  <script src="../js/date-euro.js"></script>
	 
	 <!-- DASHBOARD -->  
  <!-- <script src="assets/js/jquery.min.js"></script> -->
    <script src="../assets/js/chart.js"></script>
    <script src="../assets/js/tablesorter.min.js"></script>
    <script src="../assets/js/toolkit.js"></script>
    <script src="../assets/js/application.js"></script>
    <script> 
      // execute/clear BS loaders for docs
      $(function(){while(window.BS&&window.BS.loader&&window.BS.loader.length){(window.BS.loader.pop())()}})
    </script> <!-- DASHBOARD -->
<!--    <script type="text/javascript"> 
	$(document).ready(function() {
    $('#voucherspago').dataTable( {
		"processing":true,
		"serverSide":true,
		"ajax":{
			url :"../includes/jsonvouchers.php", // json datasource
			type: "post"// method  , by default get
		},
		"Columns": [
                {"data": "n_voucher"},
                {"data": "dni"},
                {"data": "apellido"},
                {"data": "nombre"},
				{"data": "fechacanje"},
				{"data": "importe"},
				{"data": "canjeado"}
		],
		"columnDefs": [ {
            "targets": -1,
            "data": "n_voucher",
            "defaultContent": '<div style="text-align:center"><a href="elmirasol.php?vaucher='+data+'" style="width:100%;" name="aceptarvoucher" value="aceptarvoucher" class="btn btn-info"> Aceptar </a></div>'
        } ],
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
</script> -->
<script type="text/javascript"> 
	$(document).ready(function() {
    $('#consultas1').dataTable( {
		"processing":true,
		"serverSide":true,
		"ajax":{
						url :"../includes/jsonconsultas.php", // json datasource
						type: "post"// method  , by default get
		},
		"Columns": [
                {"data": "usuario"},
                {"data": "apellido"},
                {"data": "nombre"},
                {"data": "mail"},
        {"data": "fechanac"},
        {"data": "domicilio"},
        {"data": "puntos"},
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
		
		"order": [ 6, 'desc' ],
    "lengthMenu": [[10, 25, 50, 100000], [10, 25, 50, "Todos"]],
        "dom": 'Blfrtip',
        "buttons": [
            { "extend": 'excel', "text":'Exportar a Excel' }
        ],

    } );
	
} );
</script>
<script type="text/javascript"> 
	$(document).ready(function() {
    $('#consultas2').dataTable( {
		"processing":true,
		"serverSide":true,
		"ajax":{
						url :"../includes/jsonhistorial.php", // json datasource
						type: "post"// method  , by default get
		},
		"Columns": [
                {"data": "n_voucher"},
                {"data": "dni"},
                {"data": "apellido"},
                {"data": "nombre"},
				{"data": "fechala"},
				{"data": "importe"},
        {"data": "premio"},
        {"data": "sucursal"},
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
    "lengthMenu": [[10, 25, 50, 100000], [10, 25, 50, "Todos"]],
        "dom": 'Blfrtip',
        "buttons": [
            { "extend": 'excel', "text":'Exportar a Excel' }
        ],
    } );
	
} );
</script>
<script type="text/javascript"> 
	$(document).ready(function() {
    $('#consultas3').dataTable( {
		"processing":true,
		"serverSide":true,
		"ajax":{
						url :"../includes/jsonpendientes.php", // json datasource
						type: "post"// method  , by default get
		},
		"Columns": [
                {"data": "n_voucher"},
                {"data": "dni"},
                {"data": "apellido"},
                {"data": "nombre"},
				{"data": "fechala"},
				{"data": "importe"},
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
    "lengthMenu": [[10, 25, 50, 100000], [10, 25, 50, "Todos"]],
        "dom": 'Blfrtip',
        "buttons": [
            { "extend": 'excel', "text":'Exportar a Excel' }
        ],
    } );
	
} );
</script>

<script type="text/javascript"> 
  $(document).ready(function() {
    $('#consultas4').dataTable( {
    "processing":true,
    "serverSide":true,
    "ajax":{
            url :"../includes/jsonhistorialacumulacion.php", // json datasource
            type: "post"// method  , by default get
    },
    "Columns": [
                {"data": "fechala"},
                {"data": "dni"},
                {"data": "apellido"},
                {"data": "nombre"},
                {"data": "monto"},
        {"data": "puntos"},
        {"data": "descripcion"},
        {"data": "sucursal"},
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
    "lengthMenu": [[10, 25, 50, 100000], [10, 25, 50, "Todos"]],
        "dom": 'Blfrtip',
        "buttons": [
            { "extend": 'excel', "text":'Exportar a Excel' }
        ],
    } );
  
} );
</script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/responsive-tabs.js"></script>
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
	<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

	<?php $contadorsuc = count($ventasuc); ?>
// Draw the chart and set the chart values
function drawChart() {

  var data = google.visualization.arrayToDataTable([
  ['Sucursal', 'Ventas'],
 <?php for ($i = 0; $i < $contadorsuc; $i++ ) { ?>
	['<?php echo $ventasuc[$i][0]; ?>', parseInt('<?php echo $ventasuc[$i][1]; ?>')],
<?php }  ?>
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Rendimiento de sucursales', 'width':270, 'height':280, 'backgroundColor': 'transparent', is3D:false, legend: 'none',
          pieSliceText: 'label', pieStartAngle: 100, pieSliceTextStyle: {color: 'black', fontName: 'Maven Pro', fontSize: 7}};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>
				
<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
<? if ($error4 >= 100) { ?>
  var data = google.visualization.arrayToDataTable([
  ['Vouchers', 'Estado'],
  ['Pendientes', parseInt('<?php echo $error4; ?>')],
  ['Canjeados', parseInt('<?php echo $error5; ?>')]
]);
 <? } else { ?>
  var data = google.visualization.arrayToDataTable([
  ['Vouchers', 'Estado'],
  ['Canjeados', parseInt('<?php echo $error5; ?>')]
]);
<? } ?>
  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Canjeados vs Pendientes', 'width':270, 'height':280, 'backgroundColor': 'transparent', is3D:false, legend: 'none',
          pieSliceText: 'label', pieStartAngle: 100, pieSliceTextStyle: {color: 'black', fontName: 'Maven Pro', fontSize: 7}};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
  chart.draw(data, options);
}
</script>
<script>
	var numerosid = document.querySelectorAll(".numeroid");
	var id;
	for(id in numerosid){
		numerosid[id].style.cursor = "not-allowed";
	}
</script>
          
				
<script>
	$(document).ready(function(){
		  $("#submitacummodal").click(function(){
			var dni = $("input[name=dniacum]").val();
			var puntos = $("input[name=puntos]").val();
			var monto = $("input[name=monto]").val();
			var ticket = $("input[name=ticket]").val();
			var sucursal = $("input[name=sucursal]").val();
			var uniqueid = $("input[name=unique_id]").val();
			console.log(dni);
			console.log(puntos);
			console.log(monto);
			console.log(ticket);
			console.log(sucursal);
			console.log(uniqueid);
			$("#dniconf").val(dni);
			$("#puntosconf").val(puntos);
			$("#montoconf").val(monto);
			$("#ticketconf").val(ticket);
			$("#sucursalconf").val(sucursal);
			$("#uniqueidconf").val(uniqueid);
			$("#ModalAcum").modal();
		  });
		});
</script>

</body>

</html>