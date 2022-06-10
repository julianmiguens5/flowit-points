<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo ($storename['st_name']); ?> - Flowit Loyalty</title>
    
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

<!-- icofont --> 

<link rel="stylesheet" type="text/css" href="./css/icofont.min.css">

<meta name="msapplication-TileColor" content="#ffffff">
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
            <ul class="list-group list-group-horizontal spaceIconos">
                <li class="iconosHeader"><i class="fa fa-instagram" aria-hidden="true"></i></li>
                <li class="iconosHeader"><i class="fa fa-facebook" aria-hidden="true"></i></li>
                
            </ul>
    </nav>
	
              </div>
            </div>
</body>