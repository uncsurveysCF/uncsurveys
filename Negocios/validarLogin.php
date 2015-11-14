<?php
include("../libs/PDOConfig.php");
include('../libs/Login.php');

$oLogin=new Login();
$oLogin->iniciar($_POST['txtUsuario'],$_POST['txtPass']);
	if($oLogin->validar()){	
		echo "1";
	}else{
		echo $oLogin->getError();	
}
?>