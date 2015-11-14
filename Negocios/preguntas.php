<?php
header('Content-type: text/html; charset=utf-8');
require_once('../libs/PDOConfig.php');
require_once('utilidades.php');
require_once("../Datos/modeloPreguntas.php");
require_once("../Datos/modeloPaginas.php");
require_once("../libs/Login.php");

$oLogin=new Login();
if(!$oLogin->activa()){
//	exit();
}

function agregarOpcionesOrden($base,$idPreg,$opciones,$orden)
{	
	foreach($opciones as $i=>$opcion){
		$opcion = $base->filtrar($opcion);
		$sqlOp = " INSERT INTO opcionespreguntas(idPregunta,Texto,Orden) VALUES ($idPreg,'$opcion',".$orden[$i].")";
		if(!$base->query($sqlOp)){
			return false;
		}
			
	}
	return true;
}

function agregarOpciones($base,$idPreg,$opciones)
{	
	foreach($opciones as $opcion){
		$opcion = $base->filtrar($opcion);
		$sqlOp = " INSERT INTO opcionespreguntas(idPregunta,Texto) VALUES ($idPreg,'$opcion')";
		
                if(!$base->query($sqlOp)){
                    echo $sqlOp;
                    return false;
		}
			
	}
	return true;
}

function agregarOpcionesDF($base,$idPreg,$opciones,$opciones2)
{	
	foreach($opciones as $i=>$opcion){
		$opcion = $base->filtrar($opcion);
		$sqlOp = " INSERT INTO opcionespreguntas(idPregunta,Texto,Texto2) VALUES ($idPreg,'$opcion','".$opciones2[$i]."')";
		if(!$base->query($sqlOp)){
			return false;
		}
			
	}
	return true;
}

function agregarColumnas($base,$idPreg,$columnas,$ponderaciones)
{
	foreach($columnas as $i=>$col){
		$opcion = $base->filtrar($col);
		
		if($ponderaciones != ""){
			if(isset($ponderaciones[$i])){
				$p = $ponderaciones[$i];
			}else{
				$p = "0";
			}
		}else{
			$p = "0";
		}
		$sqlOp = " INSERT INTO columnaspreguntas(idPregunta,Ponderacion,Texto) VALUES ($idPreg,$p,'$opcion')";
		//echo $sqlOp;
		if(!$base->query($sqlOp)){
			return false;
		}
			
	}
	return true;
}


function nuevaPregunta($idEncuesta, $idPagina, $nroPregunta, $tipoPregunta, $pregunta, $opciones, 
        $obligatorio, $columnas, $valores, $usuario, $escala, $formato, $vmin, $vmax, $analisis, 
        $opciones2, $diferencial, $ordenOpciones) {
    try {
        $base = new PDOConfig();


        $nroPregunta = $base->filtrar($nroPregunta);
        $tipoPregunta = $base->filtrar($tipoPregunta);
        $pregunta = $base->filtrar($pregunta);
        $obligatorio = $base->filtrar($obligatorio);
        $escala = $base->filtrar($escala);
        $formato = $base->filtrar($formato);
        $vmin = $base->filtrar($vmin);
        $vmax = $base->filtrar($vmax);
        $diferencial = $base->filtrar($diferencial);

        if (($escala == "") || ($escala == "-1"))
            $escala = 'NULL';

        if (($formato == "") || ($formato == "-1"))
            $formato = 'NULL';

        if (($diferencial == "") || ($diferencial == "-1"))
            $diferencial = 'NULL';

        if (($vmin == ""))
            $vmin = 'NULL';
        else
            $vmin = "'$vmin'";

        if (($vmax == ""))
            $vmax = 'NULL';
        else
            $vmax = "'$vmax'";

        $idPreg = 0;
        $base->beginTransaction();

        $sql = " SELECT MAX(NroPregunta) AS maxNro FROM preguntasencuestas WHERE idEncuesta = $idEncuesta";

        $resp = $base->query($sql);
        $rowMax = $resp->fetch(PDO::FETCH_ASSOC);
        if ($rowMax['maxNro'] != "") {
            $max = $rowMax['maxNro'];
            $max++;
        } else {
            $max = 1;
        }
        if ($resp) {
            $sql = " INSERT INTO preguntasencuestas(idEncuesta,idPagina,idTipoPregunta,RespuestaObligatoria,
			         Texto,NroPregunta,idEscala,ValorMinimo,ValorMaximo,idFormato,incluirAnalisis,Diferencial) VALUES
			($idEncuesta,$idPagina,$tipoPregunta,$obligatorio,'$pregunta',$max,$escala,$vmin,$vmax,$formato,$analisis,$diferencial)";
            //echo $sql;
            if ($base->query($sql)) {
                $idPreg = $base->lastInsertId();
                if ($idPreg > 0) {

                    switch ($tipoPregunta) {

                        case "1":
                            if($escala == "1"){
                                if (!agregarOpciones($base, $idPreg, $opciones)) {
                                    $base->rollBack();
                                    return "<div class='form-group has-error col-md-8'>
                                                            <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                            </div>";
                                }
                            }
                            else{
                              if (!agregarOpcionesOrden($base, $idPreg, $opciones,$ordenOpciones)) {
                                    $base->rollBack();
                                    return "<div class='form-group has-error col-md-8'>
                                                            <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                            </div>";
                                }  
                                
                            }
                            break;
                        case "2":
                            if (!agregarOpciones($base, $idPreg, $opciones)) {
                                $base->rollBack();
                                return "<div class='form-group has-error col-md-8'>
                                                        <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                        </div>";
                            }
                            break;
                        case "3":
                            if (!agregarOpciones($base, $idPreg, $opciones)) {
                                $base->rollBack();
                                return "<div class='form-group has-error col-md-8'>
                                                        <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                        </div>";
                            }

                            if (!agregarColumnas($base, $idPreg, $columnas, $valores)) {
                                $base->rollBack();
                                return "<div class='form-group has-error col-md-8'>
                                                        <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                        </div>";
                            }
                            break;
                        case "4":if (!agregarOpciones($base, $idPreg, $opciones)) {
                                $base->rollBack();
                                return "<div class='form-group has-error col-md-8'>
                                                        <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                        </div>";
                            }

                            if (!agregarColumnas($base, $idPreg, $columnas, $valores)) {
                                $base->rollBack();
                                return "<div class='form-group has-error col-md-8'>
                                                        <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                        </div>";
                            }
                            break;
                        case "5":
                            if (!agregarOpciones($base, $idPreg, $opciones)) {
                                $base->rollBack();
                                return "<div class='form-group has-error col-md-8'>
                                                        <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                        </div>";
                            }

                            if (!agregarColumnas($base, $idPreg, $columnas, $valores)) {
                                $base->rollBack();
                                return "<div class='form-group has-error col-md-8'>
                                                        <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                        </div>";
                            }
                            break;
                        case "7":
                            if (!agregarOpciones($base, $idPreg, $opciones)) {
                                $base->rollBack();
                                return "<div class='form-group has-error col-md-8'>
                                                        <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                        </div>";
                            }
                            break;
                        
                        case "11":
                            if (!agregarOpcionesDF($base, $idPreg, $opciones,$opciones2)) {
                                $base->rollBack();
                                return "<div class='form-group has-error col-md-8'>
                                    <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                    </div>";
                            }
                            break;
                        
                        case "12":
                            if (!agregarOpciones($base, $idPreg, $opciones)) {
                                    $base->rollBack();
                                    return "<div class='form-group has-error col-md-8'>
                                                            <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                            </div>";
                                }  
                            break;
                    }

                    $base->commit();
                    return $idPreg;
                } else {
                    $base->rollBack();
                    return "<div class='form-group has-error col-md-8'>
	                    <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se ha podido cargar la pregunta'>
	                </div>";
                }
            } else {
                $base->rollBack();
                return "<div class='form-group has-error col-md-8'>
	                    <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se ha podido cargar la pregunta'>
	                </div>";
            }
        } else {
            return "<div class='form-group has-error col-md-8'>
                    <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: el nro de pregunta ingresado ya existe'>
                </div>";
        }
    } catch (Exception $e) { // cierro el try de la conexion
        return "<div class='form-group has-error col-md-8'>
                    <input type='text' class='form-control' id='error2' value='Error al conectar a la Base de Datos'>
                </div>";
    }
}

