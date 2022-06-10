<?php



// iniciamos sesiones

session_start ();



// archivos necesarios

require_once 'includes/config.php';

require_once 'includes/conexion.php';

require_once 'includes/esUsuario.php';

require_once 'includes/esAdmin.php';



// obtengo puntero de conexion con la db

$dbConn = conectar();



// verificamos que no este conectado el usuario

if ( !empty( $_SESSION['usuario'] ) && !empty($_SESSION['password']) ) {

	if ( esUsuario( $_SESSION['usuario'], $_SESSION['password'], $dbConn ) ) {

		header( 'Location: index.php' );

		die;

	}

}


// si se envio el formulario

if ( !empty($_POST['submit']) ) {

	

	// definimos las variables

	if ( !empty($_POST['usuario']) ) 	$usuario 	= filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);

	if ( !empty($_POST['password']) )	$password 	= filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

	

	// completamos la variable error si es necesario

	 if ( empty($usuario) or empty($password)) 	$error['usuario'] 		= 'Complete todos los campos';

	

	// si no hay errores registramos al usuario

	if ( empty($error) ) {

		

		// verificamos que los datos ingresados corresopndan a un usuario

		if ( $arrUsuario = esUsuario($usuario,md5($password),$dbConn) ) {

			

			// definimos las sesiones

			$_SESSION['usuario'] 	= $arrUsuario['usuario'];

			$_SESSION['password']	= $arrUsuario['password'];

			$_SESSION['nombre']	= $arrUsuario['nombre'];
			
			$_SESSION['apellido']	= $arrUsuario['apellido'];
			
			$_SESSION['puntos']	= $arrUsuario['puntos'];
			
			$_SESSION['mail']	= $arrUsuario['mail'];

      $_SESSION['categoria'] = $arrUsuario['categoria'];

			header('Location: index.php');

			die;

			

		} else {

			$errorlogin	= 'El nombre de usuario o contrase&ntilde;a no coinciden';

		}

		

	}
}
		
// verificamos que no este conectado el admin

if ( !empty( $_SESSION['usuarioadmin'] ) && !empty($_SESSION['passwordadmin']) ) {

	if ( esAdmin( $_SESSION['usuarioadmin'], $_SESSION['passwordadmin'], $dbConn ) ) {

		header( 'Location: admin/index.php' );

		die;

	}

}


// si se envio el formulario (admin)

if ( !empty($_POST['submitadmin']) ) {

	

	// definimos las variables

	if ( !empty($_POST['usuarioadmin']) ) 	$usuarioadmin 	= filter_input(INPUT_POST, 'usuarioadmin', FILTER_SANITIZE_SPECIAL_CHARS);

	if ( !empty($_POST['passwordadmin']) )	$passwordadmin 	= filter_input(INPUT_POST, 'passwordadmin', FILTER_SANITIZE_SPECIAL_CHARS);

	

	// completamos la variable error si es necesario

	  if ( empty($usuarioadmin) or empty($passwordadmin)) 	$erroradmin['usuarioadmin'] 		= 'Complete todos los campos';

	

	// si no hay errores registramos al usuario

	if ( empty($erroradmin) ) {

		

		// verificamos que los datos ingresados corresopndan a un usuario

		if ( $arrAdmin = esAdmin($usuarioadmin,md5($passwordadmin),$dbConn) ) {

			

			// definimos las sesiones

			$_SESSION['usuarioadmin'] 	= $arrAdmin['usuarioadmin'];

			$_SESSION['passwordadmin']	= $arrAdmin['passwordadmin'];

      $_SESSION['sucursaladmin']  = $arrAdmin['sucursaladmin'];

			

			header('Location: admin/index.php');

			die;

			

		} else {

			$erroradmin['noExiste'] 		= 'El usuario de administrador o su contrase&ntilde;a no coinciden';

		}

		

	}

}

require_once 'includes/admin.class.php';

$obj=new inscripcionsoc;
$recup=new recuperarpass;
$store=new Stores;
$slides=new Stores;

$storename=$store->traerStore();

$slide=$slides->traerSlides();

$_SESSION['store']	= $storename['st_name'];

