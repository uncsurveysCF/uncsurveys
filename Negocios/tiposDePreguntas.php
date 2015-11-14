<?php
header('Content-type: text/html; charset=utf-8');
require_once('../libs/PDOConfig.php');
require_once('utilidades.php');

function combo($default, $selected){
	try{
		$base = new PDOConfig();

		$sql = "SELECT idTipoPregunta,Descripcion
				FROM tipospreguntas WHERE Activo = 1 ORDER BY Descripcion";

		$res = $base->query($sql);
		$Listcombo = "<option value=''>$default</option>";

		foreach ($res as $row)
		{
			if($row["idTipoPregunta"] == $selected){
				$Listcombo .= "<option value='".$row["idTipoPregunta"]."' selected='selected'>".$row["Descripcion"]."</option>";
			}else{
				$Listcombo .= "<option value='".$row["idTipoPregunta"]."' >".$row["Descripcion"]."</option>";
			}
		}
		echo $Listcombo;
	}
	catch (Exception $e){
		echo "<div class='form-group has-error col-md-10'>
                    <input type='text' class='form-control' id='error2' value='Error al conectar a la Base de Datos'>
                </div>" ;
		exit();
	}
}


function formTipoPregOM1($Nro){
	$salida = '<div class="row">
							<div class="col-md-12">
							<div class="form-group">
								<label class="text-left" >Ingrese las opciones:</label>				
							</div>
							</div>
						</div>	
						  <div class="row">
						  <div class="col-md-1 text-right">
			                   <input type="radio" name="optionsRadios">
						  </div>
						  <div class="col-md-8">
						  		<input class="form-control input-sm" id="opcionPregunta[]"
									name="opcionPregunta[]" type="text"  placeholder="Ingrese el texto de la opci&oacute;n" />
						  </div>
						 <div class="col-md-2">
						  <a class="red" style="font-size:1.4em">
						      <i class="glyphicon glyphicon-minus-sign"></i></a>
							<a class="green" style="font-size:1.4em" onclick="agregarOpcionOM1()"><i class="glyphicon glyphicon-plus-sign"></i></a>		
						 </div>
						</div>';
	return $salida;
	
}


if($_POST)
{
	$rta="";
	try{
		$oper = $_POST['oper'];

		switch ($oper){
			case 'combo': 	$default = $_POST['vdefaul'];
							$selected= $_POST["selected"];
							$rta=combo($default,$selected);
							break;
							
			case 'NuevaPregunta':
							$tipo = $_POST['tipo'];
							$Nro = $_POST['Nro'];
							
							switch ($tipo){
							case '1':
								$rta=formTipoPregOM1($Nro); break;
							
							}
							break;
						
		}

	}
	catch (Exception $e){
		echo "<div class='form-group has-error col-md-10'>
                    <input type='text' class='form-control' id='error2' value='Error ejecutar la operaci&oacute;n'>
                </div>";
		exit();
	}

	echo $rta;

}
