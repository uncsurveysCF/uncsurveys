<?php
header('Content-type: text/html; charset=utf-8');
require_once('../libs/PDOConfig.php');
require_once 'utilidades.php';
require_once('../libs/PHPExcel.php');

require_once("../libs/Login.php");
$oLogin=new Login();
if(!$oLogin->activa()){
    header('location:../index.php');
}

if($_GET){

try {

    $base = new PDOConfig ();
    $idUsuario = $oLogin->getIdUsuario();
    $idEncuesta = decrypt($_GET["id"]);

    $tabla = "";
    $where = "";
		
    $objPHPExcel = new PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setTitle($nombre)->setDescription("none");
    $objPHPExcel->setActiveSheetIndex(0);	
    $type = PHPExcel_Cell_DataType::TYPE_STRING2;

    $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);
	
	
    $sqlPreg = "SELECT * FROM (SELECT P.Texto AS Pregunta,P.NroPregunta,P.idPregunta,P.idTipoPregunta, 0 AS idOpcion
		FROM preguntasencuestas P
		WHERE P.idEncuesta = $idEncuesta AND P.idTipoPregunta NOT IN (3,4,5,11) "
            . " UNION "
            . "SELECT CONCAT(P.Texto,' - ',O.Texto) AS Pregunta,P.NroPregunta,P.idPregunta,P.idTipoPregunta,O.idOpcion
		FROM preguntasencuestas P
                INNER JOIN opcionespreguntas O ON P.idPregunta = O.idPregunta
		WHERE P.idEncuesta = $idEncuesta AND P.idTipoPregunta IN (3,4,5)"
            . " UNION "
            . "SELECT CONCAT(P.Texto,' - ',O.Texto,'/',O.Texto2) AS Pregunta,P.NroPregunta,P.idPregunta,P.idTipoPregunta,O.idOpcion
		FROM preguntasencuestas P
                INNER JOIN opcionespreguntas O ON P.idPregunta = O.idPregunta
		WHERE P.idEncuesta = $idEncuesta AND P.idTipoPregunta = 11 "
            . ") AUX ORDER BY NroPregunta";		
	//echo $sql;
    $resPreg = $base->query ( $sqlPreg );
    if($resPreg){		
        $fila = 1;
        $col = 0;
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila,"Fecha");
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila,"Recolector");
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila,"IP");
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila,"Código");
        $col++;
        $encabezado = $resPreg->fetchAll(PDO::FETCH_ASSOC);
        foreach ($encabezado as $dato)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila,$dato["NroPregunta"].". ".$dato["Pregunta"]);
            $col++;
        }
        
        $sqlRs = "SELECT R.idRespuesta, R.idEncuesta,R.FechaHoraInicio,R.FechaHoraFin,R.IP,R.idEstado,R.TipoRecolector,"
               . " R.Codigo,R.idPeriodo FROM respuestas R WHERE R.idEncuesta = $idEncuesta AND R.idEstado = 2 ";
        //echo $sqlRs;
        $resRs = $base->query ($sqlRs);
        
        if(!$resRs){
            exit();
        }else{
          $respuestas = $resRs->fetchAll(PDO::FETCH_ASSOC);
        }
        
        //print_r($respuestas);       
        foreach($respuestas as $res)
        {    
            $fila++;
            
            $col = 0;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$fila,$res["FechaHoraInicio"]);
            $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$fila,$res["TipoRecolector"]);
            $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$fila,$res["IP"]);
            $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$fila,$res["Codigo"]);
            $col++;
            //print_r($encabezado);
            foreach ($encabezado as $dato)
            {
                //echo $dato["idTipoPregunta"];
                switch($dato["idTipoPregunta"])
                {
                    case "1":
                    case "12":
                        $sql = "SELECT O.Texto AS respuesta"
                                . " FROM respuestaspreguntas R "
                                . " INNER JOIN opcionespreguntas O ON R.idOpcion=O.idOpcion "
                                . " WHERE R.idRespuesta = ".$res["idRespuesta"]." AND R.idPregunta = ".$dato["idPregunta"]; break;
                    
                    case "2":
                        $sql = "SELECT GROUP_CONCAT(O.Texto SEPARATOR ',') AS respuesta"
                                . " FROM respuestaspreguntas R "
                                . " INNER JOIN opcionespreguntas O ON R.idOpcion=O.idOpcion "
                                . " WHERE R.idRespuesta = ".$res["idRespuesta"]." AND R.idPregunta = ".$dato["idPregunta"];break;    
                
                    case "3":
                    case "4":
                    case "5":
                        $sql = "SELECT C.Texto AS respuesta"
                                . " FROM respuestaspreguntas R "
                                . " INNER JOIN columnaspreguntas C ON R.idColumna = C.idColumna "
                                . " WHERE R.idRespuesta = ".$res["idRespuesta"]." AND R.idPregunta = ".
                                    $dato["idPregunta"]." AND R.idOpcion = ".$dato["idOpcion"];  break;          
                            
                    case "11":
                        $sql = "SELECT R.RespuestaTexto AS respuesta"
                                . " FROM respuestaspreguntas R "
                                . " WHERE R.idRespuesta = ".$res["idRespuesta"]." AND R.idPregunta = ".
                                    $dato["idPregunta"]." AND R.idOpcion = ".$dato["idOpcion"];break;
                    default:
                        $sql = "SELECT R.RespuestaTexto AS respuesta"
                                . " FROM respuestaspreguntas R "
                                . " WHERE R.idRespuesta = ".$res["idRespuesta"]." AND R.idPregunta = ".$dato["idPregunta"]; break;   
                }
                //echo $sql;
                $ResultadoFila = $base->query ($sql);
                if($ResultadoFila)
                {
                    $respuestas = $ResultadoFila->fetch(PDO::FETCH_ASSOC);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$fila,$respuestas["respuesta"]);
                }
                $col++;
                               
            }
        
        }	
	
    }
}catch (Exception $e){	
    exit();
}

$objPHPExcel->setActiveSheetIndex(0);

$nombreArchi = 'exportacionDatos.xlsx';
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nombreArchi.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

}else{
exit();
}