// si se envio el formulario
if ( !empty($_POST['submitins']) ) {
	$error=$obj->Verificarsoc();
	if ($error == 1) {
		$mensajesoc_ok = 'El registro fue exitoso';
	}
	else
	{
		$mensajesocerr = 'El DNI ya está registrado en el programa. Intente recuperar la contraseña.';
	}
	//$mensins="El registro fue exitoso";
}

if (!empty($_POST['submitrecup']) ){
    $errorrecup=$recup->recuppass();
    if ($errorrecup == 1) {
      $mensajerecup_ok = 'Se envío mail para la recuperación de la contraseña.';
    }
    else {
      $mensajerecup_err = 'El usuario o la cuenta de mail no está registrada en el programa de puntos.';
    }
  }

  if (!empty($_GET['cambiopass'])) {
  $mensajerecup_ok = 'Se actualizo la contraseña correctamente.';
}

?>


<!DOCTYPE html>
<html lang="en">

<?php require_once 'header-home.php'; ?>

<!-- Abrir el modal apenas entramos a la web. -->

<!--<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal-infopicada').modal('show');
    });
</script>-->


<!-- SLIDES DE COMERCIOS -->
<script>
            
        $(function() {
                $('body').vegas({
                    delay: 5000,
                    transition: 'fade',
                    transitionDuration: 2000,
                    animation: [ 'kenburnsDown', 'kenburnsUp', 'kenburnsLeft', 'kenburnsRight' ],
                    slides: [
                    <?php foreach ($slide as $value) { ?>
                        { src: 'img/imghome/<?php echo $value ?>' },
                    <?php } ?>
                        
                    ],
                    overlay: "vegas/overlays/03b.png"
                });
            });
</script>

<body>
    <!-- Page Content -->
    
 <section id="login">
    <div class="container">
    	<div class="row">
            <div class="col-md-7">
              <div class="test-txt">
              <h4>Club <?php echo ($storename['st_name']); ?></h4>
              <h5>
                Bienvenido al <?php echo ($storename['st_name']); ?>, El Programa de Recompensas de <?php echo ($storename['st_name']); ?>. Asociate Gratis, Acumulá 1 punto por cada peso consumido y canjealo por premios y beneficios.
              </h5>
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
            </div>
            <div class="col-md-5">
            
            <form action="login.php" method="post" class="form-horizontal login jumboLogin">
            <fieldset class="loginCuadro">
            
            <!-- Form Name -->
            
            
            <h5>Entrar</h5>
            <!-- Text input-->
            <div class="form-group">
              <div class="col-md-12">
              <input id="fn" name="usuario" type="text" class="form-control input-md customInput" placeholder="N° de Socio" autocomplete="off" required>
              </div>
            </div>
            
            <!-- Text input-->
            <div class="form-group">
              <div class="col-md-12">
              <input id="ln" name="password" type="password" class="form-control input-md customInput" placeholder="Contraseña" autocomplete="off" required>
              <span class="unit" id="passVisibility"><img src="img/assets/eye-solid.svg" alt="eye-slash" class="changeImg"></span>
              <p class="recuppass text-end"  data-bs-toggle="modal" data-bs-target="#myModal2"><span>Recuperar Contraseña</span></p>
              </div>
                
            </div>

            <div class="form-group">
            <div class="col-md-12">
               <button id="submit" name="submit" class="btn btn-success btn-sors" value="login">INGRESAR</button>
              </div>
          </div>
            <p data-bs-toggle="modal" data-bs-target="#myModal">¿No sos Socio? ... <span>Registrate!</span></p>
            
            </fieldset>
            </form>
            
            <div class="errlogin">
             <?php if (!empty($errorlogin)) { ?>

					<br>

						<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close" style="float: right;"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i> <?= $errorlogin ?>
            </div>
			<?php } ?>
            </div>
            <div>
            
                    <?php if ((!empty($mensajesoc_ok)) or (!empty($mensajesocerr))) {
                ?>
            <br>
            <?php
            if (!empty($mensajesoc_ok)) { ?>       
						<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i><?php echo $mensajesoc_ok ?></div>

            <?php } 
					  if (!empty($mensajesocerr)) { ?>       
            <div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i><?php echo $mensajesocerr ?></div>
              <?php } ?>

					<?php } ?>
          <div>
            
                    <?php if ((!empty($mensajerecup_ok)) or (!empty($mensajerecup_err))) {
                ?>
            <br>
            <?php
            if (!empty($mensajerecup_ok)) { ?>       
            <div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i><?php echo $mensajerecup_ok ?></div>

            <?php } 
            if (!empty($mensajerecup_err)) { ?>       
            <div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <i class="fa fa-exclamation-triangle"></i><?php echo $mensajerecup_err ?></div>
              <?php } ?>

          <?php } ?>
            </div>
            </div>
            <div>
            <br>
            
                        <!-- Modal -->
              

		</div>
