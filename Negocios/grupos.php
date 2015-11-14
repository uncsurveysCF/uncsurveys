<?php

header('Content-type: text/html; charset=utf-8');
require_once('../libs/PDOConfig.php');
require_once("../libs/class.phpmailer.php");
require_once('utilidades.php');
require_once("../libs/Login.php");
$oLogin = new Login();
if(!$oLogin->activa()){
exit();
}

function combo($default, $selected, $usuario){
try{
$base = new PDOConfig();

$sql = "SELECT DISTINCT G.idGrupo, G.Nombre
				FROM grupos G
				LEFT JOIN usuariosgrupos UG ON G.idGrupo = UG.idGrupo
				WHERE G.Activo=1 AND (G.idAdministrador = $usuario OR (UG.idUsuario = $usuario AND UG.Activo=1))
				ORDER BY G.Nombre ";
//echo $sql;
$res = $base->query($sql);
$Listcombo = "<option value=''>$default</option>";

foreach ($res as $row)
{
if($row["idGrupo"] == $selected){
$Listcombo .= "<option value='".$row["idGrupo"]."' selected='selected'>".$row["Nombre"]."</option>";
}else{
$Listcombo .= "<option value='".$row["idGrupo"]."' >".$row["Nombre"]."</option>";
}
}
echo $Listcombo;
} catch (Exception $e){
return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>";
}
}


function nuevoGrupo($nombre, $descripcion, $administrador){
try{
$base = new PDOConfig();
$nombre = $base->filtrar($nombre);
$descripcion = $base->filtrar($descripcion);
$fecha = date('Y-m-d');


$sql = " INSERT INTO grupos(Nombre,FechaCreacion,idAdministrador,Descripcion,Activo) VALUES
		      ('$nombre','$fecha',$administrador,'$descripcion',1)";
//return $sql;
if($res = $base->query($sql)){
$id = $base->lastInsertId();
return $id;
}else{
return "<div class='form-group has-error col-md-10'>
					<input type='text' class='form-control' id='error2' value='Ha ocurrido un error al intentar cargar los datos de la encuesta'>
					</div>";
}

} catch (Exception $e){
return "<div class='form-group has-error col-md-10'>
				<input type='text' class='form-control' id='error2' value='Error al conectar a la Base de Datos'>
				</div>";
}
}


function listadoAdminstrador($usu)
{
try{
$base = new PDOConfig();

$sqlCol = "SELECT G.idGrupo,G.Nombre,G.FechaCreacion, (SELECT COUNT(*) FROM usuariosgrupos WHERE idGrupo = G.idGrupo) AS integrantes
		           FROM grupos G WHERE G.Activo = 1 AND G.idAdministrador = $usu";
//echo $sqlCol;
if($resCol = $base->query($sqlCol)){

$salOp .= "<div class='row'>
					<div class='col-md-12'>
					<table id='tblGruposAdm' class='table datatable table-bordered table-striped table-condensed'>
					<thead>
					<tr>
					<th>Grupo</th>
					<th>Creado</th>
					<th>Integrantes</th>
					<th>&nbsp;</th>
					</tr></thead><tbody>";

foreach ($resCol as $col)
{
$salOp .="<tr><td>".$col["Nombre"]."</td>
						<td>".formatFecha($col["FechaCreacion"])."</td>
						<td>".$col["integrantes"]."</td>
						<td class='text-center'>
							<a class='btn btn-default btn-sm' href='#'><i class='glyphicon glyphicon-edit'></i></a>
							<a class='btn btn-default btn-sm' href='usu_invitarAGrupo.php?id=".$col["idGrupo"]."'><i class='fa fa-user-plus'></i>	</a>
						</td>
						</tr>";
}
$salOp .= "</tbody></table></div></div>";
return $salOp;
}else{
return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al consultar los datos</div>";
}

} catch (Exception $e){
return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al Consultar la Base de Datos</div>";
}

}


