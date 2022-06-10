<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo ($storename['st_name']); ?> - Flowit Loyalty</title>
    
	<link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/all.css" crossorigin="anonymous">
    <link href="../css/customfonts.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap-datepicker3.css">
    <link href="../css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../css/buttons.dataTables.min.css" rel="stylesheet">

    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <!-- SORS ICON -->

    <!-- icofont --> 

    <link rel="stylesheet" type="text/css" href="../css/icofont.min.css">

        <!-- SORS ICON -->

<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

	        <script>
            function obtenerSuma()
            {
                // tasa de acumulacion de 100 % (1)
                document.getElementById('resultado').value=(parseFloat((Math.round(document.getElementById('sumando1').value)/1)*1).toFixed(0));
				
				
            }
            </script>

                        <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>


    <nav class="navbar navbar-dark bg-light">        
    
            <div class="navbar-header">
                <a class="navbar-brand" target="_blank"><img src="../img/logos/<?php echo $storename['st_alias'] ?>.png" alt=" " class="logo-primary"/></a>
            </div>
            <ul class="nav nav-tabs" id="myTab">
                
                <?php
				switch ($panel) {
	    		case 'insc':
	    		echo '<a href="#home" class="active" data-bs-toggle="tab"><li class="list-group-item linkHeader">Inscripción de socios</li></a>
                <a href="#puntos" data-bs-toggle="tab"><li class="list-group-item linkHeader">Acumulación de puntos</li></a>
                <a href="#messages" data-bs-toggle="tab"><li class="list-group-item linkHeader">Validación de cupones</li>
                <a href="#consultas" data-bs-toggle="tab"><li class="list-group-item linkHeader">Estadísticas</li></a>
                <a href="#edit" data-bs-toggle="tab"><li class="list-group-item linkHeader">Editar cupones</li></a>';
	    			break;
				case 'acum':
	    			echo '<a href="#home" data-bs-toggle="tab"><li class="list-group-item linkHeader">Inscripción de socios</li></a>
                <a href="#puntos" class="active" data-bs-toggle="tab"><li class="list-group-item linkHeader">Acumulación de puntos</li></a>
                <a href="#messages" data-bs-toggle="tab"><li class="list-group-item linkHeader">Validación de cupones</li>
                <a href="#consultas" data-bs-toggle="tab"><li class="list-group-item linkHeader">Estadísticas</li></a>
                <a href="#edit" data-bs-toggle="tab"><li class="list-group-item linkHeader">Editar cupones</li></a>';
	    			break;
				case 'canj':
	    			echo '<a href="#home" data-bs-toggle="tab"><li class="list-group-item linkHeader">Inscripción de socios</li></a>
                <a href="#puntos" data-bs-toggle="tab"><li class="list-group-item linkHeader">Acumulación de puntos</li></a>
                <a href="#messages" class="active" data-bs-toggle="tab"><li class="list-group-item linkHeader">Validación de cupones</li>
                <a href="#consultas" data-bs-toggle="tab"><li class="list-group-item linkHeader">Estadísticas</li></a>
                <a href="#edit" data-bs-toggle="tab"><li class="list-group-item linkHeader">Editar cupones</li></a>';
	    			break;
				case 'cons':
	    			echo '<a href="#home" data-bs-toggle="tab"><li class="list-group-item linkHeader">Inscripción de socios</li></a>
                <a href="#puntos" data-bs-toggle="tab"><li class="list-group-item linkHeader">Acumulación de puntos</li></a>
                <a href="#messages" data-bs-toggle="tab"><li class="list-group-item linkHeader">Validación de cupones</li>
                <a href="#consultas" class="active" data-bs-toggle="tab"><li class="list-group-item linkHeader">Estadísticas</li></a>
                <a href="#edit" data-bs-toggle="tab"><li class="list-group-item linkHeader">Editar cupones</li></a>';
	    			break;
				case 'edit':
	    			echo '<a href="#home" data-bs-toggle="tab"><li class="list-group-item linkHeader">Inscripción de socios</li></a>
                <a href="#puntos" data-bs-toggle="tab"><li class="list-group-item linkHeader">Acumulación de puntos</li></a>
                <a href="#messages" data-bs-toggle="tab"><li class="list-group-item linkHeader">Validación de cupones</li>
                <a href="#consultas" data-bs-toggle="tab"><li class="list-group-item linkHeader">Estadísticas</li></a>
                <a href="#edit" class="active" data-bs-toggle="tab"><li class="list-group-item linkHeader">Editar cupones</li></a>';
	    			break;
	    		
	    		default:
	    			echo '<a href="#home" data-bs-toggle="tab"><li class="list-group-item linkHeader">Inscripción de socios</li></a>
                <a href="#puntos" class="active" data-bs-toggle="tab"><li class="list-group-item linkHeader">Acumulación de puntos</li></a>
                <a href="#messages" data-bs-toggle="tab"><li class="list-group-item linkHeader">Validación de cupones</li>
                <a href="#consultas" data-bs-toggle="tab"><li class="list-group-item linkHeader">Estadísticas</li></a>
                <a href="#edit" data-bs-toggle="tab"><li class="list-group-item linkHeader">Editar cupones</li></a>';
	    			break;
	    	}
			?>
            </ul>
            <a href="index.php?salir=true"><li class="iconosHeader"><i class="icofont-exit"></i></li></a>
    </nav>
</body>