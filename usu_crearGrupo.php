<?php require('header.php'); ?>
<div>
	<ul class="breadcrumb">
		<li><a href="#">Usuarios</a>
		</li>
		<li><a href="#">Nuevo Grupo</a>
		</li>
	</ul>
</div>
<div class=" row">
	<div class="box col-md-12">
		<div class="box-inner homepage-box">
			<div class="box-header well">
				<h2>
					<i class="glyphicon glyphicon-th"></i> Crear un grupo
				</h2>
			</div>
			<div class="box-content">

				<div class="box col-md-12">
					<form id="formNuevoGrupo" action="" method="post" role="form">
						<fieldset>
							<input type="hidden" id="oper" name="oper" value="nuevoGrupo">							
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="text-left" for="txtTitulo">Nombre:</label>
										<input class="form-control input-sm" id="txtNombre"
											name="txtNombre" type="text" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="text-left" for="txtDescripcion">Descripci&oacute;n:</label>
										<textarea class="form-control input-sm" id="txtDescripcion"
											name="txtDescripcion"></textarea>
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
									<button id="btnGuardar" type="submit" class="btn btn-primary">Crear
										Grupo</button>
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
	type="text/javascript" src="js/creargrupo.js"></script>
