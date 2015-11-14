<?php
require('header.php');
require('Negocios/utilidades.php');
if ($_GET) {
    $idEncuesta = decrypt($_GET["id"]);
    $idUsuario = $oLogin->getIdUsuario();
    $dd = encrypt(1022);
    echo $dd;
}
?>
<div>
    <ul class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li><a class="active" href="#">Dise&ntilde;ar Encuesta</a></li>
    </ul>
</div>
<div class=" row">
    <div class="col-md-12">	
        <a id="btnConfigurar" class="btn btn-primary btn-sm" href="enc_configurar.php?id=<?php echo $idEncuesta; ?>"><i class="glyphicon glyphicon-cog"></i> Configurar</a>
        <a id="btnPrevia" class="btn btn-info btn-sm" href="enc_previsulizar.php?id=<?php echo encrypt($idEncuesta); ?>&op=<?php echo encrypt(1); ?>" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> Previsualizar</a>
        <a id="btnPublicar" class="btn btn-success btn-sm" href="enc_publicarEncuesta.php?id=<?php echo encrypt($idEncuesta); ?>&op=<?php echo encrypt(1); ?>" ><i class="glyphicon glyphicon-bullhorn"></i> Publicar</a>
        <a id="btnCompartir" class="btn btn-default btn-sm" href="enc_compartirEncuesta.php?id=<?php echo encrypt($idEncuesta); ?>"><i class="fa fa-share-alt"></i> Compartir</a>
    </div>
</div>
<div class=" row">
    <div class="box col-md-12">
        <input type="hidden" id="hfIdEncuesta" name="hfIdEncuesta" value="<?php echo $idEncuesta; ?>">
        <input type="hidden" id="hfIdUsuario" name="hfIdUsuario" value="<?php echo $idUsuario; ?>">
        <div class="box-inner">
            <div class="box-header well">
                <h2>
                    <span id="txtTitulo"></span>
                </h2>
            </div>
            <div class="box-content" id="txtDescripcion">
            </div>
        </div>
    </div>
    <!--/span-->
</div>
<!--/row-->
<div class="row">
    <div class="col-md-12">
        <span id="respuestaPag"></span>
    </div>
    <!--/col-md-12 -->
</div>

<div id="disenioEncuesta"></div>

<div class=" row">
    <div class="box col-md-12">
        <button id='btnNuevaPagina' type='button' class='btn btn-info'>
            <i class='glyphicon glyphicon-plus-sign'></i> Agregar P&aacute;gina</button>
    </div>
</div>	

<div class="modal fade" id="mlPagina" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    [X]
                </button>
                <h4 class="red">Cambie T&iacute;tulo de la P&aacute;gina</h4>

                <form id="formTituloPagina" action="" method="post" role="form">
                    <input type="hidden" id="oper" name="oper" value="nuevoTituloPag"> <input
                        type="hidden" id="nropagina" name="nropagina"> <input
                        type="hidden" id="hdIdEncPag" name="hdIdEncPag"
                        value="<?php echo $idEncuesta; ?>" />
                    <input type="hidden" id="hfIdEstado" name="hfIdEstado">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input class="form-control input-sm" id="txtTituloPag"
                                           name="txtTituloPag" type="text"
                                           placeholder="Ingrese el T&iacute;tulo de la P&aacute;gina" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span id="respTitPag"></span>
                        </div>
                        <!--/col-md-12 -->
                    </div>
                    <div class="modal-footer">
                        <button id="btnGuardarPag" type="submit" class="btn btn-primary">Guardar</button>
                        <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                    </div>
                </form>	
            </div>
        </div>
    </div>
</div>
<!--  ventana para cargar preguntas	-->
<div class="modal fade" id="mlPreguntas" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    [X]
                </button>
                <h4 class="red">Nueva Pregunta</h4>
            </div>
            <form id="formNuevaPregunta" action="" method="post" role="form">
                <input type="hidden" id="oper" name="oper" value="nueva"> <input
                    type="hidden" id="pagina" name="pagina" value="1"> <input
                    type="hidden" id="hdIdEncP" name="hdIdEncP"
                    value="<?php echo $idEncuesta; ?>" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cbTipoPregunta">Tipo de Pregunta: </label> <select
                                    id="cbTipoPregunta" name="cbTipoPregunta"
                                    class="form-control input-sm" data-rel="chosen">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="verFormPreg" style="display: none;">
                       
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-left" for="txtPregunta">Pregunta:</label> <input
                                        class="form-control input-sm" id="txtPregunta"
                                        name="txtPregunta" type="text"
                                        placeholder="Ingrese el texto de la pregunta" />
                                </div>
                            </div>
                        </div>
                         <div class="row" id="ordenOp">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label> <input type="checkbox" id="chOrdenarOp" name="chOrdenarOp" value="1"> Asociar Orden a las opciones
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="rowOpciones">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-left">Ingrese las opciones:</label>
                                </div>
                            </div>
                        </div>
                         <div class="row" id="opDif" >
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cbDiferenciales">Diferencial: </label> 
                                    <select id="cbDiferenciales" name="cbDiferenciales"
                                        class="form-control input-sm">
                                        <option value="">...</option>
                                        <option value="3">3</option>
                                        <option value="5">5</option>
                                        <option value="7">7</option>
                                    </select>
                                </div>
                            </div>
                         </div>     
                        <div id="verOpciones"></div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="box col-md-12" >
                                <div class="box-inner">
                                    <div class="box-content" style="background-color: #E0E0E0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkbox">
                                                    <label> <input type="checkbox" id="chRespObligatoria" name="chRespObligatoria"
                                                                   value="1" checked="checked"> Respuesta Obligatoria
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox">
                                                    <label> <input type="checkbox" id="chAnalisis" name="chAnalisis"
                                                                value="1" checked="checked"> Incluir An&aacute;lisis
                                                    </label>
                                                </div>
                                            </div>
                                        </div>	
                                        									
                                        <div class="row">
                                            <div class="col-md-4 opTexto">
                                                <div class="form-group">
                                                    <label for="cbFormato">Formato: </label> <select
                                                        id="cbFormato" name="cbFormato"
                                                        class="form-control input-sm">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 opTexto">
                                                <div class="form-group"><br />
                                                    <input class="form-control input-sm" id="txtMin"
                                                           maxlength="10"  name="txtMin" type="text" placeholder="Minimo" />
                                                </div>
                                            </div>
                                            <div class="col-md-3 opTexto">
                                                <div class="form-group"><br />
                                                    <input class="form-control input-sm" id="txtMax"
                                                       maxlength="10"  name="txtMax" type="text" placeholder="Maximo" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row opcMultiples">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cbEscala">Escala: </label> <select
                                                        id="cbEscala" name="cbEscala"
                                                        class="form-control input-sm">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span id="respuestaPreg"></span>
                            </div>
                            <!--/col-md-12 -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnGuardar" type="submit" class="btn btn-primary">Guardar
                        Pregunta</button>
                    <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                </div>
            </form>
        </div>
    </div>
