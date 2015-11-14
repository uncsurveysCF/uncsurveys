<?php
header('Content-type: text/html; charset=utf-8');
require_once('../libs/PDOConfig.php');
require_once('utilidades.php');
require_once('parametros.php');
require_once("../libs/Login.php");
require_once("../Datos/modeloPaginas.php");


$oLogin=new Login();
if(!$oLogin->activa()){
	exit();
}

function listarPaginas($idEncuesta){
	$datos = paginaXEncuesta($idEncuesta);
	if($datos != "0"){
		return json_encode($datos);
	}else{
		return "0";
	}
}


if($_POST)
{
	$rta="";
	try{
		$oper    = $_POST['oper'];
		$usuario = $oLogin->getIdUsuario();
		switch ($oper){

			case 'pagXEnc':
				$idEncuesta=$_POST["idEncuesta"];
				$rta=listarPaginas($idEncuesta);
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