<?php require('header.php'); ?>
<!-- <div>
         <ul class="breadcrumb">
                <li><a href="#">Inicio</a>
                </li>
                <li><a href="#">Mis Encuestas</a>
                </li>
        </ul>
</div> -->
<div class=" row">
    <div class="col-md-3 col-sm-3 col-xs-6">
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
    </div>

    <div class="col-md-6 col-sm-3 col-xs-6">
        <div class="box col-md-12 text-right">
            <a id='btnNuevaEncuesta' class='btn btn-success btn-lg' href="enc_nuevaEncuesta.php">
                <i class='glyphicon glyphicon-plus-sign'></i> Crear Encuesta</a>
        </div>
    </div>
</div>

<div class=" row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2>
                    <i class="glyphicon glyphicon-th"></i> Mis Encuestas
                </h2>
            </div>
            <div class="box-content">
                <div class=" row">

                </div>
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
<script type="text/javascript" src="js/enc_listado.js"></script>
