<?php
header('Content-type: text/html; charset=utf-8');
include_once("../libs/statistics.class.php");
include_once("../Negocios/utilidades.php");
require_once('../libs/PDOConfig.php');

function quitarAcentos($text)
    {
        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        $text = strtolower($text);
        $patron = array (
            // Espacios, puntos y comas por guion
            '/[\., ]+/' => '-',
            // Vocales
            '/&agrave;/' => 'a',
            '/&egrave;/' => 'e',
            '/&igrave;/' => 'i',
            '/&ograve;/' => 'o',
            '/&ugrave;/' => 'u',
 
            '/&aacute;/' => 'a',
            '/&eacute;/' => 'e',
            '/&iacute;/' => 'i',
            '/&oacute;/' => 'o',
            '/&uacute;/' => 'u',
 
            '/&acirc;/' => 'a',
            '/&ecirc;/' => 'e',
            '/&icirc;/' => 'i',
            '/&ocirc;/' => 'o',
            '/&ucirc;/' => 'u',
 
            '/&atilde;/' => 'a',
            '/&etilde;/' => 'e',
            '/&itilde;/' => 'i',
            '/&otilde;/' => 'o',
            '/&utilde;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            // Otras letras y caracteres especiales
            '/&aring;/' => 'a',
            '/&ntilde;/' => 'n',
 
            // Agregar aqui mas caracteres si es necesario
 
        );
 
        $text = preg_replace(array_keys($patron),array_values($patron),$text);
        return $text;
    }
    
function tags($string, $encoding = 'UTF-8'){
	
	$string = trim(strip_tags(html_entity_decode($string)));
	if(empty($string)){ return false; }
	 
	$extras = array(
			'p'=>array('ante', 'bajo', 'con', 'contra', 'desde', 'durante', 'entre',
					'hacia', 'hasta', 'mediante', 'para', 'por', 'pro', 'segun',
					'sin', 'sobre', 'tras', 'via', 'muy'
			),
			'a'=>array('los', 'las', 'una', 'unos', 'unas', 'este', 'estos', 'ese',
					'esos', 'aquel', 'aquellos', 'esta', 'estas', 'esa', 'esas',
					'aquella', 'aquellas', 'usted', 'nosotros', 'vosotros',
					'ustedes', 'nos', 'les', 'nuestro', 'nuestra', 'vuestro',
					'vuestra', 'mis', 'tus', 'sus', 'nuestros', 'nuestras',
					'vuestros', 'vuestras'
			),
			'o'=>array('esto', 'que', 'mas'),
	);

	$string = strtolower($string);
	//$string = mb_strtolower((string)$string, $encoding);
	//$string = utf8_decode($string);
	//$string = strtr($string,utf8_decode(����������������������),'aaaaaeeeeiiiioooouuuun');
	if(preg_match_all('/\pL{3,}/s', $string, $m)){
		$m = array_diff($m[0], $extras['p'], $extras['a'], $extras['o']);
	}
	return $m;
}

function repeatedElements($array, $returnWithNonRepeatedItems = false)
{
	$repeated = array();

	foreach( (array)$array as $value )
	{
		$inArray = false;

		foreach( $repeated as $i => $rItem )
		{
			if( $rItem['text'] === $value )
			{
				$inArray = true;
				++$repeated[$i]['weight'];
			}
		}

		if( false === $inArray )
		{
			$i = count($repeated);
			$repeated[$i] = array();
			$repeated[$i]['text'] = $value;
			$repeated[$i]['weight'] = 1;
		}
	}

	if( ! $returnWithNonRepeatedItems )
	{
		foreach( $repeated as $i => $rItem )
		{
			if($rItem['weight'] === 1)
			{
				unset($repeated[$i]);
			}
		}
	}

	sort($repeated);

	return $repeated;
}

function verSoloPregunta($id){
try{	
	$base = new PDOConfig();
	$id = $base->filtrar($id);
	$pregunta = array();
	$sqlP="SELECT P.idPregunta,P.idPagina,P.idEncuesta,P.idTipoPregunta,P.RespuestaObligatoria,
				 P.Texto,P.NroPregunta,P.AgregarOtro,T.Descripcion as tipoPregunta,
				 P.idEscala,P.ValorMinimo,P.ValorMaximo,P.idFormato,P.incluirAnalisis,P.Diferencial
		    FROM preguntasencuestas P
		    INNER JOIN tipospreguntas T ON P.idTipoPregunta = T.idTipoPregunta
		    WHERE P.idPregunta = $id";
	//echo $sql;
	$resPreg = $base->query($sqlP);
	if($resPreg)
	{
            $pregunta = $resPreg->fetch(PDO::FETCH_ASSOC);
            return $pregunta;
		
	}else{
            return "0";
	}
}catch ( Exception $e ) {
	return "0";
	}
}