function eliminar($idPreg,$idEncuesta)
{
try{
		$base = new PDOConfig();
		$idEncuesta = $base->filtrar($idEncuesta);
		$idPreg = $base->filtrar($idPreg);
		$base->beginTransaction();
                
                $sql = " DELETE FROM columnaspreguntas WHERE idPregunta=$idPreg";
		//return $sql;
		if(!$res = $base->query($sql))
                {
                  $base->rollBack();
                  return "<div class='form-group has-error col-md-8'>
                        <input type='text' class='form-control' id='error1' readonly='readonly' value='Ha ocurrido un error al intentar eliminar las columnas de la pregunta'>
                                </div>";  
                }
                
		$sql = " DELETE FROM opcionespreguntas WHERE idPregunta=$idPreg";
		//return $sql;
		if($res = $base->query($sql))
		{
			
			$sql = " DELETE FROM preguntasencuestas WHERE idPregunta=$idPreg AND idEncuesta=$idEncuesta";
			//return $sql;
			if($res = $base->query($sql)){
				$base->commit();
				return "1";
			}else
			{
				$base->rollBack();
				return "<div class='form-group has-error col-md-8'>
	                    	<input type='text' class='form-control' id='error1' readonly='readonly' value='Ha ocurrido un error al intentar eliminar la pregunta'>
	                		</div>";
			}
		}else{
			$base->rollBack();
			return "<div class='form-group has-error col-md-8'>
	                    	<input type='text' class='form-control' id='error1' readonly='readonly' value='Ha ocurrido un error al intentar eliminar las opciones de la pregunta'>
	                		</div>";
		
		}
	
	}
	catch (Exception $e){
		return "<div class='form-group has-error col-md-8'>
	                    	<input type='text' class='form-control' id='error1' readonly='readonly' value='Error al conectar a la Base de Datos'>
	                		</div>";
	}
	
}

function datosParaEditar($idPregunta,$idEncuesta){
	
	$datosPreg = verPregunta($idPregunta);
	
	if(!$datosPreg)
		return "0";
	return json_encode($datosPreg);
}

