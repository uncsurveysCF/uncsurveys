<?php
require('header.php');
require('Negocios/utilidades.php');


if ($_GET) {
    $idEncuesta = decrypt($_GET["id"]);
    $idUsuario = $oLogin->getIdUsuario();
    
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
        <input type="hidden" id="hfIdEstado" name="hfIdEstado" >
        <input type="hidden" id="hfIdUsuario" name="hfIdUsuario" value="<?php echo $idUsuario; ?>">
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
            <div class="row">
                <div class="col-md-12">
                    <span class="red" id="txtRespuestas"></span>
                </div>
            </div>
        </div>
    </div>
    <!--/span-->
</div>

<div class=" row">
    <div class="col-md-12">	
        <a class="btn btn-primary btn-sm" href="enc_configurar.php?id=<?php echo $idEncuesta; ?>"><i class="glyphicon glyphicon-cog"></i> Configuraci&oacute;n</a>
        <a class="btn btn-success btn-sm" href="enc_recopiladores.php?id=<?php echo encrypt($idEncuesta); ?>&op=<?php echo encrypt(1); ?>" ><i class="glyphicon glyphicon-bullhorn"></i> Recolectores</a>
        <a class="btn btn-info btn-sm" href="Negocios/exportarEncuesta.php?id=<?php echo encrypt($idEncuesta); ?>"><i class="glyphicon glyphicon-download-alt"></i> Exportar Datos</a>
        <a class="btn btn-danger btn-sm" href="enc_diseniarEncuesta.php?id=<?php echo encrypt($idEncuesta); ?>"><i class="fa fa-file-code-o"></i> Ver Dise&ntilde;o</a>
        <a id="btnCerrar" class="btn btn-default btn-sm" href="enc_cerrarEncuesta.php?id=<?php echo encrypt($idEncuesta); ?>"><i class="fa fa-sign-in"></i> Cerrar Encuesta</a>
    </div>
</div>
<div class=" row">&nbsp;</div>
<div class="row">
    <ul class="nav nav-tabs" id="tabsAnEncuesta">
        <li class="active"><a href="#datosEnc">Resumen</a></li>
        <li><a href="#respIndividuales">Respuestas Individuales</a></li>
        <li><a href="#anDependencias">An&aacute;lisis de Dependencias</a></li>
        <li><a href="#anLikert">Test no param&eacute;tricos</a></li>
    </ul>
    <div id="analisisEnc" class="tab-content">
        <div id="datosEnc" class="tab-pane active"></div>
        
        <div id="respIndividuales" class="tab-pane">
            <div class="row"><div class="col-md-10 text-center">
            <div id="page-selection"></div> 
                </div></div>
            <div id="contenidoPag"></div>


        </div>
        <div id="anDependencias" class="tab-pane">
            <form id="formCorrelacion" action="#">
            <div class='box-content'>
                <input type="hidden" id="escala1" name="escala1" />
                <input type="hidden" id="escala2" name="escala2" />
                <input type="hidden" id="oper" name="oper" value="anCorrelacion" />
                <div class="row">
                     <div class="col-md-12">
                         <div class="alert alert-info">
                            Aplicable a preguntas con escala al menos ordinal
                        </div>
                     </div>
                 </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cbPregunta1">Eje X: </label> 
                            <select id="cbPregunta1" name="cbPregunta1"
                                    class="form-control input-sm" data-rel="chosen">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cbPregunta2">Eje Y: </label> 
                            <select id="cbPregunta2" name="cbPregunta2"
                                    class="form-control input-sm" data-rel="chosen">
                            </select>
                        </div>
                    </div>
                        
                </div> 
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cbMetodo">M&eacute;todo: </label> 
                            <select id="cbMetodo" name="cbMetodo" class="form-control input-sm" 
                                    data-rel="chosen">
                                <option value="-1">Seleccione...</option>
                                <option value="kendall">Kendall</option>
                                <option value="spearman">Spearman</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group"><br />
                            <input type="submit" id="btnGraf" class="btn btn-primary" value="Graficar" >
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <div id="grafAnalisis" class="col-md-12"></div>
                </div>
            </div>   
            </form>    
        </div>
        
        <div id="anLikert" class="tab-pane">
            <form id="formLikert" action="#">
            <div class='box-content'>
                <input type="hidden" id="oper" name="oper" value="anLikert" />
                 <div class="row">
                     <div class="col-md-12">
                         <div class="alert alert-info">
                            Aplicable a preguntas de escala Likert
                        </div>
                     </div>
                 </div>    
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cbLikert">Escala Likert: </label> 
                            <select id="cbLikert" name="cbLikert"
                                    class="form-control input-sm" data-rel="chosen">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cbOpcionLikert">Opci&oacute;n: </label> 
                            <select id="cbOpcionLikert" name="cbOpcionLikert" class="form-control input-sm" 
                                    data-rel="chosen">
                                <option value="-1">Seleccione...</option>
                                <option value=""></option>
                            </select>
                        </div>
                    </div> 
                </div> 
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cbGrupo">Grupos: </label> 
                            <select id="cbGrupo" name="cbGrupo"
                                    class="form-control input-sm" data-rel="chosen">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4" id="grupos">
                    </div>   
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtMetodo">M&eacute;todo: </label> 
                            <input type="text" class="form-control" id="txtMetodo" name="txtMetodo" readonly="readonly" />
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group"><br />
                            <input type="submit" id="btnGraf" class="btn btn-primary" value="Graficar" >
                        </div>
                    </div>
                </div> 
                 <div class="row">
                    <div id="detAnalisis" class="col-md-12"></div>
                </div>
                <div class="row">
                    <div id="grafAnalisisLikert" class="col-md-12"></div>
                </div>
            </div>   
            </form>    
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
<script type="text/javascript" src="js/enc_analisisEncuesta.js"></script>