function verPregunta($id){
	
	$base = new PDOConfig();
	$id = $base->filtrar($id);
	$pregunta = array();
	$sqlP="SELECT P.idPregunta,P.idPagina,P.idEncuesta,P.idTipoPregunta,P.RespuestaObligatoria,
				 P.Texto,P.NroPregunta,P.AgregarOtro,T.Descripcion as tipoPregunta,
				 P.idEscala,P.ValorMinimo,P.ValorMaximo,P.idFormato,P.incluirAnalisis,P.Diferencial
		    FROM preguntasencuestas P
		    INNER JOIN tipospreguntas T ON P.idTipoPregunta = T.idTipoPregunta
		    WHERE P.idPregunta = $id";
	//echo $sql;
	$resPreg = $base->query($sqlP);
	if($resPreg)
	{
		$pregunta = $resPreg->fetch(PDO::FETCH_ASSOC);
		
		$sqlOp="SELECT idOpcion,idPregunta,Texto,Orden,Texto2
				FROM opcionespreguntas
				WHERE idPregunta = $id";
		//echo $sql;
		$resOps = $base->query($sqlOp);
		if($resOps){
			$pregunta["opciones"] = $resOps->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			return false;
		}
		$sqlCol="SELECT idColumna,idPregunta,Ponderacion, Texto
			FROM columnaspreguntas
			WHERE idPregunta = $id";
		//echo $sql;
		$resCols = $base->query($sqlCol);
		if($resCols){
			$pregunta["columnas"] = $resCols->fetchAll(PDO::FETCH_ASSOC);
		}else{
			return false;
		}
		
		return $pregunta;
		
	}else{
		return false;
	}
}


function ordenarPreguntas($idEncuesta, $lista) {
	try {
		$base = new PDOConfig ();
		$idPlantilla = $base->filtrar ( $idEncuesta );
		$lista = $base->filtrar ( $lista );
		$base->beginTransaction ();
		
		$preguntas = explode ( ",", $lista );
		foreach ( $preguntas as $i => $p ) {
			if ($p != "") {
				$orden = $i + 1;
				$sql = "UPDATE preguntasencuestas SET NroPregunta = $orden WHERE idEncuesta= $idEncuesta AND idPregunta = $p";
				// echo $sql;
				if (! $base->query ( $sql )) {
						
					$base->rollBack ();
					return false;
				}
			}
		}
		$base->commit ();
		return true;
	} catch ( Exception $e ) {
		return false;
	}
}


function preguntasXPagina($idPagina,$analsis){
	try{
            $salida = "";
            $base = new PDOConfig();
            $filtrar = "";
            if($analsis){
                $filtrar = " AND P.incluirAnalisis = 1 ";
            }

            $sqlP="SELECT P.idPregunta,P.idTipoPregunta,P.Texto,P.NroPregunta,
                P.idEscala,P.ValorMinimo,P.ValorMaximo,P.idFormato,P.incluirAnalisis,P.Diferencial
            FROM preguntasencuestas P WHERE P.idPagina = $idPagina $filtrar ORDER BY P.NroPregunta";
            //echo $sql;
            $resPreg = $base->query($sqlP);
            if($resPreg)
            {
                    $pregunta = $resPreg->fetchAll(PDO::FETCH_ASSOC);
            }
            return $pregunta;
	}catch (Exception $e){
		return "0" ;
	}
}

function preguntasXEncuesta($idEncuesta){
    try{

        $salida = "";
        $base = new PDOConfig();

        $sqlP="SELECT P.idPregunta,P.idTipoPregunta,P.Texto,P.NroPregunta,
                P.idEscala,P.ValorMinimo,P.ValorMaximo,P.idFormato,P.incluirAnalisis,P.Diferencial,P.Interpretacion
                FROM preguntasencuestas P WHERE P.idEncuesta = $idEncuesta ORDER BY P.NroPregunta";
        //echo $sql;
        $resPreg = $base->query($sqlP);
        if($resPreg)
        {
                $pregunta = $resPreg->fetchAll(PDO::FETCH_ASSOC);
        }

        return $pregunta;
    }catch (Exception $e){
            return "0" ;
    }
}

function preguntasXEncuestaAn($idEncuesta){
    try{

        $salida = "";
        $base = new PDOConfig();

        $sqlP="SELECT P.idPregunta,P.idTipoPregunta,P.Texto,P.NroPregunta,
                P.idEscala,P.ValorMinimo,P.ValorMaximo,P.idFormato,P.incluirAnalisis,P.Diferencial
                FROM preguntasencuestas P WHERE P.idEncuesta = $idEncuesta AND P.incluirAnalisis = 1 ORDER BY P.NroPregunta";
        //echo $sql;
        $resPreg = $base->query($sqlP);
        if($resPreg)
        {
                $pregunta = $resPreg->fetchAll(PDO::FETCH_ASSOC);
        }

        return $pregunta;
    }catch (Exception $e){
            return "0" ;
    }
}


function preguntasXEncuestaEscala($idEncuesta){
try{

		$salida = "";
		$base = new PDOConfig();

		$sqlP="SELECT P.idPregunta,P.idTipoPregunta,P.Texto,P.NroPregunta,
                        P.idEscala,P.ValorMinimo,P.ValorMaximo,P.idFormato,P.incluirAnalisis,P.Diferencial
                        FROM preguntasencuestas P WHERE P.idEncuesta = $idEncuesta AND"
                        . " P.idEscala >= 2 AND P.idTipoPregunta <> 3 ORDER BY P.NroPregunta";
		//echo $sql;
		$resPreg = $base->query($sqlP);
		if($resPreg)
		{
			$pregunta = $resPreg->fetchAll(PDO::FETCH_ASSOC);
		}
		
		return $pregunta;
	}catch (Exception $e){
		return "0" ;
	}
}

function consultarCantRespuestas($idEncuesta){
    
    $base = new PDOConfig();
    $idEncuesta = $base->filtrar($idEncuesta);
    
    $sqlResp="SELECT * from respuestas R "
            . " where idEncuesta=$idEncuesta AND idEstado=2 ";    
    $resOps = $base->query($sqlResp);	
    if($resOps){        
        return $resOps->rowCount();
    }
    else{
        return "0";
    } 
}

