<?php
header('Content-type: text/html; charset=utf-8');
require_once("../libs/class.phpmailer.php");
require_once('../libs/PDOConfig.php');
require_once('utilidades.php');
require_once('parametros.php');
require_once("../libs/Login.php");

require_once("../Datos/modeloRespuestas.php");
require_once("../Datos/modeloEncuestas.php");
require_once("../Datos/modeloPaginas.php");
require_once("../Datos/modeloPreguntas.php");



function combo($default, $selected,$usuario) {
    try {
        $base = new PDOConfig();
        $filtro = "";
        if($usuario != "")
        {
            $filtro = " WHERE idUsuario = $usuario ";
        }
        
        $sql = "SELECT idEncuesta, Titulo
		FROM encuestas $filtro
		ORDER BY idEncuesta ";

        $res = $base->query($sql);
        $Listcombo = "<option value=''>$default</option>";

        foreach ($res as $row) {
            if ($row["idTema"] == $selected) {
                $Listcombo .= "<option value='" . $row["idEncuesta"] . "' selected='selected'>" . $row["Titulo"] . "</option>";
            } else {
                $Listcombo .= "<option value='" . $row["idEncuesta"] . "' >" . $row["Titulo"] . "</option>";
            }
        }
        echo $Listcombo;
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>";
    }
}

function comboPeriodos($default, $selected,$idEncuesta) {
    try {
        $periodos = verPeriodosPorEncuesta($idEncuesta);
        
        $Listcombo = "<option value='' selected='selected'>$default</option>";
        foreach ($periodos as $row) {
            $desc = $row["Titulo"]." (".formatFecha($row["FechaInicio"])." - ".formatFecha($row["FechaFin"]).")";
            if ($row["idPeriodo"] == $selected) {
                $Listcombo .= "<option value='" . $row["idPeriodo"] . "' selected='selected'>$desc</option>";
            } else {
                $Listcombo .= "<option value='" . $row["idPeriodo"] . "' >$desc</option>";
            }
        }
        echo $Listcombo;
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
    				Error al consultar la base de datos</div>";
    }
}

function ver_OpMultipleUnaOpcion($idPregunta) {
    try {
        $base = new PDOConfig();
        $salOp = "";

        $sqlOP = " SELECT O.idOpcion,O.idPregunta,O.Texto,P.RespuestaObligatoria,P.idFormato
		FROM opcionespreguntas O INNER JOIN preguntasencuestas P ON O.idPregunta = P.idPregunta WHERE O.idPregunta = $idPregunta ORDER BY Orden";
        //echo $sql;
        if ($resOP = $base->query($sqlOP)) {
            foreach ($resOP as $op) {
                $obl="";
                if($op["RespuestaObligatoria"] == "1")
                {
                   $obl ="class='validate[required]'";
                }
                
                $salOp .= " <div class='radio'>
                <label>
                  <input type='radio' $obl id='respuestas[$idPregunta]' name='respuestas[$idPregunta]' value='" . $op["idOpcion"] . "'>
                  " . $op["Texto"] . "
                    </label>
                  </div>";
                
              /*  $salOp .= "<div class='row'>
                    <div class='col-md-1' >
                        <input type='radio' $obl id='respuestas[$idPregunta]' name='respuestas[$idPregunta]' value='" . $op["idOpcion"] . "'>
                    </div>
                    <div class='col-md-8'>
                    " . $op["Texto"] . "
                      </div>
                    </div>";*/
            }
            return $salOp;
        } else {
            return "";
        }
    } catch (Exception $e) {
        return "";
    }
}

function ver_OpMultipleVariasOpcion($idPregunta)
{
	try{
		$base = new PDOConfig();
		$salOp = "";

		$sqlOP = " SELECT O.idOpcion,O.idPregunta,O.Texto,P.RespuestaObligatoria,P.idFormato
		FROM opcionespreguntas O INNER JOIN preguntasencuestas P ON O.idPregunta = P.idPregunta WHERE O.idPregunta = $idPregunta";
		//echo $sql;
		if($resOP = $base->query($sqlOP)){
			foreach ($resOP as $op)
			{
                            $obl="";
                            if($op["RespuestaObligatoria"] == "1")
                            {
                               $obl ="class='validate[required]'";
                            }
                
                            $salOp .= "<div class='checkbox'>
                                <label>
                                  <input type='checkbox' $obl id='respuestas[$idPregunta][]' name='respuestas[$idPregunta][]' value='".$op["idOpcion"]."' >
                                  ".$op["Texto"]."
                                </label>
                              </div>";
                            
                            
                            /*$salOp .= "<div class='row'>
                            <div class='col-md-1 center-text'>
                                <input type='checkbox' $obl id='respuestas[$idPregunta][]' name='respuestas[$idPregunta][]' value='".$op["idOpcion"]."' >
                            </div>
                            <div class='col-md-8'>
                            ".$op["Texto"]."
                            </div></div>";*/
			}
			return 	$salOp;
		}else{
			return "" ;
		}
	}
	catch (Exception $e){
		return "" ;
	}
}


function ver_OpDiferencialSemantico($idPregunta,$diferencial) {
    try {
        $base = new PDOConfig();
        $salOp = "";

        $sqlOP = " SELECT O.idOpcion,O.idPregunta,O.Texto,O.Texto2,P.RespuestaObligatoria,P.idFormato
		FROM opcionespreguntas O INNER JOIN preguntasencuestas P ON O.idPregunta = P.idPregunta WHERE O.idPregunta = $idPregunta";
        //return $sqlOP;
        if ($resOP = $base->query($sqlOP)) {
            
//            $salOp .= "<div class='table-responsive'>
//                    <table class='table'><thead><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></thead><tbody>";
            foreach ($resOP as $op) {
                $obl="";
                if($op["RespuestaObligatoria"] == "1")
                {
                   $obl ="class='validate[required]'";
                }
//                $salOp .= "<tr><td> " . $op["Texto"] . "</td><td class='text-center'>";
//                for($i=1;$i<=$diferencial;$i++){
//                  $salOp .= "<input type='radio' title='$i' $obl id='respuestas[$idPregunta][" . $op["idOpcion"] . "]' name='respuestas[$idPregunta][" . $op["idOpcion"] . "]' value='$i'>&nbsp;&nbsp;&nbsp;&nbsp;"; 
//                }
//                
//                $salOp .= "</td><td class='text-right'> " . $op["Texto2"] . "</td></tr>";    
               
                
                $salOp .= "<div class='row'>
                            <div class='col-xs-6 col-md-3'>
                            " . $op["Texto"] . "
                            </div><div class='col-xs-6 col-md-3'>";
                for($i=1;$i<=$diferencial;$i++){
                   $salOp .= "<input type='radio' title='$i' $obl id='respuestas[$idPregunta][" . $op["idOpcion"] . "]' name='respuestas[$idPregunta][" . $op["idOpcion"] . "]' value='$i'>&nbsp;&nbsp;&nbsp;&nbsp;"; 
                }                
                $salOp .= "</div><div class='col-xs-6 col-md-3 text-right'>
                            " . $op["Texto2"] . "
                            </div>
                        </div>";
            }
//            $salOp .= "</tbody></table>
//                    </div>";
            
            return $salOp;
        } else {
            return "";
        }
    } catch (Exception $e) {
        return "";
    }
}

function ver_escalaValoracion($idPregunta) {
    try {
        $base = new PDOConfig();
        $salOp = "";
        $colsR = "";

        $sqlCol = " SELECT idColumna,idPregunta,Ponderacion,Texto
		FROM columnaspreguntas WHERE idPregunta = $idPregunta";
        $resCol = $base->query($sqlCol);

        if ($resCol) {
            $columnas = $resCol->fetchAll(PDO::FETCH_ASSOC);
            $salOp .= "<div class='row'><div class='col-md-12'><table class='table table-bordered table-striped '>
					<thead><tr><th>&nbsp;</th>";

            foreach ($columnas as $col) {
                $salOp .="<th>" . $col["Texto"] . " (" . $col["Ponderacion"] . ")</th>";
            }
        } else {
            return "";
        }

        $salOp .= "</tr></thead><tbody>";

        $sqlOP = " SELECT O.idOpcion,O.idPregunta,O.Texto,P.RespuestaObligatoria,P.idFormato
		FROM opcionespreguntas O INNER JOIN preguntasencuestas P ON O.idPregunta = P.idPregunta WHERE O.idPregunta = $idPregunta";
        //echo $sql;
        if ($resOP = $base->query($sqlOP)) {
            foreach ($resOP as $op) {                
                $obl="";
                if($op["RespuestaObligatoria"] == "1")
                {
                   $obl ="class='validate[required]'";
                }
                $salOp .= "<tr><td><strong>" . $op["Texto"] . "</strong></td>";

                for ($i = 0; $i < count($columnas); $i++) {
                    $col = $columnas[$i]; //class='validate[required]'
                    $salOp .= "<td class='center-text'>
					<input type='radio' $obl name='respuestas[$idPregunta][" . $op["idOpcion"] . "]'
					id='respuestas[$idPregunta][" . $op["idOpcion"] . "]' value='" . $col["idColumna"] . "' /></td>";
                }

                $salOp .= "</tr>";
            }

            $salOp .= "</tbody></table></div></div>";
            return $salOp;
        } else {
            return "";
        }
    } catch (Exception $e) {
        return "";
    }
}

function ver_matrizUnaResp($idPregunta) {
    try {
        $base = new PDOConfig();
        $salOp = "";
        $colsR = "";
        $sqlCol = " SELECT idColumna,idPregunta,Texto
		FROM columnaspreguntas WHERE idPregunta = $idPregunta";
        $resCol = $base->query($sqlCol);

        if ($resCol) {
            $columnas = $resCol->fetchAll(PDO::FETCH_ASSOC);
            $salOp .= "<div class='row'>
					<div class='col-md-12'>
					<table class='table table-bordered table-striped table-condensed'>
					<thead><tr><th>&nbsp;</th>";

            foreach ($columnas as $col) {
                $salOp .="<td class='center-text' >" . $col["Texto"] . "</td>";
            }
        } else {
            return "";
        }

        $salOp .= "</tr></thead><tbody>";

        $sqlOP = " SELECT O.idOpcion,O.idPregunta,O.Texto,P.RespuestaObligatoria,P.idFormato
		FROM opcionespreguntas O INNER JOIN preguntasencuestas P ON O.idPregunta = P.idPregunta WHERE O.idPregunta = $idPregunta";
        //echo $sql;
        if ($resOP = $base->query($sqlOP)) {
            foreach ($resOP as $op) {
                
                 $obl="";
                if($op["RespuestaObligatoria"] == "1")
                {
                   $obl ="class='validate[required]'";
                }
                
                $salOp .= "<tr><td>" . $op["Texto"] . "</td>";
                for ($i = 0; $i < count($columnas); $i++) {
                    $col = $columnas[$i]; //class='validate[required]'
                    $salOp .= "<td class='text-center'>
					<input type='radio' $obl name='respuestas[$idPregunta][" . $op["idOpcion"] . "]'
					id='respuesta[$idPregunta][" . $op["idOpcion"] . "]' value='" . $col["idColumna"] . "' /></td>";
                }

                $salOp .= "</tr>";
            }

            $salOp .= "</tbody></table></div></div>";
            return $salOp;
        } else {
            return "";
        }
    } catch (Exception $e) {
        return "";
    }
}

