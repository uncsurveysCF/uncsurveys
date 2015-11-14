<?php
header('Content-type: text/html; charset=utf-8');
require_once('../libs/PDOConfig.php');
require_once('utilidades.php');

function combo($default, $selected){
	try{
		$base = new PDOConfig();

		$sql = "SELECT idTema,Descripcion
				FROM temas
				WHERE Activo=1 
				ORDER BY Descripcion ";

		$res = $base->query($sql);
		$Listcombo = "<option value=''>$default</option>";

		foreach ($res as $row)
		{
			if($row["idTema"] == $selected){
				$Listcombo .= "<option value='".$row["idTema"]."' selected='selected'>".$row["Descripcion"]."</option>";
			}else{
				$Listcombo .= "<option value='".$row["idTema"]."' >".$row["Descripcion"]."</option>";
			}
		}
		echo $Listcombo;
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
			case 'combo': 	$default = $_POST['vdefaul'];
							$selected= $_POST["selected"];
							$rta=combo($default,$selected);
							break;
			
		}

	}
	catch (Exception $e){
		echo "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>" ;
	}

	echo $rta;

}