function preguntasLikert($idEncuesta){
try{

        $salida = "";
        $base = new PDOConfig();

        $sqlP="SELECT P.idPregunta,P.idTipoPregunta,P.Texto,P.NroPregunta,
                P.idEscala,P.ValorMinimo,P.ValorMaximo,P.idFormato,P.incluirAnalisis,P.Diferencial
                FROM preguntasencuestas P WHERE P.idEncuesta = $idEncuesta AND"
                . " P.idTipoPregunta = 3 ORDER BY P.NroPregunta";
        //echo $sql;
        $resPreg = $base->query($sqlP);
        if($resPreg)
        {
                $pregunta = $resPreg->fetchAll(PDO::FETCH_ASSOC);
        }
        return $pregunta;
    }catch (Exception $e){
            return "0" ;
    }
}

function preguntasNominales($idEncuesta){
try{
    $salida = "";
    $base = new PDOConfig();

    $sqlP="SELECT P.idPregunta,P.idTipoPregunta,P.Texto,P.NroPregunta,
            P.idEscala,P.ValorMinimo,P.ValorMaximo,P.idFormato,P.incluirAnalisis,P.Diferencial
            FROM preguntasencuestas P WHERE P.idEncuesta = $idEncuesta AND"
            . " P.idTipoPregunta IN (1,12) AND P.idEscala = 1 ORDER BY P.NroPregunta";
    //echo $sql;
    $resPreg = $base->query($sqlP);
    if($resPreg)
    {
       $pregunta = $resPreg->fetchAll(PDO::FETCH_ASSOC);
    }
    return $pregunta;
}catch (Exception $e){
        return "0" ;
}
}

function OpcionesPregunta($idPregunta)
{
    try{
        $salida = "";
        $base = new PDOConfig();

        $sqlP="SELECT P.idOpcion,P.idPregunta,P.Texto,P.Orden,P.Texto2
                FROM opcionespreguntas P WHERE P.idPregunta = $idPregunta ORDER BY P.Texto";
        //echo $sql;
        $resPreg = $base->query($sqlP);
        if($resPreg)
        {
           $opciones = $resPreg->fetchAll(PDO::FETCH_ASSOC);
        }
        return $opciones;
    }catch (Exception $e){
            return "0" ;
    }
}

function res_OpMultiplesNominal($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/frecuencia.R" '.$idPregunta.' 2>&1',$output);   
        //print_r($output); exit();
        if($output){  
            $datos = array();
                     
            $cantidades = substr($output[1],4);
            $relativas = substr($output[2],4);
            $arrCa = preg_split('/\s+/',trim($cantidades));
            $arrRe = preg_split('/\s+/',trim($relativas));        
           
            exec('"'._RPATH.'" "../RDatos/frecuenciaEtiquetas.R" '.$idPregunta.' 2>&1',$output1);   
            //print_r($output1); exit();
            $salEt = array();
            if($output1){
                for($i=1;$i<(COUNT($output1)-1);$i++)
                {
                    $etiquetas = trim($output1[$i]);
                    $etiquetas = substr($etiquetas,strpos($etiquetas, "\""));
                    $etiquetas = trim(str_replace("\"","",$etiquetas));   
                    $arrEt = explode("##", substr($etiquetas,0,(strlen($etiquetas) - 2)));
                    $salEt = array_merge($salEt,$arrEt);
                }
            
            $datos[]=$salEt;
            $datos[]=$arrCa;
            $datos[]=$arrRe;
             
            return $datos;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }catch (Exception $e){
	return false;
    }   
}

function res_OpMultiplesNominalPeriodo($idPregunta,$idPerido){

       try{
        exec('"'._RPATH.'" "../RDatos/frecuenciaPeriodo.R" '.$idPregunta.' '.$idPerido.' 2>&1',$output);   
        //print_r($output); exit();
        if($output){  
            $datos = array();
                     
            $cantidades = substr($output[1],4);
            $relativas = substr($output[2],4);
            $arrCa = preg_split('/\s+/',trim($cantidades));
            $arrRe = preg_split('/\s+/',trim($relativas));        
           
            exec('"'._RPATH.'" "../RDatos/frecuenciaEtiqPeriodo.R" '.$idPregunta.' '.$idPerido.' 2>&1',$output1);   
            //print_r($output1); exit();
            $salEt = array();
            if($output1){
                for($i=1;$i<(COUNT($output1)-1);$i++)
                {
                    $etiquetas = trim($output1[$i]);
                    $etiquetas = substr($etiquetas,strpos($etiquetas, "\""));
                    $etiquetas = trim(str_replace("\"","",$etiquetas));   
                    $arrEt = explode("##", substr($etiquetas,0,(strlen($etiquetas) - 2)));
                    $salEt = array_merge($salEt,$arrEt);
                }
            
            $datos[]=$salEt;
            $datos[]=$arrCa;
            $datos[]=$arrRe;
             
            return $datos;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }catch (Exception $e){
	return false;
    }   
}

function res_Modo($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/calcModa.R" '.$idPregunta.' 2>&1',$output);  
        if($output){ 
            $arrRe = explode(']',trim($output[1]));
            return $arrRe[1];
        }else{
            return false;
        }
    }catch (Exception $e){
	return false;
    }   
}

function res_ModoPeriodo($idPregunta,$idPeriodo){
    try{
        exec('"'._RPATH.'" "../RDatos/calcModaPeriodo.R" '.$idPregunta.' '.$idPeriodo.' 2>&1',$output);  
        if($output){ 
            $arrRe = explode(']',trim($output[1]));
            return $arrRe[1];
        }else{
            return false;
        }
    }catch (Exception $e){
	return false;
    }   
}

function res_GraficoFrecuencias($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/frecuenciaGraf.R" '.$idPregunta.' 2>&1', $output);  
        
        return "graFrec$idPregunta.png";
    }catch (Exception $e){
	return false;
    }   
}

function res_GraficoFrecuenciasPeriodo($idPregunta,$idPeriodo){
   try{
        exec('"'._RPATH.'" "../RDatos/frecGrafPeriodo.R" '.$idPregunta.' '.$idPeriodo.' 2>&1', $output);  
        
        return "graFrecPer$idPregunta$idPeriodo.png";
    }catch (Exception $e){
	return false;
    } 
}


function res_GraficoBloques($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/frecOrdinalGraf.R" '.$idPregunta.' 2>&1');  
        return "graBloq$idPregunta.png";
    }catch (Exception $e){
	return false;
    }   
}

