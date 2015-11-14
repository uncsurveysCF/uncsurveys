<?php

define("_RPATH", "../libs/R-3.2.0/bin/Rscript.exe");
define("_LINKREC", "http://localhost/uncsurveys/r/index.php");
define("_LINKUNCSURVEY", "http://localhost/uncsurveys/index.php");


define("_SMTP", "smtp.gmail.com");
define("_FROM", "uncsurveys2015@gmail.com");
define("_EMAILUSR", "uncsurveys2015@gmail.com");
define("_EMAILPASS", "uncSurveys15");
/*define("_SMTP", "smtp.gmail.com");
define("_FROM", "silviroa@gmail.com");
define("_EMAILUSR", "silviroa@gmail.com");
define("_EMAILPASS", "ChichiRoa263");*/
define("_PUERTO", 465);

function formatFecha($cadFecha) {
    if ($cadFecha != "") {
        $cadFecha = str_replace("/", "-", $cadFecha);
        list( $v1, $v2, $v3 ) = explode("-", $cadFecha);
        return $v3 . "-" . $v2 . "-" . $v1;
    } else
        return "";
}

function formatFechaHora($cadFecha) {
    if (($cadFecha != "") && ($cadFecha != "0000-00-00 00:00")) {
        list($v1, $v2) = explode(" ", $cadFecha);
        list($v3, $v4, $v5) = explode("-", $v1);
        $v2 = substr($v2, 0, 5);
        return $v5 . "/" . $v4 . "/" . $v3 . " " . $v2;
    } else
        return "";
}

function boolSINO($bool) {

    if (($bool) || ($bool == "1")) {
        return "SI";
    }
    return "NO";
}

function bool01($bool) {

    if (($bool)) {
        return "1";
    }
    return "0";
}

function _01bool($bool) {

    if (($bool == "1")) {
        return true;
    }
    return false;
}

function _01Checked($bool) {

    if (($bool == "1")) {
        return "checked";
    }
    return "";
}

function formatNroCert($nro) {

    return str_pad($nro, 6, "0", STR_PAD_LEFT);
}

function _toUp($str) {

    return mb_strtoupper($str, 'utf-8');
}

function decimalParaMostrar($numero) {
    //return str_replace(".",",",$numero);
    return number_format($numero, 2, ",", "");
}

function decimalParaGuardar($numero) {
    return str_replace(",", ".", $numero);
}

function sumarDias($fecha, $dias) {
    $nuevafecha = strtotime("+$dias day", strtotime($fecha));
    $nuevafecha = date("d/m/Y", $nuevafecha);
    return $nuevafecha;
}

function restarDias($fecha, $dias) {
    $nuevafecha = strtotime("-$dias day", strtotime($fecha));
    $nuevafecha = date("d/m/Y", $nuevafecha);
    return $nuevafecha;
}

function sumarMeses($fecha, $meses) {
    $nuevafecha = strtotime("+$meses month", strtotime($fecha));
    $nuevafecha = date("d/m/Y", $nuevafecha);
    return $nuevafecha;
}

function diferenciaDias($FechaD, $FechaH) {
    list( $dD, $mD, $yD ) = explode('-', $FechaD);
    list( $dH, $mH, $yH ) = explode('-', $FechaH);
//calculo timestam de las dos fechas
    $timestamp1 = mktime(0, 0, 0, $mD, $dD, $yD);
    $timestamp2 = mktime(0, 0, 0, $mH, $dH, $yH);

//resto a una fecha la otra
    $segundos_diferencia = $timestamp1 - $timestamp2;
//echo $segundos_diferencia;
//convierto segundos en d�as
    $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

//obtengo el valor absoulto de los d�as (quito el posible signo negativo)
    $dias_diferencia = abs($dias_diferencia);

//quito los decimales a los d�as de diferencia
    $dias_diferencia = floor($dias_diferencia);

    return $dias_diferencia + 1;
}