</div>
</div>



 </section>
    

 <div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content custom-modal">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="btn btn-danger pull-right btn-sors" data-bs-dismiss="modal">YA SOY SOCIO</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form class="form-horizontal formRegistro" method="post">
                    <fieldset>
                    
                    <!-- Form Name -->
                    <h4 class="text-center">Registrate</h4>
                    
                    <!--<h4>Datos Obligatorios<hr class="linea"></h4>-->
                  <div class="container-fluid">
                    <div class="row">
                    <div class="col-12 col-md-6">
                    
                      <label for="dni">DNI</label>
                      <input id="dni" name="dni" type="text" class="form-control input-md" required>
                      <label for="apellido">Apellido</label>
                      <input id="apellido" name="apellido" type="text" class="form-control input-md" required>
                      <label for="nombre">Nombre</label>
                      <input id="nombre" name="nombre" type="text" class="form-control input-md" required>
                      <label for="mail">E-Mail</label>
                      <input id="mail" name="mail" type="mail" class="form-control input-md" required>
                    </div>
                    
                    <div class="col-12 col-md-6">
                      <label for="password">Contraseña</label>
                      <input id="password" name="password" type="password" class="form-control input-md" required>
                      <label for="fecha">Fecha de Nacimiento</label>
                      <input type="date" name="fechanac" class="form-control input-md" id="fecha">
                      <label for="telefono">Teléfono</label>
                      <input id="telefono" name="telefono" type="text" placeholder="Cod. de área y sin 15" class="form-control input-md" required>
                      <input type="checkbox" name="terms" value="terms" checked><span> Terminos y condiciones</span>
                    </div>
                    </div>
                  </div>
                    

                    <!-- Text input-->
                    
                    
                    <!-- Button -->
                    <div class="form-group">
                      
                      <div class="col-md-12">
                        <button id="submit" name="submitins" class="btn btn-success pull-right btn-sors" value="submitins">ACEPTAR</button>
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
                  <div class="modal-content modal-lg custom-modal">
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

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content custom-modal">
                      <div class="modal-header">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      </div>
                      <div class="modal-body">
                        <h4>Acceso administrador</h4>
                          <form method="post" class="form-horizontal formRegistro">
                              <fieldset>
                                  <div class="form-group">
                                      <label class="control-label" for="fn">Usuario:</label>
                                          <input id="usuarioadmin" name="usuarioadmin" type="text" placeholder="Usuario" class="form-control input-md" required>
                                  </div>

                                  <!-- Text input-->
                                  <div class="form-group">
                                      <label class="control-label" for="ln">Contraseña:</label>
                                          <input id="passwordoadmin" name="passwordadmin" type="password" placeholder="Contraseña" class="form-control input-md" required>
                                          <button id="submitadmin" name="submitadmin" class="btn btn-sors" value="login">INGRESAR</button>
                                  </div>


                              </fieldset>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
        <!-- Footer -->
        <footer id="footerlogin">
          <?php require_once 'footer.php' ?>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
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

    <script>


      let boton = document.getElementById("passVisibility");
      boton.addEventListener("click", (evento) => {
        pass = document.getElementById("ln");
        if (pass.type === "password") {
          pass.type = "text";
          document.querySelector(".changeImg").src = "img/assets/eye-slash-solid.svg";
        } else {
          pass.type = "password";
          document.querySelector(".changeImg").src = "img/assets/eye-solid.svg";
        }
    });
    </script>
      

</body>

</html>