function res_GraficoGrupoBarras($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/grafGroupBar.R" '.$idPregunta.' 2>&1');  
        return "graBarGroup$idPregunta.png";
    }catch (Exception $e){
	return false;
    }   
}

function res_GraficoGrupoBarrasPeriodo($idPregunta,$idPeriodo){    
    try{
        exec('"'._RPATH.'" "../RDatos/grafGroupBarPeriodo.R" '.$idPregunta.' '.$idPeriodo.' 2>&1');  
        return "graBarGroup$idPregunta$idPeriodo.png";
    }catch (Exception $e){
	return false;
    }   
}

function res_Mediana($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/calcMedianaOrd.R" '.$idPregunta.' 2>&1',$output);  
        //return $output;
        if($output){ 
            $arrRe = explode(']',trim($output[1]));
            return $arrRe[1];
        }else{
            return false;
        }
    }catch (Exception $e){
	return false;
    }   
}

function res_MedianaPeriodo($idPregunta,$idPeriodo){
  try{
        exec('"'._RPATH.'" "../RDatos/calcMedianaOrdPeriodo.R" '.$idPregunta.' '.$idPeriodo.' 2>&1',$output);  
        //return $output;
        if($output){ 
            $arrRe = explode(']',trim($output[1]));
            return $arrRe[1];
        }else{
            return false;
        }
    }catch (Exception $e){
	return false;
    }     
}


function res_Quartiles($idPregunta)
{ 
    try{
        $datos = array();
        exec('"'._RPATH.'" "../RDatos/calcPerceptiles.R" '.$idPregunta.' 2>&1',$output); 
        if($output){
        $arrCa = preg_split('/\s+/',trim($output[1]));
        $arrRe = preg_split('/\s+/',trim($output[2]));
        $datos[]=$arrCa;
        $datos[]=$arrRe;
        return $datos;
    }
    }catch(Exception $e){
       return false; 
    }
}

function res_QuartilesPeriodo($idPregunta,$idPeriodo){
try{
        $datos = array();
        exec('"'._RPATH.'" "../RDatos/calcPerceptiles.R" '.$idPregunta.' '.$idPeriodo.' 2>&1',$output); 
        if($output){
        $arrCa = preg_split('/\s+/',trim($output[1]));
        $arrRe = preg_split('/\s+/',trim($output[2]));
        $datos[]=$arrCa;
        $datos[]=$arrRe;
        return $datos;
    }
    }catch(Exception $e){
       return false; 
    }    
}

function res_SummaryPeriodo($idPregunta,$idPeriodo){
    try{
        exec('"'._RPATH.'" "../RDatos/calcSummaryPeriodo.R" '.$idPregunta.' '.$idPeriodo.' 2>&1',$output);   
        
        if($output){  
            $datos = array();            
            $valores = $output[2];
            
            $arrEt = array("Min","1er Cuartil","Mediana","Promedio","3er Cuartil","Max");
            $arrVa = preg_split('/\s+/',trim($valores));        
            $datos[]=$arrEt;
            $datos[]=$arrVa;
            return $datos;
        }else{
            return false;
        }
    }catch (Exception $e){
	return false;
    }   
}

function res_Summary($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/calcSummary.R" '.$idPregunta.' 2>&1',$output);   
        
        if($output){  
            $datos = array();            
            $valores = $output[2];
            
            $arrEt = array("Min","1er Cuartil","Mediana","Promedio","3er Cuartil","Max");
            $arrVa = preg_split('/\s+/',trim($valores));        
            $datos[]=$arrEt;
            $datos[]=$arrVa;
            return $datos;
        }else{
            return false;
        }
    }catch (Exception $e){
	return false;
    }   
}

function res_DesvioEstandar($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/calcDesvioEstandar.R" '.$idPregunta.' 2>&1',$output);         
        if (strpos($output[0], 'Error') !== false){
            return "";
        }else{ 
            if(strpos($output[1], 'Error') !== false)
            {
             return "";    
            }
            $arrRe = explode(']',trim($output[1]));
            return $arrRe[1];
        }
    }catch (Exception $e){
	return false;
    }   
}

function res_MediaGeometrica($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/calcMediaGeo.R" '.$idPregunta.' 2>&1',$output);         
        if (strpos($output[0], 'Error') !== false){
            return "";
        }else{ 
            if(strpos($output[1], 'Error') !== false)
            {
             return "";    
            }
            $arrRe = explode(']',trim($output[1]));
            return $arrRe[1];
        }
    }catch (Exception $e){
	return false;
    }   
}

