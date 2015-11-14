<?php
header('Content-type: text/html; charset=utf-8');
require_once('../libs/PDOConfig.php');
require_once('utilidades.php');
require_once('../Datos/modeloTipoEncuestas.php');

function combo($default, $selected){
	try{
		
		$listado = listadoTiposEncuesta();
		$Listcombo = "<option value=''>$default</option>";
		foreach ($listado as $row)
		{
			if($row["idTipoEncuesta"] == $selected){
				$Listcombo .= "<option value='".$row["idTipoEncuesta"]."' selected='selected'>".$row["Descripcion"]."</option>";
			}else{
				$Listcombo .= "<option value='".$row["idTipoEncuesta"]."' >".$row["Descripcion"]."</option>";
			}
		}
		return $Listcombo;
	}
	catch (Exception $e){
		return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>" ;
	}
}


function verListado(){
	try{

		$listado = listadoTiposEncuesta();
		return json_encode($listado);
	}
	catch (Exception $e){
		return "0";
	}
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
			
			case 'listado': 
					$rta=verListado();
			break;
				
		}

	}
	catch (Exception $e){
		echo "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>" ;
	}

	echo $rta;

}