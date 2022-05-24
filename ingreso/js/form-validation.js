jQuery(document).ready(function($){

	// hide messages socios 
	$(".warning").hide();
	$("#sent-form-msg, #sent-form-msgNS, #sent-form-mail, #sent-form-mail2").hide();
	
	
	// on submit...
	$("#form_carga_km #submit").click(function() {
		$(".warning").hide();
		
		//required:
		
		//nombre
		var name = $("input#primer_nombre").val();
		var er_name = /^([a-zA-Z´`áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{2,40})+$/; 
		if(!er_name.test(name)) {   
				$("#error_nombre").fadeIn().text("(Nombre inválido)");
				$("input#primer_nombre").focus();
				return false; 
			}			
		
		// apellido
		var apellido = $("input#apellido").val();
		var er_apellido = /^([a-zA-Z´`áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{2,40})+$/; 
		if(!er_apellido.test(apellido)) {   
				$("#error_apellido").fadeIn().text("(Apellido inválido)");
				$("input#apellido").focus();
				return false;  
			}
		
		
		var num_documento = $("input#num_documento").val();
		var er_dni = /^([0-9]{7,10})+$/;
			if(!er_dni.test(num_documento)) {   
				$("#error_documento").fadeIn().text("(Numero de documento inválido)");
				$("input#num_documento").focus();
				return false;  
			} 

		
		//importe
		var importe_pesos = $("input#importe_pesos").val();
		var importe_cent = $("input#importe_cent").val();
		var er_importe = /^[0-9]+$/; 
		if(!er_importe.test(importe_pesos) || !er_importe.test(importe_cent)) {   
				$("#error_importe").fadeIn().text("(Importe inválido)");
				$("input#importe_pesos").focus();
				return false; 
			}

		
		// nacionalidad
		var nacionalidad = $("select#nacionalidad").val();
		// numero socio
		var numero_lanpass = $("input#numero_lanpass").val();
		// comercio
		var comercio = $("input#comercio").val();
				
		// send php
		var sendSocios = $("input#send-socios").val();
			
		// data string
		var dataString = 'name='+ name
						+ '&apellido=' + apellido
						+ '&nacionalidad=' + nacionalidad        
						+ '&num_documento=' + num_documento
						+ '&numero_lanpass=' + numero_lanpass
						+ '&importe_pesos=' + importe_pesos
						+ '&importe_cent=' + importe_cent
						+ '&comercio=' + comercio;
												         
		// ajax
		$.ajax({
			type:"POST",
			url: sendSocios,
			data: dataString,
			success: success()
		});
	});  
	
	
	
	
	
	
	// on submit...
	$("#form_carga_km_no_socios #submit").click(function() {
		$(".warning").hide();
		
		
		//nombre
		var NSname = $("input#NSprimer_nombre").val();
		var er_name = /^([a-zA-Z´`áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{2,40})+$/;
		if(!er_name.test(NSname)) {   
				$("#error_nombreNS").fadeIn().text("(Nombre inválido)");
				$("input#NSprimer_nombre").focus();
				return false; 
			}			
		
		// apellido
		var NSapellido = $("input#NSapellido").val();
		var er_apellido = /^([a-zA-Z´`áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{2,40})+$/;
		if(!er_apellido.test(NSapellido)) {   
				$("#error_apellidoNS").fadeIn().text("(Apellido inválido)");
				$("input#NSapellido").focus();
				return false;  
			}
		

		// fecha de nacimiento
		var NSfecha_nac = $("input#NSfecha_nac").val();
		var estructura_fecha = /^\d{2}\/\d{2}\/\d{4}$/;
		if(!estructura_fecha.test(NSfecha_nac)) {   
				$("#error_fecha_nacNS").fadeIn().text("(Fecha inválida)");
				$("input#NSfecha_nac").focus();
				return false; 
			}
			// Cadena Año  
			var Ano= new String(NSfecha_nac.substring(NSfecha_nac.lastIndexOf("/")+1,NSfecha_nac.length))
			// Cadena Mes  
			var Mes= new String(NSfecha_nac.substring(NSfecha_nac.indexOf("/")+1,NSfecha_nac.lastIndexOf("/")))  
			// Cadena Día  
			var Dia= new String(NSfecha_nac.substring(0,NSfecha_nac.indexOf("/")))  

			// Valido el año  
			if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900 || parseFloat(Ano)>2010){  
				$("#error_fecha_nacNS").fadeIn().text("(Año inválido)");
				$("input#NSfecha_nac").focus();
				return false;  
			}  
			// Valido el Mes  
			if (isNaN(Mes) || Mes.length<2 || parseFloat(Mes)<1 || parseFloat(Mes)>12){  
				$("#error_fecha_nacNS").fadeIn().text("(Mes inválido)");
				$("input#NSfecha_nac").focus();
				return false;   
			}  
			// Valido el Dia  
			if (isNaN(Dia) || Dia.length<2 || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){  
				$("#error_fecha_nacNS").fadeIn().text("(Dia inválido)");
				$("input#NSfecha_nac").focus();
				return false;  
			}  
			if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {  
				if (Mes==2 && Dia > 28 || Dia>30) {  
					$("#error_fecha_nacNS").fadeIn().text("(Fecha de Nacimiento inválida)");
					$("input#NSfecha_nac").focus();
					return false;   
				}  
			}    
		
		//Numero de documento
		var NSnum_documento = $("input#NSnum_documento").val();
		var er_dni = /^([0-9]{7,10})+$/;
			if(!er_dni.test(NSnum_documento)) {   
				$("#error_documentoNS").fadeIn().text("(Numero de documento inválido)");
				$("input#NSnum_documento").focus();
				return false;  
			}
		
		//mail
		var NSmail = $("input#NSmail").val();
		var er_mail = /^[0-9a-z_\-\.]+@[0-9a-z\-\.]+\.[a-z]{2,4}$/i;
			if(!er_mail.test(NSmail)) {   
				$("#error_mailNS").fadeIn().text("(Mail inválido)");
				$("input#NSmail").focus();
				return false;  
			} 
		
		//direccion
		var NSdireccion = $("input#NSdireccion").val();
		var er_direccion = /^([0-9a-zA-Z´`áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s\:\.\,\º\;-]{5,110})+$/;
			if(!er_direccion.test(NSdireccion)) {   
				$("#error_direccionNS").fadeIn().text("(Dirección inválida)");
				$("input#NSdireccion").focus();
				return false;  
			} 
		//localidad
		var NSlocalidad = $("input#NSlocalidad").val();
		var er_localidad = /^([a-zA-Z´`áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,40})+$/; 
		if(!er_localidad.test(NSlocalidad)) {   
				$("#error_localidadNS").fadeIn().text("(Localidad inválida)");
				$("input#NSlocalidad").focus();
				return false; 
			}
		//provincia
		var NSprovincia = $("input#NSprovincia").val();
		var er_provincia = /^([a-zA-Z´`áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{5,40})+$/; 
		if(!er_provincia.test(NSprovincia)) {   
				$("#error_provinciaNS").fadeIn().text("(Provincia/Estado inválido)");
				$("input#NSprovincia").focus();
				return false; 
			}
			
		//codigo postal
		var NScodigo_postal = $("input#NScodigo_postal").val();
		var er_postal = /^([0-9]{4,8})+$/; 
		if(!er_postal.test(NScodigo_postal)) {   
				$("#error_codigo_postalNS").fadeIn().text("(Código Postal inválido)");
				$("input#NScodigo_postal").focus();
				return false; 
			}

		
		//importe
		var NSimporte_pesos = $("input#NSimporte_pesos").val();
		var NSimporte_cent = $("input#NSimporte_cent").val();
		var er_importe = /^[0-9]+$/; 
		if(!er_importe.test(NSimporte_pesos) || !er_importe.test(NSimporte_cent)) {   
				$("#error_importeNS").fadeIn().text("(Importe inválido)");
				$("input#NSimporte_pesos").focus();
				return false; 
			}

		
		// nacionalidad
		var NSnacionalidad = $("select#NSnacionalidad").val();
		// tipo documento
		var NStipo_documento = $("select#NStipo_documento").val();
		// pais documento
		var NSpais_documento = $("select#NSpais_documento").val();

		var NSpais = $("select#NSpais").val();
		
		// comercio
		var NScomercio = $("input#NScomercio").val();
				
		// send php
		var sendNoSocios = $("input#send-no-socios").val();
			
		// data string
		var dataStringNoSocios = 'NSname='+ NSname
						+ '&NSapellido=' + NSapellido
						+ '&NSnacionalidad=' + NSnacionalidad        
						+ '&NSfecha_nac=' + NSfecha_nac
						+ '&NStipo_documento=' + NStipo_documento
						+ '&NSnum_documento=' + NSnum_documento
						+ '&NSpais_documento=' + NSpais_documento
						+ '&NSmail=' + NSmail
						+ '&NSdireccion=' + NSdireccion
						+ '&NSlocalidad=' + NSlocalidad
						+ '&NSprovincia=' + NSprovincia
						+ '&NSpais=' + NSpais
						+ '&NScodigo_postal=' + NScodigo_postal
						+ '&NSimporte_pesos=' + NSimporte_pesos
						+ '&NSimporte_cent=' + NSimporte_cent
						+ '&NScomercio=' + NScomercio;						         
		// ajax
		$.ajax({
			type:"POST",
			url: sendNoSocios,
			data: dataStringNoSocios,
			success: success2()
		});
	});
	
	
	
	// on submit...
	$("#contactForm #submit").click(function() {
		$("#error").hide();
		
		//required:
		
		//name
		var nombre = $("input#nombre").val();
		if(nombre == ""){
			$("#error").fadeIn().text("Se requiere el Nombre");
			$("input#nombre").focus();
			return false;
		}
		
		// email
		var mail = $("input#mail").val();
		if(mail == ""){
			$("#error").fadeIn().text("(Se requiere el Email)");
			$("input#mail").focus();
			return false;
		}
	
		
		// comments
		var mensaje = $("#mensaje").val();
		
		// send mail php
		var sendMailUrl = $("#sendMailUrl").val();
		
		//to, from & subject
		var to = $("#to").val();
		var from = $("#from").val();
		var subject = $("#subject").val();
		
		// data string
		var dataString = 'nombre='+ nombre
						+ '&mail=' + mail        
						+ '&mensaje=' + mensaje
						+ '&to=' + to
						+ '&from=' + from
						+ '&subject=' + subject;						         
		// ajax
		$.ajax({
			type:"POST",
			url: sendMailUrl,
			data: dataString,
			success: success3()
		});
	});
	
	
	// on submit...
	$("#contactForm2 #submit").click(function() {
		$("#error2").hide();
		
		//required:
		
		//name
		var nombre = $("input#nombre2").val();
		if(nombre == ""){
			$("#error2").fadeIn().text("Se requiere el Nombre");
			$("input#nombre2").focus();
			return false;
		}
		
		// email
		var mail = $("input#mail2").val();
		if(mail == ""){
			$("#error2").fadeIn().text("(Se requiere el Email)");
			$("input#mail2").focus();
			return false;
		}
	
		
		// comments
		var mensaje = $("#mensaje2").val();
		
		// send mail php
		var sendMailUrl = $("#sendMailUrl2").val();
		
		//to, from & subject
		var to = $("#to2").val();
		var from = $("#from2").val();
		var subject = $("#subject2").val();
		
		// data string
		var dataString = 'nombre='+ nombre
						+ '&mail=' + mail        
						+ '&mensaje=' + mensaje
						+ '&to=' + to
						+ '&from=' + from
						+ '&subject=' + subject;						         
		// ajax
		$.ajax({
			type:"POST",
			url: sendMailUrl,
			data: dataString,
			success: success4()
		});
	});
	
		
	// on success...
	 function success(){
	 	$("#sent-form-msg").fadeIn();
	 	$("#form_carga_km").fadeOut();
	 }
	 
	 // on success...
	 function success2(){
	 	$("#sent-form-msgNS").fadeIn();
	 	$("#form_carga_km_no_socios").fadeOut();
	 }
	 
	 function success3(){
	 	$("#sent-form-mail").fadeIn();
	 	$("#contactForm").fadeOut();
	 }
	 
	 function success4(){
	 	$("#sent-form-mail2").fadeIn();
	 	$("#contactForm2").fadeOut();
	 }
	
    return false;
});