function res_DesvioEstandarPeriodo($idPregunta,$idPeriodo){
    try{
        exec('"'._RPATH.'" "../RDatos/calcDesvioEstandarPeriodo.R" '.$idPregunta.' '.$idPeriodo.' 2>&1',$output);         
        if (strpos($output[0], 'Error') !== false){
            return "";
        }else{ 
            if(strpos($output[1], 'Error') !== false)
            {
             return "";    
            }
            $arrRe = explode(']',trim($output[1]));
            return $arrRe[1];
        }
    }catch (Exception $e){
	return false;
    }   
}

function res_Varianza($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/calcVarianza.R" '.$idPregunta.' 2>&1',$output);        
        if (strpos($output[0], 'Error') !== false){
            return "";
        }else{ 
            if (strpos($output[1], 'Error') !== false){
             return "";    
            }
            $arrRe = explode(']',trim($output[1]));
            return $arrRe[1];
        }
    }catch (Exception $e){
	return "";
    }   
}
function res_VarianzaPeriodo($idPregunta,$idPeriodo){
    try{
        exec('"'._RPATH.'" "../RDatos/calcVarianzaPeriodo.R" '.$idPregunta.' '.$idPeriodo.' 2>&1',$output);        
        if (strpos($output[0], 'Error') !== false){
            return "";
        }else{ 
            if (strpos($output[1], 'Error') !== false){
             return "";    
            }
            $arrRe = explode(']',trim($output[1]));
            return $arrRe[1];
        }
    }catch (Exception $e){
	return "";
    }   
} 

function res_GraficoBloxPlot($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/grafBloxPlot.R" '.$idPregunta.' 2>&1', $output);  
        
        return "graBloxPlot$idPregunta.png";
    }catch (Exception $e){
	return false;
    }   
}

function res_GraficoBloxPlotPeriodo($idPregunta,$idPeriodo){
   try{
        exec('"'._RPATH.'" "../RDatos/grafBloxPlotPeriodo.R" '.$idPregunta.' '.$idPeriodo.' 2>&1', $output);  
        
        return "graBloxPlot$idPregunta$idPeriodo.png";
    }catch (Exception $e){
	return false;
    }  
}

function res_frecuenciasPonderadas($idPregunta){    
    try{
        exec('"'._RPATH.'" "../RDatos/calcFrecuenciasPonderadas.R" '.$idPregunta.' 2>&1', $output); 
        return $output;
    }catch (Exception $e){
	return false;
    }   
}


function res_OpMultiplesReferencias($idPregunta)
{    
    $base = new PDOConfig();
    $idPregunta = $base->filtrar($idPregunta);
    $lista = array(); 
    $sqlResp="SELECT O.Orden,CONCAT(O.idOpcion,' - ',O.Texto) AS label from opcionespreguntas O "
            . " where O.idPregunta = $idPregunta ";    
    $resOps = $base->query($sqlResp);
	
    if($resOps){
        $opciones = $resOps->fetchAll(PDO::FETCH_ASSOC);            
        return $opciones;
    }
    else{
        return "0";
    }
}

function res_anFrecPonderadas($idPreguntas){
    try{
        $salida = "";
        $base = new PDOConfig();
        
        $sqlP="SELECT CONCAT(O.idOpcion,' - ', O.Texto) AS opcion, C.Texto as columna, C.Ponderacion, "
                . "(SELECT COUNT(*) FROM respuestaspreguntas R WHERE R.idPregunta=$idPreguntas AND R.idOpcion = O.idOpcion AND R.idColumna = C.idColumna) AS cantidad, "
                . "(SELECT COUNT(*) FROM respuestaspreguntas R WHERE R.idPregunta=$idPreguntas AND R.idOpcion = O.idOpcion) AS totalOp from columnaspreguntas C "
                . "LEFT JOIN opcionespreguntas O ON O.idPregunta = C.idPregunta WHERE O.idPregunta =$idPreguntas ORDER BY O.idOpcion, C.idColumna";
        //echo $sql;
        $resPreg = $base->query($sqlP);
        if($resPreg)
        {
            $salida = "<div class='table-responsive small'><table class='table datatable table-bordered'>";
            $cantCol = 0;
            $sqlCo="SELECT * FROM columnaspreguntas C WHERE C.idPregunta = $idPreguntas ORDER BY C.idColumna";
            //echo $sql;
            if($resCol = $base->query($sqlCo)){
              $cantCol =   $resCol->rowCount();
               $salida .= "<tr><th>&nbsp;</th>";    
              foreach($resCol as $c)
              {
                $salida .= "<th>".$c["Texto"]." (".$c["Ponderacion"].")</th>";  
              }
              $salida .= "<th>M. Pond.</th></tr>";    
            }

            $cantRow = 0;
            $sqlRo="SELECT * FROM opcionespreguntas O WHERE O.idPregunta = $idPreguntas ORDER BY O.idOpcion";
            //echo $sql;
            if($resRo = $base->query($sqlRo)){
              $cantRow =   $resRo->rowCount();
            }
            $respuestas = $resPreg->fetchAll(PDO::FETCH_NUM);
            //print_r($respuestas);exit();
            $i = 0;$t=0;
            for($i=0;$i<$cantRow;$i++){
                $j=0;$totalPon = 0; $cantXf = 0;
                $salida .= "<tr><th>".$respuestas[$t][0]."</th>"; 
                for($j=0;$j<$cantCol;$j++){
                    $salida .= "<td>".$respuestas[$t][3]."</td>"; 
                    $totalPon += $respuestas[$t][3] * $respuestas[$t][2];
                    $cantXf += $respuestas[$t][2];
                    $t++;
                }
                $aux = $totalPon / $cantXf;
                $salida .= "<td>".round($aux, 2)."</td></tr>";
            }

        }
        $salida .= "</table></div>"; 
        return $salida;
    }catch (Exception $e){
            return "" ;
    }
}

