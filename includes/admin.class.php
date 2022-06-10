<?php 




abstract class Conexion
{
		public function con()
	{	
		//$puntero=new mysqli('localhost', 'root', '', 'iflow_loyalty');     //DATOS DE CONEXION LOCAL
		$puntero=new mysqli('localhost', 'flowit_admin', 'JmaR7F*.Avf2', 'flowit_loyalty');      //DATOS DE CONEXION SERVIDOR
		$puntero->set_charset("utf8");
		return $puntero;
	}
}

class Stores extends Conexion
{
	public function traerStore()
	{
		if (!isset($_GET['st'])) {
			$store = 'el-luchador';
		} else {
			$store = $_GET['st'];
		}

		$query = "SELECT * FROM `tbl_stores` WHERE st_alias = '$store'";
		$result = mysqli_query(parent::con(),$query);
		$storeresult = mysqli_fetch_assoc($result);
		$storename = $storeresult['st_name'];
		return $storeresult;
	}

	public function traerSlides(){
		if (!isset($_GET['st'])) {
			$store = 'el-luchador';
		} else {
			$store = $_GET['st'];
		}

		$query = "SELECT * FROM `tbl_homeimg` INNER JOIN tbl_stores ON tbl_homeimg.imh_store = tbl_stores.st_id WHERE tbl_stores.st_alias = '$store'";
		$result = mysqli_query(parent::con(),$query);
		while ($row = mysqli_fetch_assoc($result))
			   {
			      $res_return[] = $row['imh_imgname'];
			   }
		return $res_return;
	}
}

function generar_voucher_num($longitud){ 
		$key = '';
       $pattern = '1234567890';
		 $max = strlen($pattern)-1;
		 for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		 return $key;
} 
function generar_voucher_abc($longitud){ 
	$key = '';
       $pattern = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		 $max = strlen($pattern)-1;
		 for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		 return $key;
} 
function generar_password_abc($longitud){ 
	$key = '';
       $pattern = 'abcdefghijklmnopqrstuvwxyz';
		 $max = strlen($pattern)-1;
		 for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		 return $key;
}
function nombre_est()
{
	$nombreest = "Circulo Parmegiano";
	return $nombreest;
}
function web_est()
{
	$web = "https://www.sorsrewards.com/parmegiano";
	return $web;
}
function estilo_est()
{
	$estilo = 'style="color:#CB9865;
	background-color:#fff;
	padding: 20px;
	border-radius: 8px 8px 8px 8px;
	-moz-border-radius: 8px 8px 8px 8px;
	-webkit-border-radius: 8px 8px 8px 8px;
	border: 5px double #CB9865;"';
	return $estilo;
}

function mail_est()
{
	$mailest = "sorsrewards@foconetworks.com";
	return $mailest;
}

class inscripcion extends Conexion
{
	public function Verificar(){
		//$con=new mysqli('localhost', 'root', '', 'sors');
		$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
		$apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_SPECIAL_CHARS);
		$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
		$email = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_SPECIAL_CHARS);
		$fechanac = filter_input(INPUT_POST, 'fechanac', FILTER_SANITIZE_SPECIAL_CHARS);
		$telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_SPECIAL_CHARS);
		//$genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_SPECIAL_CHARS);
		//$domicilio = filter_input(INPUT_POST, 'domicilio', FILTER_SANITIZE_SPECIAL_CHARS);
		//$ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_SPECIAL_CHARS);
		$password = generar_password_abc(10);
		$nombre_est = nombre_est();
		$web = web_est();
		$estilo = estilo_est();
		$puntos = 0;
		$nombrecom = new Stores;
		$nombrecom=$nombrecom->traerStore();
		$descripcion = "Puntos de bienvenida";
		$fecha = date('Y/m/d');
		//$nvouchernum = generar_voucher_num(6);
		//$nvoucher = $nvoucherabc . $nvouchernum;
		//$i = 0;
		$consulta = "SELECT usuario FROM usuarios WHERE usuario='$dni'";
   		$resultado = mysqli_query(parent::con(),$consulta);
  		$count = mysqli_num_rows($resultado);
		if($count!=0){
    	$emailError = "Provided Email is already in use.";
   		}
		  else {
			if(!empty($dni) and !empty($apellido) and !empty($nombre) and !empty($email)) {
			$result=mysqli_query(parent::con(),"INSERT INTO `usuarios`(`usuario`,`password`,`apellido`,`nombre`,`mail`,`fechanac`,`domicilio`,`puntos`,`recup-pass`) VALUES ('$dni',MD5('$password'),'$apellido','$nombre','$email','$fechanac','$telefono','$puntos','$password')");
			//$result2=mysqli_query(parent::con(),"INSERT INTO `acumulacion`(`fecha`,`dni`,`apellido`,`nombre`,`ticket`,`monto`,`puntos`,`descripcion`,`sucursal`) VALUES ('$fecha','$dni','$apellido','$nombre','$ticket','$monto','$puntos','$descripcion','$sucursal')");
			$emailest = mail_est();
			require "class.phpmailer.php";
			require "class.smtp.php";
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Host='smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;
			$mail->Username = "sorsrewards@foconetworks.com";
			$mail->Password = "foconet2017";
			$mail->setFrom("$emailest", $nombrecom['st_name']);
			$mail->AddAddress("$email");
			$mail->IsHTML(true);
			$mail->CharSet="utf-8";
			$mail->Subject = 'Inscripción en el Programa de Recompensas';
			$msg = '<html><body '.$estilo.'>';
			$msg .= '<p style="font-weight:bold;">';
			$msg .= "Hola,";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Tu inscripción en nuestro Programa de Recompensas ha sido exitosa.";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Recuerda que puedes administrar tu cuenta personal, consultar tus movimientos, y canjear tus Puntos por Premios, ingresando <a href=".$web.">aquí</a>.";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Tus credenciales de acceso son:";
			$msg .= '<br>';
			$msg .= "N° de Socio: ".$dni;
			$msg .= '<br>';
			$msg .= "Contraseña: ".$password;
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Saludos!";
			$msg .= '<br>';
			$msg .= '<hr>';
			$msg .= '</p>';
			$msg .= '<img src="https://flowit.es/loyalty/img/logos/'.$nombrecom['st_alias'].'.png" alt="" style="max-width:300px;" />';
			$msg .= '</html></body>';
			$mail->MsgHTML($msg);
if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
}
			return $result;
			return $mensaje='Cliente ingresado con éxito';
			}
		}
		/*if(!empty($dni) and !empty($apellido) and !empty($nombre) and !empty($mail)){
			//$nvoucherabc = generar_voucher_abc(2);
			//$nvouchernum = generar_voucher_num(6);
			//$nvoucher = $nvoucherabc . $nvouchernum;
			$result = "INSERT INTO usuarios(usuario,password, apellido, nombre, mail, fechanac, genero, domicilio, ciudad) VALUES ('$dni','$password','$apellido', '$nombre', '$mail', $fechanac', '$genero', '$domicilio', '$ciudad')";
			$result = mysqli_query(parent::con(),$result);
			return $mensaje='Cliente ingresado con éxito';
		}
		else
		{
			return $mensaje='Complete los campos';
		}*/
	}
}

