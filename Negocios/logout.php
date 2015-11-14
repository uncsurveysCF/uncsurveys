<?php
include('../libs/PDOConfig.php');
include('../libs/Login.php');
$oLogin=new Login();
if($oLogin->cerrar()){
	header('location:../index.php');
}
?>