function ver_matrizVariasResp($idPregunta) {
    try {
        $base = new PDOConfig();
        $salOp = "";
        $colsR = "";
        $sqlCol = " SELECT idColumna,idPregunta,Texto
		FROM columnaspreguntas WHERE idPregunta = $idPregunta";

        $resCol = $base->query($sqlCol);

        if ($resCol) {
            $columnas = $resCol->fetchAll(PDO::FETCH_ASSOC);
            $salOp .= "<div class=' table-responsive'><table class='table table-bordered table-striped table-condensed'>
					<thead><tr><th>&nbsp;</th>";

            foreach ($columnas as $col) {
                $salOp .="<th>" . $col["Texto"] . "</th>";
            }
        } else {
            return "";
        }

        $salOp .= "</tr></thead><tbody>";

        $sqlOP = " SELECT idOpcion,idPregunta,Texto
		FROM opcionespreguntas WHERE idPregunta = $idPregunta";
        //echo $sql;
        if ($resOP = $base->query($sqlOP)) {
            foreach ($resOP as $op) {
                $salOp .= "<tr><td>" . $op["Texto"] . "</td>";
                for ($i = 0; $i < count($columnas); $i++) {
                    $col = $columnas[$i]; //class='validate[required]'
                    $salOp .= "<td class='text-center'>
					<input type='checkbox'  name='respuestas[$idPregunta][" . $op["idOpcion"] . "][]'
					id='respuesta[$idPregunta][" . $op["idOpcion"] . "][]' value='" . $col["idColumna"] . "' /></td>";
                }
                $salOp .= "</tr>";
            }

            $salOp .= "</tbody></table></div>";
            return $salOp;
        } else {
            return "";
        }
    } catch (Exception $e) {
        return "";
    }
}

function ver_campoTexto($idPregunta) {
    $base = new PDOConfig();
    $salOp = "";
    $sqlOP = " SELECT P.RespuestaObligatoria,P.idFormato,P.ValorMinimo,P.ValorMaximo
		FROM preguntasencuestas P WHERE P.idPregunta = $idPregunta";
        //echo $sql;
        if ($resOP = $base->query($sqlOP)) {
            $op = $resOP->fetch(PDO::FETCH_ASSOC);
             $obl="validate[";
                if($op["RespuestaObligatoria"] == "1")
                {
                   $obl .= "required";
                }
            
                switch ($op["idFormato"]){
                    case "2":
                       $obl .=",custom[integer]";
                       if($op["ValorMinimo"] != ""){
                          $obl .=",min[".$op["ValorMinimo"]."]";
                       } 
                       if($op["ValorMaximo"] != ""){                           
                           if($op["ValorMinimo"] < $op["ValorMaximo"]){                           
                            $obl .=",max[".$op["ValorMaximo"]."]";
                           }
                       } 
                       break;
                    case "3":
                       $obl .=",custom[number]";
                       if($op["ValorMinimo"] != ""){
                          $obl .=",min[".$op["ValorMinimo"]."]";
                       } 
                       if($op["ValorMaximo"] != ""){
                           if($op["ValorMinimo"] < $op["ValorMaximo"]){  
                            $obl .=",max[".$op["ValorMaximo"]."]";
                           }
                       } 
                       break; 
                     case "4":
                       $obl .=",custom[date]";
                       /*if($op["ValorMinimo"] != ""){
                          $obl .=",min[".$op["ValorMinimo"]."]";
                       } 
                       if($op["ValorMaximo"] != ""){
                          $obl .=",max[".$op["ValorMaximo"]."]";
                       }*/ 
                       break; 
                     case "5":
                       $obl .=",custom[email]";
                       break;   
                }
                $obl .="]";
                
                
                if($obl == "validate[]"){
                    $obl = "";
                }
                $obl = str_replace("[,", "[", $obl);
                $salOp = "<div class='row'>
                    <div class='col-md-10'>
                    <input type='text' class='form-control input-sm $obl' name='respuestas[$idPregunta]' id='respuestas[$idPregunta]' />
                    </div>
                    </div>";
        return $salOp;
     } else {
            return "";
        }
}

function ver_campoTextoFecha($idPregunta) {
    $salOp = "<div class='row'>
	<div class='col-md-10'>
	<input type='text' class='form-control input-sm fecha' name='respuestas[$idPregunta]' id='respuestas[$idPregunta]' />
	</div>
	</div>";
    return $salOp;
}

function ver_campoComentario($idPregunta) {
    $base = new PDOConfig();
    $obl = "";
    $sqlOP = " SELECT P.RespuestaObligatoria,P.idFormato,P.ValorMinimo,P.ValorMaximo
		FROM preguntasencuestas P WHERE P.idPregunta = $idPregunta";
        //echo $sql;
    if ($resOP = $base->query($sqlOP)) {
        $op = $resOP->fetch(PDO::FETCH_ASSOC);
        if($op["RespuestaObligatoria"] == "1")
        {
           $obl ="validate[required]";
        }
    }
    
    $salOp = "<div class='row'>
	<div class='col-md-10'>	
	<textarea class='form-control input-sm $obl' name='respuestas[$idPregunta]' id='respuestas[$idPregunta]'></textarea>
	</div>
	</div>";
    return $salOp;
}

function ver_multipleTexto($idPregunta) {
    try {
        $base = new PDOConfig();
        $salOp = "";

        $sqlOP = " SELECT idOpcion,idPregunta,Texto
		FROM opcionespreguntas WHERE idPregunta = $idPregunta";
        //echo $sql;
        if ($resOP = $base->query($sqlOP)) {
            foreach ($resOP as $op) {
                $salOp .= "<div class='row'>
						<div class='col-md-2'>" .
                        $op["Texto"]
                        . "</div>
						<div class='col-md-8'>
						<input class='form-control input-sm' type='text' name='respuestas[$idPregunta][" . $op["idOpcion"] . "]' id='respuestas[$idPregunta][" . $op["idOpcion"] . "]'>
						</div>
						</div>";
            }
            return $salOp;
        } else {
            return "";
        }
    } catch (Exception $e) {
        return "";
    }
}

function crearEncuesta($titulo, $tema, $tipo, $descripcion, $usuario) {
    try {

        if ($id = nuevaEncuesta($titulo, $tema, $tipo, $descripcion, $usuario)) {
            return encrypt($id);
        } else {
            return "0";
        }
    } catch (Exception $e) {
        return "0";
    }
}