function modificarPregunta($idPregunta,$idTipoPregunta,$pregunta,$opciones,$obligatorio,$columnas,
		$valores,$usuario,$escala,$formato,$vmin,$vmax,$analsis,$opciones2, $diferencial, $ordenOpciones)
{
	try{
		$base = new PDOConfig();	
	
		$pregunta= $base->filtrar($pregunta);
		$obligatorio= $base->filtrar($obligatorio);
				
		if(($escala == "") || ($escala == "-1")) $escala = 'NULL';
		
		if(($formato == "") || ($formato == "-1"))	$formato = 'NULL';
		
		if(($vmin == "")) $vmin = 'NULL'; else $vmin = "'$vmin'";
		
		if(($vmax == "")) $vmax = 'NULL'; else $vmax = "'$vmax'";
                
                if(($diferencial == "")) $diferencial = 'NULL';
		
			$base->beginTransaction();	
		
			$sql = " UPDATE preguntasencuestas SET RespuestaObligatoria=$obligatorio,Texto='$pregunta',"
                               . "Diferencial=$diferencial,incluirAnalisis=$analsis,
                                idEscala = $escala,ValorMinimo = $vmin,ValorMaximo=$vmax,idFormato=$formato
				WHERE idPregunta=$idPregunta";
			//echo $sql;
			if($base->query($sql)){
				
				$sql = " DELETE FROM opcionespreguntas 
							WHERE idPregunta=$idPregunta";
				//echo $sql;
				if(!$base->query($sql)){
					$base->rollBack();
					return "<div class='form-group has-error col-md-8'>
	                    	<input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
	                		</div>";
				}
				
				$sql = " DELETE FROM columnaspreguntas
				WHERE idPregunta=$idPregunta";
				//echo $sql;
				if(!$base->query($sql)){
					$base->rollBack();
					return "<div class='form-group has-error col-md-8'>
	                    	<input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
	                		</div>";
				}
				
				
                                        //echo "dats:".$idTipoPregunta." rerwr".$escala; exit();
					switch($idTipoPregunta){
						case "1":
                                                        if($escala == "1"){
                                                            //print_r($opciones);
                                                            if (!agregarOpciones($base, $idPregunta, $opciones)) 
                                                            {
                                                                $base->rollBack();
                                                                return "<div class='form-group has-error col-md-8'>
                                                                        <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones '>
                                                                        </div>";
                                                            }
                                                        }
                                                        else{
                                                          if (!agregarOpcionesOrden($base, $idPregunta, $opciones,$ordenOpciones)) {
                                                                $base->rollBack();
                                                                return "<div class='form-group has-error col-md-8'>
                                                                                        <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones (orden)'>
                                                                                        </div>";
                                                            }  

                                                        }
                                                            break; 
						case "2":
							if(!agregarOpciones($base,$idPregunta,$opciones))
							{
								$base->rollBack();
								return "<div class='form-group has-error col-md-8'>
	                    		<input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
	                			</div>";
							}
							break;
						case "3":
							if(!agregarOpciones($base,$idPregunta,$opciones))
							{
								$base->rollBack();
								return "<div class='form-group has-error col-md-8'>
	                    		<input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
	                			</div>";
							}
	
							if(!agregarColumnas($base,$idPregunta,$columnas,$valores))
							{
								$base->rollBack();
								return "<div class='form-group has-error col-md-8'>
	                    		<input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
	                			</div>";
							}
							break;
						case "4":
							if(!agregarOpciones($base,$idPregunta,$opciones))
							{
								$base->rollBack();
								return "<div class='form-group has-error col-md-8'>
	                    		<input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
	                			</div>";
							}
	
						if(!agregarColumnas($base,$idPregunta,$columnas,$valores))
						{
							$base->rollBack();
							return "<div class='form-group has-error col-md-8'>
	                    	<input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
	                		</div>";
						}
						break;
						case "5":if(!agregarOpciones($base,$idPregunta,$opciones))
						{
							$base->rollBack();
							return "<div class='form-group has-error col-md-8'>
	                    	<input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
	                		</div>";
						}
	
						if(!agregarColumnas($base,$idPregunta,$columnas,$valores))
						{
							$base->rollBack();
							return "<div class='form-group has-error col-md-8'>
	                    	<input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
	                		</div>";
						}
						break;
						case "7":
							if(!agregarOpciones($base,$idPregunta,$opciones))
							{
								$base->rollBack();
								return "<div class='form-group has-error col-md-8'>
	                    	<input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
	                		</div>";
							}
							break;
                                                
                                                case "11":
                                                    if (!agregarOpcionesDF($base, $idPregunta, $opciones,$opciones2)) {
                                                        $base->rollBack();
                                                        return "<div class='form-group has-error col-md-8'>
                                                            <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                            </div>";
                                                    }
                                                    break;
                                                case "12":                                                    
                                                    if (!agregarOpciones($base, $idPregunta, $opciones)) {
                                                        $base->rollBack();
                                                        return "<div class='form-group has-error col-md-8'>
                                                                                <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se han podido cargar las opciones'>
                                                                                </div>";
                                                    }
                                                    break;
	
					}
	
					$base->commit();
					return $idPregunta;
						
				}else{
					$base->rollBack();
					return "<div class='form-group has-error col-md-8'>
	                    <input type='text' class='form-control' id='error1' readonly='readonly' value='Error: no se ha podido editar la pregunta'>
	                </div>" ;
				}
		
	}catch (Exception $e){ // cierro el try de la conexion
            return "<div class='form-group has-error col-md-8'>
                <input type='text' class='form-control' id='error2' value='Error al conectar a la Base de Datos'>
            </div>" ;
	}
	
	
}


