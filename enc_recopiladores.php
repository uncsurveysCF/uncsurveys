<?php
require('header.php');
require('Negocios/utilidades.php');
if ($_GET) {
    $idEncuesta = decrypt($_GET["id"]);
    $codigo = $_GET["id"]."-WEB";
}
?>
<div>
    <ul class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li><a class="active" href="#">Recopiladores Encuesta</a></li>
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
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2>Recopiladores</h2>
            </div>
            <div class="box-content">
                <form id="formrecopilar" action="#" method="post" role="form">
                   <input type="hidden" id="oper" name="oper" value="actReco" />
                   <input type="hidden" id="idEncuesta" name="idEncuesta" value="<?php echo $idEncuesta; ?>">
                   <input type="hidden" id="tipoEncuesta" name="tipoEncuesta" >
                   <input type="hidden" id="hfIdPeriodo" name="hfIdPeriodo" value="">
                    <div class=" row">                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-left" for="txtFcIni">Inicio de Recopilaci&oacute;n:</label>
                                <input class="form-control input-sm" id="txtFcIni"
                                       name="txtFcIni" type="text" value="" disabled="disabled" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-left" for="txtFcFin">Fin de Recopilaci&oacute;n:</label>											
                                <input class="form-control input-sm" id="txtFcFin"
                                       name="txtFcFin" type="text" />											
                            </div>
                        </div>
                    </div>
                   <div class=" row">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input id="ckIdentificacion" name="ckIdentificacion" type="checkbox" value="1">
                                    Agregar Identificaci&oacute;n de accesso para los participantes
                                </label>
                            </div>
                        </div>    
                   </div>
                   <div id="pnlIdsParticipantes" class="row">
                       <div class="col-md-12" id="filaPartAnt">
                           <div class="form-group">
                               <input id="txtIdsPartAnt" class="form-control" name="txtIdsPartAnt" type="text" data-role="tagsinput" />                               
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <input id="txtIdsPart" class="form-control" name="txtIdsPart" type="text" 
                                   placeholder="Ingrese las identificaciones de participantes que desee incorporar a la encuesta" data-role="tagsinput" />
                               <span class="small"> Separar cada entrada con coma</span>
                           </div>
                       </div>
                   </div>    
                    <div class=" row">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input id="ckRecWeb" name="ckRecolector[]" type="checkbox" value="WEB">
                                    Recopilador Web
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input id="ckRecEmail" name="ckRecolector[]" type="checkbox" value="EMAIL">
                                    Recopilador por Correo Electr&oacute;nico
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row" id="pnlRecWeb" style="display: none;">
                        <div class="col-md-10">
                            <div class="well">
                                <div class="form-group">
                                    <label class="text-left" for="txtEnlaceWeb"><b>Recopilador Web:</b></label>
                                    <input type="hidden" id="hfCodigoWeb" name="hfCodigoWeb" value="<?php echo encrypt($codigo); ?>" />
                                    <input class="form-control" id="txtEnlaceWeb" name="txtEnlaceWeb" type="text"
                                    value="http://uncsurveys.fi.uncoma.edu.ar/r/index.php?id=<?php echo encrypt($idEncuesta); ?>&cd=<?php echo encrypt($codigo); ?>" />
                                </div><!---->
                            </div>    
                        </div>
                    </div>
                    <div class="row" id="pnlRecEmail" style="display: none;">
                        <div class="col-md-10">
                            <div class="well">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-left"><b>Recopilador Correo Electr&oacute;nico:</b></label>                           
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-left" for="txtDestinosAnt">Destinos ya notificados:</label>
                                            <input id="txtDestinosAnt" class="form-control" name="txtDestinosAnt" type="text" />
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input id="txtDestinos" class="form-control" name="txtDestinos" type="text" 
                                                   placeholder="Agregue los correos electronicos de los destinatarios separados por , " data-role="tagsinput" />
                                        </div>
                                    </div>    
                                </div>
                                <div class=" row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input id="txtAsunto" class="form-control" name="txtAsunto" type="text" value="UncSurveys: Nueva Encuesta" />
                                        </div>
                                    </div>
                                </div>
                                <div class=" row">
                                    <div class="col-md-12">
                                        <div class="well">
                                            <input type="hidden" id="hfTitulo" name="hfTitulo" />
                                            <div class="alert alert-info big center-text">
                                                <strong>Encuesta: </strong><span id="spTitulo"></span>
                                            </div>
                                            <textarea class="form-control center-text" id="txtMensaje" rows="3" style="border:0px none;" 
                                                      name="txtMensaje" type="text" placeholder="Mensaje" > Estamos realizando una encuesta y su participaci&oacute;n es de gran valor. Muchas gracias por su colaboraci&oacute;n.
                                            </textarea>
                                            <div class="row">
                                                <div class="box col-md-12 center">
                                                    Para participar de la encuesta presione el bot&oacute;n<br /><br />
                                                    <button id='btnEn' type='button' class='btn btn-default'>
                                                        Comenzar la Encuesta
                                                    </button><br /><br /><br /><br />
                                                    <span class="small"><em>Por favor no reenv&iacute;e este mensaje el enlace es &uacute;nico.</em></span>
                                                    <br />
                                                    <img alt="UNCSurveys" src="img/logo80.png" /><br />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <div class=" row">
                        <div class="box col-md-12">
                            <button id='btnRecopilar' type='submit' class='btn btn-info'>
                                <i class="fa fa-bullhorn"></i> Actualizar Recopiladores
                            </button>
                            <button id='btnCerrar' type='button' class='btn btn-danger' onclick="History.back()">
                                <i class="fa fa-close"></i> Cerrar
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span id="respuesta"></span>
                        </div>
                        <!--/col-md-12 -->
                    </div>
            </div>
            </form> 
        </div>
    </div>
    <!--/span-->
</div>



<!--/row-->

<?php require('footer.php'); ?>
<!-- Mis script -->
<script	type="text/javascript" src="js/bootstrap-tagsinput.js"></script>
<script	type="text/javascript" src="js/enc_recolectoresEncuesta.js"></script>


