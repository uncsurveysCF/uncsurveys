<?php
include_once("../Negocios/utilidades.php");
$id = "";
if ($_GET) {
    $id = decrypt($_GET["id"]);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>UNCSurveys</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Silvina Roa - Universidad Nacional del Comahue">

        <!-- The styles -->
        <link id="bs-css" href="../css/bootstrap-simplex.min.css" rel="stylesheet">

        <link href="../css/charisma-app.css" rel="stylesheet">
        <link href="css/styleValEngine.css" rel="stylesheet">
        <link href='../css/jqcloud.css' rel='stylesheet'>

        <!-- jQuery 
            <script src="../bower_components/jquery/jquery.min.js"></script>-->

        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->

        <!-- The fav icon -->
        <link rel="shortcut icon" href="../img/faviconUS.ico">
        <style type="text/css">
        </style>
    </head>

    <body class="bckIni">
        <!-- topbar starts -->
        <div class="navbar" role="navigation">
            <div class="navbar-inner">		
                <a class="navbar-brand titRec" href="#"> 
                    <img alt="UNCSurveys" src="../img/logo300.png" class="" />
                </a>
            </div>
        </div>
        <!-- topbar ends -->
        <div class="ch-container" style="background: #ffffff;">
           
            <div class=" row">
                <div class="box col-md-12">
                    <input type="hidden" id="hfIdEncuesta" name="hfIdEncuesta"
                           value="<?php echo $id; ?>">
                    <input type="hidden" id="hfIdEstado" name="hfIdEstado" >
                    <div class="box-inner well">			
                        <div class="row">
                            <div class="col-md-12">
                                <h4><span id="txtTitulo"></span></h4>
                            </div>
                        </div>				
                        <div class="row">
                            <div class="col-md-12" id="txtDescripcion"></div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row"><div class="col-md-12" id="txtTema"></div></div>
                                <div class="row"><div class="col-md-12" id="txtTipo"></div></div>
                                <div class="row"><div class="col-md-12" id="txtProposito"></div></div>
                                <div class="row"><div class="col-md-12" id="txtPoblacion"></div></div>
                                <div class="row"><div class="col-md-12" id="txtCarMu"></div></div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-12">
                                <span class="red" id="txtRespuestas"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/span-->
            </div>
            <div class='row'>&nbsp;</div>
            <div id="datosEnc"></div>
            
            
            <footer class="row">
                <p class="col-md-9 col-sm-9 col-xs-12 copyright">
                    &copy; <a href="#" target="_blank">UNCSurveys</a>
                    2015
                </p>

                <p class="col-md-3 col-sm-3 col-xs-12 powered-by">
                    Universidad Nacional del Comahue
                </p>
            </footer>

        </div>
        <!--/.fluid-container-->

        <!-- external javascript -->
        <script type="text/javascript" src="js/jquery-latest.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery.bootstrap.wizard.js"></script>
        <script type="text/javascript" src="js/jquery.validation.js"></script>
        <script type="text/javascript" src="js/jquery.validationEngine-es.js"></script>

        <script type="text/javascript" src="../js/ui/i18n/jquery.ui.datepicker-es.js"></script>
        <script type="text/javascript" src="../js/ui/jquery.ui.core.js"></script>
        <script type="text/javascript" src="../js/ui/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="../js/ui/jquery.ui.datepicker.js"></script>
        <script type="text/javascript" src="../js/jqcloud.js"></script>
        <script type="text/javascript" src="../js/resumenFinal.js"></script>

    </body>
</html>
