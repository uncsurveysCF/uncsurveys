<?php require('header.php'); ?>
<div>
	<ul class="breadcrumb">
		<li><a href="#">Inicio</a>
		</li>
		<li><a href="#">Encuestas de acceso P&uacute;blico</a>
		</li>
	</ul>
</div>

<div class=" row">
	<div class="box col-md-12">
		<div class="box-inner">
			<div class="box-header well">
                            <h2>
                                    <i class="glyphicon glyphicon-th"></i> Encuestas de acceso P&uacute;blico
                            </h2>
			</div>
			<div class="box-content">	
			
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
                                <button id="btnGuardar" type="submit" class="btn btn-primary">Buscar Encuestas</button>
                            </div>
                            <!--/col-md-12 -->
                        </div> 
                        <div class="row">&nbsp;</div>
			<div class=" row">
				<div class="box col-md-12">			
				<div id="listadoDatos"></div>
				</div>
			</div>	
			</div>	
		</div>
	</div>
	<!--/span-->


</div>
<!--/row-->
<?php require('footer.php'); ?>

<!-- Mis script -->
<script type="text/javascript" src="js/enc_publicas.js"></script>