function listadoXPaginas($idPagina, $analisis){
	$textPreguntas="";
	$datos = preguntasXPagina($idPagina,$analisis);
	//print_r($datos);exit;
	if($datos != "0"){		
		foreach ($datos as $d){			
                    $textPreguntas .= "<div class='box-inner'>
                                    <div class='box-header well'><h6>".$d["NroPregunta"].". ".$d["Texto"]."</h6></div>
                                    <div class='box-content'><div class='row'><div class='col-md-6' id='preguntas1".$d["idPregunta"]."'></div>"
                                . " <div id='preguntas2".$d["idPregunta"]."' class='col-md-6'>&nbsp;</div></div>"
                            . "<div class='row interpre'>&nbsp;</div><div class='row interpre'>"
                            . "<div class='col-md-10'>
                                <div class='form-group'>
                                    <label class='text-left' for='txtInterpretacion".$d["idPregunta"]."'>Interpretaci&oacute;n:</label>
                                    <textarea class='form-control input-sm' id='txtInterpretacion".$d["idPregunta"]."'
                                              name='txtInterpretacion".$d["idPregunta"]."' ></textarea>
                                </div></div><div class='col-md-2'><br /><br /><button id='btnGuardar' class='btn btn-primary' onclick=\"guardarInterpretacion('".$d["idPregunta"]."');\"><i class='glyphicon glyphicon-ok'></i></button></div>"
                            . "</div>"
                            . "</div></div>"
                            . "<div class='row'>&nbsp;</div>";
				
		}
		
		return $textPreguntas;
	}else{
		return "0";
	}
}

function mostrarPaginas($idEncuesta,$analisis){
	
        if(consultarCantRespuestas($idEncuesta) <= 0)
        {
            return "-1";
        }   
        
        $paginas = paginaXEncuesta($idEncuesta);
	$textPagina ="";
        
	if($paginas != "0"){		
		foreach ($paginas as $p){
			$textPagina .="<div class='row'>
			 <div class='box col-md-12'>";
                        if($p["Titulo"] !=""){ 
                        $textPagina .=" <h3><small>".$p["NroPagina"].".".$p["Titulo"]."</small></h3>";
                        }
			$textPagina .="<div class='box-inner'><div class='box-content'><div class='row'>
			 <div class='col-md-12' id='paginas".$p["idPagina"]."'>";
			
                         $dPreg = listadoXPaginas($p["idPagina"],$analisis);
                        
			if($dPreg != "0"){
				$textPagina.=$dPreg;
			}			
			$textPagina .="</div></div></div></div></div></div>";
		}
		return $textPagina;
	}else{
		return "0";
	}
}


function preguntasXEnc($idEncuesta){
	$datos = preguntasXEncuesta($idEncuesta);
	if($datos != "0"){		
		return json_encode($datos);
	}else{
		return "0";
	}
}

function comboXEscala($default, $selected, $idEncuesta){
try {
        $datos = preguntasXEncuestaEscala($idEncuesta);
	if($datos != "0"){
            $Listcombo = "<option value=''>$default</option>";
	 foreach ($datos as $row) {
         
            if ($row["idPregunta"] == $selected) {
                $Listcombo .= "<option value='" . $row["idPregunta"] . "' selected='selected'>" .$row["NroPregunta"].".".$row["Texto"] . "</option>";
            } else {
                $Listcombo .= "<option value='" . $row["idPregunta"] . "' >" .$row["NroPregunta"].".".$row["Texto"] . "</option>";
            }
        }
        return $Listcombo;
	}else{
            return "";
	}
    } catch (Exception $e) {
        return "";
    }
}

function comboParaAnalisis($default, $selected,$idEncuesta){
    try {
        $datos = preguntasXEncuestaAn($idEncuesta);
	if($datos != "0"){
            $Listcombo = "<option value=''>$default</option>";
	 foreach ($datos as $row) {
         
            if ($row["idPregunta"] == $selected) {
                $Listcombo .= "<option value='" . $row["idPregunta"] . "' selected='selected'>" .$row["NroPregunta"].". ".$row["Texto"] . "</option>";
            } else {
                $Listcombo .= "<option value='" . $row["idPregunta"] . "' >" .$row["NroPregunta"].".".$row["Texto"] . "</option>";
            }
        }
        return $Listcombo;
	}else{
            return "";
	}
    } catch (Exception $e) {
        return "";
    }
}

function comboLikert($default, $selected, $idEncuesta){
try {
        $datos = preguntasLikert($idEncuesta);
	if($datos != "0"){
            $Listcombo = "<option value=''>$default</option>";
	 foreach ($datos as $row) {
         
            if ($row["idPregunta"] == $selected) {
                $Listcombo .= "<option value='" . $row["idPregunta"] . "' selected='selected'>" .$row["NroPregunta"].".".$row["Texto"] . "</option>";
            } else {
                $Listcombo .= "<option value='" . $row["idPregunta"] . "' >" .$row["NroPregunta"].".".$row["Texto"] . "</option>";
            }
        }
        return $Listcombo;
	}else{
            return "";
	}
    } catch (Exception $e) {
        return "";
    }
}

function comboNominales($default, $selected, $idEncuesta){
try {
        $datos = preguntasNominales($idEncuesta);
	if($datos != "0"){
            $Listcombo = "<option value=''>$default</option>";
	 foreach ($datos as $row) {
         
            if ($row["idPregunta"] == $selected) {
                $Listcombo .= "<option value='" . $row["idPregunta"] . "' selected='selected'>" .$row["NroPregunta"].".".$row["Texto"] . "</option>";
            } else {
                $Listcombo .= "<option value='" . $row["idPregunta"] . "' >" .$row["NroPregunta"].".".$row["Texto"] . "</option>";
            }
        }
        return $Listcombo;
	}else{
            return "";
	}
    } catch (Exception $e) {
        return "";
    }
}


