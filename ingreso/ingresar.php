<?php

// iniciamos sesiones
session_start ();

require('clases/comercio.class.php');

$objComercio=new login;


// si se envio el formulario
if ( !empty($_POST['submit']) ) {
	
	// definimos las variables
	if ( !empty($_POST['usuario']) ) 	$usuario 	= $_POST['usuario'];
	if ( !empty($_POST['password']) )	$password 	= $_POST['password'];
	
	// completamos la variable error si es necesario
	if ( empty($usuario) ) 	$error['usuario'] 		= 'Es obligatorio completar el nombre de usuario';
	if ( empty($password) ) $error['password'] 		= 'Es obligatorio completar la contraseña';
	
	// si no hay errores registramos al usuario
	if ( empty($error) ) {
		
		// verificamos que los datos ingresados corresopndan a un usuario
		if ( $arrUsuario =$objComercio->esUsuario($usuario,md5($password)) ) {
			
			// definimos las sesiones
			$_SESSION['usuario'] = $arrUsuario['usuario'];
			$_SESSION['password'] = $arrUsuario['password'];
			$_SESSION['nombre-login'] = $arrUsuario['nombre-login'];
			
			if($_SESSION['usuario']=='admin') {
				header('Location: admin/index.php');
				die;
			} else {
				header('Location: index.php');
				die;
			}
			
		} else {
			$error['noExiste'] = 'Error en los datos ingresados';
		}
		
	}
		
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Login</title>
    
    <link rel="stylesheet" href="css/grilla.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/page.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="fuentes/fuente.css" type="text/css" media="screen" charset="utf-8">
    
</head>

<body>

		<div class="wrapper">
                <div id="wrapper_login">
                	<div id="contenido_login">
                        <? if (!empty($error)) { ?>
                            <? foreach ($error as $mensaje) { ?>
                                <p class="error_login"><?= $mensaje ?></p>
                            <? } ?>
                        <? } ?>
                        
                        <form action="ingresar.php" method="post" class="formulario_login" id="loginForm">
                        
                            <p>
                                <label for="usuario">Usuario</label><br />
                                <input name="usuario" type="text"  class="campos_login" value="<? if ( ! empty($usuario) ) echo $usuario; ?>" />
                            </p>
                            <p>
                                <label for="password">Contrase&ntilde;a</label><br />
                                <input name="password" type="password"  class="campos_login" value="<? if ( ! empty($password) ) echo $password; ?>" />
                            </p>
                            <p>
                                <input name="submit" type="submit" value="INGRESAR"/>
                            </p>
                            
                        </form>
					</div>
               </div>
    	</div>
</body>
</html>