class inscripcionsoc extends Conexion
{
	public function Verificarsoc(){
		//$con=new mysqli('localhost', 'root', '', 'sors');
		$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
		$apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_SPECIAL_CHARS);
		$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
		$email = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_SPECIAL_CHARS);
		$fechanac = filter_input(INPUT_POST, 'fechanac', FILTER_SANITIZE_SPECIAL_CHARS);
		$telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_SPECIAL_CHARS);
		//$genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_SPECIAL_CHARS);
		//$domicilio = filter_input(INPUT_POST, 'domicilio', FILTER_SANITIZE_SPECIAL_CHARS);
		//$ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
		$nombre_est = nombre_est();
		$estilo = estilo_est();
		$puntos = 0;
		$descripcion = "Puntos de bienvenida";
		$fecha = date('Y/m/d');
		$nombrecom = new Stores;
		$nombrecom=$nombrecom->traerStore();
		//$nvouchernum = generar_voucher_num(6);
		//$nvoucher = $nvoucherabc . $nvouchernum;
		//$i = 0;
		$consulta = "SELECT usuario FROM usuarios WHERE usuario='$dni'";
   		$resultado = mysqli_query(parent::con(),$consulta);
  		$count = mysqli_num_rows($resultado);
		if($count!=0){
    	$emailError = "Provided Email is already in use.";
   		}
		  else {
			if(!empty($dni) and !empty($apellido) and !empty($nombre) and !empty($email)) {
			$result=mysqli_query(parent::con(),"INSERT INTO `usuarios`(`usuario`,`password`,`apellido`,`nombre`,`mail`,`fechanac`,`domicilio`,`puntos`,`recup-pass`,`cambio_cat`) VALUES ('$dni',MD5('$password'),'$apellido','$nombre','$email','$fechanac','$telefono','$puntos','$password','$fecha')");
			//$result2=mysqli_query(parent::con(),"INSERT INTO `acumulacion`(`fecha`,`dni`,`apellido`,`nombre`,`ticket`,`monto`,`puntos`,`descripcion`,`sucursal`) VALUES ('$fecha','$dni','$apellido','$nombre','$ticket','$monto','$puntos','$descripcion','$sucursal')");
			$web = web_est();
			$emailest = mail_est();
			require "class.phpmailer.php";
			require "class.smtp.php";
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Host='smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;
			$mail->Username = "sorsrewards@foconetworks.com";
			$mail->Password = "foconet2017";
			$mail->setFrom("$emailest", $nombrecom['st_name']);
			$mail->AddAddress("$email");
			$mail->IsHTML(true);
			$mail->CharSet="utf-8";
			$mail->Subject = 'Inscripción en el Programa de Recompensas';
			$msg = '<html><body '.$estilo.'>';
			$msg .= '<p style="font-weight:bold;">';
			$msg .= "Hola,";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Tu inscripción en nuestro Programa de Recompensas ha sido exitosa.";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Recuerda que puedes administrar tu cuenta personal, consultar tus movimientos, y canjear tus Puntos por Premios, ingresando <a href=".$web.">aquí</a>.";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Tus credenciales de acceso son:";
			$msg .= '<br>';
			$msg .= "N° de Socio: ".$dni;
			$msg .= '<br>';
			$msg .= "Contraseña: ".$password;
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Saludos!";
			$msg .= '<br>';
			$msg .= '<hr>';
			$msg .= '</p>';
			$msg .= '<img src="https://flowit.es/loyalty/img/logos/'.$nombrecom['st_alias'].'.png" alt="" style="max-width:300px;"  />';
			$msg .= '</html></body>';
			$mail->MsgHTML($msg);
if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
}
			return $result;
			return $mensaje='Cliente ingresado con éxito';
			}
			}
		/*if(!empty($dni) and !empty($apellido) and !empty($nombre) and !empty($mail)){
			//$nvoucherabc = generar_voucher_abc(2);
			//$nvouchernum = generar_voucher_num(6);
			//$nvoucher = $nvoucherabc . $nvouchernum;
			$result = "INSERT INTO usuarios(usuario,password, apellido, nombre, mail, fechanac, genero, domicilio, ciudad) VALUES ('$dni','$password','$apellido', '$nombre', '$mail', $fechanac', '$genero', '$domicilio', '$ciudad')";
			$result = mysqli_query(parent::con(),$result);
			return $mensaje='Cliente ingresado con éxito';
		}
		else
		{
			return $mensaje='Complete los campos';
		}*/
	}
}