function res_anFrecPonderadasPeriodo($idPregunta,$idPeriodo){
    try{
        $salida = "";
        $base = new PDOConfig();
        $sqlP="SELECT O.Texto AS opcion, C.Texto as columna,C.Ponderacion, "
                . "(SELECT COUNT(*) FROM respuestaspreguntas R INNER JOIN respuestas E ON R.idRespuesta = E.idRespuesta WHERE E.idPeriodo = $idPeriodo AND R.idPregunta=$idPregunta AND R.idOpcion = O.idOpcion AND R.idColumna = C.idColumna) AS cantidad, "
                . "(SELECT COUNT(*) FROM respuestaspreguntas R INNER JOIN respuestas E ON R.idRespuesta = E.idRespuesta WHERE E.idPeriodo = $idPeriodo AND R.idPregunta=$idPregunta AND R.idOpcion = O.idOpcion) AS totalOp from columnaspreguntas C "
                . " LEFT JOIN opcionespreguntas O ON O.idPregunta = C.idPregunta WHERE O.idPregunta =$idPregunta ORDER BY O.idOpcion, C.idColumna";
        //return $sqlP;
        $resPreg = $base->query($sqlP);
        if($resPreg)
        {
            $salida = "<table class='table datatable table-bordered'>";
            $cantCol = 0;
            $sqlCo="SELECT * FROM columnaspreguntas C WHERE C.idPregunta = $idPregunta ORDER BY C.idColumna";
            //echo $sql;
            if($resCol = $base->query($sqlCo)){
              $cantCol =   $resCol->rowCount();
               $salida .= "<tr><th>&nbsp;</th>";    
              foreach($resCol as $c)
              {
                $salida .= "<th>".$c["Texto"]." (".$c["Ponderacion"].")</th>";  
              }
              $salida .= "<th>M. Pond.</th></tr>";    
            }

            $cantRow = 0;
            $sqlRo="SELECT * FROM opcionespreguntas O WHERE O.idPregunta = $idPregunta ORDER BY O.idOpcion";
            //echo $sql;
            if($resRo = $base->query($sqlRo)){
              $cantRow =   $resRo->rowCount();
            }
            $respuestas = $resPreg->fetchAll(PDO::FETCH_NUM);
            //print_r($respuestas);exit();
            $i = 0;$t=0;
            for($i=0;$i<$cantRow;$i++){
                $j=0;$totalPon = 0; $cantXf = 0;
                $salida .= "<tr><th>".$respuestas[$t][0]."</th>"; 
                for($j=0;$j<$cantCol;$j++){
                    $salida .= "<td>".$respuestas[$t][3]."</td>"; 
                    $totalPon += $respuestas[$t][3] * $respuestas[$t][2];
                    $cantXf += $respuestas[$t][2];
                    $t++;
                }
                $aux = $totalPon / $cantXf;
                $salida .= "<td>".round($aux, 2)."</td></tr>";
            }

        }
        $salida .= "</table>"; 
        return $salida;
    }catch (Exception $e){
       return "" ;
    }
}


function res_OpMultiples($idPregunta, $idEscala){
    $resultado = array();
    if($idEscala == "1")
    {
        $resultado["frecuencias"] = res_OpMultiplesNominal($idPregunta);
        $resultado["modo"] = res_Modo($idPregunta);
        $resultado["grafico"] = res_GraficoFrecuencias($idPregunta);
    }else{
        if($idEscala == "2")
        {
            $resultado["cuartiles"] = res_Quartiles($idPregunta);
            $resultado["mediana"] = res_Mediana($idPregunta);
            $resultado["modo"] = res_Modo($idPregunta);
            $resultado["grafico"] = res_GraficoFrecuencias($idPregunta);
            $resultado["referencias"] = res_OpMultiplesReferencias($idPregunta);            
        }
    }
    //print_r($resultado); exit();
    return json_encode($resultado);
}

function res_OpMultiplesPeriodo($idPregunta, $idPeriodo, $idEscala){
    $resultado = array();
    if($idEscala == "1")
    {
        $resultado["frecuencias"] = res_OpMultiplesNominalPeriodo($idPregunta,$idPeriodo);
        $resultado["modo"] = res_ModoPeriodo($idPregunta,$idPeriodo);
        $resultado["grafico"] = res_GraficoFrecuenciasPeriodo($idPregunta,$idPeriodo);
    }else{
        if($idEscala == "2")
        {
            $resultado["cuartiles"] = res_QuartilesPeriodo($idPregunta,$idPeriodo);
            $resultado["mediana"] = res_MedianaPeriodo($idPregunta,$idPeriodo);
            $resultado["modo"] = res_ModoPeriodo($idPregunta,$idPeriodo);
            $resultado["grafico"] = res_GraficoFrecuenciasPeriodo($idPregunta,$idPeriodo);
            $resultado["referencias"] = res_OpMultiplesReferencias($idPregunta);            
        }
    }
    //print_r($resultado); exit();
    return $resultado;
}