</div>


<!--  ventana para modificar preguntas	-->
<div class="modal fade" id="mlModifPreguntas" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">[X]</button>
                <h4 class="red">Modificar Pregunta</h4>
            </div>
            <form id="formModifPregunta" action="" method="post" role="form">
                <input type="hidden" id="oper" name="oper" value="modificarPregunta"> 
                <input type="hidden" id="hdIdEncModif" name="hdIdEncModif" value="<?php echo $idEncuesta; ?>" />
                <input type="hidden" id="paginaModfi" name="paginaModfi"> 				
                <input type="hidden" id="hdIdPregModif" name="hdIdPregModif" />
                <input type="hidden" id="hdIdTipoPreg" name="hdIdTipoPreg" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipoPreg">Tipo de Pregunta: </label> 
                                <input class="form-control input-sm" id="txtTipoPreguntaM"
                                       name="txtTipoPreguntaM" type="text" />
                            </div>
                        </div>
                    </div>
                    <div id="verFormPregM" >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-left" for="txtPreguntaM">Pregunta:</label> <input
                                        class="form-control input-sm" id="txtPreguntaM"
                                        name="txtPreguntaM" type="text"
                                        placeholder="Ingrese el texto de la pregunta" />
                                </div>
                            </div>
                        </div>
                         <div class="row" id="ordenOpM">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label> <input type="checkbox" id="chOrdenarOpM" name="chOrdenarOpM" value="1"> Asociar Orden a las opciones
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="rowOpcionesM">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-left">Ingrese las opciones:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="opDifM" >
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cbDiferencialesM">Diferencial: </label> 
                                    <select id="cbDiferencialesM" name="cbDiferencialesM"
                                        class="form-control input-sm">
                                        <option value="">...</option>
                                        <option value="3">3</option>
                                        <option value="5">5</option>
                                        <option value="7">7</option>
                                    </select>
                                </div>
                            </div>
                         </div>
                        <div id="verOpcionesM"></div>
                        <div id="verColumnasM"></div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="box col-md-12" >
                                <div class="box-inner">
                                    <div class="box-content" style="background-color: #E0E0E0;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkbox">
                                                    <label> <input type="checkbox" id="chRespObligatoriaM" name="chRespObligatoriaM"
                                                                  checked="checked" value="1"> Respuesta Obligatoria
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox">
                                                    <label> <input type="checkbox" id="chAnalisisM" name="chAnalisisM"
                                                               value="1" checked="checked"> Incluir An&aacute;lisis
                                                    </label>
                                                </div>
                                            </div>
                                        </div>	
                                        									
                                        <div class="row">
                                            <div class="col-md-4 opTextoM">
                                                <div class="form-group">
                                                    <label for="cbFormatoM">Formato: </label> <select
                                                        id="cbFormatoM" name="cbFormatoM"
                                                        class="form-control input-sm">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 opTextoM">
                                                <div class="form-group"><br />
                                                    <input class="form-control input-sm" id="txtMinM"
                                                        maxlength="10"   name="txtMinM" type="text" placeholder="Minimo" />
                                                </div>
                                            </div>
                                            <div class="col-md-3 opTextoM">
                                                <div class="form-group"><br />
                                                    <input class="form-control input-sm" id="txtMaxM"
                                                      maxlength="10"     name="txtMaxM" type="text" placeholder="Maximo" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row opcMultiplesM">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cbEscalaM">Escala: </label> <select
                                                        id="cbEscalaM" name="cbEscalaM"
                                                        class="form-control input-sm">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span id="respuestaPregM"></span>
                            </div>
                            <!--/col-md-12 -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnModificar" type="submit" class="btn btn-primary">Guardar
                        Pregunta</button>
                    <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                </div>
            </form>
        </div>

    </div>
</div>



<?php require('footer.php'); ?>
<!-- Mis script -->
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script
type="text/javascript" src="js/preg_tiposDePreguntas.js"></script>
<script
type="text/javascript" src="js/enc_diseniarEncuesta.js"></script>