class acumulacion extends Conexion
{
	public function acumpuntos()
	{
		if ($_SESSION['usuarioadmin'] != '') {
		$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
		$ticket = filter_input(INPUT_POST, 'ticket', FILTER_SANITIZE_SPECIAL_CHARS);
		$monto = filter_input(INPUT_POST, 'monto', FILTER_SANITIZE_SPECIAL_CHARS);
		$puntos = filter_input(INPUT_POST, 'puntos', FILTER_SANITIZE_SPECIAL_CHARS);
		$sucursal = filter_input(INPUT_POST, 'sucursal', FILTER_SANITIZE_SPECIAL_CHARS);
		$uniqueid = filter_input(INPUT_POST, 'unique_id', FILTER_SANITIZE_SPECIAL_CHARS);
		if ($puntos == 0) {
			$puntos = $monto;
		}
		$query = mysqli_query(parent::con(),"SELECT * FROM acumulacion WHERE uniqueid='$uniqueid'");
		$count = mysqli_num_rows($query);
		if ($count == 0) { 
		$descripcion = "Acumulación de puntos";
		$fecha = date('Y-m-d H:i:sa');
		$consulta = "SELECT usuario FROM usuarios WHERE usuario='$dni'";
   		$resultado = mysqli_query(parent::con(),$consulta);
  		$count = mysqli_num_rows($resultado);
		if($count!=0){
		$consultanomape = mysqli_query(parent::con(),"SELECT `apellido`,`nombre` FROM `usuarios` WHERE `usuario`='$dni'");
		$rownomape=mysqli_fetch_array($consultanomape);
		$apellido=$rownomape['apellido'];
		$nombre=$rownomape['nombre'];
		$result=mysqli_query(parent::con(),"INSERT INTO `acumulacion`(`fecha`,`dni`,`apellido`,`nombre`,`ticket`,`monto`,`puntos`,`descripcion`,`sucursal`,`uniqueid`) VALUES ('$fecha','$dni','$apellido','$nombre','$ticket','$monto','$puntos','$descripcion','$sucursal','$uniqueid')");
		$resultmail=mysqli_query(parent::con(),"SELECT mail FROM usuarios WHERE usuario='$dni'");
		$row=mysqli_fetch_array($resultmail);
		$email=$row['mail'];
		$resultpuntos=mysqli_query(parent::con(),"SELECT puntos FROM usuarios WHERE usuario='$dni'");
		$row2=mysqli_fetch_array($resultpuntos);
		$puntostotales=($row2['puntos']+$puntos);
		$suma=mysqli_query(parent::con(),"UPDATE usuarios SET puntos=puntos+'$puntos' WHERE usuario='$dni'");
		$nombre_est = nombre_est();
		$web = web_est();
		$estilo = estilo_est();
		$emailest = mail_est();
		$nombrecom=new Stores;
		$nombrecom=$nombrecom->traerStore();
		require "class.phpmailer.php";
		require "class.smtp.php";
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Host='smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;
			$mail->Username = "sorsrewards@foconetworks.com";
			$mail->Password = "foconet2017";
			$mail->setFrom("$emailest", $nombrecom['st_name']);
			$mail->AddAddress("$email");
			$mail->IsHTML(true);
			$mail->CharSet="utf-8";
			$mail->Subject = 'Acumulación de puntos';
			$msg = '<html><body '.$estilo.'>';
			$msg .= '<p style="font-weight:bold;">';
			$msg .= "Hola,";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Has acumulado ".$puntos." Puntos en tu cuenta personal de nuestro Programa de Recompensas.";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Recuerda que puedes administrar tu cuenta personal, consultar tus movimientos, y canjear tus Puntos por Premios, ingresando <a href=".$web.">aquí</a>.";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Saludos!";
			$msg .= '<br>';
			$msg .= '<hr>';
			$msg .= '</p>';
			$msg .= '<img src="https://flowit.es/loyalty/img/logos/'.$nombrecom['st_alias'].'.png" alt="" style="max-width:300px;"  />';
			$msg .= '</html></body>';
			$mail->MsgHTML($msg);
			if(!$mail->Send())
			{
			   echo "Message could not be sent. <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			}
		return $result;
		}
		else
		{
		$error=true;
		}
		}
		else {
			$acumulado = 1;
			return $acumulado;
		}
	}
}
}
class restaacum extends Conexion
{
	public function restaracum()
	{
		$dni = $_SESSION['usuario'];
		$apellido = $_SESSION['apellido'];
		$nombre = $_SESSION['nombre'];
		$descripcion = "Canje de puntos";
		$fecha = date('Y/m/d');
		$mp = (filter_input(INPUT_POST, 'montopuntos', FILTER_SANITIZE_SPECIAL_CHARS));
		$puntostotales = $_SESSION['puntos'];
		if ($puntostotales >= $mp)
		{
			$montopuntos = -(filter_input(INPUT_POST, 'montopuntos', FILTER_SANITIZE_SPECIAL_CHARS));
			$restaracumulacion=mysqli_query(parent::con(),"INSERT INTO `acumulacion`(`fecha`,`dni`,`apellido`,`nombre`,`descripcion`,`puntos`) VALUES ('$fecha','$dni','$apellido','$nombre','$descripcion','$montopuntos')");
			return $restaracumulacion;
		} else {
			$error = true;
			return $error;
		}
		

	}
}

/*class sumapuntos extends Conexion
{
	public function sumarpuntos()
	{
		$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
		$puntos = filter_input(INPUT_POST, 'puntos', FILTER_SANITIZE_SPECIAL_CHARS);
		$suma=mysqli_query(parent::con(),"UPDATE usuarios SET puntos=puntos+'$puntos' WHERE usuario='$dni'");
		return $suma;
	}
}*/
class restapuntos extends Conexion
{
	public function restarpuntos()
	{
		$dni = $_SESSION['usuario'];
		$puntos = $_SESSION['puntos'];
		$montopuntos = filter_input(INPUT_POST, 'montopuntos', FILTER_SANITIZE_SPECIAL_CHARS);
		if ($puntos >= $montopuntos)
		{
		$_SESSION['puntos'] = $_SESSION['puntos']-$montopuntos;
		$resta=mysqli_query(parent::con(),"UPDATE usuarios SET puntos=puntos-'$montopuntos' WHERE usuario='$dni'"); 
		return $resta;
		}
		else
		{
			$error=true;
			return $error;
		}
	}
}

class cuentap extends Conexion
{
	public function ptscount()
	{
		$dni = $_SESSION['usuario'];
		$puntosacum=mysqli_query(parent::con(),"SELECT SUM(puntos) AS ptotales FROM `acumulacion` WHERE `dni`='$dni'");
		$row = mysqli_fetch_array($puntosacum, MYSQLI_ASSOC);
		$montopuntos = filter_input(INPUT_POST, 'montopuntos', FILTER_SANITIZE_SPECIAL_CHARS);
		$puntostot=$row["ptotales"];
		if ($puntostot >= $montopuntos) {
			$puntostot=$row["ptotales"]-$montopuntos;
		}
		return $puntostot;
	}
}

class cantacum extends Conexion
{
	public function cuentaacum()
	{
		$dni = $_SESSION['usuario'];
		$query = mysqli_query(parent::con(),"SELECT SUM(puntos) as sumacum FROM `acumulacion` WHERE `dni`='$dni' AND `puntos` > 0 AND `fecha` > NOW() - INTERVAL 180 DAY");
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		$categoria = $_SESSION['categoria'];
		if (($row["sumacum"]) <= 1500) {
			$categoria = $categoria - 1;
			if ($categoria < 0) {
				$categoria = 0;
			}
		}
		else
		{
			$categoria = 1;
			$query2 = mysqli_query(parent::con(),"SELECT SUM(puntos) as sumacum FROM `acumulacion` WHERE `dni`='$dni' AND `puntos` > 0 AND `fecha` > NOW() - INTERVAL 90 DAY");
			$row2 = mysqli_fetch_array($query2, MYSQLI_ASSOC);
			if (($row2["sumacum"]) > 3500) {
			$categoria = $categoria + 1;
			if ($categoria > 2) {
				$categoria = 2;
				}
			}
		}
		if ($categoria > $_SESSION['categoria']) {
			$fecha = date('Y/m/d');
			mysqli_query(parent::con(),"UPDATE `usuarios` SET `categoria`='$categoria',`cambio_cat`='$fecha' WHERE `usuario` = '$dni'");
		}
		else {
			$query3 = mysqli_query(parent::con(),"SELECT `cambio_cat` FROM `usuarios` WHERE `usuario` = '$dni'");
			$row3 = mysqli_fetch_array($query3, MYSQLI_ASSOC);
			$fecha1 = $row3['cambio_cat'];
			$cambio_cat = new DateTime($fecha1);
			$ahora = new DateTime();
			$intervalo = date_diff($cambio_cat, $ahora);
			$intervalnum = $intervalo->format('%a');
			if ($intervalnum > 180) {
				$fechahoy = date('Y/m/d');
				mysqli_query(parent::con(),"UPDATE `usuarios` SET `categoria`='$categoria',`cambio_cat`='$fechahoy' WHERE `usuario` = '$dni'");
			}
		}
		return $categoria;
		// return $row["sumacum"];
	}
}


/* class cantacum extends Conexion
{
	public function cuentaacum()
	{
		$dni = $_SESSION['usuario'];
		$query = mysqli_query(parent::con(),"SELECT SUM(puntos) as sumacum FROM `acumulacion` WHERE `dni`='$dni' AND `puntos` > 0 AND `fecha` > NOW() - INTERVAL 90 DAY");
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			if (($row["sumacum"]) <= 15000) {
			$categoria = 0;}
			else
			{ 
			if (($row["sumacum"]) <= 30000) {
			$categoria = 1;
			
		}
				else
				{
				$categoria = 2;
				$dni = $_SESSION['usuario'];
				$query = mysqli_query(parent::con(),"SELECT SUM(puntos) as sumacum FROM `acumulacion` WHERE `dni`='$dni' AND `puntos` > 0 AND `fecha` > NOW() - INTERVAL 180 DAY");
				$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
				if (($row["sumacum"]) <= 15000) {
					$categoria = $categoria - 1;
					if ($categoria < 0) {
						$categoria = 0;
					}
				}
		mysqli_query(parent::con(),"UPDATE `usuarios` SET `categoria`=$categoria WHERE `usuario` = '$dni'");
		return $categoria;
		// return $row["sumacum"];
	}
}
}
}*/ 
class canjevoucher extends Conexion
{
	public function canjearvoucher()
		{
			$nvoucherabc = generar_voucher_abc(2);
			$nvouchernum = generar_voucher_num(6);
			$nvoucher = $nvoucherabc . $nvouchernum;
			$dni = $_SESSION['usuario'];
			$apellido = $_SESSION['apellido'];
			$nombre = $_SESSION['nombre'];
			$email = $_SESSION['mail'];
			$fecha = date('Y/m/d');
			$importe = filter_input(INPUT_POST, 'importe', FILTER_SANITIZE_SPECIAL_CHARS);
			$montopuntos = filter_input(INPUT_POST, 'montopuntos', FILTER_SANITIZE_SPECIAL_CHARS);
			$premio = filter_input(INPUT_POST, 'premio', FILTER_SANITIZE_SPECIAL_CHARS);
			$puntostotales = $_SESSION['puntos'];
			$nombrecom=new Stores;
			$nombrecom=$nombrecom->traerStore();
			if ($puntostotales >= $montopuntos)
			{	
			$canjevoucher=mysqli_query(parent::con(),"INSERT INTO `vouchers`(`n_voucher`,`dni`,`apellido`,`nombre`,`fechacanje`,`importe`,`premio`,`puntos`) VALUES ('$nvoucher','$dni','$apellido','$nombre','$fecha','$importe','$premio','$montopuntos')");
			$nombre_est = nombre_est();
			$web = web_est();
			$estilo = estilo_est();
			//$webreservas = "http://reservaturno.com/results?search=barber%20%25job";
			$emailest = mail_est();
			require "class.phpmailer.php";
			require "class.smtp.php";
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Host='smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;
			$mail->Username = "sorsrewards@foconetworks.com";
			$mail->Password = "foconet2017";
			$mail->setFrom("$emailest", $nombrecom['st_name']);
			$mail->AddAddress("$email");
			$mail->IsHTML(true);
			$mail->CharSet="utf-8";
			$mail->Subject = 'Canje de Puntos';
			$msg = '<html><body '.$estilo.'>';
			$msg .= '<p style="font-weight:bold;">';
			$msg .= "Hola,";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Has canjeado ".$montopuntos." Puntos de tu cuenta personal por el siguiente Premio de nuestro Programa de Recompensas: ";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "N° de Voucher: ".$nvoucher;
			$msg .= '<br>';
			if (($premio) == "Voucher") {
			$msg .= "Valor del Voucher: $ ".$importe;
			}
			else {
			$msg .= "Valor del Voucher: ".$premio;
			}
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "N° de Socio: ".$dni;
			$msg .= '<br>';
			$msg .= "Apellido: ".$apellido;
			$msg .= '<br>';
			$msg .= "Nombre: ".$nombre;
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Por favor, imprime o guarda este correo para ser presentado en nuestro establecimiento.";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Recuerda que puedes administrar tu cuenta personal, consultar tus movimientos, y canjear tus Puntos por Premios, ingresando <a href=".$web.">aquí</a>.";
			//$msg .= '<br>';
			//$msg .= '<br>';
			//$msg .= "Puedes reservar tu turno ingresando <a href=".$webreservas.">aquí</a>, o comunicate telefónicamente para hacer tu reserva y avisanos que tenés un Barber Check.";
			$msg .= '<br>';
			$msg .= '<br>';
			//$msg .= $sucursales;
			//$msg .= '<br>';
			//$msg .= "Proximamente Sucursal Villa del Parque. Nogoyá 3272, Ciudad Autónoma de Buenos Aires.";
			//$msg .= '<br>';
			//$msg .= '<br>';
			$msg .= '<img src="https://www.flowit.es/loyalty/img/logos/'.$nombrecom['st_alias'].'.png" alt="" style="max-width:300px;"  />';
			$msg .= '</html></body>';
			$mail->MsgHTML($msg);
			if(!$mail->Send())
			{
			   echo "Message could not be sent. <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			}
			return $nvoucher;
			}
			else
			{
				$error=true;
				return $error;
			}
		}
}

class sumaimportes extends Conexion
{	
	public function sumarimportes()
	{
		$result = mysqli_query(parent::con(),"SELECT SUM(importe) as total FROM vouchers WHERE canjeado=0");
		$row = mysqli_fetch_assoc($result);
		return $row["total"];
	}
}

class sumacanjeado extends Conexion
{	
	public function sumarcanjeado()
	{
		$result = mysqli_query(parent::con(),"SELECT SUM(importe) as total FROM vouchers WHERE canjeado=1");
		$row = mysqli_fetch_assoc($result);
		return $row["total"];
	}
}

class sumasucursal extends Conexion 
{
	public function sumarsucursales ()
	{
		$result=mysqli_query(parent::con(),"SELECT sucursal, SUM(monto) FROM acumulacion GROUP BY sucursal");
		while ($row = mysqli_fetch_array($result))
			   {
			      $res_return[] = $row;
			   }
		return $res_return;
	}
}

class modalvou extends Conexion
{
	public function modalvoucher()
	{
		$nvoucher = filter_input(INPUT_POST, 'voucher', FILTER_SANITIZE_SPECIAL_CHARS);
		$result = mysqli_query(parent::con(),"SELECT * FROM vouchers WHERE n_voucher='$nvoucher' ");
		$row=mysqli_fetch_array($result);
		return $row;
	}
}

class cumples extends Conexion 
{
	public function cumpleanos()
	{
		$current_date = date("m-d");
		$result = mysqli_query(parent::con(),"SELECT * FROM usuarios WHERE fechanac LIKE '%$current_date%'");
		while ($row = mysqli_fetch_assoc($result))
			   {
			      $res_return[] = $row;
			   }
		return $res_return;
	}
}

class top5 extends Conexion
{
	public function topcinco()
	{
		$result = mysqli_query(parent::con(),"SELECT nombre, apellido, puntos FROM usuarios ORDER BY puntos DESC LIMIT 10");
		while ($row = mysqli_fetch_assoc($result))
		{
			$res_return[] = $row;
		}
		return $res_return;
	}
}

class aceptarvou extends Conexion
{
	public function aceptarvoucher(){
		//$con=new mysqli('localhost', 'root', '', 'voucherlatampass');
		//$cuit = filter_input(INPUT_POST, 'cuit', FILTER_SANITIZE_SPECIAL_CHARS);
		$nvoucher = filter_input(INPUT_POST, 'voucher', FILTER_SANITIZE_SPECIAL_CHARS);
		
		if(!empty($nvoucher)) { 
			$result = mysqli_query(parent::con(),"SELECT * FROM vouchers WHERE n_voucher ='$nvoucher' ");			
			$cnt=$result->num_rows;
			$sucursal = $_SESSION['sucursaladmin'];
			if($cnt>0) {
				$row = $result->fetch_assoc();
				$canjeado = $row["canjeado"];
				if ($canjeado == 0) {
						mysqli_query(parent::con(),"UPDATE `vouchers` SET `canjeado`='1',`sucursal`='$sucursal' WHERE `n_voucher` = '$nvoucher'");
						$consultadni = mysqli_query(parent::con(),"SELECT `dni`,`premio`,`importe` FROM `vouchers` WHERE `n_voucher` = '$nvoucher'");
						$rowdni=mysqli_fetch_array($consultadni);
						$dni=$rowdni['dni'];
						$premio=$rowdni['premio'];
					    $importe=$rowdni['importe'];
						$consultapremio = mysqli_query(parent::con(),"SELECT `item`,`valordinero` FROM `tbl_listavouchers` WHERE `item` = '$premio' AND `valordinero` != 0" );
						$rowpremio=mysqli_fetch_array($consultapremio);
						$valordinero=$rowpremio['valordinero'];
						$consultamail = mysqli_query(parent::con(),"SELECT `mail` FROM `usuarios` WHERE `usuario` = '$dni'");
						$rowmail=mysqli_fetch_array($consultamail);
						$email=$rowmail['mail'];
						$nombre_est = nombre_est();
						$web = web_est();
						$estilo = estilo_est();
						$emailest = mail_est();
						$nombrecom=new Stores;
						$nombrecom=$nombrecom->traerStore();
						require "class.phpmailer.php";
						require "class.smtp.php";
						$mail = new PHPMailer();
						$mail->IsSMTP();
						$mail->Host='smtp.gmail.com';
						$mail->SMTPAuth = true;
						$mail->SMTPSecure = 'tls';
						$mail->Port       = 587;
						$mail->Username = "sorsrewards@foconetworks.com";
						$mail->Password = "foconet2017";
						$mail->setFrom("$emailest", $nombrecom['st_name']);
						$mail->AddAddress("$email");
						$mail->IsHTML(true);
						$mail->CharSet="utf-8";
						$mail->Subject = 'Premio canjeado';
						$msg = '<html><body '.$estilo.'>';
						$msg .= '<p style="font-weight:bold;">';
						$msg .= "Hola,";
						$msg .= '<br>';
						$msg .= '<br>';
						$msg .= "Has canjeado el Voucher ".$nvoucher." en ".$nombre_est;
						$msg .= '<br>';
						$msg .= '<br>';
						$msg .= "Recuerda que puedes administrar tu cuenta personal, consultar tus movimientos, y canjear tus Puntos por Premios, ingresando <a href=".$web.">aquí</a>.";
						$msg .= '<br>';
						$msg .= '<br>';
						$msg .= "Saludos!";
						$msg .= '<br>';
						$msg .= '<hr>';
						$msg .= '</p>';
						$msg .= '<img src="https://flowit.es/loyalty/img/logos/'.$nombrecom['st_alias'].'.png" alt="" style="max-width:300px;"  />';
						$msg .= '</html></body>';
						$mail->MsgHTML($msg);
						if(!$mail->Send())
						{
						   echo "Message could not be sent. <p>";
						   echo "Mailer Error: " . $mail->ErrorInfo;
						}
						$mensaje = "El voucher se ha validado con éxito. Es valido por $premio";	
						if ($importe < 10000) {
							$mensaje .= " + $ $valordinero";
						}
						return $mensaje;
				} else {
					return $mensaje = "Error en los datos. El voucher ya se ha utilizado.";
				}
			} else {
				return $mensaje="Voucher no encontrado";
			}
		} else {
			return $mensaje='Complete los campos';
		}
		$panel="canj";
		echo '<a href="index.php?panel='.$panel.'"</a>';
	}
}

class vouchers extends Conexion {
	public function listarVoucher()
		{
		$query=	"SELECT * FROM `tbl_listavouchers` ORDER BY `valorpuntos`";


							$result_prod=mysqli_query(parent::con(),"$query");
							$row_cnt = mysqli_num_rows($result_prod);
							$imagenv='parmegiano.png';
							$nombrevoucher='Voucher';
							
							if($row_cnt>0) {
								while($prod=$result_prod->fetch_assoc())
								{
								echo '

								<div class="col-sm-4 col-lg-4 col-md-4">
                        			<div class="thumbnail" style="background-image: url(../loyalty/img/imgcupon/'.$prod['img'].');">
                                        <div class="row fondoRow">
                                        <div class="col-4">
                                            <div class="imagenvou">
                                                
                                            </div>
                                        </div>
                            			
 
                                    <div class="col-8">
                                        <div class="caption">
                                        <h4>'.$prod['valorpuntos'].' Puntos';
											if (($prod['valordinero']) > 0) {
												echo ' + $ '.$prod['valordinero'].'</h4>';
											}	else {
												echo '</h4>';
											}
										echo '<h4>'.$prod['item'].'
											</h4>
                                        <button id="canjear" class="btn btn-sors btn-canje" data-bs-toggle="modal" data-bs-target="#num'.$prod['ID'].'" name="canjear" value="canjear">CANJEAR</button>
                                        </div>
                                    </div>


                            </div>
                                

                        </div>
                    </div>
					
					<!-- Modal -->
					<div class="modal fade" id="num'.$prod['ID'].'" role="dialog">
					  <div class="modal-dialog modal-lg">
			  
				<!-- Modal content-->
								<div class="modal-content custom-modal">
								  <!-- Form Name -->
								  <br>
								  <div class="modal-body">
								  <legend class="text-center">¿Confirma canje de '.$prod['item'].'?<br>Se le descontarán '.$prod['valorpuntos'].' puntos de su cuenta.</legend>
								  <div class="form-group">
									<label class="control-label" for="submit"></label>
									<div>
									<form method="post">
									  <input type="hidden" name="importe" value="'.$prod['valorpuntos'].'">
									  <input type="hidden" name="montopuntos" value="'.$prod['valorpuntos'].'">
									  <input type="hidden" name="premio" value="'.$prod['item'].'">
									  <button id="submit'.$prod['ID'].'" name="canje1" class="btn btn-primary btn-sors" value="canje1">ACEPTAR</button>
									  <button type="button" class="btn pull-right btn-sors" data-bs-dismiss="modal">CANCELAR</button>
									</form>
									</div>
								  </div>
							  </div>
				
						  </div>
					  </div>
				  </div>';
								}
		}
	}
}

class editarvoucher extends Conexion {
	public function editVoucher(){
		$result=mysqli_query(parent::con(), "SELECT * FROM `tbl_listavouchers` ORDER BY `valorpuntos`");
		$row_cnt = mysqli_num_rows($result);
		if($row_cnt>0) {
			echo '<table class="table table-striped">
			  <tr>
				<th>ID</th>
				<th>Producto</th>
				<th>Puntos Necesarios</th>
				<th>$ Necesario</th>
				<th>GUARDAR</th>
			  </tr>';
				while($prod=$result->fetch_assoc()) {
					echo '<form method="post"><tr><td><input type="text" class="form-control numeroid" name="id" value="'.$prod['ID'].'" readonly> </td>';
					echo '<td><input type="text" class="form-control" name="item" value="'.$prod['item'].'"></td>';
					echo '<td><input type="number" class="form-control" name="valorpuntos" value="'.$prod['valorpuntos'].'"></td>';
					echo '<td><input type="number" class="form-control" name="valordinero" value="'.$prod['valordinero'].'"></td>';
					echo '<td><button id="submit" name="vouedit" class="btn btn-success" value="vouedit">EDITAR</button></td></tr></form>';
				}
			echo '</table>';
		}
	}
	