function comboOpciones($default, $selected, $idPregunta){
try {
        $datos = OpcionesPregunta($idPregunta);
	if($datos != "0"){
            $Listcombo = "<option value=''>$default</option>";
	 foreach ($datos as $row) {         
                $Listcombo .= "<option value='" . $row["idOpcion"] . "' >" .$row["Texto"]."</option>";
            }
        return $Listcombo;
	}else{
            return "";
	}
    } catch (Exception $e) {
        return "";
    }
}


function verEscala($idPregunta){
    try
    {
        $datos = verSoloPregunta($idPregunta);
	if($datos != "0"){
            return $datos["idEscala"];
        }else{
            return "0";
	}
    } catch (Exception $e) {
        return "0";
    }
}

function analisisPorPeriodo($idEncuesta,$idPregunta){
   try
    {
        $salida = "";
        $datosPer = verPeriodosPorEncuesta($idEncuesta);
	if($datosPer != "0"){
            foreach ($datosPer as $per)
            {
                $fechaFin = "";
                if($per["FechaFin"] != ""){
                    $fechaFin = " - ".formatFecha($per["FechaFin"]);
                }
                $enc = $per["Titulo"]." (".formatFecha($per["FechaInicio"]).$fechaFin.")";
                $salida .= "<div class='row'>
                            <div class='box col-md-12'>
                            <div class='box-inner'>
                            <div class='box-header well'><h2>".$enc."</h2></div><div class='box-content'>";
                
                $datosPreg = verSoloPregunta($idPregunta);
                if($datosPer != "0"){
                    $salidaDiv1 ="";
                    $salidaDiv2 = "";
                    switch($datosPreg["idTipoPregunta"])
                    {
                        /*<div class='row'><div class='col-md-6' id='preguntas1".$d["idPregunta"]."'></div><div id='preguntas2".$d["idPregunta"]."' class='col-md-6'>&nbsp;</div></div>
                         * */
                         
                        case "1":
                        case "12":
                        case "2":
                            $datosRespAn = res_OpMultiplesPeriodo($idPregunta, $per["idPeriodo"],$datosPreg["idEscala"]);
                            //print_r($datosRespAn);exit();
                            if($datosRespAn)
                            {
                                if($datosPreg["idEscala"] == "1"){
                                    $salidaDiv1 .= "<table  class='table datatable table-bordered'><tr><th rowspan='2'>Opci&oacute;n</th>"
                                                ."<th colspan='2'>Respuestas</th></tr><tr><th>Frecuencia</th><th>Frecuencia Relativa</th></tr>";
                                                   
                                    for($j=0;$j< Count($datosRespAn["frecuencias"][0]);$j++)
                                    {
                                        $salidaDiv1 .= "<tr><td>".$datosRespAn["frecuencias"][0][$j]."</td><td>".$datosRespAn["frecuencias"][1][$j]."</td><td>"
                                                 .$datosRespAn["frecuencias"][2][$j]." %</td></tr>";
                                    }
                                    $salidaDiv1 .= "<tr><th colspan='3'>MODA: ".$datosRespAn["modo"]." </th></tr></table>";
                                }
                                else
                                {
                                    $textos="";
                                    $porcentajes="";
                                    $ordenes="";
                                    $cuartiles="";                                                    
                                    if($datosPreg["idEscala"] == "2"){
                                        $salidaDiv1 .= "<table  class='table datatable table-bordered'>"
                                                . "<tr><th colspan='3'>Referencias</th></tr><tr><td>"
                                                . "<table  class='table datatable table-bordered'>";                                                
                                        for ($f=0;$f<Count($datosRespAn["referencias"]);$f++)
                                        {
                                            $textos .= "<td>".$datosRespAn["referencias"][$f]["label"]."</td>";
                                            $ordenes .= "<td>".$datosRespAn["referencias"][$f]["Orden"]."</td>";
                                        }
                                        $salidaDiv1 .= "<tr><td>&nbsp;</td>$textos</tr><tr><td>Orden</td>$ordenes</tr></table></td></tr>".
                                                 "<tr><th colspan='3'>MODA: ".$datosRespAn["modo"]." </th></tr>".
                                                 "<tr><th colspan='3'>MEDIANA: ".$datosRespAn["mediana"]." </th></tr>".
                                                 "<tr><td><table class='table datatable table-bordered'><tr><th colspan='3'>Quartiles</th></tr>";

                                        for ($q=0;$q<Count($datosRespAn["cuartiles"][0]);$q++)
                                        {
                                            $porcentajes .= "<td>".$datosRespAn["cuartiles"][0][$q]."</td>";
                                            $cuartiles .= "<td>".$datosRespAn["cuartiles"][1][$q]."</td>";
                                        } 
                                        $salidaDiv1.="<tr>$porcentajes</tr><tr>$cuartiles</tr></table></td></tr></table>";
                                    }
                                }
                                $salida .="<div class='row'><div class='col-md-6' id='preguntas1'><div class='col-md-10'>"
                                        . "<a href='Datos/img/".$datosRespAn["grafico"]."' target='_blank' title='Click para descargar'>"
                                        . "<img class='img-responsive' src='Datos/img/".$datosRespAn["grafico"]."' alt='Distribucion de Frecuencias' /></a></div></div>"
                                        . "<div id='preguntas2' class='col-md-6'>$salidaDiv1</div></div>";
                            }
                            break;
                            case "3":
                            case "4":
                                $datosRespAn = res_matricesPeriodo($idPregunta, $per["idPeriodo"]);
                                $salida .="<div class='row'><div class='col-md-6' style='min-height:200px;' id='preguntas1'>"
                                        . "<div class='col-md-10'><a href='Datos/img/".$datosRespAn["grafico"]."' target='_blank' title='Click para descargar'><img class='img-responsive' src='Datos/img/".$datosRespAn["grafico"]."' alt='Distribucion de Frecuencias' /></a></div></div>"
                                        . "<div id='preguntas2' class='col-md-6'>".$datosRespAn["tabla"]."</div></div>";
                            
                                break;
                            case "6":
                            case "8":
                                if($datosPreg["idFormato"] == "1")
                                    $rta=res_NubeTextoPeriodo($idPregunta,$per["idPeriodo"]);
                                else
                                    $rta=res_AnTextoEscalasPeriodo($idPregunta,$datosPreg["idEscala"],$per["idPeriodo"]);
                                
                                if(($datosPreg["idEscala"] == "2") || ($datosPreg["idEscala"] == "3") || ($datosPreg["idEscala"] == "4"))
                                {
                                    $salidaDiv1 .="<table  class='table datatable table-bordered'>";
                                    for ($f=0;$f<Count($rta["summary"][0]);$f++)
                                    {
                                        $salidaDiv1 .= "<tr><td><b>".$rta["summary"][0][$f].": <b></td><td>".$rta["summary"][1][$f]."</td></tr>";
                                    }
                                    $salidaDiv1 .= "<tr><td><b>Varianza:</b></td><td>".$rta["varianza"]."</td></tr>";
                                    $salidaDiv1 .= "<tr><td><b>Desvio estandar:</b></td><td>".$rta["desvioEst"]."</td></tr>";
                                    $salidaDiv1 .= "</table>";
                                    $salida .="<div class='row'><div class='col-md-6' id='preguntas1'><div class='col-md-10'>
                                        <a href='Datos/img/".$rta["grafico"]."' target='_blank' title='Click para descargar'>
                                            <img class='img-responsive' src='Datos/img/".$rta["grafico"]."' alt='Grafico de Cajas' /></a></div></div>"
                                        . "<div id='preguntas2' class='col-md-6'>$salidaDiv1</div></div>";
                                    
                                }else{
                                    $salida .="<div class='row'><div class='col-md-6 nube' style='min-height:200px' id='preguntas1'></div>"
                                            . "<div id='preguntas2' class='col-md-6'><div class='col-md-10'>&nbsp;</div></div></div>"
                                            . " <script>\$('.nube').jQCloud(".$rta.");</script>";
                                    
                                }
                                break;
                           
                            case "11":
                                $datosRespAn = res_AnDiferencialSemantico($idPregunta, $per["idPeriodo"]);
                                $salida .="<div class='row'><div class='col-md-6' id='preguntas1'>".$datosRespAn."</div>"
                                        . "<div id='preguntas2' class='col-md-6'>&nbsp;</div></div>";
                            
                                break;    
                                
                                
                    
                }
                
                
                $salida .= "</div></div></div></div><div class='row'>&nbsp;</div>";
            }else{
                return "";
            }
            
            }
            return $salida;
        }else{
            return "";
	}
    } catch (Exception $e) {
        return "<div class='form-group has-error col-md-8'>
                <input type='text' class='form-control' id='error2' value='Error al conectar a la Base de Datos'>
            </div>" ;
    }
    
}

