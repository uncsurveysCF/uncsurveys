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
        <li><a class="active" href="#">An&aacute;lisis de Encuesta</a></li>
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
                        <div class="col-md-6" id="txtHoraLimite"></div></div>
                    <div class="row"><div class="col-md-6" id="txtMaxAcc">&nbsp;</div>
                        <div class="col-md-6" id="ckTieneClave">&nbsp;</div></div>
                </div>
                <div class="col-md-6">
                    <div class="row"><div class="col-md-12" id="txtProposito"></div></div>
                    <div class="row"><div class="col-md-12" id="txtPoblacion"></div></div>
                    <div class="row"><div class="col-md-12" id="txtCarMu"></div></div>
                </div>
            </div>    
        </div>
    </div>
    <!--/span-->
</div>

<div class=" row">
    <div class="col-md-12">	
        <a class="btn btn-primary btn-sm" href="enc_configurar.php?id=<?php echo $idEncuesta; ?>"><i class="glyphicon glyphicon-cog"></i> Configuraci&oacute;n</a>
        <a class="btn btn-default btn-sm" href="enc_PeriodosLong.php?id=<?php echo encrypt($idEncuesta); ?>"><i class="glyphicon glyphicon-th-large"></i> Per&iacute;odos</a>
    </div>
</div>
<div class=" row">&nbsp;</div>
<div class="row">
    <ul class="nav nav-tabs" id="tabsAnEncuesta">
        <li class="active"><a href="#datosEnc">An&aacute;lisis por respuestas</a></li>
        <li><a href="#respIndividuales">Respuestas Individuales</a></li>
    </ul>
    <div id="analisisEnc" class="tab-content">
        <div id="datosEnc" class="tab-pane active">
            <div class="box" style="margin-top: 0px;">
                <div class="box-inner" style="border-top: 0px none;"><div class="box-content" style="border-top: 0px none;">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="cbPregunta">Pregunta: </label> 
                                    <select id="cbPregunta" name="cbPregunta"
                                            class="form-control input-sm" data-rel="chosen">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2"> <br />
                                <input type="button" id="btnAnalisis" class="btn btn-default" name="btnAnalisis"
                                       value="Ver An&aacute;lisis">
                            </div>
                        </div> 
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-12" id="resultAn">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="respIndividuales" class="tab-pane">
            <div class="box" style="margin-top: 0px;">
                <div class="box-inner"><div class="box-content" >
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="cbPeriodos">Per&iacute;odo: </label> 
                                    <select id="cbPeriodos" name="cbPeriodos"
                                            class="form-control input-sm" data-rel="chosen">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2"> <br />
                                <input type="button" id="btnRespuestas" class="btn btn-default" name="btnRespuestas"
                                       value="Ver Respuestas">
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-10 text-center">
                                <div id="page-selection"></div> 
                            </div></div>
                        <div id="contenidoPag"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!--/row-->

<?php require('footer.php'); ?>
<script type="text/javascript" src="js/jqcloud.js"></script>
<!-- chart libraries start -->
<script src="bower_components/flot/jquery.flot.js"></script>
<script src="bower_components/flot/jquery.flot.resize.js"></script>
<script src="bower_components/flot/jquery.flot.categories.js"></script>
<script src="js/jquery.bootpag.js"></script>
<!-- Mis script -->
<script type="text/javascript" src="js/enc_analisisEncuestaLong.js"></script>


