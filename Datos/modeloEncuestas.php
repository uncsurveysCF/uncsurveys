<?php

require_once('../Negocios/utilidades.php');
require_once('../Negocios/parametros.php');
/**
 * Carga una nueva encuesta 
 *
 * @param string $titulo
 * @param string $idTema
 * @param string $descripcion
 * @param string $usuario
 * 
 */
function nuevaEncuesta($titulo, $idTema, $tipo, $descripcion, $usuario) {
    try {
        $base = new PDOConfig();
        $titulo = $base->filtrar($titulo);
        $idTema = $base->filtrar($idTema);
        $tipo = $base->filtrar($tipo);
        $descripcion = $base->filtrar($descripcion);
        $id = "";
        $fecha = date('Y-m-d');

        $sql = " INSERT INTO encuestas(idTema,idTipoEncuesta,idEstado,idUsuario,Titulo,Descripcion,FechaCarga) VALUES
				($idTema,$tipo,1,$usuario,'$titulo','$descripcion','$fecha')";
        //echo $sql;
        if ($res = $base->query($sql)) {
            $id = $base->lastInsertId();
            $sql = " INSERT INTO paginasencuestas(idEncuesta,Titulo,NroPagina) VALUES
					($id,'',1)";
            //return $sql;
            if ($res = $base->query($sql)) {
                return $id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function actEncuesta($titulo, $tema, $tipo, $descripcion, $usuario, $fechalimite, $horaLimite, $tieneClave,
        $mostrarRe, $claveAcc, $cantAcc, $proposito, $poblacion, $txtCarMu, $idEncuesta, $bloquearIP,$tags) {
    try {
        $base = new PDOConfig();
        $titulo = $base->filtrar($titulo);
        $idTema = $base->filtrar($tema);
        $tipo = $base->filtrar($tipo);
        $descripcion = $base->filtrar($descripcion);
        $proposito = $base->filtrar($proposito);
        $poblacion = $base->filtrar($poblacion);
        $txtCarMu = $base->filtrar($txtCarMu);
        $fechalimite = $base->filtrar($fechalimite);
        $horaLimite = $base->filtrar($horaLimite);
        $tieneClave = $base->filtrar($tieneClave);
        $mostrarRe = $base->filtrar($mostrarRe);
        $claveAcc = $base->filtrar($claveAcc);
        $cantAcc = $base->filtrar($cantAcc);
        $tags = $base->filtrar($tags);

        if ($fechalimite != "") {
            $fechalimite = "'" . formatFecha($fechalimite) . "'";
        } else {
            $fechalimite = 'NULL';
        }

        if ($horaLimite != "")
            $horaLimite = "'$horaLimite'";
        else
            $horaLimite = 'NULL';
        if ($cantAcc == "")
            $cantAcc = 'NULL';

        $ArrTags = explode(",", $tags);
        
        $fecha = date('Y-m-d');

        $base->beginTransaction();
            
        $sqlIn = "DELETE FROM tagsencuesta WHERE idEncuesta = $idEncuesta";
        if (!$base->query($sqlIn)) {
            $base->rollBack();
            return false;
        }
        
        $sql = " UPDATE encuestas SET idTema=$idTema,idTipoEncuesta=$tipo,
		                Titulo = '$titulo',Descripcion='$descripcion',FechaLimite=$fechalimite,HoraLimite=$horaLimite,
		                CantMaxAccesos=$cantAcc,ClaveAcceso='$claveAcc',TieneClave=$tieneClave,MostrarResultados=$mostrarRe,
				Proposito='$proposito',Poblacion='$poblacion',CaractecisticasMuestra='$txtCarMu',BloquearIP=$bloquearIP
				WHERE idEncuesta = $idEncuesta";
        //return $sql;
        if ($res = $base->query($sql)) {
            
            foreach ($ArrTags as $a)
            {
                $idT = 0;
                $sqlIn = "SELECT idtag,Tag FROM tagsbusqueda WHERE Tag='$a'"; 
                if ($resT = $base->query($sqlIn)) {
                    if($resT->rowCount() > 0){
                        $da = $resT->fetch(PDO::FETCH_ASSOC);
                        $idT = $da["idtag"];
                    }else{
                        $sqlInT = "INSERT INTO tagsbusqueda(Tag) VALUES ('$a')"; 
                        if ($base->query($sqlInT)) {
                            $idT = $base->lastInsertId();
                        }else{
                            $base->rollBack();
                            return false;
                        } 
                    }
                }else{
                    $base->rollBack();
                    return false;
                }
                
                if($idT > 0){
                    $sqlInT =   "INSERT INTO tagsencuesta(idEncuesta,idTag) VALUES ($idEncuesta,$idT)";
                    if (!$base->query($sqlInT)) {
                        $base->rollBack();
                        return false;
                    } 
                }
            }
            $base->commit();            
            return true;
        } else {
            $base->rollBack();
            return false;
        }
    } catch (Exception $e) {
        $base->rollBack();
        return false;
    }
}

/**
 * Lista Todas las Encuestas
 *
 */
function listadoEncuestas() {
    try {
        $base = new PDOConfig();
        $resultado = array();
        $sql = "SELECT E.idEncuesta,E.idTema,E.idTipoEncuesta,E.idEstado,E.idUsuario,E.Titulo,E.Descripcion,
				     E.CodigoAcceso,E.FechaCarga,E.FechaRecopilacion,E.FechaLimite,E.HoraLimite,E.CantMaxAccesos, 
				     E.ClaveAcceso,E.TieneClave,E.MostrarResultados,T.Descripcion AS Tema, I.Descripcion AS TipoEncuesta
				FROM encuestas E
				INNER JOIN temas T ON E.idTema = T.idTema
				INNER JOIN estados S ON E.idEstado = S.idEstado
				INNER JOIN tiposencuestas I ON E.idTema = T.idTema
				ORDER BY E.FechaCarga ";

        $res = $base->query($sql);

        if ($res) {
            $resultado = $res->fetchAll(PDO::FETCH_ASSOC);
        }

        return $resultado;
    } catch (Exception $e) {
        return false;
    }
}

function chekearCondicionesReco($idEncuesta) {
    try {
        $base = new PDOConfig();
        $sql = "SELECT E.idEstado,E.idUsuario,E.FechaLimite,E.HoraLimite,E.CantMaxAccesos,E.BloquearIP
                FROM encuestas E WHERE E.idEncuesta = $idEncuesta";
        //return $sql;
        $res = $base->query($sql);
        if ($res) {
            $fila = $res->fetch(PDO::FETCH_ASSOC);
            return $fila;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function verificarPeriodoActivo($idEncuesta) {
    $base = new PDOConfig();
    $sqpPe = "SELECT idPeriodo FROM periodosrecopilacion P WHERE idEncuesta = $idEncuesta AND FechaInicio <= '" . date('Y-m-d') . "'"
            . " AND (FechaFin >= '" . date('Y-m-d') . "' OR FechaFin is null)";

    if ($resPe = $base->query($sqpPe)) {
        if ($resPe->rowCount() <= 0) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function totalRespuestasCompletas($idEncuesta) {
    try {
        $base = new PDOConfig();
        $sql = "SELECT *
                FROM respuestas WHERE 
                idEncuesta = $idEncuesta AND idEstado = 2";

        $res = $base->query($sql);
        if ($res) {
            return $res->rowCount();
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function exiteRespuestaCompletaIP($idEncuesta, $IPpublica) {
    try {
        $base = new PDOConfig();
        $sql = "SELECT *
                FROM respuestas WHERE 
                idEncuesta = $idEncuesta AND idEstado = 2 AND IP='$IPpublica'";

        $res = $base->query($sql);
        if ($res) {
            if ($res->rowCount() > 0)
                return true;
            else
                return false;
        }else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}



function cargarPeriodo($idEncuesta, $fechaIni, $fechaFin, $tituloPer, $base) {
    if ($fechaFin == "") {
        $fechaFin = 'NULL';
    } else {
        $fechaFin = "'" . formatFecha($fechaFin) . "'";
    }
    $sql = " INSERT INTO periodosrecopilacion(idEncuesta,FechaInicio,FechaFin,Titulo) VALUES ($idEncuesta,'"
            . formatFecha($fechaIni) . "'," . $fechaFin . ",'".$tituloPer."')";
    //return $sql;
    if ($res = $base->query($sql)) {
        return $base->lastInsertId();
    } else {
        return false;
    }
}

function cargarReclector($idEncuesta, $tipo, $codigo, $asunto, $mensaje, $idPeriodo, $base) {
    if ($asunto == "") {
        $asunto = 'NULL';
    } else {
        $asunto = "'" . $asunto . "'";
    }
    if ($mensaje == "") {
        $mensaje = 'NULL';
    } else {
        $mensaje = "'" . $mensaje . "'";
    }

    $sql = " INSERT INTO recolectores(idEncuesta,Tipo,FechaCarga,Codigo,Asunto,Mensaje,idPeriodo) VALUES "
            . "($idEncuesta,'" . $tipo . "','" . date("Y-m-d") . "','" . $codigo . "',$asunto,$mensaje,$idPeriodo)";
    //echo $sql; exit();
    if ($res = $base->query($sql)) {
        return true;
    } else {
        return false;
    }
}

function cargarDestinoRecolector($idEncuesta, $idPeriodo, $destino, $codigoRec, $asunto, $mensaje, $titulo, $base) {
    $codigoPers = encrypt($idEncuesta . $idPeriodo . $destino);
    $sql = " INSERT INTO recolectoresemails(idEncuesta,idPeriodo,Email,CodigoAccesso) VALUES "
            . "($idEncuesta," . $idPeriodo . ",'" . $destino . "','" . $codigoPers . "')";
    //return $sql;
    if ($res = $base->query($sql)) {
        $codEnc = encrypt($idEncuesta);
        $cuerpo = envioVinculoRecoleccion($mensaje, $titulo, $codEnc, $codigoRec, $codigoPers);
        if (enviarMail($destino, $asunto, $cuerpo)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function cargarIdentificadores($idEncuesta, $idPeriodo, $ids, $base) {

    $sql = " INSERT INTO identificadoresparticipantes(idEncuesta,idPeriodo,Identificacion) VALUES "
            . "($idEncuesta," . $idPeriodo . ",'" . $ids . "')";
    //return $sql;
    if ($res = $base->query($sql)) {
        return true;
    } else {
        return false;
    }
}

function cerrarEncuesta($idEncuesta, $idPeriodo,$usuario) {
    try {
        $base = new PDOConfig();
        $base->beginTransaction();
        
        $sql = " UPDATE encuestas SET idEstado = 3, "
                . " FechaCierre='" . date('Y-m-d') . "', idUsuarioCierre=$usuario 
	           WHERE idEncuesta=$idEncuesta";
        //return $sql;
        if ($res = $base->query($sql)) {
            if($idPeriodo == "0")
            {
                $sqlS = "SELECT * FROM periodosrecopilacion WHERE Activo = 1 AND idEncuesta = $idEncuesta ";
                if ($resPer = $base->query($sqlS)) {
                    $datosP = $resPer->fetch(PDO::FETCH_ASSOC);
                    $idPeriodo = $datosP["idPeriodo"];
                }else{
                    $base->rollBack();
                    return false;
                }
            }
            
            $sqlIn = " UPDATE periodosrecopilacion SET Activo= 0, FechaFin='" . date('Y-m-d') . "' 
                        WHERE idEncuesta=$idEncuesta AND idPeriodo = $idPeriodo";
            //return $sqlIn;
            if (!$res = $base->query($sqlIn)) {
             $base->rollBack();
             return false;
            }
            $base->commit();
            return true;
        } else {
            $base->rollBack();
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function publicarEncuesta($idEncuesta, $fechaIni, $fechaFin, $recolectores, $codigoWeb, 
        $destinos, $asunto, $mensaje, $titulo, $identificadores,$tituloPer) {

    try {
        global $ESTADOSENC;
        $base = new PDOConfig();
        $idEncuesta = $base->filtrar($idEncuesta);
        $fechaIni = $base->filtrar($fechaIni);
        $fechaFin = $base->filtrar($fechaFin);
        $codigoWeb = $base->filtrar($codigoWeb);
        $destinos = $base->filtrar($destinos);
        $asunto = $base->filtrar($asunto);
        $mensaje = $base->filtrar($mensaje);
        $titulo = $base->filtrar($titulo);
        $tituloPer = $base->filtrar($tituloPer);
        $tieneIdentificadores = "0";
        $base->beginTransaction();
        $idPeriodo = 0;
        
        if ($idPeriodo = cargarPeriodo($idEncuesta, $fechaIni, $fechaFin,$tituloPer, $base)) {
           
            if (in_array("WEB", $recolectores, true)) {
                $codigo = encrypt($idEncuesta . "-WEB");
               
                if (!cargarReclector($idEncuesta, "WEB", $codigo, "", "", $idPeriodo, $base)) {
                    $base->rollBack();
                    return "3";
                }
            }

            if (in_array("EMAIL", $recolectores, true)) {
                $codigo = encrypt($idEncuesta . "-EMAIL");
                if (!cargarReclector($idEncuesta, "EMAIL", $codigo, $asunto, $mensaje, $idPeriodo, $base)) {
                    $base->rollBack();
                    return "4";
                }
                $arrDestinos = explode(",", $destinos);
                foreach ($arrDestinos as $d) {
                    if (!cargarDestinoRecolector($idEncuesta, $idPeriodo, $d, $codigo, $asunto, $mensaje, $titulo, $base)) {
                        $base->rollBack();
                        return "5";
                    }
                }
            }

            if ($identificadores != "") {
                $tieneIdentificadores = "1";
                $arrIdentifics = explode(",", $identificadores);
                foreach ($arrIdentifics as $ids) {
                    if (!cargarIdentificadores($idEncuesta, $idPeriodo, $ids, $base)) {
                        $base->rollBack();
                        return "6";
                    }
                }
            }

            if ($fechaFin == "") {
                $fechaFinE = 'NULL';
            } else {
                $fechaFinE = "'" . formatFecha($fechaFin) . "'";
            }
            
            $sql = " UPDATE encuestas SET idEstado = " . $ESTADOSENC["RECOPILACION"] . ", FechaRecopilacion='" . date('Y-m-d') . "', 
			FechaLimite=$fechaFinE,tieneIdentificadores = $tieneIdentificadores WHERE idEncuesta=$idEncuesta";
            //return $sql;
            if ($res = $base->query($sql)) {
                $base->commit();
                return "1";
            } else {
                $base->rollBack();
                return "6";
            }
        } else {
            $base->rollBack();
            return "2";
        }
    } catch (Exception $e) {
        return "2";
    }
}

function actualizarPeriodo($idEncuesta, $idPeriodo, $fechaIni, $fechaFin, $base){
    if ($fechaFin == "") {
        $fechaFin = 'NULL';
    } else {
        $fechaFin = "'" . formatFecha($fechaFin) . "'";
    }
    $sql = " UPDATE periodosrecopilacion SET FechaFin = " . $fechaFin . " WHERE idEncuesta = $idEncuesta AND idPeriodo = $idPeriodo";
    //return $sql;
    if ($res = $base->query($sql)) {
        return true;
    } else {
        return false;
    }
}

function existeRecolector($tipo,$idEncuesta,$idPeriodo){
    try {
        $base = new PDOConfig();
        $sql = "SELECT *
                FROM recolectores WHERE 
                idEncuesta = $idEncuesta AND idPeriodo=$idPeriodo AND Tipo = '$tipo'";

        $res = $base->query($sql);
        if ($res) {
            if ($res->rowCount() > 0)
                return true;
            else
                return false;
        }else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function actualizaRecoEnc($idEncuesta, $idPeriodo, $fechaIni, $fechaFin, $recolectores, $codigoWeb, $destinos, $asunto, $mensaje, $titulo, $identificadores) {

    try {
        global $ESTADOSENC;
        $base = new PDOConfig();
        $idEncuesta = $base->filtrar($idEncuesta);
        $idPeriodo = $base->filtrar($idPeriodo);
        $fechaIni = $base->filtrar($fechaIni);
        $fechaFin = $base->filtrar($fechaFin);
        $codigoWeb = $base->filtrar($codigoWeb);
        $destinos = $base->filtrar($destinos);
        $asunto = $base->filtrar($asunto);
        $mensaje = $base->filtrar($mensaje);
        $titulo = $base->filtrar($titulo);
        $tieneIdentificadores = "0";
        $base->beginTransaction();
       
        if (actualizarPeriodo($idEncuesta, $idPeriodo, $fechaIni, $fechaFin, $base)) 
        {            
            if (in_array("WEB", $recolectores, true)) {
                if(!existeRecolector("WEB",$idEncuesta,$idPeriodo))
                {
                    $codigo = encrypt($idEncuesta . "-WEB");
                    if (!cargarReclector($idEncuesta, "WEB", $codigo, "", "", $idPeriodo, $base)) {
                        $base->rollBack();
                        return "3";
                    }
                }
            }

            if (in_array("EMAIL", $recolectores, true)) {
                
                $codigo = encrypt($idEncuesta . "-EMAIL");
                if(!existeRecolector("EMAIL",$idEncuesta,$idPeriodo))
                {
                    if (!cargarReclector($idEncuesta, "EMAIL", $codigo, $asunto, $mensaje, $idPeriodo, $base)) {
                        $base->rollBack();
                        return "4";
                    }
                }
                
                $arrDestinos = explode(",", $destinos);
                foreach ($arrDestinos as $d) {
                    if (!cargarDestinoRecolector($idEncuesta, $idPeriodo, $d, $codigo, $asunto, $mensaje, $titulo, $base)) 
                    {
                        $base->rollBack();
                        return "5";
                    }
                }
            }

            if ($identificadores != "") {
                $tieneIdentificadores = "1";
                $arrIdentifics = explode(",", $identificadores);
                foreach ($arrIdentifics as $ids) {
                    if (!cargarIdentificadores($idEncuesta, $idPeriodo, $ids, $base)) {
                        $base->rollBack();
                        return "6";
                    }
                }
            }

            $sql = " UPDATE encuestas SET FechaRecopilacion='" . date('Y-m-d') . "', 
			tieneIdentificadores = $tieneIdentificadores WHERE idEncuesta=$idEncuesta";
            //return $sql;
            if ($res = $base->query($sql)) {
                $base->commit();
                return "1";
            } else {
                $base->rollBack();
                return "6";
            }
        } else {
            $base->rollBack();
            return "2";
        }
    } catch (Exception $e) {
        return "2";
    }
}
