<?php
require_once('libs/PDOConfig.php');
require_once('Negocios/utilidades.php');
$base = new PDOConfig();
$mesaje = "";
if($_POST){
    $nombre = $base->filtrar($_POST["txtNombre"]);
    $apellido = $base->filtrar($_POST["txtApellido"]);
    $email = $base->filtrar($_POST["txtEmail"]);
    $idUsuario = $base->filtrar($_POST["hfId"]);
    $sqlUp = "UPDATE usuarios SET Apellido = '$apellido',Nombre ='$nombre',Email='$email' WHERE idUsuario = $idUsuario ";
    $respU = $base->query($sqlUp);
    if ($respU) {
        $mesaje = "Los datos se actualizaron Correctamente";
    }else{
        $mesaje = "Ha ourrido un error al actualizar los datos";
    }
}

require('header.php');
$nomUsu = $oLogin->getNombreUsuario();
$idUsu = $oLogin->getIdUsuario();

$sql = " SELECT * FROM usuarios WHERE idUsuario = $idUsu";
$resp = $base->query($sql);
if ($resp) {
    $datos = $resp->fetch(PDO::FETCH_ASSOC);
}
?>
<div>
    <ul class="breadcrumb">
        <li><a href="#">Usuarios</a>
        </li>
        <li><a href="#">Datos de Perfil</a>
        </li>
    </ul>
</div>
<div class=" row">
    <div class="box col-md-12">
        <div class="box-inner homepage-box">
            <div class="box-header well">
                <h2>
                    <i class="glyphicon glyphicon-th"></i> Datos del Usuario
                </h2>
            </div>
            <div class="box-content">
                <form id="formRegistro" action="#" method="post">
                    <fieldset>
                        <input type="hidden" id="hfId" name="hfId" value="<?php echo $idUsu; ?>">
                        <input type="hidden" id="oper" name="oper" value="actualizar">
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <div class="form-group">
                                    <label class="text-left" for="txtApellido">&nbsp;&nbsp;&nbsp;Apellido:</label> <input
                                        class="form-control input-sm" value='<?php echo $datos["Apellido"]; ?>' id="txtApellido" name="txtApellido" type="text" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <div class="form-group">
                                    <label class="text-left" for="txtNombre">&nbsp;&nbsp;&nbsp;Nombre:</label> <input
                                        class="form-control input-sm" id="txtNombre" value='<?php echo $datos["Nombre"]; ?>' name="txtNombre" type="text" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <div class="form-group">
                                    <label class="text-left" for="txtEmail">&nbsp;&nbsp;&nbsp;Email:</label> <input
                                        class="form-control input-sm" value='<?php echo $datos["Email"]; ?>' id="txtEmail" name="txtEmail" type="text" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <div class="form-group">
                                    <label class="text-left" for="txtUsuario">&nbsp;&nbsp;&nbsp;Usuario:</label> <input
                                        class="form-control input-sm" id="txtUsuario" name="txtUsuario" value="<?php echo $nomUsu; ?>" readonly="readonly" type="text" />
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12 text-center">
                                <span id="respuestaReg" class='red'>
                                   <?php echo $mesaje; ?>
                                </span>
                            </div>
                            <!--/col-md-12 -->
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button id="btnActualizar" type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                            <!--/col-md-12 -->
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!--/span-->


</div>
<!--/row-->
<?php require('footer.php'); ?>

<!-- Mis script -->
<script
type="text/javascript">
$("#formRegistro").validate({
      	ignore: null,
    	ignore: 'input[type="hidden"]',
    	rules: {
        txtApellido: "required",
      txtNombre: "required",
      txtEmail: {
				required: true,
				email: true
			}
    		},
    	messages: {
    		txtApellido: "Ingrese Apellido",
    		txtNombre: "Ingrese Nombre",
    		
			txtEmail: {required: "Ingrese Email",
                                    email: "Email Invalido"
                            }
		
    	}
    });
</script>