function diferencialSemantico($idEncuesta,$idPeriodo)
{
    
}

function cargarInterpretacion($idPregunta,$texto)
{
    try {
        $base = new PDOConfig();
        $idPregunta = $base->filtrar($idPregunta);
        $texto = $base->filtrar($texto);

        $sql = " UPDATE preguntasencuestas SET Interpretacion = '$texto' WHERE idPregunta = $idPregunta";
        //return $sql;
        if ($res = $base->query($sql)) {            
            return "1";
        } else {
            return "0";
        }
    } catch (Exception $e) {
        return "0";
    }
}

if($_POST)
{
	$rta="";
	try{
		$oper = $_POST['oper'];

		switch ($oper){
		
                        case 'comboPreg': $default = $_POST['vdefaul'];
                                        $selected = $_POST["selected"];
                                        $idEncuesta = $_POST["idEncuesta"];
                                        $rta = comboXEscala($default, $selected,$idEncuesta);
                                        break;
                                    
                        case 'comboPregAn': $default = $_POST['vdefaul'];
                                        $selected = $_POST["selected"];
                                        $idEncuesta = $_POST["idEncuesta"];
                                        $rta = comboParaAnalisis($default, $selected,$idEncuesta);
                                        break;
                                    
                        case 'comboPregLikert': $default = $_POST['vdefaul'];
                                        $selected = $_POST["selected"];
                                        $idEncuesta = $_POST["idEncuesta"];
                                        $rta = comboLikert($default, $selected,$idEncuesta);
                                        break;
                        
                        case 'comboPregNom': $default = $_POST['vdefaul'];
                                        $selected = $_POST["selected"];
                                        $idEncuesta = $_POST["idEncuesta"];
                                        $rta = comboNominales($default, $selected,$idEncuesta);
                                        break;  
                                    
                        case 'comboOpcionesPreg':
                                        $default = $_POST['vdefaul'];
                                        $selected = $_POST["selected"];
                                        $idPregunta = $_POST["idPregunta"];
                                        $rta = comboOpciones($default, $selected, $idPregunta);
                                        break; 
                         
                        case 'OpcionesPreg':
                                        $idPregunta = $_POST["idPregunta"];
                                        $datos = OpcionesPregunta($idPregunta);
                                        $rta = json_encode($datos);
                                        break;            
                                    
			case 'nueva': 	
                                        $usuario = $oLogin->getIdUsuario();
                                        $idEncuesta=$_POST["hdIdEncP"];
                                        $idPagina=$_POST["pagina"];
                                        $nroPregunta= $_POST['txtNroPreg'];
                                        $tipoPregunta= $_POST["cbTipoPregunta"];
                                        $pregunta= $_POST["txtPregunta"];
                                        $escala= $_POST["cbEscala"];
                                        $formato= $_POST["cbFormato"];
                                        $vmin= $_POST["txtMin"];
                                        $vmax= $_POST["txtMax"];
                                        $diferencial= $_POST["cbDiferenciales"];
							
                                        if($tipoPregunta == "10"){
                                                $rta=nuevaPregunta($idEncuesta, $idPagina, $nroPregunta, "6", "Apellido",
                                                                "","1","","",$usuario,"","1","","","0");
                                                $rta=nuevaPregunta($idEncuesta, $idPagina, $nroPregunta, "6", "Nombre",
                                                                "","1","","",$usuario,"","1","","","0");
                                                $rta=nuevaPregunta($idEncuesta, $idPagina, $nroPregunta, "6", "Nacionalidad",
                                                                "","1","","",$usuario,"","1","","","1");
                                                $rta=nuevaPregunta($idEncuesta, $idPagina, $nroPregunta, "6", "Estado/Provincia",
                                                                "","1","","",$usuario,"","1","","","1");
                                                $rta=nuevaPregunta($idEncuesta, $idPagina, $nroPregunta, "6", "Localidad",
                                                                "","1","","",$usuario,"","1","","","1");
                                                $rta=nuevaPregunta($idEncuesta, $idPagina, $nroPregunta, "6", "Domicilio",
                                                                "","1","","",$usuario,"","1","","","0");
                                        }else{

                                        if(isset($_POST['opcionPregunta']))
                                        {
                                                $opciones= $_POST['opcionPregunta'];
                                        }else{
                                                $opciones = "";
                                        }

                                        if(isset($_POST['columnasPregunta']))
                                        {
                                                $columnas = $_POST['columnasPregunta'];
                                        }else{
                                                $columnas = "";
                                        }

                                        if(isset($_POST['valorPregunta']))
                                        {
                                                $valores = $_POST['valorPregunta'];
                                        }else{
                                                $valores = "";
                                        }

                                        if(isset($_POST['OrdenOpcion']))
                                        {
                                                $ordenOpciones = $_POST['OrdenOpcion'];
                                        }else{
                                                $ordenOpciones = "";
                                        }

                                        if(isset($_POST['opcion2Pregunta']))
                                        {
                                                $opciones2 = $_POST['opcion2Pregunta'];
                                        }else{
                                                $opciones2 = "";
                                        }

                                        if(isset($_POST["chRespObligatoria"]))
                                                $obligatorio = 1;
                                        else
                                                $obligatorio = 0;

                                        if(isset($_POST["chAnalisis"]))
                                                $analsis = 1;
                                        else
                                                $analsis = 0;

                                        if($tipoPregunta == 1)
                                        {
                                          if(isset($_POST['chOrdenarOp'])){
                                              $escala = "2"; 
                                          } else{
                                              $escala = "1"; 
                                          } 
                                        }else{
                                            if(($tipoPregunta == 2) || ($tipoPregunta == 4))
                                            {
                                                $escala = "1"; 
                                            }else{
                                                if($tipoPregunta == 3){
                                                    $escala = "2";
                                                }
                                                if($tipoPregunta == 12){
                                                    $escala = "1";
                                                }
                                                if($tipoPregunta == 6 || $tipoPregunta == 7 || $tipoPregunta == 8){
                                                    if($formato == "" || $formato == "-1"){
                                                        $formato = "1";
                                                    }else{
                                                       if($formato == "" || $formato == "-1"){
                                                           
                                                       }  
                                                        
                                                    }
                                                    
                                                    if($tipoPregunta == 8){
                                                        $escala = "1";
                                                    }
                                                }
                                            }
                                        }

                                        $rta=nuevaPregunta($idEncuesta, $idPagina, $nroPregunta, $tipoPregunta, $pregunta, 
                                                $opciones,$obligatorio,$columnas,$valores,$usuario,$escala,$formato,
                                                $vmin,$vmax,$analsis,$opciones2,$diferencial,$ordenOpciones);
                                        }
                                        break;
			
			case 'eliminar':$idEncuesta=$_POST["idEncuesta"];
                                        $idPregunta=$_POST["idPregunta"];
                                        $rta=eliminar($idPregunta,$idEncuesta);
                                        break;
				 			
			case 'editar':$idEncuesta=$_POST["idEncuesta"];
                                    $idPregunta=$_POST["idPregunta"];
                                    $rta=datosParaEditar($idPregunta,$idEncuesta);
                                    break;
				 			
			case 'modificarPregunta': 	
                                        $usuario = $oLogin->getIdUsuario();
                                        $idPregunta=$_POST["hdIdPregModif"];
                                        $pregunta= $_POST["txtPreguntaM"];
                                        $TipoPregunta= $_POST["hdIdTipoPreg"];
                                        $escala= $_POST["cbEscalaM"];
                                        $formato= $_POST["cbFormatoM"];
                                        $vmin= $_POST["txtMinM"];
                                        $vmax= $_POST["txtMaxM"];
                                        $diferencial= $_POST["cbDiferencialesM"];
                                        
                                        if(isset($_POST['opcionPregunta']))
                                        {
                                                $opciones= $_POST['opcionPregunta'];
                                        }else{
                                                $opciones = "";
                                        }

                                        if(isset($_POST['columnasPregunta']))
                                        {
                                                $columnas = $_POST['columnasPregunta'];
                                        }else{
                                                $columnas = "";
                                        }

                                        if(isset($_POST['valorPregunta']))
                                        {
                                                $valores = $_POST['valorPregunta'];
                                        }else{
                                                $valores = "";
                                        }
				 				
                                        if(isset($_POST["chRespObligatoriaM"]))
                                                $obligatorio = 1;
                                        else
                                                $obligatorio = 0;

                                        if(isset($_POST["chAnalisisM"]))
                                                $analsis = 1;
                                        else
                                                $analsis = 0;

                                        if(isset($_POST['OrdenOpcion']))
                                        {
                                                $ordenOpciones = $_POST['OrdenOpcion'];
                                        }else{
                                                $ordenOpciones = "";
                                        }

                                        if(isset($_POST['opcion2Pregunta']))
                                        {
                                                $opciones2 = $_POST['opcion2Pregunta'];
                                        }else{
                                                $opciones2 = "";
                                        }
                                        
                                        
                                        if($TipoPregunta == 1)
                                        {
                                          if(isset($_POST['chOrdenarOpM'])){
                                              $escala = "2"; 
                                          } else{
                                              $escala = "1"; 
                                          } 
                                        }else{
                                           if(($TipoPregunta == 2) || ($TipoPregunta == 4))
                                            {
                                                $escala = "1"; 
                                            }else{
                                                if($TipoPregunta == 3){
                                                    $escala = "2";
                                                }
                                                
                                                if($TipoPregunta == 12){
                                                    $escala = "1";
                                                }
                                                
                                                if($TipoPregunta == 6 || $TipoPregunta == 7 || $TipoPregunta == 8){
                                                    if($formato == "" || $formato == "-1"){
                                                        $formato = "1";
                                                    }
                                                    if($TipoPregunta == 8){
                                                        $escala = "1";
                                                    }
                                                }
                                                
                                            }
                                        }
                                        
                                        /* //$rta = "Tipo:".$tipoPregunta."  Escala ". $escala;
                                        print_r($_POST);*/
                                       $rta=modificarPregunta($idPregunta,$TipoPregunta,$pregunta,$opciones,$obligatorio,
                                        $columnas,$valores,$usuario,$escala,$formato,$vmin,$vmax,$analsis,$opciones2,$diferencial,$ordenOpciones);
                                        
                                        break;
			case 'ordenarPreguntas':
                                            $idEncuesta=$_POST["idEncuesta"];
                                            $lista=$_POST["lista"];
                                            $rta=ordenarPreguntas($idEncuesta, $lista);
                                            break;
			case 'pregXPagAn': $idEncuesta=$_POST["idEncuesta"];
					   $rta=mostrarPaginas($idEncuesta,true);
						break;
				 			
			case 'listaXenc': $idEncuesta=$_POST["idEncuesta"];
                                        $rta=preguntasXEnc($idEncuesta);
                                        break;
                                    
			case 'verEscala':
                                        $idPregunta=$_POST["idPregunta"];
                                        $rta=verEscala($idPregunta);
                                        break;
                                        
			case 'anPregOpciones':
                                        $idPregunta =$_POST["idPregunta"];
                                        $idEscala =$_POST["idEscala"];
                                        $rta = res_OpMultiples($idPregunta,$idEscala);
                                        break;
                        case 'anPregMatriz':
                                        $idPregunta =$_POST["idPregunta"];
                                        $rta = res_matrices($idPregunta);
                                        break;
			case 'anPregTexto':
                                    $idPregunta=$_POST["idPregunta"];
                                    $idEscala =$_POST["idEscala"];
                                    $idFormato =$_POST["idFormato"];

                                    if($idFormato == "1")
                                        $rta=res_NubeTexto($idPregunta);
                                    else
                                        $rta=res_AnTextoEscalas($idPregunta,$idEscala);
                                    break;
                        case 'anDifSem':
                                    $idPregunta=$_POST["idPregunta"];
                                    $rta=res_AnDiferencialSemantico($idPregunta,"0");
                                     break;   
                        case 'anCorrelacion':
                                    $idPregunta1=$_POST["cbPregunta1"];
                                    $idPregunta2 =$_POST["cbPregunta2"];
                                    $metodo =$_POST["cbMetodo"];
                                    $rta=res_AnCorrelacion($idPregunta1,$idPregunta2,$metodo);
                                    break;
			
                        case 'anLikert':
                                    $idPreguntaLikert=$_POST["cbLikert"];
                                    $idOpcionLikert =$_POST["cbOpcionLikert"];
                                    $idgrupo =$_POST["cbGrupo"];
                                    $metodo =$_POST["txtMetodo"];
                                    $rta=res_AnLikert($idPreguntaLikert,$idOpcionLikert,$idgrupo,$metodo);
                                    break;                    
                        
                        case 'cantResp':             
                                        $idEncuesta=$_POST["idEncuesta"];
                                        $rta= consultarCantRespuestas($idEncuesta);
                                        break;
                                    
                        case 'anPregXPeriodo':
                                        $idEncuesta=$_POST["idEncuesta"];
                                        $idPregunta=$_POST["idPregunta"];
                                        $rta= analisisPorPeriodo($idEncuesta,$idPregunta);
                                        break;
                                    
                        case 'cargaInterp':   
                                        $idPregunta=$_POST["idPregunta"];
                                        $texto=$_POST["Texto"];
                                        $rta= cargarInterpretacion($idPregunta,$texto);
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
