<?php
include_once("../Negocios/utilidades.php");
$id = "";
$op = "0";
$codPers = "";
$recopilador = "";
if ($_GET) {
    $id = decrypt($_GET["id"]);
    $de= explode('-',decrypt($_GET["cd"]));
    $recopilador = $de[1];   
    if (isset($_GET["op"])) {
        $op = "1";
    }
    if(isset($_GET["cp"]))
    {
        $codPers = decrypt($_GET["cp"]);
    }
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


        <!-- jQuery 
            <script src="../bower_components/jquery/jquery.min.js"></script>-->

        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->

        <!-- The fav icon -->
        <link rel="shortcut icon" href="../img/faviconUS.ico">
        <style type="text/css">
        .navbar-inner {
            line-height: 20px;
        }

        .nav > li > a {
            position: relative;
            display: block;
            padding: 4px;
        }

        .navbar {
            background:#ffffff;
            background-repeat: no-repeat;
            filter: none;
            border: 0px none;
            text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.3);
        }
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
            <div class="row">
                <div id="content" class="col-lg-12 col-sm-12">
                    <input type="hidden" id="hfop" name="hfop" value="<?php echo $op; ?>">
                    <!-- content starts -->
                    <div class="row" id="divPrueba" style="display:none;">
                        <div class="box col-md-12">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Vista Previa!</strong> <br /> No se guardaran los datos de esta previsualizaci&oacute;n.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="box col-md-12">
                            <div class="box-inner">
                                <div class="box-header well" data-original-title="">
                                    <h2><i class="glyphicon glyphicon-th-large"></i> 
                                        <span id="txtTitulo"></span>
                                    </h2>
                                </div>
                                <div class="box-content">
                                    <div class="row">
                                        <div class="col-md-12" id="divDescripcion"></div>
                                    </div>
                                    <br style="clear: both;" />
                                    <br style="clear: both;" />
                                    <div class="row" id="divClave" style="display: none;">
                                        <div class="col-md-12">
                                            <div class="content-box-large">
		  				<div class="panel-heading">
                                                    <div class="panel-title">Para contestar la encuesta debe tener una clave de acceso</div>
						</div>
		  				<div class="panel-body">
                                                    <div class="row">
                                                    <div class="col-md-12">
                                                    <form class="form-inline">
                                                        <input type="hidden" id="hfIdEncuesta" name="hfIdEncuesta"
                                                                   value="<?php echo $id; ?>">
                                                        <input type="hidden" id="hfClaveAcceso" name="hfClaveAcceso"
                                                                   value="">
                                                        <input type="hidden" id="hfCodigoPers" name="hfCodigoPers"
                                                                   value="<?php echo $codPers; ?>">
                                                        <input type="hidden" id="hfRecopilador" name="hfRecopilador"
                                                                   value="<?php echo $recopilador; ?>">
                                                        <input type="hidden" id="hfIdAcceso" name="hfIdAcceso"
                                                                   value="">
                                                        <div id="pnlClaveAcc" class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="txtClave">Ingrese Clave</label>
                                                            <input type="password" class="form-control" id="txtClave" name="txtClave" placeholder="Clave de acceso">
                                                        </div>
                                                        </div>    
                                                        </div>
                                                        
                                                        <div class="row" id="ingIdes">
                                                        <div class="col-md-12" >
                                                        <div class="form-group">
                                                            <label for="txtIdentificacion">Ingrese Identificaci&oacute;n</label>
                                                            <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" placeholder="Identificaci&oacute;n de acceso">
                                                        </div>
                                                        </div>    
                                                        </div>
                                                        
                                                        <input id="btnCheckEncuesta" type="button" class="btn btn-default" value="Ingresar"/>
                                                    </form>
                                                    </div>
                                                    </div>
                                                    <div class="row"><div class="col-md-12" id="msnResp"></div></div>
                                            </div>
                                            </div>      
                                        </div>
                                    </div>

                                    <div class="row" id="divEncuesta" style="display: none;">
                                        <div class="col-lg-12">
                                            <div id="rootwizard">
                                                <div class="navbar" >
                                                    <div class="navbar-inner">
                                                        <div class="container"  style='margin-left:0px;padding-left:0px;' id="navegador"></div>
                                                    </div>
                                                </div>
                                                <form id="formEncuesta" method="post">
                                                    <fieldset>
                                                        <input type="hidden" id="hfIdEncuesta" name="hfIdEncuesta"
                                                               value="<?php echo $id; ?>">
                                                        <input type="hidden" id="hfRecopilador" name="hfRecopilador"
                                                                   value="<?php echo $recopilador; ?>">
                                                        <input type="hidden" id="hfCodigoPers" name="hfCodigoPers"
                                                                   value="<?php echo $codPers; ?>">
                                                        <input type="hidden" id="oper" name="oper"
                                                               value="recopilar">
                                                        <input type="hidden" id="hfIde" name="hfIde" value="">
                                                        <input type="hidden" id="hfidRespuesta" name="hfidRespuesta" >	
                                                        <div id="contenidoEncuesta" style="padding: 10px;">

                                                        </div>	
                                                        <div class="row">
                                                            <div class="col-lg-12" id="respuesta"></div>
                                                        </div>										
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                        <!--/span-->

                    </div>
                    <!--/row-->

                    <!-- content ends -->
                </div>
                <!--/#content.col-md-0-->
            </div>
            <!--/fluid-row-->


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
        <script type="text/javascript" src="../js/jquery.md5.js"></script>
        <script type="text/javascript" src="../js/recopilarEncuesta.js"></script>

    </body>
</html>