function res_NubeTexto($idPregunta){
    $base = new PDOConfig();
    $idPregunta = $base->filtrar($idPregunta);
    $palabras = array();
    $lista = array();
    $texto ="";
    $sqlResp="SELECT RespuestaTexto from respuestaspreguntas R 
              WHERE R.idPregunta = $idPregunta";

    $resOps = $base->query($sqlResp);
    if($resOps){
            $resultado = $resOps->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $row)
            {
                    $texto .= " ".$row["RespuestaTexto"];
            }
            //echo $texto;exit();
            $palabras = tags(quitarAcentos($texto));		
            $lista = repeatedElements($palabras, true);
            //print_r($lista);exit();
            return json_encode($lista);
    }
    else{
            return "0";
    }
}

function res_NubeTextoPeriodo($idPregunta,$idPeriodo){
    $base = new PDOConfig();
    $idPregunta = $base->filtrar($idPregunta);
    $palabras = array();
    $lista = array();
    $texto ="";
    $sqlResp="SELECT RespuestaTexto from respuestaspreguntas R INNER JOIN respuestas E ON R.idRespuesta = E.idRespuesta
              WHERE E.idPeriodo = $idPeriodo AND R.idPregunta = $idPregunta";

    $resOps = $base->query($sqlResp);
    if($resOps){
            $resultado = $resOps->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $row)
            {
                    $texto .= " ".$row["RespuestaTexto"];
            }
            //echo $texto;exit();
            $palabras = tags(quitarAcentos($texto));		
            $lista = repeatedElements($palabras, true);
            //print_r($lista);exit();
            return json_encode($lista);
    }
    else{
            return "0";
    }
}

function res_AnDiferencialSemantico($idPregunta,$idPeriodo){
    $base = new PDOConfig();
    $idPregunta = $base->filtrar($idPregunta);
    $salida = "";
    $where = "";
    if($idPeriodo != "0")
    {
        $where = " AND E.idPeriodo = $idPeriodo";
    }
    
    $sqlResp="SELECT O.Texto, O.Texto2, SUM(RespuestaTexto) AS cantResp from respuestaspreguntas R 
           INNER JOIN respuestas E ON R.idRespuesta = E.idRespuesta
           INNER JOIN opcionespreguntas O ON R.idOpcion = O.idOpcion
           WHERE  R.idPregunta = $idPregunta $where GROUP BY O.Texto, O.Texto2";

    $resOps = $base->query($sqlResp);
    if($resOps){
        $resultado = $resOps->fetchAll(PDO::FETCH_ASSOC);
        $salida = "<table class='table datatable table-bordered'><tr><th>Opciones</th><th>Total</th></tr>";
              
        foreach($resultado as $res)
        {
          $salida .= "<tr><td>".$res["Texto"]." - ".$res["Texto2"]."</td><td>".$res["cantResp"]."</td></tr>";  
        }

        $salida .= "</table>";
        return $salida;
    }
    else{
        return false;
    }
}


function res_AnTextoEscalas($idPregunta, $idEscala){
    $resultado = array();
    if($idEscala == "2")
    {
        $resultado["sumary"] = res_Summary($idPregunta);
    }else{
        if($idEscala == "3")
        {
            $resultado["summary"] = res_Summary($idPregunta);
            $resultado["varianza"] = res_Varianza($idPregunta);
            $resultado["desvioEst"] = res_DesvioEstandar($idPregunta);
            $resultado["grafico"] = res_GraficoBloxPlot($idPregunta);
        }else{
            if($idEscala == "4")
            {
                $desvio = res_DesvioEstandar($idPregunta);
                $sumary = res_Summary($idPregunta);
                $promedio = $sumary[1][3];
                $coef = (100*$desvio)/$promedio;
                $resultado["summary"] = $sumary;
                $resultado["varianza"] = res_Varianza($idPregunta);
                $resultado["desvioEst"] = res_DesvioEstandar($idPregunta);
                $resultado["mediaGeo"] = res_MediaGeometrica($idPregunta);
                $resultado["grafico"] = res_GraficoBloxPlot($idPregunta);
                $resultado["coeficiente"] = number_format($coef, 2, '.', '');
            }
        }
    }
    return json_encode($resultado);
}

function res_AnTextoEscalasPeriodo($idPregunta, $idEscala, $idPeriodo){
    $resultado = array();
    if($idEscala == "2")
    {
        $resultado["sumary"] = res_SummaryPeriodo($idPregunta,$idPeriodo);
    }else{
        if($idEscala == "3")
        {
            $resultado["summary"] = res_SummaryPeriodo($idPregunta,$idPeriodo);
            $resultado["varianza"] = res_VarianzaPeriodo($idPregunta,$idPeriodo);
            $resultado["desvioEst"] = res_DesvioEstandarPeriodo($idPregunta,$idPeriodo);
            $resultado["grafico"] = res_GraficoBloxPlotPeriodo($idPregunta,$idPeriodo);
        }else{
            if($idEscala == "4")
            {
                $resultado["summary"] = res_SummaryPeriodo($idPregunta,$idPeriodo);
                $resultado["varianza"] = res_VarianzaPeriodo($idPregunta,$idPeriodo);
                $resultado["desvioEst"] = res_DesvioEstandarPeriodo($idPregunta,$idPeriodo);
                $resultado["grafico"] = res_GraficoBloxPlotPeriodo($idPregunta,$idPeriodo);
                $resultado["coeficiente"] = "0";
            }
        }
    }
    return $resultado;
}


function res_matrices($idPregunta){
    $resultado = array();
    $resultado["grafico"] = res_GraficoGrupoBarras($idPregunta);
    $resultado["tabla"] = res_anFrecPonderadas($idPregunta);
    return json_encode($resultado);
    
}

