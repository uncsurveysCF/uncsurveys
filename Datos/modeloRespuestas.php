<?php

function respuestasPorEncuesta($idEncuesta,$idPeriodo){
    try{

        $salida = "";
        $base = new PDOConfig();
        $where = "";
        if($idPeriodo!=0)
        {
            $where .= " AND R.idPeriodo = $idPeriodo";
        }
        
        $sql = "SELECT R.idRespuesta, R.FechaHoraInicio,R.FechaHoraFin,R.IP,R.idEstado, 
                E.Descripcion AS estado,R.TipoRecolector,R.Codigo,R.Identificacion FROM respuestas R 
                INNER JOIN estadosrespuestas E ON R.idEstado = E.idEstado
                WHERE R.idEncuesta = $idEncuesta AND R.idEstado = 2 $where ORDER BY R.FechaHoraInicio";
        //echo $sql;exit();
        $resPreg = $base->query($sql);
        if($resPreg)
        {
            $respuestas = $resPreg->fetchAll(PDO::FETCH_ASSOC);
            return $respuestas;
        }else{
            return false;
        }
        
    }catch (Exception $e)
    {
        return false;
    }
}

function verUnaRespuesta($idEncuesta,$idRespuesta){
    try{

        $salida = "";
        $base = new PDOConfig();

        $sql = "SELECT R.idRespuesta, R.FechaHoraInicio,R.FechaHoraFin,R.IP,R.idEstado, 
                E.Descripcion AS estado, R.TipoRecolector,R.Codigo,R.Identificacion FROM respuestas R 
                INNER JOIN estadosrespuestas E ON R.idEstado = E.idEstado
                WHERE R.idEncuesta = $idEncuesta AND R.idRespuesta= $idRespuesta";
        //echo $sql;
        $resPreg = $base->query($sql);
        if($resPreg)
        {
            $respuesta = $resPreg->fetch(PDO::FETCH_ASSOC);
            return $respuesta;
        }else{
            return false;
        }
        
    }catch (Exception $e)
    {
        return false;
    }
}

function verRespuestaPregunta($idRespuesta,$idPregunta){
    try{

        $salida = "";
        $base = new PDOConfig();

        $sql = "SELECT R.idRP,R.idRespuesta,R.idPregunta,R.idOpcion,R.idColumna,R.RespuestaTexto,
                R.FechaHoraCarga,C.Texto AS columna,C.Ponderacion,O.Texto AS opcion1, O.Orden,O.Texto2 AS opcion2
                FROM respuestaspreguntas R 
                LEFT JOIN opcionespreguntas O ON R.idOpcion = O.idOpcion
                LEFT JOIN columnaspreguntas C ON R.idColumna = C.idColumna
                WHERE R.idPregunta = $idPregunta AND R.idRespuesta= $idRespuesta";
        //return $sql;
        $resPreg = $base->query($sql);
        if($resPreg)
        {
            $respuestas = array();
            if($resPreg->rowCount()>0)
                $respuestas = $resPreg->fetchAll(PDO::FETCH_ASSOC);
            /*else {
                $respuestas = array();
            }*/
            return $respuestas;
        }else{
            return "0";
        }
        
    }catch (Exception $e)
    {
        return "0";
    }
}
/*
$d = verRespuestaPregunta(37,64);
print_r($d);*/