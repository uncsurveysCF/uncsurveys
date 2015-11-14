<?php
function listadoEscalas(){
	try{
		$base = new PDOConfig();
		$resultado = array();

		$sql = "SELECT idEscala,Descripcion
				      FROM escalas WHERE idEscala > 1 ";

		$res = $base->query($sql);
		if($res)
		{
			$resultado = $res->fetchAll(PDO::FETCH_ASSOC);
		}

		return $resultado;

	}
	catch (Exception $e){
		return false;
	}
}

function listadoFormatos(){
	try{
		$base = new PDOConfig();
		$resultado = array();

		$sql = "SELECT idFormato,Descripcion
				      FROM formatos ";

		$res = $base->query($sql);
		if($res)
		{
			$resultado = $res->fetchAll(PDO::FETCH_ASSOC);
		}

		return $resultado;

	}
	catch (Exception $e){
		return false;
	}
}