function diasEntreFechas($Inicio, $fin) {
    $dif = (($d * 24) + $h) . hrs . " " . $m . "min";
    $dif2 = $d . $space . dias . " " . $h . hrs . " " . $m . "min";

    echo "Diferencia en horas: " . $dif;

    echo "Diferencia en dias: " . $dif2;

    $date1 = new DateTime(formatFecha($Inicio));
    $date2 = new DateTime(formatFecha($fin));
    $intervalo = $date1->diff($date2);
    return $intervalo->format('%a');
}

function suma_fechas($fecha, $ndias) {
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha))
        list($dia, $mes, $anio) = explode("/", $fecha);

    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha))
        list($dia, $mes, $anio) = explode("-", $fecha);

    $nueva = mktime(0, 0, 0, $mes, $dia, $anio) + $ndias * 24 * 60 * 60;
    $nuevafecha = date("Y-m-d", $nueva);

    return ($nuevafecha);
}

function compara_fechas($fecha1, $fecha2) {

    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha1))
        list($dia1, $mes1, $anio1) = explode("/", $fecha1);

    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha1))
        list($dia1, $mes1, $anio1) = explode("-", $fecha1);

    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha2))
        list($dia2, $mes2, $anio2) = explode("/", $fecha2);

    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha2))
        list($dia2, $mes2, $anio2) = explode("-", $fecha2);

    $dif = mktime(0, 0, 0, $mes1, $dia1, $anio1) - mktime(0, 0, 0, $mes2, $dia2, $anio2);

    return ($dif);
}

function fechaEspaniol() {
    $diaSt = date('w');
    $dia = date('d');
    $mes = date('n');
    $ano = date('Y');
    $meses = array('', 'Enero', 'Febrero',
        'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
        'Noviembre', 'Diciembre');

    $diass = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
    return $diass[$diaSt] . ', ' . $dia . ' de ' . $meses[$mes] . ' de ' . $ano;
}

function redondearDecimal($num) {
    return round($num * 100) / 100;
}

/* * *********************************************** */

function encrypt($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+', '/', '='), array('-', '_', '.'), $data);
    return $data;
}

