<?php

function listadoTiposEncuesta(){
	try{
		$base = new PDOConfig();
		$resultado = array();
		
		$sql = "SELECT idTipoEncuesta,Descripcion,Observaciones
				      FROM tiposencuestas ";
		
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