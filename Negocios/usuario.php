<?php
header('Content-type: text/html; charset=utf-8');
require_once('../libs/PDOConfig.php');
require_once('utilidades.php');


function registro($nombre, $apellido, $email, $pais, $user, $pass,$fechaNac){
	try{
	if($fechaNac != ""){
		$fechaNac = formatFecha($fechaNac);
	}
	
	if(($pais == "") || ($pais == "-1")){
	
		$pais = "null";
	}
	
	$sql = " SELECT * FROM usuarios WHERE Usuario = '$user'";
	$resp = $base->query($sql);
	
	if($resp->rowCount() <= 0){	
		$sql = " INSERT usuarios(Usuario,Password,Apellido,Nombre,Email,FechaNac,idPais,FechaCarga,Activo) VALUES
		('$user','".sha1($user.$pass)."','$apellido','$nombre','$email','$fechaNac',$pais,'".date('Y-m-d')."',1)";
		
		if($base->query($sql)){		
			return "1";
		}
		else{
			return "<div class='form-group has-error col-md-8'>
	                    <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se ha podido cargar el usuario'>
	                </div>" ;
			}
	}
	else{
		return "<div class='form-group has-error col-md-8'>
                    <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: el usuario ingresado ya existe'>
                </div>" ;
	}
	}catch (Exception $e){ // cierro el try de la conexion
		return "<div class='form-group has-error col-md-8'>
                    <input type='text' class='form-control' id='error2' value='Error al conectar a la Base de Datos'>
                </div>" ;
	}
	
}

function recuperarClave(){
    
    
}


if($_POST)
{
	$rta="";
	try{		
		$oper    = filtrar($_POST['oper']);
		
		switch ($oper){
			/*case 'combo': 	$default = $basePost->filtrar($_POST['vdefaul']);
							$selected= $basePost->filtrar($_POST["selected"]);
							$idcircunscripcion=$basePost->filtrar($_POST['cbCircunscripciones']);
							
							$rta=combo($selected, $default, $idcircunscripcion);
							break;*/
			case 'registro': 	$nombre= filtrar($_POST["txtNombre"]);
                                                $apellido= filtrar($_POST['txtApellido']);
                                                $email=filtrar($_POST['txtEmail']);
                                                $pais= filtrar($_POST["cbPais"]);
                                                $usuario= filtrar($_POST["txtUsuario"]);
                                                $pass= filtrar($_POST["txtPass"]);							
                                                $rta=registro($nombre, $apellido, $email, $pais, $usuario, $pass,'');
							break;
							
			/*case 'update':	$iddeposito= $basePost->filtrar($_POST["idDepoModif"]);
							$nombre= $basePost->filtrar($_POST["txtNombreModif"]);
							$idcircunscripcion=$basePost->filtrar($_POST['cbCircunscripcionesModif']);
							$idlocalidad=$basePost->filtrar($_POST['cbLocalidadesModif']);
							$direccion= $basePost->filtrar($_POST["txtDireccionModif"]);
							$contacto= $basePost->filtrar($_POST["txtContactoModif"]);
							$responsable= $basePost->filtrar($_POST["txtResponsableModif"]);
							$contactoresp= $basePost->filtrar($_POST["txtContactoRespModif"]);
							$idorganismo=$basePost->filtrar($_POST['cbOrganismosModif']);
							$iddependencia=$basePost->filtrar($_POST['cbDependenciasModif']);
							if(isset($_POST["externoOptionsModif"]))
								$externo= $basePost->filtrar($_POST["externoOptionsModif"]);
							else
								$externo = 0;
							
							$rta=update($iddeposito,$nombre, $idcircunscripcion, $idlocalidad, $direccion, $contacto, $responsable, $contactoresp, $idorganismo, $iddependencia, $externo);
							break;
			case 'del'   :	$iddeposito= $basePost->filtrar($_POST["idDepoDel"]);
							$rta=del($iddeposito);
							break;
			case 'tabla' :	$idcircunscripcion=$basePost->filtrar($_POST['idCircunscripcion']);
							$rta=table($idcircunscripcion);
							break;*/
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