function actualizarEncuesta($idEncuesta, $titulo, $tema, $tipo, $descripcion, $usuario, $fechalimite, 
        $horaLimite, $tieneClave, $mostrarRe, $claveAcc, $cantAcc, $proposito, $poblacion, $txtCarMu,
        $bloquearIP,$tags) {

    try {

        if ($id = actEncuesta($titulo, $tema, $tipo, $descripcion, $usuario, $fechalimite, $horaLimite, 
                $tieneClave, $mostrarRe, $claveAcc, $cantAcc, $proposito, $poblacion, $txtCarMu, 
                $idEncuesta,$bloquearIP,$tags)) {
           
            return "<div class='alert alert-success'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
												Los datos se cargaron correctamente</div>";
        } else {
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
												Error intentar actualizar la encuesta</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
												Error intentar actualizar la encuesta</div>";
    }
}

function copiarEncuesta($idEncOrg, $titulo, $usuario) {
    try {
        $base = new PDOConfig();
        $titulo = $base->filtrar($titulo);
        $tema = $base->filtrar($tema);
        $descripcion = $base->filtrar($descripcion);
        $id = "";
        $fecha = date('Y-m-d');

        $base->beginTransaction();

        $sql = "INSERT INTO encuestas (idTema,idTipoEncuesta,idEstado,idUsuario,Titulo,Descripcion,FechaCarga)
				SELECT idTema,idTipoEncuesta,1,$usuario,'$titulo',Descripcion,'$fecha'
				FROM encuestas
				WHERE idEncuesta = $idEncOrg";

        //return $sql;
        if ($res = $base->query($sql)) {
            $id = $base->lastInsertId();

            $sqlPag = "SELECT idPagina,idEncuesta,Titulo,NroPagina FROM paginasencuestas
					WHERE idEncuesta = $idEncOrg";

            $resPag = $base->query($sqlPag);
            if ($resPag) {
                foreach ($resPag as $rowPag) {

                    $sqlInPag = "INSERT INTO paginasencuestas(idEncuesta,Titulo,NroPagina) VALUES
								($id,'" . $rowPag["Titulo"] . "'," . $rowPag["NroPagina"] . ")";

                    if ($res = $base->query($sqlInPag)) {
                        $idPag = $base->lastInsertId();

                        $sqlPreg = "SELECT idPregunta,idTipoPregunta,RespuestaObligatoria,Texto,NroPregunta,AgregarOtro,idEscala,ValorMinimo,ValorMaximo,idFormato,incluirAnalisis,Diferencial FROM preguntasencuestas
				   WHERE idPagina = " . $rowPag["idPagina"];

                        $resPreg = $base->query($sqlPreg);
                        if ($resPreg) {
                            foreach ($resPreg as $rowPreg) {
                                $idPregOrg = $rowPreg["idPregunta"];
                                if($rowPreg["idFormato"] == "") $rowPreg["idFormato"] = "NULL";
				if($rowPreg["Diferencial"] == "") $rowPreg["Diferencial"] = "NULL";
				if($rowPreg["idEscala"] == "") $rowPreg["idEscala"] = "1";
                                
                                
                                $sqlInPreg = "INSERT INTO preguntasencuestas(idEncuesta,idTipoPregunta,RespuestaObligatoria,Texto,NroPregunta,AgregarOtro,idPagina,
                                    idEscala,ValorMinimo,ValorMaximo,idFormato,incluirAnalisis,Diferencial) VALUES
								($id," . $rowPreg["idTipoPregunta"] . "," . $rowPreg["RespuestaObligatoria"] . ",'" . $rowPreg["Texto"] . "'," . $rowPreg["NroPregunta"] .
                                        "," . $rowPreg["AgregarOtro"] . ",$idPag," . $rowPreg["idEscala"] . ",'".$rowPreg["ValorMinimo"]."','".
                                        $rowPreg["ValorMaximo"]."',".$rowPreg["idFormato"].",".$rowPreg["incluirAnalisis"].",".$rowPreg["Diferencial"].")";

                                if ($resInPreg = $base->query($sqlInPreg)) {
                                    $idPreg = $base->lastInsertId();

                                    $sqlInOp = "INSERT INTO opcionespreguntas(idPregunta,Texto,Orden,Texto2)
									SELECT $idPreg, Texto,Orden,Texto2
									FROM opcionespreguntas
									WHERE idPregunta = $idPregOrg";

                                    if (!$resInOps = $base->query($sqlInOp)) {
                                        $base->rollBack();
                                        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
												Error al insertar las opciones </div>";
                                    }

                                    $sqlInCol = "INSERT INTO columnaspreguntas(idPregunta,Ponderacion,Texto)
									SELECT $idPreg,Ponderacion,Texto
									FROM columnaspreguntas
									WHERE idPregunta = $idPregOrg";

                                    if (!$resInCols = $base->query($sqlInCol)) {
                                        $base->rollBack();
                                        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
												Error al insertar las columnas </div>";
                                    }
                                } else {
                                    $base->rollBack();
                                    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
												Error al insertar las preguntas</div>";
                                }
                            }//cierra foreach	
                        } else {
                            $base->rollBack();
                            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
										Error al consultar las preguntas de la encuesta original</div>";
                        }
                    } else {
                        $base->rollBack();
                        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
										Error al consultar las paginas de la encuesta original</div>";
                    }
                }//cierre for each
            } else {
                $base->rollBack();
                return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
							Error al consultar las paginas de la encuesta original</div>";
            }

            $base->commit();
            return $id;
        } else {
            $base->rollBack();
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
							Error al intentar cargar la encuesta</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
							Error al conectar la base de datos</div>";
    }
}

function verEncuesta($idEncuesta) {

    try {
        $base = new PDOConfig();
        $salida = "";
        $idEncuesta = $base->filtrar($idEncuesta);

        $sql = " SELECT E.idEncuesta,E.idTema,E.idEstado,E.idUsuario,E.Titulo,E.Descripcion,E.FechaCarga,E.CodigoAcceso,
		E.FechaLimite,E.HoraLimite,E.CantMaxAccesos,E.ClaveAcceso,E.TieneClave,E.MostrarResultados, E.idTipoEncuesta,
		E.Proposito,E.Poblacion,E.CaractecisticasMuestra,E.BloquearIP,E.tieneIdentificadores,T.Descripcion AS Tema,I.Descripcion as Tipo,
                (SELECT COUNT(*) FROM respuestas WHERE idEncuesta = $idEncuesta AND idEstado = 2) AS cantResp
		FROM encuestas E 
		INNER JOIN temas T ON E.idTema = T.idTema
		INNER JOIN tiposencuestas I ON E.idTipoEncuesta = I.idTipoEncuesta
		WHERE idEncuesta = $idEncuesta";
        //echo $sql;
        if ($res = $base->query($sql)) {
            $row = $res->fetch(PDO::FETCH_ASSOC);

            $fechaCarga = date_create($row ["FechaCarga"]);
            $row ["FechaCarga"] = date_format($fechaCarga, 'd/m/Y');

            if ($row["FechaLimite"] != "") {
                $fechaLim = date_create($row ["FechaLimite"]);
                $row ["FechaLimite"] = date_format($fechaLim, 'd/m/Y');
            }

            if ($row["TieneClave"] == "" || $row["TieneClave"] == "0") {
                $row ["TieneClave"] = "0";
            } else {
                $row ["TieneClave"] = "1";
            }
            
            if ($row["CantMaxAccesos"] == "" || $row["CantMaxAccesos"] == "0") {
                $row ["CantMaxAccesos"] = "";
            } 

            if ($row["MostrarResultados"] == "" || $row["MostrarResultados"] == "0") {
                $row ["MostrarResultados"] = "0";
            } else {
                $row ["MostrarResultados"] = "1";
            }

            $salida = json_encode($row);
        } else {
            return "0";
        }
        return $salida;
    } catch (Exception $e) {
        return "0";
    }
}

function preguntasXEncuestas($idEncuesta) {
    try {
        $salida = "";
        $base = new PDOConfig();

        $sql = "SELECT idPagina,idEncuesta,Titulo,NroPagina
		FROM paginasencuestas
		WHERE idEncuesta = $idEncuesta
		ORDER BY NroPagina ";
        //echo $sql;
        $res = $base->query($sql);
        if ($res) {
            foreach ($res as $row) {
                $salida .= "<div class='row'>
						<div class='box col-md-12'>
						<div class='box-inner'>
						<div class='box-header well'><h2>" . $row["Titulo"] . "</h2>
								<div class='box-icon'>
								<a href='#' class='btn btn-setting btn-round btn-default' onclick=\"editarTitulo('" . $idEncuesta . "','" . $row["idPagina"] . "','" . $row["Titulo"] . "')\">
										<i class='glyphicon glyphicon-pencil'></i></a>
								<a href='#' class='btn btn-setting btn-round btn-default' onclick=\"eliminarPagina('" . $idEncuesta . "','" . $row["idPagina"] . "','" . $row["Titulo"] . "');\">
										<i class='glyphicon glyphicon-remove'></i></a>		
										</div>
										</div>
										<div class='box-content'>
										<div id='PreguntasPag" . $row["idPagina"] . "'><ul class='sortable'>";

                $sqlP = "SELECT idPregunta,idPagina,idEncuesta,idTipoPregunta,RespuestaObligatoria,
						Texto,NroPregunta,AgregarOtro,Diferencial
						FROM preguntasencuestas
						WHERE idPagina = " . $row["idPagina"] . "
								ORDER BY NroPregunta ";
                //echo $sql;
                $resPreg = $base->query($sqlP);
                if ($resPreg) {
                    foreach ($resPreg as $preg) {
                        $salida .= "<li id='" . $preg['idPregunta'] . "' class='ui-state-default'><div class='row' class='sortable'>
								<div class='box col-md-12'>
								<h5>
								<div class='box-icon'>
								<a href='#' class='btn btn-setting btn-round btn-primary' title='Mover Pregunta'><i class='glyphicon glyphicon-move'></i></a>
								<a href='#' class='btn btn-setting btn-round btn-primary' title='Editar Pregunta' onclick=\"editarPregunta('" . $preg['idPregunta'] . "','" . $idEncuesta . "');\"><i class='glyphicon glyphicon-pencil'></i></a>
								<a href='#' class='btn btn-close btn-round btn-primary' title='Eliminar Pregunta' onclick=\"eliminarPregunta('" . $preg['idPregunta'] . "','" . $idEncuesta . "');\"><i class='glyphicon glyphicon-remove'></i></a>
										</div>
										<span id='s" . $preg['idPregunta'] . "'>" . $preg['NroPregunta'] . "</span>. " . $preg['Texto'] . "
												</h5>
												</div></div>";

                        switch ($preg['idTipoPregunta']) {
                            case "1":
                            case "12":    
                                $salida .= ver_OpMultipleUnaOpcion($preg['idPregunta']);
                                break;
                            case "2": $salida .= ver_OpMultipleVariasOpcion($preg['idPregunta']);
                                break;
                            case "3": $salida .= ver_escalaValoracion($preg['idPregunta']);
                                break;
                            case "4": $salida .= ver_matrizUnaResp($preg['idPregunta']);
                                break;
                            case "5": $salida .= ver_matrizVariasResp($preg['idPregunta']);
                                break;
                            case "6": $salida .= ver_campoTexto($preg['idPregunta']);
                                break;
                            case "7": $salida .= ver_multipleTexto($preg['idPregunta']);
                                break;
                            case "8": $salida .= ver_campoComentario($preg['idPregunta']);
                                break;
                            case "9": $salida .= ver_campoTextoFecha($preg['idPregunta']);
                                break;
                            case "11": $salida .= ver_OpDiferencialSemantico($preg['idPregunta'],$preg['Diferencial']);
                                 
                                break;
                            
                            
                        }
                        $salida .= "</li>";
                    }
                    $salida .= "</ul>";
                } else {
                    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
							Error al consultar los datos de las preguntas</div>";
                }

                $salida .= "</div>
						<div class='row'>
						<div class='col-md-12'>
						<span id='respuestaPreg" . $row["idPagina"] . "'></span>
								</div><!--/col-md-12 -->
								</div>
								<div class='row'>
								<div class='col-md-12 center'>
								<button id='btnNuevaPreg' type='button' class='btn btn-primary btnpreg' onclick=\"agregarPregunta('" . $row["idPagina"] . "')\">
										<i class='glyphicon glyphicon-plus-sign'></i> Agregar Pregunta</button>
										</div><!--/col-md-12 -->
										</div></div></div></div><!--/box col-md-12--></div><!--/row-->";
            }

            return $salida;
        } else {
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al consultar los datos</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al consultar la base de datos</div>";
    }
}

function nuevaPagina($idEncuesta) {
    try {
        $base = new PDOConfig();
        $idEncuesta = $base->filtrar($idEncuesta);
        $fecha = date('Y-m-d');

        $sql = " SELECT MAX(NroPagina) AS maxNro FROM paginasencuestas WHERE idEncuesta = $idEncuesta";

        $resp = $base->query($sql);
        $rowMax = $resp->fetch(PDO::FETCH_ASSOC);
        if ($rowMax['maxNro'] != "") {
            $max = $rowMax['maxNro'];
            $max++;
        } else {
            $max = 1;
        }

        $sql = " INSERT paginasencuestas(idEncuesta,Titulo,NroPagina) VALUES ($idEncuesta,'',$max)";
        //return $sql;
        if ($res = $base->query($sql)) {
            $idPag = $base->lastInsertId();
            return $idPag;
        } else {
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
		Ha ocurrido al intentar cargar la nueva p&aacute;gina</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
		Ha ocurrido al consultar la base de datos</div>";
    }
}

function eliminarPagina($idEncuesta, $idPagina) {
    try {
        $base = new PDOConfig();
        $idEncuesta = $base->filtrar($idEncuesta);
        $idPagina = $base->filtrar($idPagina);
        $fecha = date('Y-m-d');

        $base->beginTransaction();

        $sql = "DELETE FROM preguntasencuestas WHERE idEncuesta = $idEncuesta AND idPagina = $idPagina";

        if (!($res = $base->query($sql))) {
            $base->rollBack();           
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
		Ha ocurrido al intentar eliminar las preguntas de la p&aacute;gina</div>";
        }
                
        $sql = "DELETE FROM paginasencuestas WHERE idEncuesta = $idEncuesta AND idPagina = $idPagina";

        if (!($res = $base->query($sql))) {
            $base->rollBack(); 
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
		Ha ocurrido al intentar eliminar la p&aacute;gina</div>";
        }
        
        $base->commit();
        return "1";
        
    } catch (Exception $e) {
       return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
		Ha ocurrido al consultar la base de datos</div>";
    }
}

function cambiarTituloPagina($idEncuesta, $idPagina, $titulo) {

    try {
        $base = new PDOConfig();
        $idEncuesta = $base->filtrar($idEncuesta);
        $idPagina = $base->filtrar($idPagina);
        $titulo = $base->filtrar($titulo);

        $sql = " UPDATE paginasencuestas SET Titulo = '$titulo' WHERE idEncuesta=$idEncuesta AND idPagina = $idPagina";
        //return $sql;
        if ($res = $base->query($sql)) {
            return "1";
        } else {
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
		       Ha ocurrido al cargar el t&iacute;tulo de la p&aacute;gina</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
		Ha ocurrido al consultar la base de datos</div>";
    }
}

function listado($usu) {
    try {
        $base = new PDOConfig();
        global $ESTADOSENC;
        $sqlCol = " SELECT E.idEncuesta,E.idTema, E.idEstado,E.idUsuario,E.Titulo,E.FechaCarga,E.idTipoEncuesta,T.Descripcion AS tema,
		CONCAT(U.Apellido,', ',U.Nombre) AS usuCrea, S.Descripcion AS estado, TE.Descripcion AS tipoEnc
		FROM encuestas E
		INNER JOIN temas T ON E.idTema = T.idTema
                INNER JOIN tiposencuestas TE ON E.idTipoEncuesta = TE.idTipoEncuesta
		INNER JOIN usuarios U ON E.idUsuario = U.idUsuario
		INNER JOIN estados S ON E.idEstado = S.idEstado
		WHERE E.idUsuario = $usu
		ORDER BY E.FechaCarga DESC ";
        //echo $sqlCol;
        if ($resCol = $base->query($sqlCol)) {

            $salOp .= "<div class='row'>
					<div class='col-md-12'>
					<table id='tblEncuestas' class='table datatable table-striped'>
					<thead>
					<tr>
					<th>Encuesta</th>
					<th>Tema</th>
                                        <th>Tipo</th>
					<th>Creada</th>
					<th>Creada Por</th>
					<th>Estado</th>
					<th>Respuestas</th>
					<th>&nbsp;</th>
					</tr></thead><tbody>";

            foreach ($resCol as $col) {
                $cantRes = 0;
                $sqlRe = "SELECT * FROM respuestas WHERE idEstado = 2 AND idEncuesta = ".$col["idEncuesta"];
                 if ($resT = $base->query($sqlRe)) {
                   $cantRes = $resT->rowCount();  
                 }
                
                $salOp .="<tr><td>" . $col["Titulo"] . "</td>
						<td>" . $col["tema"] . "</td>
                                                <td>" . $col["tipoEnc"] . "</td>
						<td>" . formatFecha($col["FechaCarga"]) . "</td>
						<td>" . $col["usuCrea"] . "</td>
						<td>" . $col["estado"] . "</td>
						<td class='text-center'>".$cantRes."</td>
						<td class='text-center'>";
                if ($col["idEstado"] == $ESTADOSENC["DISENIO"]) {
                    $salOp .="<a class='btn btn-info btn-sm' href='enc_diseniarEncuesta.php?id=" . encrypt($col["idEncuesta"]) . "'>"
                            . "<i class='glyphicon glyphicon-edit'></i></a>";
                }
                if (($col["idEstado"] == $ESTADOSENC["RECOPILACION"]) && ($col["idTipoEncuesta"] <= 1)) {
                    $salOp .="<a class='btn btn-info btn-sm' href='enc_analisisEncuesta.php?id=" . encrypt($col["idEncuesta"])."'>"
                            . " <i class='glyphicon glyphicon-signal'></i> </a>";
                }
                if (($col["idEstado"] == $ESTADOSENC["CERRADA"]) && ($col["idTipoEncuesta"] <= 1)) {
                    $salOp .="<a class='btn btn-info btn-sm' href='enc_analisisEncuesta.php?id=" . encrypt($col["idEncuesta"])."'>"
                            . " <i class='fa fa-bar-chart' ></i></a>";
                }
                
                
                if (($col["idEstado"] == $ESTADOSENC["RECOPILACION"]) && ($col["idTipoEncuesta"] > 1)) {
                    $salOp .="<a class='btn btn-info btn-sm' href='enc_analisisEncuestaLong.php?id=" . encrypt($col["idEncuesta"])."'>"
                            . " <i class='glyphicon glyphicon-signal'></i> </a>";
                }
                
                if (($col["idEstado"] == $ESTADOSENC["CERRADA"]) && ($col["idTipoEncuesta"] > 1)) {
                    $salOp .="<a class='btn btn-info btn-sm' href='enc_analisisEncuestaLong.php?id=" . encrypt($col["idEncuesta"])."'>"
                            . " <i class='fa fa-bar-chart' ></i> </a>";
                }
                $salOp .="</td></tr>";
            }
            $salOp .= "</tbody></table></div></div>";
            return $salOp;
        } else {
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al consultar los datos</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al Consultar la Base de Datos</div>";
    }
}

function listadoCompartidas($usu) {
    try {
        $base = new PDOConfig();
        global $ESTADOSENC;
        $sqlCol = " SELECT E.idEncuesta,E.idTema, E.idEstado,E.idUsuario,E.Titulo,E.FechaCarga,T.Descripcion AS tema,
		CONCAT(U.Apellido,', ',U.Nombre) AS usuCrea, S.Descripcion AS estado
		FROM encuestas E
		INNER JOIN temas T ON E.idTema = T.idTema
		INNER JOIN usuarios U ON E.idUsuario = U.idUsuario
		INNER JOIN estados S ON E.idEstado = S.idEstado
		WHERE E.idEncuesta IN (SELECT idEncuesta FROM encuestasgrupos GE 
                    INNER JOIN usuariosgrupos GU ON GE.idGrupo = GU.idGrupo 
                    WHERE GU.idUsuario = $usu AND GU.Activo = 1)
		ORDER BY E.FechaCarga ";
        //echo $sqlCol;
        if ($resCol = $base->query($sqlCol)) {

            $salOp .= "<div class='row'>
					<div class='col-md-12'>
					<table id='tblEncuestas' class='table datatable table-bordered table-striped table-condensed'>
					<thead>
					<tr>
					<th>Encuesta</th>
					<th>Tema</th>
					<th>Creada</th>
					<th>Creada Por</th>
					<th>Modificada</th>
					<th>Estado</th>
					<th>Respuestas</th>
					<th>&nbsp;</th>
					</tr></thead><tbody>";

            foreach ($resCol as $col) {
                
                $cantRes = 0;
                $sqlRe = "SELECT * FROM respuestas WHERE idEstado = 2 AND idEncuesta = ".$col["idEncuesta"];
                 if ($resT = $base->query($sqlRe)) {
                   $cantRes = $resT->rowCount();  
                }
                
                $salOp .="<tr><td>" . $col["Titulo"] . "</td>
						<td>" . $col["tema"] . "</td>
						<td>" . formatFecha($col["FechaCarga"]) . "</td>
						<td>" . $col["usuCrea"] . "</td>
						<td>" . formatFecha($col["FechaCarga"]) . "</td>
						<td>" . $col["estado"] . "</td>
						<td class='text-center'>".$cantRes."</td>
						<td class='text-center'>";
                if ($col["idEstado"] == $ESTADOSENC["DISENIO"]) {
                    $salOp .="<a class='btn btn-info btn-sm' href='enc_diseniarEncuesta.php?id=" . encrypt($col["idEncuesta"]) . "'>"
                            . "<i class='glyphicon glyphicon-edit'></i></a>";
                }
                if (($col["idEstado"] == $ESTADOSENC["RECOPILACION"]) && ($col["idTipoEncuesta"] <= 1)) {
                    $salOp .="<a class='btn btn-info btn-sm' href='enc_analisisEncuesta.php?id=" . encrypt($col["idEncuesta"])."'>"
                            . " <i class='glyphicon glyphicon-signal'></i> </a>";
                }
                if (($col["idEstado"] == $ESTADOSENC["CERRADA"]) && ($col["idTipoEncuesta"] <= 1)) {
                    $salOp .="<a class='btn btn-info btn-sm' href='enc_analisisEncuesta.php?id=" . encrypt($col["idEncuesta"])."'>"
                            . " <i class='fa fa-bar-chart' ></i></a>";
                }
                
                
                if (($col["idEstado"] == $ESTADOSENC["RECOPILACION"]) && ($col["idTipoEncuesta"] > 1)) {
                    $salOp .="<a class='btn btn-info btn-sm' href='enc_analisisEncuestaLong.php?id=" . encrypt($col["idEncuesta"])."'>"
                            . " <i class='glyphicon glyphicon-signal'></i> </a>";
                }
                
                if (($col["idEstado"] == $ESTADOSENC["CERRADA"]) && ($col["idTipoEncuesta"] > 1)) {
                    $salOp .="<a class='btn btn-info btn-sm' href='enc_analisisEncuestaLong.php?id=" . encrypt($col["idEncuesta"])."'>"
                            . " <i class='fa fa-bar-chart' ></i> </a>";
                }
                $salOp .="</td></tr>";
            }
            $salOp .= "</tbody></table></div></div>";
            return $salOp;
        } else {
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al consultar los datos</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al Consultar la Base de Datos</div>";
    }
}

function listadoPublicas() {
    try {
        $base = new PDOConfig();
        global $ESTADOSENC;
        $sqlCol = " SELECT E.idEncuesta,E.idTema, E.idEstado,E.idUsuario,E.Titulo,E.FechaCarga,E.idTipoEncuesta,T.Descripcion AS tema,
		CONCAT(U.Apellido,', ',U.Nombre) AS usuCrea, S.Descripcion AS estado, TE.Descripcion AS tipoEnc
		FROM encuestas E
		INNER JOIN temas T ON E.idTema = T.idTema
                INNER JOIN tiposencuestas TE ON E.idTipoEncuesta = TE.idTipoEncuesta
		INNER JOIN usuarios U ON E.idUsuario = U.idUsuario
		INNER JOIN estados S ON E.idEstado = S.idEstado
		WHERE E.MostrarResultados = 1 AND E.idEstado = 3 
		ORDER BY E.FechaCarga ";
        //echo $sqlCol;exit();
        if ($resCol = $base->query($sqlCol)) {

            $salOp .= "<div class='row'>
					<div class='col-md-12'>
					<table id='tblEncuestas' class='table datatable table-striped'>
					<thead>
					<tr>
					<th>Encuesta</th>
					<th>Tema</th>
                                        <th>Tipo</th>
					<th>Creada</th>
					<th>Creada Por</th>
					<th>Estado</th>
					<th>Respuestas</th>
					<th>&nbsp;</th>
					</tr></thead><tbody>";

            foreach ($resCol as $col) {
                $cantRes = 0;
                $sqlRe = "SELECT * FROM respuestas WHERE idEstado = 2 AND idEncuesta = ".$col["idEncuesta"];
                 if ($resT = $base->query($sqlRe)) {
                   $cantRes = $resT->rowCount();  
                 }
                
                $salOp .="<tr><td>" . $col["Titulo"] . "</td>
						<td>" . $col["tema"] . "</td>
                                                <td>" . $col["tipoEnc"] . "</td>
						<td>" . formatFecha($col["FechaCarga"]) . "</td>
						<td>" . $col["usuCrea"] . "</td>
						<td>" . $col["estado"] . "</td>
						<td class='text-center'>".$cantRes."</td>
						<td class='text-center'>";
                
                
                if (($col["idEstado"] == $ESTADOSENC["CERRADA"]) && ($col["idTipoEncuesta"] <= 1)) {
                    $salOp .="<a class='btn btn-info btn-sm' target='_blank' href='r/enc_resumenFinal.php?id=" . encrypt($col["idEncuesta"])."'>"
                            . " <i class='fa fa-bar-chart' ></i></a>";
                }
                /*
                if (($col["idEstado"] == $ESTADOSENC["CERRADA"]) && ($col["idTipoEncuesta"] > 1)) {
                    $salOp .="<a class='btn btn-info btn-sm' href='enc_resumenEncuestaPubLong.php?id=" . encrypt($col["idEncuesta"])."'>"
                            . " <i class='fa fa-bar-chart' ></i> </a>";
                }*/
                $salOp .=' <a class= "btn btn-info btn-sm" href="Negocios/exportarEncuesta.php?id='.encrypt($col["idEncuesta"]).'"><i class="glyphicon glyphicon-download-alt"></i></a>';
                $salOp .="</td></tr>";
            }
            $salOp .= "</tbody></table></div></div>";
            return $salOp;
        } else {
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al consultar los datos</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al Consultar la Base de Datos</div>";
    }
}




function encuestaParaRecopilar($idEncuesta) {
    try {
        $salida = "";
        $navegar = "";
        $preguntas = "";
        $base = new PDOConfig();

        $sql = "SELECT idPagina,idEncuesta,Titulo,NroPagina
		FROM paginasencuestas
		WHERE idEncuesta = $idEncuesta
		ORDER BY NroPagina";
        //echo $sql;
        $res = $base->query($sql);
        if ($res) {



            foreach ($res as $row) {
                $salida .= "<div class='tab-pane' id='pagina" . $row["NroPagina"] . "'>";

                if ($row["Titulo"] != "") {
                    $salida .= "<legend style='font-size: 16px; font-weight:bold;'> <i class='glyphicon glyphicon-file'></i> " . $row["Titulo"] . "</legend>";
                }

                $sqlP = "SELECT idPregunta,idPagina,idEncuesta,idTipoPregunta,RespuestaObligatoria,
						Texto,NroPregunta,AgregarOtro,Diferencial
						FROM preguntasencuestas
						WHERE idPagina = " . $row["idPagina"] . "
								ORDER BY NroPregunta ";
                //echo $sql;
                $resPreg = $base->query($sqlP);
                if ($resPreg) {
                    foreach ($resPreg as $preg) {
                        $salida .= "<h5 style='padding-bottom:5px;'>
								<span id='s" . $preg['idPregunta'] . "'>" . $preg['NroPregunta'] . "</span>. " . $preg['Texto'] . "
										</h5>
										<input type='hidden' id='o" . $preg['idPregunta'] . "' value='" . $preg['RespuestaObligatoria'] . "' />
												<div class='alert alert-danger' id='alert" . $preg['idPregunta'] . "' style='display:none;'>
														<button type='button' class='close' data-dismiss='alert'>�</button>
														Se requiere una respuesta
														</div>";
                        switch ($preg['idTipoPregunta']) {
                            case "1":
                            case "12":    
                                $salida .= ver_OpMultipleUnaOpcion($preg['idPregunta']);
                                break;
                            case "2": $salida .= ver_OpMultipleVariasOpcion($preg['idPregunta']);
                                break;
                            case "3": $salida .= ver_escalaValoracion($preg['idPregunta']);
                                break;
                            case "4": $salida .= ver_matrizUnaResp($preg['idPregunta']);
                                break;
                            case "5": $salida .= ver_matrizVariasResp($preg['idPregunta']);
                                break;
                            case "6": $salida .= ver_campoTexto($preg['idPregunta']);
                                break;
                            case "7": $salida .= ver_multipleTexto($preg['idPregunta']);
                                break;
                            case "8": $salida .= ver_campoComentario($preg['idPregunta']);
                                break;
                            case "9": $salida .= ver_campoTextoFecha($preg['idPregunta']);
                                break;
                            case "11": $salida .= ver_OpDiferencialSemantico($preg['idPregunta'],$preg['Diferencial']);
                                //$www = ver_OpDiferencialSemantico($preg['idPregunta'],$preg['Diferencial']);
                                //return $www;
                                break;
                        }
                        $salida .= "<br />";
                    }
                } else {
                    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
							Error al consultar los datos de las preguntas</div>";
                }

                $salida .= "</div>";
            }

            return $salida;
        } else {
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al consultar los datos</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al consultar la base de datos</div>";
    }
}

function iniciaEncuesta($idEncuesta) {
    try {
        global $ESTADOSRESP;
        $base = new PDOConfig();
        $idEncuesta = $base->filtrar($idEncuesta);
        $IPpublica = $_SERVER['REMOTE_ADDR'];
        if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '' ) {
           $IPpublica = $_SERVER['HTTP_X_FORWARDED_FOR'];

        } else {
            $IPpublica = $_SERVER['REMOTE_ADDR'];
        }
        
        $idPeriodo = 0;
        $sqpPe = "SELECT idPeriodo FROM periodosrecopilacion P WHERE idEncuesta = $idEncuesta AND FechaInicio <= '".date('Y-m-d')."'"
            . " AND (FechaFin >= '".date('Y-m-d')."' OR FechaFin is null)"; 
        
        if ($resPe = $base->query($sqpPe)) {
            if($resPe->rowCount() > 0){            
                $datos = $resPe->fetch(PDO::FETCH_ASSOC);
                $idPeriodo = $datos["idPeriodo"];
            }else {
                return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
			No se encontr&oacute; un periodo activo para participar de la encuesta</div>";
            }
        }
        
        
        $sql = " INSERT INTO respuestas(idEncuesta,FechaHoraInicio,IP,idEstado,idPeriodo) "
                . " VALUES($idEncuesta,NOW(),'$IPpublica'," . $ESTADOSRESP["INCOMPLETA"].",$idPeriodo)";
        //return $sql;
        if ($res = $base->query($sql)) {
            return $base->lastInsertId();
        } else {
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al iniciar la encuesta</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al consultar la base de datos</div>";
    }
}

function guardar_OpMultipleUnaOpcion($base, $idPreg, $idRespuesta, $resp) {

    try {

        $sql = " INSERT INTO respuestaspreguntas(idRespuesta,idPregunta,idOpcion,FechaHoraCarga) VALUE($idRespuesta,$idPreg,$resp,NOW())";
        //return $sql;
        if ($res = $base->query($sql)) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function guardar_OpMultipleVariasOpcion($base, $idPreg, $idRespuesta, $resp) {

    try {

        foreach ($resp as $op) {
            $sql = " INSERT INTO respuestaspreguntas(idRespuesta,idPregunta,idOpcion,FechaHoraCarga) VALUE($idRespuesta,$idPreg,$op,NOW())";
            //return $sql;
            if (!$res = $base->query($sql)) {
                return false;
            }
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function guardar_escalaValoracion($base, $idPreg, $idRespuesta, $resp) {

    try {

        foreach ($resp as $op => $col) {
            $sql = " INSERT INTO respuestaspreguntas(idRespuesta,idPregunta,idOpcion,idColumna,FechaHoraCarga) VALUE($idRespuesta,$idPreg,$op,$col,NOW())";
            //return $sql;
            if (!$res = $base->query($sql)) {
                return false;
            }
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function guardar_matrizUnaResp($base, $idPreg, $idRespuesta, $resp) {

    try {

        foreach ($resp as $op => $col) {
            $sql = " INSERT INTO respuestaspreguntas(idRespuesta,idPregunta,idOpcion,idColumna,FechaHoraCarga) VALUE($idRespuesta,$idPreg,$op,$col,NOW())";
            //return $sql;
            if (!$res = $base->query($sql)) {
                return false;
            }
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function guardar_matrizVariasResp($base, $idPreg, $idRespuesta, $resp) {

    try {

        foreach ($resp as $op => $cols) {
            foreach ($cols as $col) {
                $sql = " INSERT INTO respuestaspreguntas(idRespuesta,idPregunta,idOpcion,idColumna,FechaHoraCarga) VALUE($idRespuesta,$idPreg,$op,$col,NOW())";
                //return $sql;
                if (!$res = $base->query($sql)) {
                    return false;
                }
            }
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function guardar_campoTexto($base, $idPreg, $idRespuesta, $resp) {
    try {
        $resp = $base->filtrar($resp);
        $sql = " INSERT INTO respuestaspreguntas(idRespuesta,idPregunta,RespuestaTexto,FechaHoraCarga) VALUE($idRespuesta,$idPreg,'$resp',NOW())";
        //return $sql;
        if ($res = $base->query($sql)) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function guardar_multipleTexto($base, $idPreg, $idRespuesta, $resp) {
    try {
        //print_r($resp);
        foreach ($resp as $op => $tex) {
            $sql = " INSERT INTO respuestaspreguntas(idRespuesta,idPregunta,idOpcion,RespuestaTexto,FechaHoraCarga) VALUE($idRespuesta,$idPreg,$op,'$tex',NOW())";
            //echo $sql;
            if (!$res = $base->query($sql)) {
                return false;
            }
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function contestarEncuesta($idEncuesta, $idRespuesta, $respuestas,$identificador,$recopilador,$codigoPers) {
    try {
        global $ESTADOSRESP;
        $base = new PDOConfig();
        $idEncuesta = $base->filtrar($idEncuesta);
        $base->beginTransaction();

        foreach ($respuestas as $idPreg => $resp) {
            $sqlP = "SELECT idPregunta,idTipoPregunta
		     FROM preguntasencuestas
		     WHERE idPregunta = $idPreg";

            $resPreg = $base->query($sqlP);
            if ($resPreg) {
                $row = $resPreg->fetch(PDO::FETCH_ASSOC);
                //print_r($row);
                switch ($row['idTipoPregunta']) {
                    case "1": $salida = guardar_OpMultipleUnaOpcion($base, $idPreg, $idRespuesta, $resp);
                        break;
                    case "2": $salida = guardar_OpMultipleVariasOpcion($base, $idPreg, $idRespuesta, $resp);
                        break;
                    case "3": $salida = guardar_escalaValoracion($base, $idPreg, $idRespuesta, $resp);
                        break;
                    case "4": $salida = guardar_matrizUnaResp($base, $idPreg, $idRespuesta, $resp);
                        break;
                    case "5": $salida = guardar_matrizVariasResp($base, $idPreg, $idRespuesta, $resp);
                        break;
                    case "6": $salida = guardar_campoTexto($base, $idPreg, $idRespuesta, $resp);
                        break;
                    case "7": $salida = guardar_multipleTexto($base, $idPreg, $idRespuesta, $resp);
                        break;
                    case "8": $salida = guardar_campoTexto($base, $idPreg, $idRespuesta, $resp);
                        break;
                    case "9": $salida = guardar_campoTexto($base, $idPreg, $idRespuesta, $resp);
                        break;
                    case "11": $salida = guardar_multipleTexto($base, $idPreg, $idRespuesta, $resp);
                        break;
                    case "12": $salida = guardar_OpMultipleUnaOpcion($base, $idPreg, $idRespuesta, $resp);
                        break;
                }
                //echo "Salida: ".$salida." - - ".$idPreg."<br />"; exit();
                if (!$salida) {
                    $base->rollBack();
                    return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al intentar cargar las respuestas</div>";
                }
            }//cierre $resPreg
            else {
                $base->rollBack();
                return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al consultar por las preguntas contestadas</div>";
            }
        }//cierre foreach
               
        
        $sql = " UPDATE respuestas SET FechaHoraFin = NOW(), idEstado = " . $ESTADOSRESP["COMPLETA"] . 
                ",TipoRecolector = '$recopilador', Codigo='$codigoPers',Identificacion='$identificador' "
                . " WHERE idRespuesta = $idRespuesta";
        //return $sql;
        if ($res = $base->query($sql)) {
            $base->commit();
            return "1";
        } else {
            $base->rollBack();
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al actualizar la respuesta general la encuesta</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al consultar la base de datos</div>";
    }
}

function publicarParaRecopilar($idEncuesta,$fechaIni,$fechaFin,$recolectores,
                       $codigoWeb,$destinos,$asunto,$mensaje,$titulo,$identificadores,$tituloPer) 
{
    try {
        $mensResp ="";
        $resp = publicarEncuesta($idEncuesta,$fechaIni,$fechaFin,$recolectores,
                          $codigoWeb,$destinos,$asunto,$mensaje,$titulo,$identificadores,$tituloPer); 
        //print_r($resp); return "";
        switch ($resp)
        {
            case "1": 
                $mensResp = "1";
                      break;
            case "2":
                $mensResp = "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al cargar el per&iacute;odo de recolecci&oacute;n</div>";
                break;
            case "3":
            case "4":
            case "5":    
                $mensResp = "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al cargar el recolector seleccionado $resp</div>";
                break;  
            case "6":    
                $mensResp = "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al actualizar el estado de la encuesta</div>";
                break;  
            default:  
               $mensResp = "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al consultar la base de datos</div>";
                break;
        }
        return $mensResp;
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al consultar la base de datos</div>";
    }
}


function actualizarRecopiladores($idEncuesta,$idPeriodo,$fechaIni,$fechaFin,$recolectores,
                        $codigoWeb,$destinos,$asunto,$mensaje,$titulo,$identificadores)
{
 
     try {
        $mensResp ="";
        $resp = actualizaRecoEnc($idEncuesta,$idPeriodo,$fechaIni,$fechaFin,$recolectores,
                          $codigoWeb,$destinos,$asunto,$mensaje,$titulo,$identificadores); 
        //return $resp;
        switch ($resp)
        {
            case "1": 
                $mensResp = "1";
                      break;
            case "2":
                $mensResp = "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al cargar el per&iacute;odo de recolecci&oacute;n</div>";
                break;
            case "3":
            case "4":
            case "5":    
                $mensResp = "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al cargar el recolector seleccionado</div>";
                break;  
            case "6":    
                $mensResp = "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al actualizar el estado de la encuesta</div>";
                break;  
            default:  
               $mensResp = "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al consultar la base de datos</div>";
                break;
        }
        return $mensResp;
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al consultar la base de datos</div>";
    }
    
}


function compartirEncuesta($idEncuesta, $idGrupo) {
    try {
        $base = new PDOConfig();
        $idEncuesta = $base->filtrar($idEncuesta);
        $idGrupo = $base->filtrar($idGrupo);

        $sql = "SELECT * FROM encuestasgrupos WHERE idGrupo=$idGrupo AND idEncuesta=$idEncuesta ";

        if ($resel = $base->query($sql)) {
            if ($resel->rowCount() > 0) {
                return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					La encuesta ya est&aacute; compartida al grupo seleccionado</div>";
            }
        } else {
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al consultar datos de la encuesta</div>";
        }

        $sql = "INSERT INTO encuestasgrupos(idGrupo,idEncuesta) VALUES ($idGrupo,$idEncuesta)";
        //return $sql;
        if ($res = $base->query($sql)) {
            return "1";
        } else {
            return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
					Error al compartir la encuesta</div>";
        }
    } catch (Exception $e) {
        return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
				Error al consultar la base de datos</div>";
    }
}

function listadoPagEnc($idEncuesta) {

    $datos = paginaXEncuesta($idEncuesta);
    if ($datos != "0") {
        return json_encode($datos);
    } else {
        return "0";
    }
}

function verUnaEncuestaCompleta($idEncuesta,$idRespuesta) {
    $salida = "";
    $respGeneral = verUnaRespuesta($idEncuesta,$idRespuesta);
    //print_r($respGeneral);
    if($respGeneral){
        
        $salida .= "<div class='row'>"
                . "<div class='box col-md-10'>"
                . "<div class='box-inner well'><div class='row'>"
                . " <div class='col-md-2 text-right'><img alt='Respuesta' src='img/logoSolo.png' class='img-circle' /></div> "
                ." <div class='col-md-6'>"
                ." <strong>".$respGeneral["estado"]."</strong><br>
                   <strong>Inicio:</strong> ".$respGeneral["FechaHoraInicio"]."<br>
                   <strong>Finalizaci&oacute;n:</strong> ".$respGeneral["FechaHoraFin"]."<br>
                   <strong>IP:</strong> ".$respGeneral["IP"]."<br>"
                . "<strong>Recolector:</strong> ".$respGeneral["TipoRecolector"];
                if($respGeneral["Identificacion"] != ""){
                    $salida .="<br><strong>Identificador:</strong> ".$respGeneral["Identificacion"];
                }
                $salida .= "</div></div></div></div></div>";
        
        $paginas = paginaXEncuesta($idEncuesta);
        if(!$paginas){  return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
        Error al consultar la base de datos</div>";}
        
        foreach ($paginas as $p){
            $salida .= "<div class='row'>
		<div class='box col-md-10'>";
                if($p["Titulo"] != ""){
                $salida .= "<h3><small>".$p["NroPagina"].".".$p["Titulo"]."</small></h3>";
                }
            $salida .= "<div class='box-inner'>
                <div class='box-content'><dl>";
            
            $preguntas = preguntasXPagina($p["idPagina"],false);
            
            if(!$preguntas) { return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
            Error al consultar la base de datos de preguntas</div>";}
            
            foreach ($preguntas as $preg){                
                $respuestas =  verRespuestaPregunta($idRespuesta,$preg['idPregunta']);
                //return $respuestas;
                if($respuestas == "0"){  return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
                Error al consultar la base de datos de respuestas ".$preg['idPregunta']."</div>";}
                
                $salida .= "<dt><span id='s" . $preg['idPregunta'] . "'>" . $preg['NroPregunta'] . "</span>. " . $preg['Texto'] . "</dt><dd>";
                if(count($respuestas) > 0){
                
                switch ($preg['idTipoPregunta'])
                {
                    case "1":
                    case "12": 
                         foreach ($respuestas as $r){
                            $salida .= $r["opcion1"];                                    
                        }
                        break;
                    case "2":
                        foreach ($respuestas as $r){
                            $salida .= $r["opcion1"]." / ";                                    
                        }
                        break;
                    case "3":
                        foreach ($respuestas as $r){
                            $salida .= $r["opcion1"].": ".$r["columna"]." (".$r["Ponderacion"].") / ";                                    
                        }
                        break;    
                    case "4":
                        foreach ($respuestas as $r){
                            $salida .= $r["opcion1"].": ".$r["columna"]." / ";                                    
                        }
                        break;
                    case "11":
                        foreach ($respuestas as $r){
                            $salida .= $r["opcion1"]." - ".$r["opcion2"].": ".$r["RespuestaTexto"]." / ";                                    
                        }
                        break;    
                    default:  
                        foreach ($respuestas as $r){
                            $salida .= $r["RespuestaTexto"];                                    
                        }
                        break;
                }
                $salida .= "<br /></dd>";
                }
            }
            $salida .= "</dl></div></div>";
        }
         $salida .= "</div>";   
}
    return $salida;
}


function chekearEncuestaParaRecopilar($idEncuesta){
    //return "1";
    $fila=chekearCondicionesReco($idEncuesta);
    //print_r($fila); exit();        
    if($fila)
    {   
        if($fila["idEstado"] == "3")
        {
            //ya se cerro la encuesta
            return "2";
        }
        $fechaLimite = "";
        $horaLimite = "";
        if($fila["FechaLimite"] != "")
        {
            if($fila["HoraLimite"] != "")
            {
                $fechaLimite .= " ".$fila["HoraLimite"];
            }else{
                $fechaLimite .= " 23:59:00";
            }
            
            $hoy = new DateTime('NOW');
            $limite = new DateTime($fechaLimite);
            if($hoy >= $limite){
                //Ya paso la fecha limite de accesso
                return "3";
            }
        }
        if(($fila["CantMaxAccesos"] != "") && ($fila["CantMaxAccesos"] > 0))
        {
            $cant = totalRespuestasCompletas($idEncuesta);
            if(is_integer($cant))
            {
                if($fila["CantMaxAccesos"] < $cant){
                //ya se alcanzo la cantidad maxima de accesos 
                return "4";
                }
            }
            else{
                return "0";
            }
        }
        if(($fila["BloquearIP"] == "1"))
        {
            $IPpublica = $_SERVER['REMOTE_ADDR'];
            if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '' ) {
               $IPpublica = $_SERVER['HTTP_X_FORWARDED_FOR'];

            } else {
                $IPpublica = $_SERVER['REMOTE_ADDR'];
            }
            if(exiteRespuestaCompletaIP($idEncuesta,$IPpublica))
            {
                //ya se completo la encuesta con la ip ingresada
                return "5";
            }
        }
         // $dd= verificarPeriodoActivo($idEncuesta);
         // return $dd;
        if(!verificarPeriodoActivo($idEncuesta))
        {
           return "3";
        }
        
        return "1";
    }else{
        return "0";
    }
}

function chequearIdentificadorEncuesta($idEncuesta,$identificador){
    try{
    $base = new PDOConfig();
    $idEncuesta = $base->filtrar($idEncuesta);
    $identificador = $base->filtrar($identificador);
    
    $idPeriodo = 0;
    $sqpPe = "SELECT idPeriodo FROM periodosrecopilacion P WHERE idEncuesta = $idEncuesta AND FechaInicio <= '".date('Y-m-d')."'"
            . " AND (FechaFin >= '".date('Y-m-d')."' OR FechaFin is null)"; 
        
    if ($resPe = $base->query($sqpPe)) {
            if($resPe->rowCount() > 0){            
                $datos = $resPe->fetch(PDO::FETCH_ASSOC);
                $idPeriodo = $datos["idPeriodo"];
            }else {
                return "0";
            }
    }else{
        return "0";
    }
        
    $sql = "SELECT * FROM identificadoresparticipantes WHERE idPeriodo= $idPeriodo AND Identificacion='$identificador' AND idEncuesta=$idEncuesta ";
    //return $sql;
        if ($resel = $base->query($sql)) {
            if ($resel->rowCount() > 0) {
                $sql = "SELECT * FROM respuestas WHERE idPeriodo= $idPeriodo AND Identificacion='$identificador' AND idEncuesta=$idEncuesta ";
   
                if ($resel = $base->query($sql)) {
                    if ($resel->rowCount() > 0) {
                        return "2";
                    }else{
                        return "1";
                    }
                }else{
                    return "0";
                }
            }else{
                return "0";
            }
        } else {
            return "0";
        }

    } catch (Exception $e) {
        return "0";
    }
}

function verPeriodoEncuesta($idEncuesta,$idPeriodo){
 try{
    $base = new PDOConfig();
    $idEncuesta = $base->filtrar($idEncuesta);
    $idPeriodo = $base->filtrar($idPeriodo);
    $where = "";
    if($idPeriodo != "" && $idPeriodo != "0")
    {
        $where = " AND idPeriodo = $idPeriodo";
    }
    $sql = "SELECT idPeriodo,FechaInicio,FechaFin,Activo,Titulo FROM periodosrecopilacion "
            . " WHERE idEncuesta=$idEncuesta $where ";

    if ($resel = $base->query($sql)) {
        $resultado = $resel->fetch(PDO::FETCH_ASSOC);
        if($resultado["FechaInicio"] != ""){
            $resultado["FechaInicio"] = formatFecha($resultado["FechaInicio"]);    
        }
        
        if($resultado["FechaFin"] != ""){
            $resultado["FechaFin"] = formatFecha($resultado["FechaFin"]);    
        }        
       return json_encode($resultado);
    } else {
        return "0";
    }

  } catch (Exception $e) {
    return "0";
  }
}

function verRecolectoresEncuesta($idEncuesta,$idPeriodo){
 try{
    $base = new PDOConfig();
    $idEncuesta = $base->filtrar($idEncuesta);
    $idPeriodo = $base->filtrar($idPeriodo);
    $where = "";
    
    if($idPeriodo != "" && $idPeriodo != "0")
    {
        $where = " AND idPeriodo = $idPeriodo";
    }
    
    $sql = "SELECT R.idRecolector,R.idEncuesta,R.Tipo,R.FechaCarga,R.Codigo,R.Asunto,R.Mensaje,"
            . " (SELECT GROUP_CONCAT(O.Identificacion SEPARATOR '; ') FROM identificadoresparticipantes O WHERE O.idEncuesta =  R.idEncuesta AND O.idPeriodo = R.idPeriodo) AS identificadores, "
            . " (SELECT GROUP_CONCAT(E.Email SEPARATOR '; ') FROM recolectoresemails E WHERE E.idEncuesta =  R.idEncuesta AND E.idPeriodo = R.idPeriodo) AS emails "
            . " FROM recolectores R WHERE idEncuesta=$idEncuesta  $where ";

    if ($resel = $base->query($sql)) {
        $resultado = $resel->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($resultado);
    } else {
        return "0";
    }

  } catch (Exception $e) {
    return "0";
  }
}

function verTagsEncuesta($idEncuesta){
    try{
    $base = new PDOConfig();
    $idEncuesta = $base->filtrar($idEncuesta);
    
    $sql = "SELECT GROUP_CONCAT(T.Tag SEPARATOR ',') AS respuesta "
            . " FROM tagsencuesta R INNER JOIN tagsbusqueda T ON R.idTag = T.idtag "
            . " WHERE R.idEncuesta=$idEncuesta ";

    if ($resel = $base->query($sql)) {
        $resultado = $resel->fetch(PDO::FETCH_ASSOC);
        return $resultado["respuesta"];
    } else {
        return "";
    }

  } catch (Exception $e) {
    return "";
  }
}

function cerrarUnaEncuesta($idEncuesta,$idPeriodo,$idUsuario){
    
    //return cerrarEncuesta($idEncuesta, $idPeriodo,$idUsuario);
    if(cerrarEncuesta($idEncuesta, $idPeriodo,$idUsuario))
    {
        return "1";
    }else{
       return "<div class='alert alert-danger'><button class='close' data-dismiss='alert' type='button'>x</button><strong></strong>
		Ha ocurrido un error al intentar cerrar la encuesta</div>";
    }
}

function listarPeriodos($idEncuesta){
    
    try
    {
        $hayActivo = false;
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
                
                if($per["Activo"] == "1")
                {
                    $hayActivo = true;
                    $salida .= " <div class='row'><div class='col-md-12'><b>Estado: </b> Activo </div></div><div class='row'>&nbsp;</div>";
                }else{
                    $salida .= " <div class='row'><div class='col-md-12'><b>Estado: </b> Cerrado </div></div><div class='row'>&nbsp;</div>";
                }
                
                $datosReco = verRecolectoresEncuesta($idEncuesta, $per["idPeriodo"]);
                if($datosReco != "0"){
                    $datosComp = json_decode($datosReco);
                    //print_r($datosComp); exit();
                    if($datosComp[0]->identificadoresparticipantes != "")
                    {
                         $salida .= " <div class='row'><div class='col-md-12'><b>Identificadores: </b> ".$datosComp[0]->identificadoresparticipantes."</div></div><div class='row'>&nbsp;</div>";
                    }
                    
                    foreach ($datosComp as $datos){
                        
                        if($datos->Tipo == "WEB")
                        {
                             $salida .= " <div class='row'><div class='col-md-12'><b>Recolector Web: </b> http://uncsurveys.fi.uncoma.edu.ar/r/index.php?id=".encrypt($idEncuesta)."&cd=".encrypt($datos->Codigo)."</div></div><div class='row'>&nbsp;</div>";
                        }

                        if($datos->Tipo == "EMAIL")
                        {
                             $salida .= " <div class='row'><div class='col-md-12'><b>Recolector EMAIL: </b> ".$datos->recolectoresemails."</div></div><div class='row'>&nbsp;</div>";
                        }
                    }
                    
                    $salida .= " <div class='row'><div class='col-md-12'>";
                    $salida .="<a class='btn btn-info btn-sm' href='Negocios/exportarEncuestaPeriodo.php?id=".encrypt($idEncuesta)."&idP=".encrypt($per["idPeriodo"])."'>Exportar Respuestas</a>&nbsp;&nbsp;";
                    if($per["Activo"] == "1")
                    {
                         $salida .="<a class='btn btn-danger btn-sm' href='#'>Actualizar</a>&nbsp;&nbsp;";
                         $salida .="<a class='btn btn-primary btn-sm' href='#' onclick=\"cerrarPeriodo('".$idEncuesta."','".$per["idPeriodo"]."','".$per["Titulo"]."')\">Cerrar Per&iacute;odo</a>&nbsp;&nbsp;";
                    } 
                     
                }
                $salida .= "</div></div><div class='row'>&nbsp;</div>";
                $salida .= "</div></div></div></div><div class='row'>&nbsp;</div>";
            }
            
            if(!$hayActivo){
                    $salida .= " <div class='row'><div class='col-md-12'>";
                    $salida .="<a class='btn btn-info btn-sm' href='enc_publicarEncuestaLog.php?id=".encrypt($idEncuesta)."'>Nuevo Per&iacute;odo</a></div></div>";
                }
                
                
            
        }else{
            return "";
	}
        return $salida;
    } catch (Exception $e) {
        return "<div class='form-group has-error col-md-8'>
                <input type='text' class='form-control' id='error2' value='Error al conectar a la Base de Datos'>
            </div>" ;
    }
    
}

function listarParticipantesPanel($idEncuesta){
  try{
    $base = new PDOConfig();
    $idEncuesta = $base->filtrar($idEncuesta);
    $where = "";
    $idPeriodo = "0";
    $datosSalida = array();
    $datosSalida["Identificadores"] = "";
    $datosSalida["Emails"] = "";
    
    $sqlB = "SELECT MAX(idPeriodo) as idPeriodo FROM periodosrecopilacion WHERE idEncuesta = $idEncuesta";
     if ($resel = $base->query($sqlB)) {
        if($resel->rowCount() > 0){
            $resultado = $resel->fetch(PDO::FETCH_ASSOC);
            $idPeriodo = $resultado["idPeriodo"];
         }
     }else{
      return "0";
    } 
    
     if($idPeriodo <= 0)
         return "0";
         
    $sqlIde = "SELECT GROUP_CONCAT(O.Identificacion SEPARATOR ',') AS identificadores FROM respuestas O WHERE O.idEncuesta =  $idEncuesta AND O.idPeriodo = $idPeriodo";
     if ($resIdes = $base->query($sqlIde)) {
        if($resIdes->rowCount() > 0){
            $resultado = $resIdes->fetch(PDO::FETCH_ASSOC);
            $datosSalida["Identificadores"] = $resultado["identificadores"];
         }
     }else{
      return "0";
    }    

    $sqlEm = " SELECT GROUP_CONCAT(E.Email SEPARATOR ',') AS emails FROM recolectoresemails E WHERE E.idEncuesta =  $idEncuesta AND E.idPeriodo = $idPeriodo ";
    if ($resEm = $base->query($sqlEm)) {
        if($resEm->rowCount() > 0){
            $resultado = $resEm->fetch(PDO::FETCH_ASSOC);
            $datosSalida["Emails"] = $resultado["emails"];
        }
    }else{
      return "0";
    } 

    return json_encode($datosSalida);
    
  } catch (Exception $e) {
    return "0";
  }  
    
}


if ($_POST) {
    $rta = "";
    try {
        $oper = $_POST['oper'];
           
        if($oper != "iniciarEncuesta" && $oper != "compReco" && $oper != "comprobarIdentificador" && $oper != "verParaRecopilar" 
                && $oper != "pagXEnc" && $oper != "verEncuesta" && $oper != "recopilar")
        {
            $oLogin = new Login();
            if (!$oLogin->activa()) {
                exit();
            }
            $usuario = $oLogin->getIdUsuario();
        }else{
            $usuario = "";
        }
        switch ($oper) {

            case 'nueva': 
                $usuario = $oLogin->getIdUsuario();
                $titulo = $_POST["txtTitulo"];
                $tema = $_POST['cbTema'];
                $tipoEncuesta = $_POST['cbTipoEncuesta'];
                $descripcion = $_POST['txtDescripcion'];
                $rta = crearEncuesta($titulo, $tema, $tipoEncuesta, $descripcion, $usuario);
                break;

            case 'actualizar':
                $usuario = $oLogin->getIdUsuario();
                $idEncuesta = $_POST["hfIdEncuesta"];
                $titulo = $_POST["txtTitulo"];
                $tema = $_POST['cbTema'];
                $tipo = $_POST['cbTipoEnc'];
                $descripcion = $_POST['txtDescripcion'];
                $fechalimite = $_POST['txtFechaLimite'];
                $horaLimite = $_POST['txtHoraLimite'];
                $tags = $_POST['txtTags'];

                if (isset($_POST['ckTieneClave']))
                    $tieneClave = $_POST['ckTieneClave'];
                else
                    $tieneClave = "0";
                
                if (isset($_POST['ckMostrarResult']))
                    $mostrarRe = $_POST['ckMostrarResult'];
                else
                    $mostrarRe = "0";
                
                if (isset($_POST['ckBloquearIP']))
                    $bloquearIP = $_POST['ckBloquearIP'];
                else
                    $bloquearIP = "0";

                $claveAcc = $_POST['txtClaveAcc'];
                $cantAcc = $_POST['txtMaxAcc'];
                $proposito = $_POST['txtProposito'];
                $poblacion = $_POST['txtPoblacion'];
                $txtCarMu = $_POST['txtCarMu'];
                //echo $tema;
                $rta = actualizarEncuesta($idEncuesta, $titulo, $tema, $tipo, $descripcion, $usuario,
                        $fechalimite, $horaLimite, $tieneClave, $mostrarRe, $claveAcc, $cantAcc, $proposito,
                        $poblacion, $txtCarMu,$bloquearIP,$tags);
                break;

            case 'verEncuesta':
                $idEncuesta = $_POST["idEncuesta"];
                $rta = verEncuesta($idEncuesta);
                break;
            case 'listar':
                $usuario = $oLogin->getIdUsuario();
                $rta = listado($usuario);
                break;

            case 'listarCompartidas':
                $usuario = $oLogin->getIdUsuario();
                $rta = listadoCompartidas($usuario);
                break;
            
            case 'preguntasXEncuesta':
                $idEncuesta = $_POST["idEncuesta"];
                $rta = preguntasXEncuestas($idEncuesta);
                break;

            case 'nuevaPagina':
                $usuario = $oLogin->getIdUsuario();
                $idEncuesta = $_POST["idEncuesta"];
                $rta = nuevaPagina($idEncuesta);
                break;

            case 'eliminarPagina':
                $usuario = $oLogin->getIdUsuario();
                $idEncuesta = $_POST["idEncuesta"];
                $idPagina = $_POST["idPagina"];

                $rta = eliminarPagina($idEncuesta, $idPagina);
                break;
            case 'nuevoTituloPag':
                $usuario = $oLogin->getIdUsuario();
                $idEncuesta = $_POST["hdIdEncPag"];
                $idPagina = $_POST["nropagina"];
                $titulo = $_POST["txtTituloPag"];
                $rta = cambiarTituloPagina($idEncuesta, $idPagina, $titulo);
                break;

            case 'verParaRecopilar':
                $idEncuesta = $_POST["idEncuesta"];
                $rta = encuestaParaRecopilar($idEncuesta);
                break;

            case 'pagXEnc':
                //$usuario = $oLogin->getIdUsuario();
                $idEncuesta = $_POST["idEncuesta"];
                $rta = listadoPagEnc($idEncuesta);
                break;

            case 'iniciarEncuesta':
                $idEncuesta = $_POST["idEncuesta"];                           
                $rta = iniciaEncuesta($idEncuesta);
                break;
            
            case 'recopilar':
                $respuestas = $_POST["respuestas"];
                $idEncuesta = $_POST["hfIdEncuesta"];
                $idRespuesta = $_POST["hfidRespuesta"];
                
                $identificador = $_POST["hfIde"];
                $recopilador = $_POST["hfRecopilador"];
                $codigoPers = $_POST["hfCodigoPers"];     
                //print_r($_POST);
                $rta = contestarEncuesta($idEncuesta, $idRespuesta, $respuestas,$identificador,$recopilador,$codigoPers);
                break;
            
            case 'combo': 
                $usuario = $oLogin->getIdUsuario();
                $default = $_POST['vdefaul'];
                $selected = $_POST["selected"];
                $rta = combo($default, $selected,$usuario);
                break;
            case 'nuevaCopia': 
                $usuario = $oLogin->getIdUsuario();
                $titulo = $_POST["txtTituloCopia"];
                $idEncuesta = $_POST['cbMisEnc'];
                $rta = copiarEncuesta($idEncuesta, $titulo, $usuario);
                break;

            case 'publicar':
                $usuario = $oLogin->getIdUsuario();
                $idEncuesta = $_POST['idEncuesta'];
                $fechaIni = $_POST['txtFcIni'];
                $fechaFin = $_POST['txtFcFin'];
                $recolectores = $_POST['ckRecolector'];
                $codigoWeb = $_POST['hfCodigoWeb'];
                $enlaceWeb = $_POST['txtEnlaceWeb'];
                $destinos = $_POST['txtDestinos'];
                $asunto = $_POST['txtAsunto'];
                $mensaje = $_POST['txtMensaje'];
                $titulo = $_POST['hfTitulo'];
                $identificadores = $_POST['txtIdsPart'];                
                //print_r($_POST);
                $rta = publicarParaRecopilar($idEncuesta,$fechaIni,$fechaFin,$recolectores,
                        $codigoWeb,$destinos,$asunto,$mensaje,$titulo,$identificadores,"");
                break;
            
            case 'publicarLong':
                $usuario = $oLogin->getIdUsuario();
                $idEncuesta = $_POST['idEncuesta'];
                $fechaIni = $_POST['txtFcIni'];
                $fechaFin = $_POST['txtFcFin'];
                $recolectores = $_POST['ckRecolector'];
                $codigoWeb = $_POST['hfCodigoWeb'];
                $enlaceWeb = $_POST['txtEnlaceWeb'];
                $destinos = $_POST['txtDestinos'];
                $asunto = $_POST['txtAsunto'];
                $mensaje = $_POST['txtMensaje'];
                $titulo = $_POST['hfTitulo'];
                $identificadores = $_POST['txtIdsPart']; 
                $tituloPer = $_POST['txtTituloPeriodo'];
                //print_r($_POST);
                $rta = publicarParaRecopilar($idEncuesta,$fechaIni,$fechaFin,$recolectores,
                        $codigoWeb,$destinos,$asunto,$mensaje,$titulo,$identificadores,$tituloPer);
                break;
            
            case 'actReco':
                $usuario = $oLogin->getIdUsuario();
                $idEncuesta = $_POST['idEncuesta'];
                $fechaIni = $_POST['txtFcIni'];
                $fechaFin = $_POST['txtFcFin'];
                $recolectores = $_POST['ckRecolector'];
                $codigoWeb = $_POST['hfCodigoWeb'];
                $enlaceWeb = $_POST['txtEnlaceWeb'];
                $destinos = $_POST['txtDestinos'];
                $asunto = $_POST['txtAsunto'];
                $mensaje = $_POST['txtMensaje'];
                $titulo = $_POST['hfTitulo'];
                $identificadores = $_POST['txtIdsPart'];
                $idPeriodo = $_POST['hfIdPeriodo'];
                //print_r($_POST);
                $rta = actualizarRecopiladores($idEncuesta,$idPeriodo,$fechaIni,$fechaFin,$recolectores,
                        $codigoWeb,$destinos,$asunto,$mensaje,$titulo,$identificadores);
                break;
            
            case 'compReco':
                $idEncuesta = $_POST['idEncuesta'];
                $rta =chekearEncuestaParaRecopilar($idEncuesta);
                break;
            
            case 'compartir':
                $idEncuesta = $_POST['hfIdEncuesta'];
                $idGrupo = $_POST['cbGrupos'];
                $rta = compartirEncuesta($idEncuesta, $idGrupo);
                break;
            
            case 'verEncInd':
                    $idEncuesta = $_POST['hfIdEncuesta'];
                    $idGrupo = $_POST['cbGrupos'];
                    $rta = compartirEncuesta($idEncuesta, $idGrupo);
                    break;
            case 'respXEnc':
                    $idEncuesta = $_POST['idEncuesta'];
                    $rta = json_encode(respuestasPorEncuesta($idEncuesta,0));
                    break;
            case 'respXEncXPer':    
                    $idEncuesta = $_POST['idEncuesta'];
                    $idPeriodo = $_POST['idPeriodo'];
                    $rta = json_encode(respuestasPorEncuesta($idEncuesta,$idPeriodo));
                    break;
            case 'unaResps':
                    $idEncuesta = $_POST['idEncuesta'];
                    $idRespuesta = $_POST['idRespuesta'];
                    $rta = verUnaEncuestaCompleta($idEncuesta,$idRespuesta);
                    break;
            case 'comprobarIdentificador':
                    $idEncuesta = $_POST['idEncuesta'];
                    $identificador = $_POST['ide'];
                    $rta = chequearIdentificadorEncuesta($idEncuesta,$identificador);
                    break;
            
            case 'verPer':
                    $idEncuesta = $_POST['idEncuesta'];
                    $idPeriodo = $_POST['idPeriodo'];
                    $rta = verPeriodoEncuesta($idEncuesta,$idPeriodo);
                    break;    
                
            case 'verRecos':
                    $idEncuesta = $_POST['idEncuesta'];
                    $idPeriodo = $_POST['idPeriodo'];
                    $rta = verRecolectoresEncuesta($idEncuesta,$idPeriodo);
                    break;
            case 'comboPeriodosAn':
                $default = $_POST['vdefaul'];
                $selected = $_POST["selected"];
                $idEncuesta = $_POST['idEncuesta'];
                $rta = comboPeriodos($default, $selected,$idEncuesta);
                break;
            
            case 'tagsEnc':
                $idEncuesta = $_POST['idEncuesta'];
                $rta = verTagsEncuesta($idEncuesta);
                break;
            
            case 'cerrarEncuesta':
                $idEncuesta = $_POST['idEncuesta'];
                $idPeriodo = $_POST['idPeriodo'];
                $usuario = $oLogin->getIdUsuario();
                $rta = cerrarUnaEncuesta($idEncuesta,$idPeriodo,$usuario);
                break;
            
            case 'listarPerLog':
                $idEncuesta = $_POST['idEncuesta'];
                $rta = listarPeriodos($idEncuesta);
                break;
        
            case 'verPartPanel':
                $idEncuesta = $_POST['idEncuesta'];
                $rta = listarParticipantesPanel($idEncuesta);
                break;
            
            case 'listarPublicas':
                $rta = listadoPublicas();
                break;
            
            default : $rta = "Operaci&oacute;n Incorrecta";
                break;
        }
    } catch (Exception $e) {
        echo "<div class='form-group has-error col-md-10'>
				<input type='text' class='form-control' id='error2' value='Error ejecutar la operaci&oacute;n'>
				</div>";
        exit();
    }

    echo $rta;
}