function res_matricesPeriodo($idPregunta,$idPeriodo){
    $resultado = array();
    $resultado["grafico"] = res_GraficoGrupoBarrasPeriodo($idPregunta,$idPeriodo);
    $resultado["tabla"] = res_anFrecPonderadasPeriodo($idPregunta,$idPeriodo);
    return $resultado;
    
}


function res_GraficoPearson($idPregunta1,$idPregunta2){    
    try{
        exec('"'._RPATH.'" "../RDatos/grafPearson.R" '.$idPregunta1.' '.$idPregunta2.' 2>&1');  
        return "grafPearson".$idPregunta1.$idPregunta2.".png";
    }catch (Exception $e){
	return false;
    }   
}


function res_AnCorrelacion($idPregunta1,$idPregunta2,$metodo){    
    try{
        $resultado = array();
        $base = new PDOConfig();
        $sqlP1="SELECT P.idTipoPregunta,COUNT(*) AS cant from preguntasencuestas P INNER JOIN "
                . " respuestaspreguntas R ON P.idPregunta = R.idPregunta "
                . " WHERE P.idPregunta =$idPregunta1 GROUP BY idTipoPregunta";
        
        
        $sqlP2="SELECT P.idTipoPregunta,COUNT(*) AS cant from preguntasencuestas P INNER JOIN "
                . " respuestaspreguntas R ON P.idPregunta = R.idPregunta "
                . " WHERE P.idPregunta =$idPregunta2 GROUP BY idTipoPregunta";
        
        $resPreg1 = $base->query($sqlP1);
        $resPreg2 = $base->query($sqlP2);
        if($resPreg1 && $resPreg2)
        {
            $res1 = $resPreg1->fetch(PDO::FETCH_ASSOC);
            $res2 = $resPreg2->fetch(PDO::FETCH_ASSOC);
            if($res1["cant"] == $res2["cant"]){
                //return '"'._RPATH.'" "../RDatos/grafPearson.R" '.$idPregunta1.' '.$res1["idTipoPregunta"].' '.$idPregunta2.' '.$res2["idTipoPregunta"].' '.$metodo.' 2>&1';
                exec('"'._RPATH.'" "../RDatos/GrafCorrelacion.R" '.$idPregunta1.' '.$res1["idTipoPregunta"].' '.$idPregunta2.' '.$res2["idTipoPregunta"].' '.$metodo.' 2>&1',$output);  
                //return $output;
                $resultado = array("resultado" => "ok","salida" => "grafCorr_".$metodo.$idPregunta1.$idPregunta2.".png");        
            }else{
                $resultado = array("resultado" =>"Error","salida" =>"La cantidad de respuestas obtenidas de las preguntas seleccionas no coinciden");
            }
        }else{
            $resultado = array("resultado" =>"Error","salida" =>"Error al consultar los datos");            
        }
        return json_encode($resultado);
    }catch (Exception $e){
	$resultado = array("resultado" =>"Error","salida" =>"Error al consultar los datos");
        return json_encode($resultado);
    }   
}


function res_GraficoMannWhitney($idP1,$idP2,$idOp){    
    try{
        $resultado = array();
        
        exec('"'._RPATH.'" "../RDatos/grafMannWhitney.R" '.$idP1.' '.$idOp.' '.$idP2.' 2>&1', $output);  
        $resultado["resultado"] = "ok";
        $resultado["grafico"] = "grafMannWhitney_".$idP1.$idOp.$idP2.".png";
        $resultado["valorP"] = $output[7];
        return json_encode($resultado);
    }catch (Exception $e){
	return 0;
    }   
}

function res_GraficoKruskalWallis($idP1,$idP2,$idOp){    
    try{
        $resultado = array();
        exec('"'._RPATH.'" "../RDatos/grafKruskalWallis.R" '.$idP1.' '.$idOp.' '.$idP2.' 2>&1', $output);  
        $resultado["resultado"] = "ok";
        $resultado["grafico"] = "grafKruskalWallis_".$idP1.$idOp.$idP2.".png";
        $resultado["valorP"] = $output[7];
        return json_encode($resultado);
    }catch (Exception $e){
	return 0;
    }   
}

function res_AnLikert($idP1,$idOp,$idP2,$metodo){  
    $salida = 0;
    if($metodo == "Mann-Whitney"){
       $salida = res_GraficoMannWhitney($idP1,$idP2,$idOp); 
    }else{
        if($metodo == "Kruskal-Wallis"){
            $salida = res_GraficoKruskalWallis($idP1,$idP2,$idOp); 
        }
    }
    return $salida;
}

function verPeriodosPorEncuesta($idEncuesta) {
    try{
        $base = new PDOConfig();
        $sqpPe = "SELECT idPeriodo,idEncuesta,FechaInicio,FechaFin,Activo,Titulo FROM "
                . " periodosrecopilacion P WHERE idEncuesta = $idEncuesta";

        if ($resPe = $base->query($sqpPe)) {
           $salida = $resPe->fetchAll(PDO::FETCH_ASSOC);
           return $salida;
        } else {
            return 0;
        }
    }catch (Exception $e){
	return 0;
    } 
}
/*
$resultado["frecuencias"] = res_OpMultiplesNominal($idPregunta);
        $resultado["modo"] = res_Modo($idPregunta);
        $resultado["grafico"] = res_GraficoFrecuencias($idPregunta);
$d = res_AnTextoEscalasPeriodo(44,4,8);//res_OpMultiplesNominal(68);
print_r($d);*/
/*
/*
$d = res_GraficoKruskalWallis(52,68,96);
print_r($d);
 * */