<?php
require('header.php');
require('Negocios/utilidades.php');
if ($_GET) {
    $idEncuesta = decrypt($_GET["id"]);
}
?>
<div>
    <ul class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li><a class="active" href="#">Cerrar Encuesta</a></li>
    </ul>
</div>
<div class=" row">
    <div class="box col-md-12">
        <input type="hidden" id="hfIdEncuesta" name="hfIdEncuesta"
               value="<?php echo $idEncuesta; ?>">
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
                <div class="col-md-6">
                    <div class="row"><div class="col-md-12" id="txtTema"></div></div>
                    <div class="row"><div class="col-md-12" id="txtTipo"></div></div>
                    <div class="row"><div class="col-md-6" id="txtFechaLimite"></div>
                        <div class="col-md-6" id="txtHoraLimite"></div>
                                         
                    </div>
                    <div class="row"><div class="col-md-8" id="txtMaxAcc">&nbsp;</div>
                                     <div class="col-md-6" id="ckTieneClave">&nbsp;</div></div>
                </div>
                <div class="col-md-6">
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
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col-md-12">
                   <div class="form-group">
                        <input type="submit" id="btnCerrar" class="btn btn-primary" value="Cerrar Encuesta" >
                        <input type="button" id="btnCancel" class="btn btn-default" value="Cancelar" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="resultado">
                    
                </div>
            </div>
        </div>
    </div>
    <!--/span-->
</div>
<!--/row-->

<?php require('footer.php'); ?>
<!-- Mis script -->
<script type="text/javascript" src="js/enc_cerrarEncuesta.js"></script>

