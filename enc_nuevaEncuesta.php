<?php require('header.php'); ?>
<div>
	<ul class="breadcrumb">
		<li><a href="#">Inicio</a>
		</li>
		<li><a href="#">Nueva Encuesta</a>
		</li>
	</ul>
</div>
<div class=" row">
	<div class="box col-md-12">
		<div class="box-inner">
			<div class="box-header well">
                            <h2>
                                <i class="glyphicon glyphicon-th"></i> Crear Nueva encuesta
                            </h2>
			</div>
			<div class="box-content">
				<ul class="nav nav-tabs" id="tabsNuevaEncuesta">
					<li class="active"><a href="#tabNueva">Nueva Encuesta</a></li>
					<li><a href="#tabCopia">Copiar Encuesta Existente</a></li>
				</ul>

				<div id="crearEnc" class="tab-content">
					<div class="tab-pane active" id="tabNueva">
						<h4>Genere una nueva encuesta desde cero</h4>
						<form id="formNuevaEnc" action="" method="post" role="form">
							<fieldset>
							<input type="hidden" id="oper" name="oper" value="nueva">
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="text-left" for="cbTema">Tema:</label> <select
												id="cbTema" name="cbTema" class="form-control input-sm">
												<option value="">...</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="text-left" for="txtTitulo">T&iacute;tulo:</label>
											<input class="form-control input-sm" id="txtTitulo"
                                                                                               name="txtTitulo" type="text" maxlength="250" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="text-left" for="cbTipoEncuesta">Tipo de Encuesta:</label>
											<select	id="cbTipoEncuesta" name="cbTipoEncuesta" class="form-control input-sm" >
												<option value="">...</option>
											</select>
										</div>
									</div>
									<div class="col-md-4"><br />
									<a id="lisTipos" href="#" class="btn btn-round btn-info btn-sm" data-toggle="popover">
									 <i class="glyphicon glyphicon-question-sign"></i>
									 </a>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="text-left" for="txtDescripcion">Descripci&oacute;n:</label>
											<textarea class="form-control input-sm" id="txtDescripcion"
                                                                                                  name="txtDescripcion" maxlength="500"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8 ">
										<input type="hidden" id="hdIdEnc" id="hdIdEnc" />
										<span id="respuestaNueva"></span>
									</div>
									<!--/col-md-12 -->
								</div>
								<div class="row">
									<div class="col-md-8 text-right">
										<button id="btnGuardar" type="submit" class="btn btn-primary">Crear Encuesta</button>
										<button id="btnPreguntas" type="button" class="btn btn-primary" style="display: none;">Cargar Preguntas</button>
									</div>
									<!--/col-md-12 -->
								</div>
							</fieldset>
						</form>
					</div>
					<div class="tab-pane" id="tabCopia">
						<h4>Genere una nueva encuesta partiendo de una existente</h4>
						<form id="formNuevaEncCopia" action="" method="post" role="form">
							<fieldset>
							<input type="hidden" id="oper" name="oper" value="nuevaCopia">
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="text-left" for="cbMisEnc">Mis Encuesta:</label> <select
												id="cbMisEnc" name="cbMisEnc" class="form-control input-sm">
												<option value="">...</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="text-left" for="txtTituloCopia">T&iacute;tulo:</label>
											<input class="form-control input-sm" id="txtTituloCopia"
												name="txtTituloCopia" type="text" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8 ">
										<input type="hidden" id="hdIdEncCopia" id="hdIdEncCopia" />
										<span id="respuestaCopia"></span>
									</div>
									<!--/col-md-12 -->
								</div>
								<div class="row">
									<div class="col-md-8 text-right">
										<button id="btnGuardarCopia" type="submit" class="btn btn-primary">Crear Encuesta</button>
										<button id="btnPreguntasCopia" type="button" class="btn btn-primary" style="display: none;">Cargar Preguntas</button>
									</div>
									<!--/col-md-12 -->
								</div>
								
							</fieldset>
						</form>								
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
<script type="text/javascript" src="js/enc_crearEncuesta.js"></script>
