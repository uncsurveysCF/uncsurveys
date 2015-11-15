<?php 
include 'config.php';
require_once("libs/Login.php");
$oLogin=new Login();
if(!$oLogin->activa()){
	header('location:index.php');	
}
$nomUsuario = $oLogin->getNombreUsuario();      
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--   ===
        This comment should NOT be removed.Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <title>UNCSurveys</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Desarrollo de encuestas. Surveys">
    <meta name="author" content="Roa Silvina">

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-simplex.min.css" rel="stylesheet">

    <link href="css/charisma-app.css" rel="stylesheet">
    <link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>
    <link href='css/font-awesome.min.css' rel='stylesheet'>
    <link href='css/datepicker.css' rel='stylesheet'>
    <link href='css/jqcloud.css' rel='stylesheet'>
    <link href='css/bootstrap-tagsinput.css' rel='stylesheet'>
    <link href='css/imprimir.css' rel='stylesheet' media="print" >
    
    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
   <link rel="shortcut icon" href="img/faviconUS.ico">

</head>

<body>
<?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">
        <div class="navbar-inner">
           
            <a class="navbar-brand" href="#">
             <img alt="Logo UNCSurveys" src="img/logo180.png" class=""/></a>

              <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> 
                    <?php echo $nomUsuario; ?></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="usu_cambiarContrasenia.php">Cambiar Contrase&ntilde;a</a></li>
                    <li class="divider"></li>
                    <li><a href="Negocios/logout.php">Salir</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->

        </div>
    </div>
    <!-- topbar ends -->
<?php } ?>
<div class="ch-container">
    <div class="row">
        <?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>

        <!-- left menu starts -->
        <div id="menuLateral" class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">
                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">Menu</li>
                        <li><a href="enc_listadoEncuestas.php"><i class="glyphicon glyphicon-check"></i> <span> Mis Encuestas</span></a></li>
                        <li><a href="enc_listadoCompartidas.php"><i class="fa fa-share-alt"></i> <span> Compartidas</span></a></li>
                        <li><a href="usu_listadoGrupos.php" style="font-size: small;"><i class="fa fa-users"></i> <span> Grupos</span></a></li>
                        <li><a href="enc_publicas.php" style="font-size: small;"><i class="fa fa-server"></i> <span> Encuestas P&uacute;blicas</span></a></li>
                    </ul>
                    
                    
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Alerta!</h4>

                <p>Usted necesita habiltar el uso de <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    para navegar este sitio correctamente.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <?php } ?>