function listadoMiembro($usuario){
try{
$base = new PDOConfig();

$sqlCol = "SELECT G.idGrupo,G.Nombre,G.FechaCreacion, (SELECT COUNT(*) FROM usuariosgrupos WHERE idGrupo = G.idGrupo) AS integrantes,
					(SELECT Activo FROM usuariosgrupos WHERE idGrupo = G.idGrupo) AS Activo
					FROM grupos G  
					WHERE G.Activo = 1 AND G.idGrupo IN (SELECT idGrupo FROM usuariosgrupos WHERE idUsuario = $usuario)";
//echo $sqlCol;
if($resCol = $base->query($sqlCol)){

$salOp .= "<div class='row'>
					<div class='col-md-12'>
					<table id='tblGruposMiembro' class='table datatable table-bordered table-striped table-condensed'>
					<thead>
					<tr>
					<th>Grupo</th>
					<th>Creado</th>
					<th>Integrantes</th>
					<th>Estado</th>
					<th>&nbsp;</th>
					</tr></thead><tbody>";

foreach ($resCol as $col)
{
    $salOp .="<tr><td>".$col["Nombre"]."</td>
    <td>".formatFecha($col["FechaCreacion"])."</td>
    <td>".$col["integrantes"]."</td>";
    
    if($col["Activo"] == "1"){
        $salOp .="<td>Activo</td>
        <td class='text-center'>
                <a class='btn btn-default btn-sm' href='#' onclick=\"dejarGrupo('".$col["idGrupo"]."','".$col["Nombre"]."','".$usuario."')\"><i class='glyphicon glyphicon-remove-sign'></i></a>
        </td>";
    }else{
        $salOp .="<td>Pendiente</td>
        <td class='text-center'>
            <a class='btn btn-default btn-sm' href='#' title='Incorprar a Grupo' onclick=\"activarEnGrupo('".$col["idGrupo"]."','".$col["Nombre"]."','".$usuario."')\"><i class='glyphicon glyphicon-ok-sign'></i></a>
        </td>";
    }
    $salOp .="</tr>";
}
$salOp .= "</tbody></table></div></div>";
return $salOp;
}else{
    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al consultar los datos</div>";
}

} catch (Exception $e){
    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al Consultar la Base de Datos</div>";
}


}

function verGrupo($id){

try{
$base = new PDOConfig();
$salida = "";
$id = $base->filtrar($id);

$sql = " SELECT idGrupo,Nombre,FechaCreacion,idAdministrador,Descripcion
				FROM grupos WHERE idGrupo = $id";
//echo $sql;
if($res = $base->query($sql)){
$row = $res->fetch(PDO::FETCH_ASSOC);

$fechaCarga = date_create ($row ["FechaCreacion"]);
$row ["FechaCreacion"] = date_format($fechaCarga, 'd/m/Y');

$salida = json_encode($row);
}else{
return "0";
}
return $salida;
} catch (Exception $e){
return "0";
}

}


function listarIntegrantesGrupo($idGrupo, $soloVer)
{
try{
$base = new PDOConfig();

$sqlCol = "SELECT U.Apellido,U.Nombre,U.Email,U.Usuario, GU.Activo FROM usuariosgrupos GU INNER JOIN usuarios U ON GU.idusuario = U.idUsuario 
					WHERE GU.idGrupo = $idGrupo";

//echo $sqlCol;
if($resCol = $base->query($sqlCol)){

if($resCol->rowCount()>0)
{

$salOp .= "<div class='row'>
					<div class='col-md-12'>
					<table id='tblIntegrantes' class='table datatable table-bordered table-striped table-condensed'>
					<thead>
					<tr>
					<th>Nombre</th>
					<th>Email</th>
					<th>Usuario</th>
					<th>Estado</th>
					<th>&nbsp;</th>
					</tr></thead><tbody>";

foreach ($resCol as $col)
{
$salOp .="<tr><td>".$col["Apellido"].", ".$col["Nombre"]."</td>
						<td>".$col["Email"]."</td>
						<td>".$col["Usuario"]."</td>";
if($col["Activo"] == "1")
{
$salOp .="<td>Activo</td>";
}else{
$salOp .="<td>Pendiente</td>";
}
if($soloVer != "1")
{
$salOp .="<td class='text-center'>
            <a class='btn btn-default btn-sm' href='#'><i class='glyphicon glyphicon-remove'></i></a>
	</td>";
}
$salOp .="</tr>";
}
$salOp .= "</tbody></table></div></div>";
return $salOp;
}
else{
return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					No hay usuarios pertenecientes al grupo</div>";
}

}else{
return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al consultar los datos</div>";
}

} catch (Exception $e){
return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al Consultar la Base de Datos</div>";
}

}

