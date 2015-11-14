<?php
$numError = $_GET["er"];
$mensaje = "";
switch($numError){
    case '0': $mensaje = "Error desconocido"; break;
    case '2': $mensaje = "La encuesta ya se encuentra cerrada"; break;
    case '3': $mensaje = "Ya finaliz&oacute; el per&iacute;odo de tiempo para contestar la encuesta"; break;
    case '4': $mensaje = "Ya se alcanz&oacute; el n&uacute;mero m&acute;ximo de accesos a la encuesta"; break;
    case '5': $mensaje = "La encuesta ya fue contestada desde la IP que está intentando ingresar"; break;
    case '6': $mensaje = "La encuesta ya fue contestada con la identificaci&oacute;n ingresada"; break;
    default: $mensaje = "Error desconocido"; break;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>UNCSurvey</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Encuestas,Survey">
    <meta name="author" content="Roa Silvina">

    <!-- The styles -->
    <link id="bs-css" href="../css/bootstrap-simplex.min.css" rel="stylesheet">

    <link href="../css/charisma-app.css" rel="stylesheet">
   
    <!-- jQuery -->
    <script src="../bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/faviconUS.ico">

</head>

<body class="bckIni">
<div class="ch-container">
    <div class="row">
        <div class="col-md-12 center login-header">
            <img src="../img/logo300.png" alt='UNCSurvey' />
            <h2></h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <div class="alert alert-danger">
                No es Posible Tener Acceso a la Encuesta
            </div>
            <span id="spmensaje"><?php echo $mensaje; ?></span>
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/.fluid-container-->
<footer class="row col-md-6 center-block">
        <p class="col-md-12">
        &copy; <a href="#" target="_blank">UNCSurvey - Universidad Nacional del Comahue</a></p>

        <p class="col-md-12">Desarrollado por: <a
                href="#">Roa Silvina</a></p>
</footer>
<!-- external javascript -->

<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