	public function guardarVoucher(){
		$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
		$item = filter_input(INPUT_POST, 'item', FILTER_SANITIZE_SPECIAL_CHARS);
		$valordinero = filter_input(INPUT_POST, 'valordinero', FILTER_SANITIZE_SPECIAL_CHARS);
		$valorpuntos = filter_input(INPUT_POST, 'valorpuntos', FILTER_SANITIZE_SPECIAL_CHARS);
		$result=mysqli_query(parent::con(), "UPDATE tbl_listavouchers SET `item`='$item',`valordinero`='$valordinero',`valorpuntos`='$valorpuntos' WHERE ID='$id'");
		return $result;
	}
}

/*class aceptarvou extends Conexion
{
	 public function listaVoucherNoCanjeados()
	{
		$result=mysqli_query(parent::con(),"SELECT *, DATE_FORMAT(fechacanje,'%d-%m-%Y') AS fechala FROM `vouchers` WHERE `canjeado`= 0 ORDER BY `id` DESC");
		$panel="canj";
		while($voucher=$result->fetch_assoc()){
		
			echo '<tr><td>'.$voucher['n_voucher'].'</td>
			<td>'.$voucher['dni'].'</td>
			<td>'.$voucher['apellido'].'</td>
			<td>'.$voucher['nombre'].'</td>
			<td>'.$voucher['fechala'].'</td>
			<td>'.$voucher['importe'].'</td>
			<td><a href="elmirasol.php?vaucher='.$voucher['n_voucher'].'&panel='.$panel.'" style="width:100%;" name="aceptarvoucher" value="aceptarvoucher" class="btn btn-info" data-confirm="Confirma el canje del Voucher '.$voucher['n_voucher'].'"> Aceptar </a></td></tr>';
		}
	}
	
	private $id_vaucher;
	
	public function aceptarvoucher($numvaucher)
	{
		$this->id_vaucher = mysqli_real_escape_string(parent::con(), $numvaucher);
		
		mysqli_query(parent::con(),"UPDATE vouchers SET canjeado='1' WHERE n_voucher='$this->id_vaucher'");
		return "El voucher fue canjeado con éxito";
	}
}*/

class editarinfo extends Conexion
{
	public function ver()
	{
		$dni = $_SESSION['usuario'];
		$result=mysqli_query(parent::con(),"SELECT * FROM `usuarios` WHERE usuario='$dni'");
		return $result->fetch_assoc();
	}
	public function editar()
	{
		$dni = $_SESSION['usuario'];
		$apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_SPECIAL_CHARS);
		$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
		$mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_SPECIAL_CHARS);
		$fechanac = filter_input(INPUT_POST, 'fechanac', FILTER_SANITIZE_SPECIAL_CHARS);
		$domicilio = filter_input(INPUT_POST, 'domicilio', FILTER_SANITIZE_SPECIAL_CHARS);
		$ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
		$result = mysqli_query(parent::con(),"UPDATE usuarios SET `apellido`='$apellido',`nombre`='$nombre',`mail`='$mail',`fechanac`='$fechanac',`domicilio`='$domicilio',`ciudad`='$ciudad',`recup-pass`='$password',`password`=MD5('$password') WHERE usuario='$dni'");
		return $result;
	}
}