function decrypt($string) {
    $data = str_replace(array('-', '_', '.'), array('+', '/', '='), $string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

function generaPass(){
    //Se define una cadena de caractares. Te recomiendo que uses esta.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
     
    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass=5;
     
    //Creamos la contraseña
    for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
     
        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}


/* * *********************************************** */

function enviarMail($destino,$asunto, $cuerpo) {
    $mail = new phpmailer();
// Introducimos la información del remitente del mensaje
    $mail->From = _FROM;
    $mail->FromName = "UNCSurveys";
// y los destinatarios del mensaje. Podemos especificar más de un destinatario
    $mail->AddAddress($destino, "UNCSurveys");
    $mail->IsHTML(true); // enviar como HTML
// Añadimos el mensaje: asunto, cuerpo del mensaje en HTML y en formato
// solo texto
    $mail->AddEmbeddedImage('../img/logo80.png', 'logo_2u', '../img/logo80.png', 'base64', 'image/png');
    $mail->AddEmbeddedImage('../img/logo300.png', 'logo_2uP', '../img/logo300.png', 'base64', 'image/png');
    $mail->Subject = $asunto;
    $mail->Body = $cuerpo;
//$mail->AltBody  =  "Y este es el mensaje de solo texto"; // Para los queno pueden recibir en formato HTML

    $mail->IsSMTP();                                   // enviar vía SMTP
    $mail->Host = _SMTP; // Servidores SMTP
    $mail->SMTPAuth = true;     // activar la identificacín SMTP
    $mail->Username = _EMAILUSR;  // usuario SMTP
    $mail->Password = _EMAILPASS; // clave SMTP
    $mail->Port = _PUERTO;
    $mail->SMTPSecure = "ssl";
//print_r($mail);

    if (!$mail->Send()) {
        echo "El mensaje no se ha podido enviar - Error: " . $mail->ErrorInfo; exit();
        return false;
    } else {
        return true;
    }
}

function envioVinculoRecoleccion($mensaje, $titulo, $idEncuenta,$codigoReco,$codigoPers) {
       
    $cuerpo ="";
    $mensaje = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"<br/>",$mensaje);//nl2br($mensaje);
    $cuerpo .= "<table style='width:650px;margin:10px auto;font:normal 12px Arial;border: 2px solid #e8e8e8;'>
				<tr>
                 <td colspan='2' style='background:#D9EDF7;text-align:center'><br />
                 <h1 style='color:#3A87AD;font:normal 18px Arial;'><span><img alt='UNCSurveys' src='cid:logo_2uP' /></span>
                 <h3 style='color:#3A87AD;font:normal 14px Arial;'> Encuesta: $titulo</h3>
                 <br />
                </td><tr>
				<tr>
					<td colspan='2' style='border-top: 2px solid #e8e8e8;'>&nbsp;</td>
				</tr>
				<tr>
					<td align='center' colspan='2'>
					".$mensaje."	
					</td>
				</tr>
				<tr>
				<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
				<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<td align='center' colspan='2'>
                                            Para participar de la encuesta presione el botón						 
					</td>
				</tr>
				<tr>
				<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<td align='center' colspan='2'>
						<a href='"._LINKREC."?id=$idEncuenta&cd=$codigoReco&cp=$codigoPers' style='padding: 8px 12px;color:#ffffff;font:normal 14px Arial;
						                        background-color:#474949;text-decoration:none;'>
						Comenzar la Encuesta </a>
					</td>
				</tr>
				<tr>
				<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
				<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
				<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
				<td align='center' colspan='2' style='border-top: 2px solid #e8e8e8;'><p>
				<small><i>Por favor no reenv&iacute;e este mensaje el enlace es &uacute;nico.</i></small>
				</td>
				</tr>
				<tr>
				<td colspan='2' align='center'>
				<img alt='UNCSurveys' src='cid:logo_2u' />
				</td>
				</tr>
				</table>";

    return $cuerpo;
}

function envioRecuperarClave($mensaje) {
        
    $cuerpo .="";
    $cuerpo .= "<html>
                <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'></head><body>
                <table style='width:650px;margin:10px auto;font:normal 12px Arial;border: 2px solid #e8e8e8;'>
		<tr>
                 <td colspan='2' style='background:#D9EDF7;text-align:center'><br />
                 <h1 style='color:#3A87AD;font:normal 18px Arial;'><span><img alt='UNCSurveys' src='cid:logo_2uP' /></span>
                 <h3 style='color:#3A87AD;font:normal 14px Arial;'> Usuarios</h3>
                 <br />
                </td></tr>
                        <tr>
                            <td colspan='2' style='border-top: 2px solid #e8e8e8;'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align='center' colspan='2'>
                            $mensaje	
                            </td>
                        </tr>
                        <tr>
                        <td colspan='2'>&nbsp;</td>
                        </tr>
                        <tr>
                                <td align='center' colspan='2'>
                                        <a href='"._LINKUNCSURVEY."' style='padding: 8px 12px;color:#ffffff;font:normal 14px Arial;
                                                                background-color:#474949;text-decoration:none;'>
                                        INGRESAR UNCSURVEYS </a>
                                </td>
                        </tr>
                        <tr>
                        <td colspan='2'>&nbsp;</td>
                        </tr>
                        <tr>
                        <td align='center' colspan='2' style='border-top: 2px solid #e8e8e8;'><p>
                        <small><i>Gracias por utilizar nuestros servicios</i></small>
                        </td>
                        </tr>
                        <tr>
                        <td colspan='2' align='center'>
                        <img alt='UNCSurveys' src='cid:logo_2u' />
                        <br />uncsurveys.fi.uncoma.edu.ar
                        </td>
                        </tr>
                        </table></body></html>";

    return $cuerpo;
}


function envioInvitacionGrupo($mensaje) {        
    $cuerpo .="";
    $cuerpo .= "<html>
                <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'></head><body>
                <table style='width:650px;margin:10px auto;font:normal 12px Arial;border: 2px solid #e8e8e8;'>
		<tr>
                 <td colspan='2' style='background:#D9EDF7;text-align:center'><br />
                 <h1 style='color:#3A87AD;font:normal 18px Arial;'><span><img alt='UNCSurveys' src='cid:logo_2uP' /></span>
                 <h3 style='color:#3A87AD;font:normal 14px Arial;'> Usuarios - Grupos</h3>
                 <br />
                </td></tr>
                        <tr>
                            <td colspan='2' style='border-top: 2px solid #e8e8e8;'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align='center' colspan='2'>
                            $mensaje	
                            </td>
                        </tr>
                        <tr>
                        <td colspan='2'>&nbsp;</td>
                        </tr>
                        <tr>
                                <td align='center' colspan='2'>
                                        <a href='"._LINKUNCSURVEY."' style='padding: 8px 12px;color:#ffffff;font:normal 14px Arial;
                                                                background-color:#474949;text-decoration:none;'>
                                        INGRESAR UNCSURVEYS </a>
                                </td>
                        </tr>
                        <tr>
                        <td colspan='2'>&nbsp;</td>
                        </tr>
                        <tr>
                        <td align='center' colspan='2' style='border-top: 2px solid #e8e8e8;'><p>
                        <small><i>Gracias por utilizar nuestros servicios!</i></small>
                        </td>
                        </tr>
                        <tr>
                        <td colspan='2' align='center'>
                        <img alt='UNCSurveys' src='cid:logo_2u' />
                        <br />uncsurveys.fi.uncoma.edu.ar
                        </td>
                        </tr>
                        </table></body></html>";

    return $cuerpo;
}

function envioNuevaCuenta($user, $pass) {        
    $cuerpo .="";
    $cuerpo .= "<html>
                <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'></head><body>
        <table style='width:650px;margin:10px auto;font:normal 12px Arial;border: 2px solid #e8e8e8;'>
		<tr>
                 <td colspan='2' style='background:#D9EDF7;text-align:center'><br />
                 <h1 style='color:#3A87AD;font:normal 18px Arial;'><span><img alt='UNCSurveys' src='cid:logo_2uP' /></span>
                 <h3 style='color:#3A87AD;font:normal 16px Arial;'> Usuarios </h3>
                 <br />
                </td></tr>
                        <tr>
                            <td colspan='2' style='border-top: 2px solid #e8e8e8;'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align='center' colspan='2'>
                            Te has registrado en UNCSurveys con los siguientes datos: <br /><br />
                            <b>Usuario:</b> $user<br />
                            <b>Contrase&ntilde;a:</b> $pass</td>
                        </tr>
                        <tr>
                        <td colspan='2'>&nbsp;</td>
                        </tr>
                        <tr>
                                <td align='center' colspan='2'>
                                        <a href='"._LINKUNCSURVEY."' style='padding: 8px 12px;color:#ffffff;font:normal 14px Arial;
                                                                background-color:#474949;text-decoration:none;'>
                                        INGRESAR UNCSURVEYS </a>
                                </td>
                        </tr>
                        <tr>
                        <td colspan='2'>&nbsp;</td>
                        </tr>
                        <tr>
                        <td align='center' colspan='2' style='border-top: 2px solid #e8e8e8;'><p>
                        <small><i>Gracias por utilizar nuestros servicios!</i></small>
                        </td>
                        </tr>
                        <tr>
                        <td colspan='2' align='center'>
                        <img alt='UNCSurveys' src='cid:logo_2u' />
                        <br />uncsurveys.fi.uncoma.edu.ar
                        </td>
                        </tr>
                        </table></body></html>";

    return $cuerpo;
}