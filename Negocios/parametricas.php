<?php
header('Content-type: text/html; charset=utf-8');
require_once('../libs/PDOConfig.php');
require_once('utilidades.php');
require_once('parametros.php');
require_once("../libs/Login.php");
require_once("../Datos/tblParametricas.php");

$oLogin=new Login();
if(!$oLogin->activa()){
	exit();
}


function comboEscalas($default, $selected){
	try{

		$listado = listadoEscalas();
		$Listcombo = "<option value=''>$default</option>";
		foreach ($listado as $row)
		{
			if($row["idEscala"] == $selected){
				$Listcombo .= "<option value='".$row["idEscala"]."' selected='selected'>".$row["Descripcion"]."</option>";
			}else{
				$Listcombo .= "<option value='".$row["idEscala"]."' >".$row["Descripcion"]."</option>";
			}
		}
		return $Listcombo;
	}
	catch (Exception $e){
		return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>" ;
	}
}

function comboFormatos($default, $selected){
	try{

		$listado = listadoFormatos();
		$Listcombo = "<option value=''>$default</option>";
		foreach ($listado as $row)
		{
			if($row["idFormato"] == $selected){
				$Listcombo .= "<option value='".$row["idFormato"]."' selected='selected'>".$row["Descripcion"]."</option>";
			}else{
				$Listcombo .= "<option value='".$row["idFormato"]."' >".$row["Descripcion"]."</option>";
			}
		}
		return $Listcombo;
	}
	catch (Exception $e){
		return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>" ;
	}
}

if($_POST)
{
	$rta="";
	try{
		$oper = $_POST['oper'];

		switch ($oper){
			case 'escalas': 	$default = $_POST['vdefaul'];
								$selected= $_POST["selected"];
								$rta=comboEscalas($default,$selected);
								break;
				
			case 'formatos': 	$default = $_POST['vdefaul'];
								$selected= $_POST["selected"];
								$rta=comboFormatos($default,$selected);
								break;

		}

	}
	catch (Exception $e){
		echo "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>" ;
	}

	echo $rta;

}