function agregarIntegranteGrupo($idGrupo, $email, $nombreGrupo, $idusu){
try{
    $base = new PDOConfig();
    $email = $base->filtrar($email);
    $idGrupo = $base->filtrar($idGrupo);
    $nombreGrupo = $base->filtrar($nombreGrupo);
    $sql = "SELECT idUsuario FROM usuarios WHERE Email = '$email'";

    if($resel = $base->query($sql)){
    if($resel->rowCount()<= 0){
    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                                            No se encontr&oacute; ning&uacute;n usuario con el email ingresado</div>";
    }

    $row = $resel->fetch(PDO::FETCH_ASSOC );
    $idUsuario = $row["idUsuario"];

    $sql = "SELECT idUsuario FROM usuariosgrupos WHERE idGrupo =$idGrupo AND idUsuario = $idUsuario";

    if($resel = $base->query($sql))
    {
        if($resel->rowCount() > 0){
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                                            El usuario ya es un integrante del grupo</div>";
        }
        $base->beginTransaction();
        $sql = "INSERT INTO usuariosgrupos(idGrupo,idUsuario,FechaCarga,Activo) VALUES ($idGrupo,$idUsuario,'".date("Y-m-d")."',0)";
        //return $sql;
        if($res = $base->query($sql)){
            $mensaje = "Usted ha sido invitado a formar parte del grupo de trabajo: <b>".$nombreGrupo."</b>. <br />";
            $mensajeNot = "Usted ha sido invitado a formar parte del grupo de trabajo: <b>$nombreGrupo</b>.";
            $sql = "INSERT INTO notificaciones(FechaCarga,idUsuario,Titulo,Mensaje) VALUES ('".date("Y-m-d")."',$idusu,'UNCSurveys: Integrar Grupo','$mensajeNot')";
            //return $sql;
            $res = $base->query($sql);
            if($res)
            {
                $idNot = $base->lastInsertId();
                $sqlD = "INSERT INTO destinatariosnotificacion(idNotificacion,idUsuario,Leido) VALUES ($idNot,$idUsuario,0)";
                //return $sql;
                $resD = $base->query($sqlD);
                if($resD)
                {
                    $cuerpo = envioInvitacionGrupo($mensaje);
                    $salida = enviarMail($email, "UNCSurveys: Integrar Grupo", $cuerpo);
                    $base->commit();
                    return "1";
                }else{
                    $base->rollBack();
                    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                                                    Error al cargar la notificaci&acute;n</div>";
                }
            }else{
                $base->rollBack();
                return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                                                    Error al cargar la notificaci&acute;n</div>";
            }

    }
    else{
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                                            Error al consultar datos del grupo</div>";
    }

    }else{
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                                            Error al consultar datos del usuario</div>";
    }

    }else{
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                                            Error al consultar datos del usuario</div>";
    }

} 
catch (Exception $e){
    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                                    Error al consultar la base de datos</div>";
    }
}

function activarIntegranteGrupo($idGrupo, $idusuario, $nomGrupo){
    
  try{
    $base = new PDOConfig();
    $idGrupo = $base->filtrar($idGrupo);
    $idusuario = $base->filtrar($idusuario);
    $nomUsuario = "";
    $base->beginTransaction();
    $sql = "UPDATE usuariosgrupos SET Activo = 1 WHERE idUsuario = $idusuario AND idGrupo=$idGrupo";
    //return $sql;
    if($res = $base->query($sql)){
        
        $sql = "SELECT Apellido, Nombre FROM usuarios WHERE idUsuario = $idusuario";

        if($resel = $base->query($sql)){
            $row = $resel->fetch(PDO::FETCH_ASSOC );
            $nomUsuario = $row["Apellido"]." ".$row["Nombre"];
        }
        
        $mensaje = "Se ha integrado al grupo $nomGrupo un nuevo usuario: <b>$nomUsuario</b>. <br />";
        $sql = "INSERT INTO notificaciones(FechaCarga,idUsuario,Titulo,Mensaje) VALUES ('".date("Y-m-d")."',$idusuario,'UNCSurveys: Nuevo Integrante Grupo','$mensaje')";
        //return $sql;
        $res = $base->query($sql);
        if($res)
        {
            $idNot = $base->lastInsertId();
            $sqlD = "INSERT INTO destinatariosnotificacion(idNotificacion,idUsuario,Leido) "
                    . "SELECT $idNot,idUsuario,0 FROM usuariosgrupos WHERE idGrupo = $idGrupo AND idUsuario <> $idusuario"
                    . " UNION SELECT $idNot,idAdministrador,0 FROM grupos WHERE idGrupo = $idGrupo";
            //return $sqlD;
            $resD = $base->query($sqlD);
            if($resD)
            {               
                $base->commit();
                return "1";
            }else{
                $base->rollBack();
                return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                        Error al cargar la notificaci&oacute;n</div>";
            }
        }else{
            $base->rollBack();
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                    Error al cargar la notificaci&oacute;n</div>";
        }
    }
    else{
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>    
                    Error al activar el usuario</div>";
    }

 } 
catch (Exception $e){
    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                                    Error al consultar la base de datos</div>";
    }   
}

