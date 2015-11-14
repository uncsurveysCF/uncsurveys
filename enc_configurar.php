<?php
require('header.php');
if ($_GET) {
    $idEncuesta = $_GET["id"];
}
?>
<div>
    <ul class="breadcrumb">
        <li><a href="#">Inicio</a>
        </li>
        <li><a href="#">Configurar Encuesta</a>
        </li>
    </ul>
</div>
<div class=" row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2>
                    <i class="glyphicon glyphicon-th"></i> Configurar encuesta
                </h2>
            </div>
            <div class="box-content">		
                <form id="formConfigEnc" action="#" method="post" role="form">
                    <fieldset>
                        <input type="hidden" id="oper" name="oper" value="actualizar">
                        <input type="hidden" id="hfIdEncuesta" name="hfIdEncuesta" value="<?php echo $idEncuesta; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-left" for="cbTema">Tema:</label> <select
                                        id="cbTema" name="cbTema" class="form-control input-sm"
                                        data-rel="chosen">
                                        <option value="">...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-left" for="cbTema">Tipo de Encuesta:</label> <select
                                        id="cbTipoEnc" name="cbTipoEnc" class="form-control input-sm"
                                        data-rel="chosen">
                                        <option value="">...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-left" for="txtTitulo">T&iacute;tulo:</label>
                                    <input class="form-control input-sm" id="txtTitulo"
                                           name="txtTitulo" type="text" maxlength="250" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-left" for="txtDescripcion">Descripci&oacute;n:</label>
                                    <textarea class="form-control input-sm" id="txtDescripcion"
                                              name="txtDescripcion" maxlength="500"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-left" for="txtFechaLimite">Fecha L&iacute;mite de acceso:</label>
                                    <input class="form-control input-sm" id="txtFechaLimite"
                                           name="txtFechaLimite" type="text" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-left" for="txtHoraLimite">Hora L&iacute;mite de acceso:</label>											
                                    <input class="form-control input-sm" id="txtHoraLimite"
                                           name="txtHoraLimite" type="text" />											
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-left" for="txtMaxAcc">Cantidad M&aacute;xima de Accesos:</label>
                                    <input class="form-control input-sm" id="txtMaxAcc"
                                           name="txtMaxAcc" type="text" />		
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <label>
                                        <input name="ckBloquearIP" id="ckBloquearIP" value="1" type="checkbox">
                                        Solo una respuesta por computadora (IP)
                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <label>
                                        <input name="ckTieneClave" id="ckTieneClave" value="1" type="checkbox">
                                        Tiene Clave de Acceso
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-left" for="txtClaveAcc">Ingrese Clave de acceso:</label>
                                    <input class="form-control input-sm" id="txtClaveAcc"
                                           name="txtClaveAcc" type="text" maxlength="100" />		
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input name="ckMostrarResult" id="ckMostrarResult" value="1" type="checkbox">
                                        Publicar Resultados una vez cerrada la encuesta
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">


                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-left" for="txtProposito">Prop&oacute;sito:</label>
                                    <textarea class="form-control input-sm" id="txtProposito"
                                              name="txtProposito"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-left" for="txtPoblacion">Poblaci&oacute;n:</label>
                                    <textarea class="form-control input-sm" id="txtPoblacion"
                                              name="txtPoblacion"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-left" for="txtCarMu">Caracter&iacute;sticas de la Muestra:</label>
                                    <textarea class="form-control input-sm" id="txtCarMu"
                                              name="txtCarMu"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">                        
                            <div class="col-md-12">
                               <div class="form-group">
                                   <input id="txtTags" class="form-control" name="txtTags" type="text"
                                          placeholder="Introduzca aquí los tags de b&uacute;squeda" data-role="tagsinput" />
                                   <span class="small"><em>(*) Separar cada entrada con coma</em> </span>
                               </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <span id="respuestaNueva"></span>
                            </div>
                            <!--/col-md-12 -->
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button id="btnGuardar" type="submit" class="btn btn-primary">Guardar Encuesta</button>
                                <button id="btnCancelar" type="button" class="btn btn-danger" onclick="window.history.back();">Cancelar</button>
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
<script	type="text/javascript" src="js/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="js/enc_configurarEncuesta.js"></script>

