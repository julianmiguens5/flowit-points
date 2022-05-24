<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo ($storename['st_name']); ?> - Iflow Loyalty</title>
    
	<link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/customfonts.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-datepicker3.css">
    <link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vegas/vegas.min.css">

    <!-- SORS ICON -->

    <link rel="apple-touch-icon" sizes="57x57" href="../img/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="../img/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="../img/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="../img/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="../img/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="../img/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="../img/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="../img/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="../img/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="../img/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="../img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="../img/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="../img/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	        <script>
            function obtenerSuma()
            {
                document.getElementById('resultado').value=(parseFloat((Math.round(document.getElementById('sumando1').value)/1.21)*0.1).toFixed(0));
                
                
            }
            </script>
        <script src="js/jquery.js"></script>
            
        <script src="vegas/vegas.min.js"></script>

    <script>
        $(document).ready(function(){
          // Add smooth scrolling to all links except Carousel
         // $("a").on('click', function(event)
          $('a[href*="#"]:not([href="#collapse1"])').on('click', function(event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
              // Prevent default anchor click behavior
              event.preventDefault();

              // Store hash
              var hash = this.hash;

              // Using jQuery's animate() method to add smooth page scroll
              // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
              $('html, body').animate({
                scrollTop: $(hash).offset().top
              }, 800, function(){
           
                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
              });
            } // End if
          });
        });
        </script>
	
	<script type="text/javascript">
        
        jQuery(document).ready(function($){

            // hide messages 
            $("#error").hide();
            $("#sent-form-msg").hide();
            
            // on submit...
            $("#form_contact #submitconsulta").click(function() {
                $("#error").hide();
                
                //required:
                        

                        var tipo_consulta = document.getElementsByName("tipo_consulta");
                        var seleccionado = false;
                        for(var i=0; i<tipo_consulta.length; i++) {    
                          if(tipo_consulta[i].checked) {
                            seleccionado = true;
                            var tipo=document.form_contact.tipo_consulta[i].value;
                            break;
                          }
                        } 
                        if(!seleccionado) {
                            $("#error").fadeIn().text("Selecciona el tipo de consulta");
                            $("input#tipo_consulta").focus();
                            return false;
                        }

                        
                        
                        var mensaje=document.form_contact["mensaje"].value;
                        if(mensaje == ""){
                            $("#error").fadeIn().text("Escribí tu consulta");
                            $("input#mensaje").focus();
                            return false;
                        }
                        
                        
                        var nombre=document.form_contact["nombre"].value;
                        var er_name = /^([a-zA-Z´`áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{2,40})+$/; 
                        if(!er_name.test(nombre)) {   
                                $("#error").fadeIn().text("Nombre incorrecto");
                                $("input#nombre").focus();
                                return false; 
                            }
                    
                        var email=document.form_contact["email"].value;
                        var er_mail = /^[0-9a-z_\-\.]+@[0-9a-z\-\.]+\.[a-z]{2,4}$/i;
                        if(!er_mail.test(email)) {   
                            $("#error").fadeIn().text("Mail incorrecto");
                            $("input#email").focus();
                            return false;  
                        } 

				var dni=document.form_contact["dni"].value;
                       
                       /* var er_codref = /^[A-Za-z0-9 ]{6,20}$/;
                        if(!er_codref.test(codref)) {   
                            $("#error").fadeIn().text("Código de referencia incorrecto");
                            $("input#codref").focus();
                            return false;  
                        } */
                    
                        
        
                
                // send mail php
                var sendMailUrl = 'enviar_mail.php';
                
                
                // data string
                var dataString = 'mensaje='+ mensaje
                                + '&tipo=' + tipo      
                                + '&nombre=' + nombre
                                + '&email=' + email
								+ '&dni=' + dni;
                // ajax
                $.ajax({
                    type:"POST",
                    url: sendMailUrl,
                    data: dataString,
                    success: success()
                });
            });  
            
        
            // on success...
             function success(){
                $("#sent-form-msg").fadeIn();
                $("#formulario_contacto").fadeOut();
             }
            
            return false;
            
        });
        
        
        
        $(document).ready(function() {
            function close_accordion_section() {
                $('.accordion .accordion-section-title').removeClass('active');
                $('.accordion .accordion-section-content').slideUp(300).removeClass('open');
            }
         
            $('.accordion-section-title').click(function(e) {
                // Grab current anchor value
                var currentAttrValue = $(this).attr('href');
         
                if($(e.target).is('.active')) {
                    close_accordion_section();
                }else {
                    close_accordion_section();
         
                    // Add active class to section title
                    $(this).addClass('active');
                    // Open up the hidden content panel
                    $('.accordion ' + currentAttrValue).slideDown(300).addClass('open'); 
                }
         
                e.preventDefault();
            });
        });
        

        </script>
        
        <script type="text/javascript">   
            function MostrarOcultar(capa)  
            {  
                if (document.getElementById)  
                {  
                    var aux = document.getElementById(capa).style;  
                    aux.display = aux.display? "":"block";
                }  
            }   
        </script> 
</head>

<body>

    <!-- Navigation -->


    <nav class="navbar navbar-dark bg-light">
    <div class="navbar-header">
                <a class="navbar-brand" target="_blank"><img src="img/logos/<?php echo $storename['st_alias'] ?>.png" alt=" " class="logo-primary"/></a>
                
                
                
            </div>
</nav>
	<div class="modal right fade" id="myModalconsultas" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                    
                      <div class="modal-body">
                    <div class="col contenido">
                        <div class="row">
                            <button type="button" class="btn btn-danger btn-sm pull-right" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </div>
                      
                        
                        <div id="formulario_contacto">
                                <br><br>
                                <div id="error" class="txt_error_contact"></div>
                                
                                <form name="form_contact" method="post" action="" id="form_contact">
                                
                                
                                    <div class="accordion">
                                        <div class="accordion-section">
                                            <a class="accordion-section-title active" href="#accordion-1">Paso 1. Tipo de Consulta</a>
                                             
                                            <div id="accordion-1" class="accordion-section-content open" style="display: block;">
                                                <div class="wrap_cons">
                                                <input name="tipo_consulta" id="tipo_consulta" type="radio"  value="Problema al recuperar la contraseña" onChange="javascript:MostrarOcultar('content2');">
                                                <label for="tipo_consulta" class="txt">Problema al recuperar la contraseña</label>
                                                
                                                                <div id="content2" class="block-consult" style="display:none;">
                                                                    
                                                                    <p>Para ayudarte a recuperarla llena los siguientes datos.<br>
                                                                    <br>
                                                                   </p>
                                                                 </div>
                                                </div>
                                                
                                                 <div class="wrap_cons">
                                                <input name="tipo_consulta" id="tipo_consulta" type="radio"  value="Otras Consultas">
                                                <label for="tipo_consulta" class="txt">Otras consultas</label>
                                                
                                                </div>
                                            </div><!--end .accordion-section-content-->
                                            <br>
                                        </div><!--end .accordion-section-->
                                        <div class="accordion-section">
                                            <a class="accordion-section-title" href="#accordion-3">Paso 2. Datos de Contacto</a>
                                             
                                            <div id="accordion-3" class="accordion-section-content">
                                                
                                                <label for="nombre" class="txt">Nombre y Apellido:</label><br>
                                                <input name="nombre" type="text" id="nombre" value="">
                                                <br>
                                                <label for="email" class="txt">Email:</label><br>
                                                <input name="email" type="email" id="email" value="">
												<br>
                                                <label for="dni" class="txt">DNI:</label><br>
                                                <input name="dni" type="text" id="dni" value="">
                                                
                                                
                                            </div><!--end .accordion-section-content-->
                                        </div><!--end .accordion-section-->
                                        
                                        <div class="accordion-section">
                                            <a class="accordion-section-title" href="#accordion-2">Paso 3. Consulta</a>
                                             
                                            <div id="accordion-2" class="accordion-section-content">
                                                <label for="mensaje" class="txt">Consulta:</label><br>
                                                <textarea name="mensaje" type="text" id="mensaje" rows="4" cols="50" value=""></textarea>
                                                <br>
                                                <br>
                                                <span class="button-wrap submit"><input type="button" value="Enviar consulta" name="submitconsulta" id="submitconsulta" class="btn btn-success button-pill"/></span>
                                            </div><!--end .accordion-section-content-->
                                            <br>
                                        </div><!--end .accordion-section-->
                                        
                                        
                                        
                                    </div><!--end .accordion-->
                                    
                                </form>
                        </div>

                        <p id="sent-form-msg" class="txt"><i class="fa fa-check"></i> Tu mensaje fue enviado. Estaremos atento a tu consulta para entregarte una pronta respuesta.<br />
<br />
<strong>Muchas gracias.</strong></p>

                        
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
</body>