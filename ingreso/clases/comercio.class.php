<?php 
include_once("conexion.class.php");


class comercio{
	
 	var $con;
 	public function comercio(){
 		$this->con=new DBManager;
 	}

	public function agregar_kms_socios($comercio, $rg_fecha_canje, $name, $apellido, $nacionalidad, $num_documento, $numero_lanpass, $importe){
		if($this->con->conectar()==true){
			
			$result=mysql_query("SELECT moneda_consumo FROM usuarios WHERE usuario='$comercio'");
			$datos=mysql_fetch_assoc($result);
			
			if($datos["moneda_consumo"]=='peso') {
				mysql_query("INSERT INTO `tbl_registros` (rg_comercio, rg_condicion, rg_fecha_canje, rg_nombre, rg_apellido, rg_nacionalidad, rg_numero_documento, rg_numero_socio, rg_importe_pesos) VALUES ('$comercio','socio','$rg_fecha_canje','$name', '$apellido','$nacionalidad','$num_documento','$numero_lanpass','$importe')");
			} else {
				mysql_query("INSERT INTO `tbl_registros` (rg_comercio, rg_condicion, rg_fecha_canje, rg_nombre, rg_apellido, rg_nacionalidad, rg_numero_documento, rg_numero_socio, rg_importe_dolares) VALUES ('$comercio','socio','$rg_fecha_canje','$name', '$apellido','$nacionalidad','$num_documento','$numero_lanpass','$importe')");
			}
			
		}
	}
	
	public function agregar_kms_no_socios($NScomercio, $rg_fecha_canje, $NSname, $NSapellido, $NSnacionalidad, $NSfecha_nac, $NStipo_documento, $NSnum_documento, $NSpais_documento, $NSmail, $NSdireccion, $NSlocalidad, $NSprovincia, $NSpais, $NScodigo_postal, $importe){
		if($this->con->conectar()==true){
			
			$result=mysql_query("SELECT moneda_consumo FROM usuarios WHERE usuario='$NScomercio'");
			$datos=mysql_fetch_assoc($result);
			
			if($datos["moneda_consumo"]=='peso') {
				mysql_query("INSERT INTO `tbl_registros` (rg_comercio, rg_condicion, rg_fecha_canje, rg_nombre, rg_apellido, rg_nacionalidad, rg_fecha_nacimiento, rg_tipo_documento, rg_numero_documento, rg_pais_documento, rg_mail, rg_direccion, rg_localidad, rg_provincia_estado, rg_pais_residencia, rg_codigo_postal, rg_importe_pesos) 
			VALUES 
('$NScomercio','no socio','$rg_fecha_canje','$NSname', '$NSapellido','$NSnacionalidad','$NSfecha_nac','$NStipo_documento','$NSnum_documento','$NSpais_documento','$NSmail', '$NSdireccion', '$NSlocalidad', '$NSprovincia', '$NSpais', '$NScodigo_postal','$importe')");
			} else {
				mysql_query("INSERT INTO `tbl_registros` (rg_comercio, rg_condicion, rg_fecha_canje, rg_nombre, rg_apellido, rg_nacionalidad, rg_fecha_nacimiento, rg_tipo_documento, rg_numero_documento, rg_pais_documento, rg_mail, rg_direccion, rg_localidad, rg_provincia_estado, rg_pais_residencia, rg_codigo_postal, rg_importe_dolares) 
			VALUES 
('$NScomercio','no socio','$rg_fecha_canje','$NSname', '$NSapellido','$NSnacionalidad','$NSfecha_nac','$NStipo_documento','$NSnum_documento','$NSpais_documento','$NSmail', '$NSdireccion', '$NSlocalidad', '$NSprovincia', '$NSpais', '$NScodigo_postal','$importe')");
			}
			
		}
	}
	
	public function filtros($comercio, $mes, $ano){
		if($this->con->conectar()==true){	
			
			$fecha_ini=date("Y-m-d",mktime(0,0,0,$mes-1,26,$ano));
			$fecha_fin=date("Y-m-d",mktime(0,0,0,$mes,26,$ano));
					
			return mysql_query("SELECT * FROM tbl_registros WHERE rg_comercio='".mysql_real_escape_string($comercio)."' AND rg_fecha_canje>='$fecha_ini' AND rg_fecha_canje<='$fecha_fin' ");
		}
	}
	
	public function informes($mes, $ano){
		if($this->con->conectar()==true){
			
			$fecha_ini=date("Y-m-d",mktime(0,0,0,$mes-1,26,$ano));
			$fecha_fin=date("Y-m-d",mktime(0,0,0,$mes,26,$ano));
					
			return mysql_query("SELECT * FROM tbl_registros INNER JOIN usuarios ON tbl_registros.rg_comercio=usuarios.usuario WHERE rg_fecha_canje>='$fecha_ini' AND rg_fecha_canje<='$fecha_fin' ORDER BY rg_comercio, rg_fecha_canje ASC");
		}
	}
	
	public function filtro_dni($comercio, $documento){
		if($this->con->conectar()==true){		
			return mysql_query("SELECT * FROM tbl_registros WHERE rg_comercio='".mysql_real_escape_string($comercio)."' AND rg_numero_documento='".mysql_real_escape_string($documento)."' ");
		}
	}
	
	public function paises(){
		if($this->con->conectar()==true){		
			return mysql_query("SELECT * FROM tbl_paises ");
		}
	}
	
	public function calculo_km($fecha_cotiz){
		if($this->con->conectar()==true){		
			return mysql_query("SELECT * FROM tbl_cotiz_dolar WHERE cot_fecha='".mysql_real_escape_string($fecha_cotiz)."' ");
		}
	}
	
	
	public function extract_registros($ayer){
		if($this->con->conectar()==true){		
			return mysql_query("SELECT * FROM tbl_registros WHERE rg_fecha_canje='$ayer' ");
		}
	}
	
	public function datos($comercio){
		if($this->con->conectar()==true){		
			$result=mysql_query("SELECT moneda_consumo FROM usuarios WHERE usuario='".mysql_real_escape_string($comercio)."'");
			return mysql_fetch_assoc($result);
		}
	}
	
	public function resultados($result){
		$this->array=mysql_fetch_assoc($result);
		return $this->array;
	}
	
}


class login{
	
 	var $con;
 	public function login(){
 		$this->con=new DBManager;
 	}
	
	var $query;
	var $arr_usuarios = array();
	var $password_from_db;
	
	public function esUsuario($usuario, $password){
		if($this->con->conectar()==true){
			$usuario=mysql_real_escape_string($usuario);
			
			$this->query = mysql_query("SELECT * FROM `usuarios` WHERE usuario = '$usuario'");
			$this->arr_usuarios=mysql_fetch_array($this->query);
			
			$this->password_from_db = $this->arr_usuarios['password'];
			
			if ( $this->password_from_db == $password ) {
				return $this->arr_usuarios;
			} else return false;
		}
	}
	
}
?>