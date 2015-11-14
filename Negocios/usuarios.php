<?php
header('Content-type: text/html; charset=utf-8');
require_once('../libs/PDOConfig.php');
require_once("../libs/class.phpmailer.php");
require_once('utilidades.php');

function nuevoUsuario($apellido,$nombre,$email,$user,$pass){
	try{
	$base = new PDOConfig();
	$apellido = $base->filtrar($apellido);
	$nombre = $base->filtrar($nombre);
	$email = $base->filtrar($email);	
	$user = $base->filtrar($user);
	$pass = $base->filtrar($pass);
		
	$sql = " SELECT * FROM usuarios WHERE Usuario = '$user'";	
	$resp = $base->query($sql);
	
	if($resp->rowCount() > 0){		
			return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error: el usuario ingresado ya existe</div>" ;
		}	
	
	$sql = " SELECT * FROM usuarios WHERE Email = '$email'";
	$resp = $base->query($sql);
	if($resp->rowCount() > 0){
		return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error: el email ingresado ya existe</div>" ;
	}
		
		$sql = " INSERT usuarios(Usuario,Password,Apellido,Nombre,Email,FechaCarga,Activo) VALUES 
					('$user','".sha1($user.$pass)."','$apellido','$nombre','$email','".date('Y-m-d')."',1)";	
		//echo $sql;	
		if($base->query($sql)){
                    $cuerpo = envioNuevaCuenta($user, $pass);
                    enviarMail($email, "UNCSurveys: Registro", $cuerpo);                            
                    echo "1";	
		}
		else{
			return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error: no se ha podido cargar el usuario</div>" ;
		}	
	
	}
	catch (Exception $e){
		return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>" ;
	}
}

function recuperarClave($usuario,$email){
try{
    $base = new PDOConfig();
    $usuario = $base->filtrar($usuario);
    $correoElect =$base->filtrar($email);            
    $base->beginTransaction();        
    $sqlResp="SELECT * from usuarios U 
              WHERE U.Usuario = '$usuario' AND U.Email = '$correoElect'";

    $resOps = $base->query($sqlResp);
    if($resOps){
        if($resOps->rowCount() > 0)
        {
            $nuevaPass = generaPass();
            $sqlUp="UPDATE usuarios SET Password = '".sha1($usuario.$nuevaPass)."' 
              WHERE Usuario = '$usuario' AND Email = '$correoElect'";
            //return $sqlUp;
            $resUps = $base->query($sqlUp);
            if($resUps){
                $mensaje = "Usted ha solicitado recuperar su contrase&ntilde;a de acceso: <br />"
                        . "<b>Usuario:</b> $usuario<br /><b>Contrase&ntilde;a:</b> $nuevaPass";
                $cuerpo = envioRecuperarClave($mensaje);
                $salida = enviarMail($correoElect,"UNCSurveys: Cambio de Contraseña", $cuerpo);
                //$base->rollBack(); 
                //return $salida;
                if($salida)
                {
                    $base->commit();
                    echo "1";
                }else{
                    $base->rollBack();  
                    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                      Error al intentar enviar la nueva contrase&ntilde;a</div>";  
                  }
                
            }else{
              $base->rollBack();  
              return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                Error al intentar cambiar la Contrase&ntilde;a</div>";  
            }
        }
        else{
            $base->rollBack();
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
            No se encontr&oacute; ning&uacute;n usuario con los datos ingresados</div>";
        }
        
    }
    else{
        $base->rollBack();
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    	Error al consultar la base de datos</div>";
    }      
}
 catch (Exception $ex){
    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    	Error al consultar la base de datos</div>";
    } 
    
}

function cambiarClave($idUsuario,$usuario,$nuevaClave){
try{
    $base = new PDOConfig();
    $idUsuario = $base->filtrar($idUsuario);
    $usuario = $base->filtrar($usuario);
    $nuevaClave =$base->filtrar($nuevaClave);            
    $base->beginTransaction();        
        
    $sqlUp="UPDATE usuarios SET Password = '".sha1($usuario.$nuevaClave)."' 
                WHERE idUsuario = '$idUsuario'";
    //return $usuario.$nuevaClave." -- ".$sqlUp;
    $resUps = $base->query($sqlUp);
    if($resUps){
            $base->commit();
            echo "1";
    }else{
      $base->rollBack();  
      return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
        Error al intentar cambiar la Contrase&ntilde;a</div>";  
    }
}  
 catch (Exception $ex){
    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    	Error al consultar la base de datos</div>";
    } 
    
}


if($_POST)
{
	$rta="";
	try{
		$oper = $_POST['oper'];

		switch ($oper){
			case 'add': 	
                                $apellido = $_POST['txtApellido'];
                                $nombre = $_POST["txtNombre"];
                                $email = $_POST["txtEmail"];
                                $usuario = $_POST["txtUsuario"];
                                $pass = $_POST["txtPass"];
                                $rta=nuevoUsuario($apellido,$nombre,$email,$usuario,$pass);
                                break;
                        case 'ver': 	
                                $idusuario = $_POST['hfIdUsuario'];
                                $rta=verUsuario($idusuario);
                                break;            
                            
                        case 'recuperarClave':
                                $usuario = $_POST['txtUsuario'];
                                $correoElect = $_POST['txtCE'];
                                $rta=recuperarClave($usuario,$correoElect);
                                break;
                         
                        case 'cambiarClave':
                                $usuario = $_POST['txtUsuario'];
                                $idusuario = $_POST['hfIdUsuario'];
                                $nuevapass = $_POST['txtPass'];
                                $rta=cambiarClave($idusuario,$usuario,$nuevapass);
                                break;    
		}

	}
	catch (Exception $e){
		echo "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>" ;
	}

	echo $rta;

}