function bajarIntegranteGrupo($idGrupo, $idusuario, $nomGrupo){
    
  try{
    $base = new PDOConfig();
    $idGrupo = $base->filtrar($idGrupo);
    $idusuario = $base->filtrar($idusuario);
    $nomUsuario = "";
    $base->beginTransaction();
    $sql = "DELETE FROM usuariosgrupos WHERE idUsuario = $idusuario AND idGrupo=$idGrupo";
    //return $sql;
    if($res = $base->query($sql)){
        
        $sql = "SELECT Apellido, Nombre FROM usuarios WHERE idUsuario = $idusuario";

        if($resel = $base->query($sql)){
            $row = $resel->fetch(PDO::FETCH_ASSOC );
            $nomUsuario = $row["Apellido"]." ".$row["Nombre"];
        }
        
        $mensaje = "Se ha dado de baja al grupo $nomGrupo al usuario: <b>$nomUsuario</b>. <br />";
        $sql = "INSERT INTO notificaciones(FechaCarga,idUsuario,Titulo,Mensaje) VALUES ('".date("Y-m-d")."',$idusuario,'UNCSurveys: Nuevo Integrante Grupo','$mensaje')";
        //return $sql;
        $res = $base->query($sql);
        if($res)
        {
            $idNot = $base->lastInsertId();
            $sqlD = "INSERT INTO destinatariosnotificacion(idNotificacion,idUsuario,Leido) "
                    . "SELECT $idNot,idUsuario,0 FROM usuariosgrupos WHERE idGrupo = $idGrupo AND idUsuario <> $idusuario"
                    . " UNION SELECT $idNot,idAdministrador,0 FROM grupos WHERE idGrupo = $idGrupo";
            //return $sqlD;
            $resD = $base->query($sqlD);
            if($resD)
            {               
                $base->commit();
                return "1";
            }else{
                $base->rollBack();
                return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                        Error al cargar la notificaci&oacute;n</div>";
            }
        }else{
            $base->rollBack();
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                    Error al cargar la notificaci&oacute;n</div>";
        }
    }
    else{
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>    
                    Error al activar el usuario</div>";
    }

 } 
catch (Exception $e){
    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                                    Error al consultar la base de datos</div>";
    }   
}

if($_POST)
{
    $rta = "";
    try{
        $oper = $_POST['oper'];
        $usuario = $oLogin->getIdUsuario();
        switch ($oper){
        case 'combo':
            $default = $_POST['vdefaul'];
            $selected = $_POST["selected"];
            $rta = combo($default, $selected, $usuario);
            break;

        case 'nuevoGrupo':
            $nombre = $_POST['txtNombre'];
            $descripcion = $_POST["txtDescripcion"];
            $rta = nuevoGrupo($nombre, $descripcion, $usuario);
            break;
        
        case 'listadoAd':
            $rta = listadoAdminstrador($usuario);
            break;

        case 'ver':
            $idGrupo = $_POST['idGrupo'];
            $rta = verGrupo($idGrupo);
            break;

        case 'listarIntegrantes':
            $idGrupo = $_POST['idGrupo'];
            $soloVer = $_POST['soloVer'];
            $rta = listarIntegrantesGrupo($idGrupo, $soloVer);
            break;

        case 'invitarUsuario':
            $idusuario = $oLogin->getIdUsuario();
            $idGrupo = $_POST['hfIdGrupo'];
            $nomGrupo = $_POST['txtNomGrupo'];
            $email = $_POST['txtemail'];
            $rta = agregarIntegranteGrupo($idGrupo, $email, $nomGrupo, $idusuario);
            break;

        case 'listadoMiembro':
            $rta = listadoMiembro($usuario);
            break;
        
        case 'acUsuGrupo':
            $idusuario = $oLogin->getIdUsuario();
            $idGrupo = $_POST['idGrupo'];
            $nomGrupo = $_POST['txtNomGrupo'];
            $rta = activarIntegranteGrupo($idGrupo, $idusuario,$nomGrupo);
            break;
        
        case 'delUsuGrupo':
            $idusuario = $oLogin->getIdUsuario();
            $idGrupo = $_POST['idGrupo'];
            $nomGrupo = $_POST['nomGrupo'];
            $rta = bajarIntegranteGrupo($idGrupo, $idusuario,$nomGrupo);
            break;
            
    }

} catch (Exception $e){
echo "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>";
}

echo $rta;

}
