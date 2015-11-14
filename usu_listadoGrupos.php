<?php require('header.php'); ?>
<div>
	<ul class="breadcrumb">
		<li><a href="#">Inicio</a>
		</li>
		<li><a href="#">Grupos</a>
		</li>
	</ul>
</div>

<div class=" row">
	<div class="box col-md-12">
		<div class="box-inner">
			<div class="box-header well">
				<h2>
					<i class="glyphicon glyphicon-th"></i>Grupos
				</h2>
			</div>
			<div class="box-content">	
			<div class=" row">
				<div class="box col-md-12 text-right">
				<a id='btnNuevGrupo' class='btn btn-success' href="usu_crearGrupo.php">
							<i class='glyphicon glyphicon-plus-sign'></i> Crear Grupo</a>
				</div>
			</div>
			<div class=" row">
				<div class="box col-md-12">
				 <div class="box-header well" data-original-title="">
                    <h2>Grupos Administrados</h2>	
                 </div>
                 <div class="box-content">   			
					<div id="listadoDatos"></div>
			    </div>
				</div>
			</div>	
			<div class=" row">
				<div class="box col-md-12">
				 <div class="box-header well" data-original-title="">
                    <h2>Es Miembro en Grupos</h2>	
                 </div>
                 <div class="box-content">   			
					<div id="listadoGruposComp"></div>
			    </div>
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
<script type="text/javascript" src="js/listadoGrupos.js"></script>
