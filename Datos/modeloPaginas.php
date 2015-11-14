<?php

function paginaXEncuesta($idEncuesta){
	try{
		$salida = "";
		$base = new PDOConfig();

		$sql="SELECT idPagina,idEncuesta,Titulo,NroPagina
		FROM paginasencuestas
		WHERE idEncuesta = $idEncuesta
		ORDER BY NroPagina ";
		
		$res = $base->query($sql);
		if($res){
			$salida = $res->fetchAll(PDO::FETCH_ASSOC);
			return $salida;
		}
	}catch (Exception $e){
		return "0" ;
	}

}