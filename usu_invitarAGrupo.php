<?php
require('header.php');
require('Negocios/utilidades.php');
if ($_GET) {
    $idGrupo = $_GET["id"];
}
?>
<div>
    <ul class="breadcrumb">
        <li><a href="#">Usuarios</a></li>
        <li><a class="active" href="#">Invitar Usuarios</a></li>
    </ul>
</div>
<div class=" row">
    <div class="box col-md-12">		
        <div class="box-inner">

            <div class="box-header well">
                <h2>
                    <span id="txtGrupo"></span>
                </h2>
            </div>
            <div class="box-content">
                <div class=" row">
                    <div class="col-md-10" id="txtDescripcion">

                    </div>
                </div>
                <div class=" row">
                    <div class="box col-md-6">		
                        <div class="box-header well" data-original-title="">
                            <h2>Integrantes</h2>	
                        </div>
                        <div class="box-content">   
                            <div id="listadoIntegrantes"></div>
                        </div>	
                    </div>
                </div>
                <form id="formInvitar">	
                    <input type="hidden" id="hfIdGrupo" name="hfIdGrupo" value="<?php echo $idGrupo; ?>" />
                    <input type="hidden" id="oper" name="oper" value="invitarUsuario" />
                    <input type="hidden" id="txtNomGrupo" name="txtNomGrupo" />
                    <div class=" row">
                        <div class="box col-md-6">			
                            <div class="form-group">
                                <input class="form-control input-sm" id="txtemail"
                                       name="txtemail" type="text" placeholder="Ingrese Email del Usuario"	/>
                            </div>
                        </div>
                        <div class="box col-md-2">
                            <button id='btnInvitar' type="submit" class='btn btn-info'>
                                Enviar Invitaci&oacute;n</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span id="respuesta"></span>
                        </div>
                        <!--/col-md-12 -->
                    </div>

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
type="text/javascript" src="js/usu_invitarGrupo.js"></script>
