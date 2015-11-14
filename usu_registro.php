<!DOCTYPE html>
<html lang="es">
<head>
  
    <meta charset="utf-8">
    <title>UNCSurvey</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Encuestas,Survey">
    <meta name="author" content="Roa Silvina">

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-simplex.min.css" rel="stylesheet">

    <link href="css/charisma-app.css" rel="stylesheet">
   
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
                Registrese para crear una cuenta nueva
            </div>
            <form id="formRegistro" action="#" method="post">
                <fieldset>
                	<input type="hidden" id="oper" name="oper" value="add">
                 	<div class="row">
						<div class="col-md-12 text-left">
							<div class="form-group">
								<label class="text-left" for="txtApellido">&nbsp;&nbsp;&nbsp;Apellido:</label> <input
									class="form-control input-sm" id="txtApellido" name="txtApellido" type="text" />
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-12 text-left">
							<div class="form-group">
								<label class="text-left" for="txtNombre">&nbsp;&nbsp;&nbsp;Nombre:</label> <input
									class="form-control input-sm" id="txtNombre" name="txtNombre" type="text" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-left">
							<div class="form-group">
								<label class="text-left" for="txtEmail">&nbsp;&nbsp;&nbsp;Email:</label> <input
									class="form-control input-sm" id="txtEmail" name="txtEmail" type="text" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-left">
							<div class="form-group">
								<label class="text-left" for="txtUsuario">&nbsp;&nbsp;&nbsp;Usuario:</label> <input
									class="form-control input-sm" id="txtUsuario" name="txtUsuario" type="text" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-left">
							<div class="form-group">
								<label class="text-left" for="txtPass">&nbsp;&nbsp;&nbsp;Contrase&ntilde;a:</label> <input
									class="form-control input-sm" id="txtPass" name="txtPass" type="password" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-left">
							<div class="form-group">
								<label class="text-left" for="txtRPass">&nbsp;&nbsp;&nbsp;Repita Contrase&ntilde;a:</label> <input
									class="form-control input-sm" id="txtRPass" name="txtRPass" type="password" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<span id="respuestaReg"></span>
						</div>
						<!--/col-md-12 -->
					</div>
					<div class="row">
						<div class="col-md-12 text-right">
							<button id="btnRegistrarse" type="submit" class="btn btn-primary">Registrarse</button>
						</div>
						<!--/col-md-12 -->
					</div>
					<div class="row">&nbsp;</div>
					<div class="row">
						<div class="col-md-12 text-center">
						<a href="index.php" >Volver al Login</a>
						</div>
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
<script src="js/registro.js"></script>
</body>
</html>
