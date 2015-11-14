<?php require('header.php'); 
$nomUsu = $oLogin->getNombreUsuario();
$idUsu = $oLogin->getIdUsuario()
?>
<div>
    <ul class="breadcrumb">
        <li><a href="#">Usuarios</a>
        </li>
        <li><a href="#">Cambiar Contrase&ntilde;a</a>
        </li>
    </ul>
</div>
<div class=" row">
    <div class="box col-md-12">
        <div class="box-inner homepage-box">
            <div class="box-header well">
                <h2>
                    <i class="glyphicon glyphicon-th"></i> Cambiar Contrase&ntilde;a
                </h2>
            </div>
            <div class="box-content">

                <div class="box col-md-12">
                    <form id="formCambiarClave" action="" method="post" role="form">
                        <fieldset>
                            <input type="hidden" id="oper" name="oper" value="cambiarClave">	
                            <input type="hidden" id="hfIdUsuario" name="hfIdUsuario" value="<?php echo $idUsu; ?>">	
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="text-left" for="txtUsuario">Usuario:</label>
                                        <input class="form-control input-sm" id="txtUsuario"
                                               name="txtUsuario" type="text" readonly="true" value="<?php echo $nomUsu; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="text-left" for="txtPass">Nueva Contrase&ntilde;a:</label>
                                       <input class="form-control input-sm" id="txtPass"
                                               name="txtPass" type="password" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="text-left" for="txtRPass">Repita Contrase&ntilde;a:</label>
                                       <input class="form-control input-sm" id="txtRPass"
                                              name="txtRPass" type="password" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <span id="respuestaNueva"></span>
                                </div>
                                <!--/col-md-12 -->
                            </div>
                            <div class="row">
                                <div class="col-md-8 text-right">
                                    <button id="btnCambiarCave" type="submit" class="btn btn-primary">
                                        Cambiar Clave
                                    </button>
                                </div>
                                <!--/col-md-12 -->
                            </div>
                        </fieldset>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!--/span-->


</div>
<!--/row-->
<?php require('footer.php'); ?>
<!-- Mis script -->
<script
type="text/javascript" src="js/cambiarClave.js"></script>
