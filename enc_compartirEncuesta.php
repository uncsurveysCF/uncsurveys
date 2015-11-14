<?php
require('header.php');
require('Negocios/utilidades.php');
if($_GET){
	$idEncuesta = decrypt($_GET["id"]);
}
?>
<div>
	<ul class="breadcrumb">
		<li><a href="#">Inicio</a></li>
		<li><a class="active" href="#">Dise&ntilde;ar Encuesta</a></li>
	</ul>
</div>
<div class=" row">
	<div class="box col-md-12">
		
		<div class="box-inner">
			<div class="box-header well">
				<h2>
					<span id="txtTitulo"></span>
				</h2>
				<div class='box-icon'>
				<a href="r/index.php?id=<?php echo encrypt($idEncuesta); ?>&op=<?php echo encrypt(1); ?>" target="_blank" class="btn btn-round btn-default" title="Vista Previa de Encuesta">
				<i class="glyphicon glyphicon-eye-open"></i></a>		
                </div>
			</div>
			<div class="box-content" id="txtDescripcion">
			</div>
		</div>
	</div>
	<!--/span-->
</div>
<div class=" row">
	<div class="box col-md-12">
		<div class="box-inner">
			<div class="box-header well">
				<h2>Compartir Encuesta</h2>
			</div>
			<div class="box-content">
			<form id="formCompartir">
			<input type="hidden" id="hfIdEncuesta" name="hfIdEncuesta" value="<?php echo $idEncuesta; ?>">
			<input type="hidden" id="oper" name="oper" value="compartir">
			<div class=" row">
			<div class="col-md-10">
				<div class="form-group">
						<label class="text-left" for="cbGrupos">Grupos:</label> <select
							id="cbGrupos" name="cbGrupos" class="form-control input-sm"
							data-rel="chosen">
							<option value="">...</option>
						</select>
					</div>
			</div>
			</div>
			<div class=" row">
				<div class="box col-md-12">
				<button id='btnCompartir' type="submit" class='btn btn-info'>
							Compartir</button>
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
	type="text/javascript" src="js/enc_compartirEncuesta.js"></script>