<!DOCTYPE html>
<html lang="es">
<head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <title>UNCSurvey</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Encuestas,Surveys">
    <meta name="author" content="Roa Silvina">

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-simplex.min.css" rel="stylesheet">

    <link href="css/charisma-app.css" rel="stylesheet">
   
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>    
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>

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
        
    <div class="row">
        <div class="col-md-12 center login-header">
            <img src="img/logo300.png" alt='Logo UNCSurvey' />
            <h2></h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <div class="alert alert-danger">
                Ingrese Usuario y Contrase&ntilde;a
            </div>
            <form id="formLogin" class="form-horizontal" action="#" method="post">
                <fieldset>
                  <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" placeholder="Usuario">
                    </div>
                    <div class="clearfix"></div><br />
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" class="form-control" id="txtPass" name="txtPass" placeholder="Contrase&ntilde;a">
                    </div>     
                    <div class="clearfix"></div>               
                    <br />
                    <div class='form-group has-error col-md-12' id="divResp" style="display: none;">                    
                    	<input type='text' class='form-control' readonly="readonly" style="color:#ff0000;" id='respuesta' >
                	</div>
                    <div class="clearfix"></div>
                    <p class="center col-md-8">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </p>
                    <p>&nbsp;</p>
                    <div class="clearfix"></div>
                    <div class="input-prepend text-left">
                        <a href='usu_recuperarClave.php' title='Recuperar Contrase&ntilde;a'><i class='glyphicon glyphicon-lock'></i> Olvid&oacute; su Contrase&ntilde;a?</a><br />
                        <a href='usu_registro.php' title='Registrar Usuario'><i class='glyphicon glyphicon-user'></i> Crear una nueva cuenta</a>
                    </div>
                </fieldset>
            </form>
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->

<!-- external javascript -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- library for cookie management -->
<script src="js/jquery.cookie.js"></script>
<!-- Login -->
<script src="js/jquery.validate.js"></script>
<script src="js/login.js"></script>
</body>
</html>