class productos extends Conexion
{
	public function lista_prod()
	{
		$productos=mysqli_query(parent::con(),"SELECT * FROM `productos`");
		echo '<input id="producto" name="producto" list="allProducts" class="form-control input-md" placeholder="Producto" required /> <datalist id="allProducts">';
		while ($rows=mysqli_fetch_array($productos)) {
			?> <option value="<?php echo $rows["codigo"].$rows["producto"]; ?>">
			<?php
		}
		?>
		</datalist>
		<?php
	}
}

class recuperarpass extends Conexion
{
	public function recuppass()
	{
		$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
		$email = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_SPECIAL_CHARS);
		$query = mysqli_query(parent::con(),"SELECT * FROM usuarios WHERE usuario='$dni' AND `mail`='$email'");
		$count = mysqli_num_rows($query);
		if ($count!=0) {
					$codigo1 = generar_voucher_abc(6);
					$codigo2 = generar_voucher_num(6);
					$codigorecup = $codigo1 . $codigo2;
					$linkrecup = "https://www.sorsrewards.com/parmegiano/recupero.php?code=".$codigorecup."&dni=".$dni;
					$result=mysqli_query(parent::con(),"INSERT INTO `tbl_recuppass`(`re_dni`,`re_codigo`) VALUES ('$dni','$codigorecup')");
					$rowrecup=mysqli_fetch_array($query);
					$dni=$rowrecup['usuario'];
					$email=$rowrecup['mail'];
					$password=$rowrecup['recup-pass'];
					$web = web_est();
					$emailest = mail_est();
					$nombrecom=new Stores;
					$nombrecom=$nombrecom->traerStore();
					require "class.phpmailer.php";
						require "class.smtp.php";
						$mail = new PHPMailer();
						$mail->IsSMTP();
						$mail->Host='smtp.gmail.com';
						$mail->SMTPAuth = true;
						$mail->SMTPSecure = 'tls';
						$mail->Port       = 587;
						$mail->Username = "sorsrewards@foconetworks.com";
						$mail->Password = "foconet2017";
						$mail->setFrom("$emailest", $nombrecom['st_name']);
						$mail->AddAddress("$email");
						$mail->IsHTML(true);
						$mail->CharSet="utf-8";
			$mail->Subject = 'Recupero de contraseña';
			$msg = '<html><body '.$estilo.'>';
			$msg .= '<p style="font-weight:bold;">';
			$msg .= "Hola,";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Este mail fue generado para la recuperación de su contraseña.";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Utiliza el siguiente link para resetear tu contraseña:";
			$msg .= '<br>';
			$msg .= $linkrecup;
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Si no solicitaste el recupero de tu contraseña, cambiala de inmediato.";
			$msg .= '<br>';
			$msg .= '<br>';
			$msg .= "Saludos!";
			$msg .= '<br>';
			$msg .= '<hr>';
			$msg .= '</p>';
			$msg .= '<img src="https://flowit.es/loyalty/img/logos/'.$nombrecom['st_alias'].'.png" alt="" style="max-width:300px;"  />';
			$msg .= '</html></body>';
			$mail->MsgHTML($msg);
				if(!$mail->Send())
						{
  								 echo "Message could not be sent. <p>";
   								 echo "Mailer Error: " . $mail->ErrorInfo;
						}
			$error = 1;
		}
		else {
			$error = 0;
		}
		return $error;
	}
	
	public function recuppass2() {
		$dni = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);
		$code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
		$query = mysqli_query(parent::con(),"SELECT * FROM tbl_recuppass WHERE `re_dni`='$dni' AND `re_codigo`='$code'");
		$rownomape=mysqli_fetch_array($query);
		$codigo=$rownomape['re_codigo'];
		$usado=$rownomape['re_usado'];
		if (($usado == 0) && ($codigo == $code)) {
			$cambiopass = mysqli_query(parent::con(),"UPDATE `tbl_recuppass` SET `re_usado`='1' WHERE `re_codigo`='$code'");
			$result = mysqli_query(parent::con(),"UPDATE `usuarios` SET `recup-pass`='$password',`password`=MD5('$password') WHERE `usuario`='$dni'");
			header( 'Location: https://www.sorsrewards.com/parmegiano/?cambiopass=exito' );
		} else {
			$error = 0;
		}
		return $error;
	}
}

?>