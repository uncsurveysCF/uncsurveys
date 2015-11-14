<?php
header('Content-type: text/html; charset=utf-8');
require_once("html2pdf.class.php");
require_once('../libs/PDOConfig.php');
require_once('../Negocios/utilidades.php');
require_once("../libs/Login.php");

 $oLogin=new Login();
 if(!$oLogin->activa()){
 header('location:../index.php');
 }
if($_GET){
	
	$idV = strtoupper($_GET["id"]);
	$base = new PDOConfig();
		
	/*$sql = " SELECT * FROM vw_verificaciones WHERE idVerificacion = $idV AND idTaller = $idT";*/
	
	$sql = "SELECT V.*, L.Descripcion AS LocalidadVe, T.Descripcion AS tipoUso, P.* FROM vehiculos V  
			INNER JOIN personas P ON V.CodigoTitular = P.CodigoTitular
			INNER JOIN tipousovehiculo T ON V.idTipoUso = T.idTipoUso
			INNER JOIN localidades L ON V.idLocalidad = L.idLocalidad
			WHERE V.Dominio = '$idV'";	
	
	//echo $sql;
	$resp = $base->query($sql);

	if($row = $resp->fetch(PDO::FETCH_ASSOC))
	{
		$fecha = date("d/m/Y");
		$hora = date("H:i");
		
		$dominio = $row["Dominio"];
		$idTipoVe = $row["idTipoVehiculo"];
		$idTipoUso = $row["idTipoUso"];
		$TipoUso = $row["tipoUso"];
		$marca = $row["Marca"];
		$modelo = $row["Modelo"];
		$anio = $row["Anio"];
		$motorMarca = $row["MotorMarca"];
		$MotorNro = $row["MotorNro"];
		$MotorAnio = $row["MotorAnio"];
		
		$idLocT = $row["LocalidadVe"];
		
		$tipoDoc = $row["TipoDoc"];
		$nroDoc = $row["NroDoc"];
		$cuit = $row["Cuit"];
		$domicilio = $row["Domicilio"];
		$telefono = $row["Telefono"];
		$tipoPer = $row["TipoPersona"];
		$email = $row["Email"];
		$codigoTitular = $row["CodigoTitular"];
		$ChasisMarca = $row["ChasisMarca"];
		$ChasisNro = $row["ChasisNro"];
		$ChasisAnio = $row["ChasisAnio"];
		
		
		
		if($tipoPer == "F"){
			$doc = $tipoDoc." ".$nroDoc;
			$DescTitular = $row["Apellido"].", ".$row["Nombre"];
		}else{
			$doc = "CUIT ".$cuit;
			$DescTitular = $row["RasonSocial"];
		}
		
	}

$content = '
<div style="background-color: #fff;font-family: Arial, Geneva, sans-serif;font-size: 8pt;">
  		<table align="center" cellpadding="0" width="700" cellspacing="0" style="border: 1px solid;">
  			<tr>
  				<td style="border-bottom: 1px solid;text-align: left;" width="350" height="30" valign="middle" ><b>REVISION TECNICA VEHICULOS</b></td>
  				<td style="border-bottom: 1px solid;text-align: right;" width="350" valign="middle">'._toUp($TipoUso).'&nbsp;&nbsp;&nbsp;</td>
  			</tr> 
  			<tr>
  				<td colspan="2" align="right" border: 1px solid;text-align:center;font-weight: bold;">
  				<b>Fecha: '.$fecha.' &nbsp;&nbsp;&nbsp;&nbsp; Hora: '.$hora.'</b></td>
  			</tr>
  			<tr>
  				<td colspan="2">&nbsp;</td>
  			</tr> 
  			<tr>
  				<td align="center">'._toUp($DescTitular).' - '._toUp($doc).' </td>
  			</tr>
  			<tr>
  				<td align="center">'._toUp($domicilio).'</td>
  				<td align="center" >'._toUp($motorMarca).'<br />'._toUp($MotorNro).'</td>
  			</tr> 
  			<tr>
  				<td align="center">'._toUp($idLocT).'</td>
  				<td align="center">'._toUp($ChasisMarca).'<br />'._toUp($ChasisNro).'</td>
  			</tr> 
  			<tr>
  				<td align="center">'._toUp($dominio).'</td>
  				<td>&nbsp;</td>
  			</tr>  			
  			<tr>
  				<td colspan="2">&nbsp;</td>
  			</tr> 
  			<tr>
  				<td>&nbsp;</td>
  				<td style="margin:0px;padding:0px;">
  				<table width="360" style="border: 1px solid;border-bottom:0px none;margin:0px;padding:0px;" cellpadding="0" cellspacing="0">
  					<tr><td style="border: 1px solid;" width="350" colspan="5">TACOGRAFO</td></tr>
  					<tr><td style="border: 1px solid;" colspan="5">MARCA</td></tr>
  					<tr><td style="border: 1px solid;" colspan="5">N&deg;</td></tr>
  					<tr>
  					<td style="border: 1px solid;" width="73"><span style="font-size: 7pt;">ASIENTOS</span><br /><br /></td>
  					<td style="border: 1px solid;" width="73"><span style="font-size: 7pt;">BAR</span><br /><br /></td>
  					<td style="border: 1px solid;" width="73"><span style="font-size: 7pt;">BA&Ntilde;O</span><br /><br /></td>
  					<td style="border: 1px solid;" width="73"><span style="font-size: 7pt;">REFR</span><br /><br /></td>
  					<td style="border: 1px solid;" width="70"><span style="font-size: 7pt;">CALEF</span><br /><br /></td>
  					</tr>
  				</table>
  				</td>
  			</tr> 
  			<tr>
  				<td colspan="2" style="margin:0px;padding:0px;">
  				<table width="700" style="border: 1px solid;border-right:none;margin:0px;padding:0px;" cellpadding="0" cellspacing="0">
  				<tr>
  					<td style="border: 1px solid;" width="160">ALINEACI&Oacute;N <span style="width:30pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> M/KM</td>
  					<td style="border: 1px solid;" width="73">CO</td>
  					<td style="border: 1px solid;" width="73">HC</td>
  					<td style="border: 1px solid;" width="73">HUMO</td>
  					<td style="border: 1px solid;border-left:none;" width="340">RUIDO<span style="width:30pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
  					INTERIOR<span style="width:30pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
  					DB/ESCAPE<span style="width:30pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>DB</td>
  				</tr>
  				</table>
  				</td>
  			</tr>
  			<tr>
  				<td style="margin:0px;padding:0px;border: 1px solid;" height="120" rowspan="2">
  				SISTEMA DE DIRECCI&Oacute;N
  				</td>
  				<td style="margin:0px;padding:0px;border: 1px solid;" height="40">
  				SISTEMA DE ESCAPE
  				</td>
  			</tr>	
  			<tr>
  				<td style="margin:0px;padding:0px;border: 1px solid;border-bottom:0pt none;" height="20">
  				SISTEMA ELECTRICO - LUCES - INSTRUMENTIS Y ACCESORIOS
  				</td>
  			</tr>
  			<tr>
  				<td style="margin:0px;padding:0px;border: 1px solid;" 
  				height="100" rowspan="4">
  				TREN DELANTERO
  				</td>
  			</tr>
  			<tr>
  				<td style="margin:0px;padding:0px;border-left:1px solid;border-right:1px solid;" height="50">&nbsp;</td>
  			</tr>
  			<tr>
  				<td style="margin:0px;padding:0px;border-left:1px solid;border-right:1px solid;" height="30">&nbsp;</td>
  			</tr>
  			<tr>
  				<td style="margin:0px;padding:0px;padding-top:5px;;border: 1px solid;">
  				CARROCERIA - LETREROS E INDICACIONES
  			</td>
  			</tr>
  			<tr>
  			<td style="margin:0px;padding:0px;border: 1px solid;" rowspan="2">
  				TREN TRASERO
  			</td>
  			<td style="border: 1px solid;">
  			<table width="350" style="margin:1px;padding:0px;" cellpadding="0" cellspacing="0">
  			<tr>
  				<td style="font-size:7pt;" colspan="6">BANDA</td>
  			</tr>	
  			<tr style="font-size:7pt;">
  				<td width="60">FRENTE</td>
  				<td width="60"><table cellpadding="0" cellspacing="1">
  				<tr><td>SI </td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  				<td>NO </td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  				</tr></table></td>
  				<td>LAT. DER. </td>
  				<td width="60"><table cellpadding="0" cellspacing="1"><tr><td>SI </td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  				<td>NO </td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  				</tr></table></td>
  				<td >CIRCULO </td>
  				<td width="60"><table cellpadding="0" cellspacing="1"><tr><td>SI </td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  				<td>NO </td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  				</tr></table></td>
  			</tr>
  			<tr style="font-size:7pt;">
  				<td>TRASERA</td>
  				<td width="60"><table width="60" cellpadding="0" cellspacing="1"><tr><td>SI </td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  				<td>NO </td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  				</tr></table></td>
  				<td>LAT. IZQ. </td>
  				<td width="60"><table width="60" cellpadding="0" cellspacing="1"><tr><td>SI </td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  				<td>NO </td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  				</tr></table></td>
  			</tr>
  			</table>	
  			</td>
  			</tr>
			<tr>
			<td>
			<table width="350" style="margin:0px;padding:0px;" cellpadding="0" cellspacing="0">
				<tr>
				 <td style="border: 1px solid;" align="center" width="55">EJES</td>
				 <td style="border: 1px solid;" align="center" width="105">PESO (KG)</td>
				 <td style="border: 1px solid;" align="center" width="105">F. IZQ</td>
				 <td style="border: 1px solid;" align="center" width="105">F. DER</td>
				</tr>
				<tr>
				 <td style="border: 1px solid;" align="center" width="50">1&deg;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				</tr>
				<tr>
				 <td style="border: 1px solid;" align="center" width="50">2&deg;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				</tr>
				<tr>
				 <td style="border: 1px solid;" align="center" width="50">3&deg;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				</tr>
				<tr>
				 <td style="border: 1px solid;" align="center" width="50">4&deg;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				</tr>
				<tr>
				 <td style="border: 1px solid;" align="center" colspan="2">FRENO DE ESTACIONAMIENTO</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				 <td style="border: 1px solid;" align="center" width="100">&nbsp;</td>
				</tr>
			</table>
			</td>
  			</tr>
  			<tr>
			<td style="border: 1px solid;" >
			CHASIS<br /><br />
			ALTO<br />
			ANCHO<br />
			LARGO<br />
			</td>
			<td style="border: 1px solid;" rowspan="2">
			<table width="350" style="margin:0px;margin-top:5px;;padding:0px;" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="3" height="20">FRENOS</td>
				</tr>
				<tr>
					<td width="50" height="30">1&deg; EJE</td>
					<td width="120">
					<table cellpadding="0" cellspacing="1">
					<tr>
						<td>EFICIENCIA</td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>	  				
	  				</tr></table>
					</td>
					<td>
					<table cellpadding="0" cellspacing="1">
					<tr>
						<td>DIFERENCIA ENTRE RUEDAS</td>
						<td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>	  				
	  				</tr></table>
					</td>
				</tr>
				<tr>
					<td width="50" height="30">2&deg; EJE</td>
					<td width="120">
					<table cellpadding="0" cellspacing="1">
					<tr>
						<td>EFICIENCIA</td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>	  				
	  				</tr></table>
					</td>
					<td>
					<table cellpadding="0" cellspacing="1">
					<tr>
						<td>DIFERENCIA ENTRE RUEDAS</td>
						<td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>	  				
	  				</tr></table>
					</td>
				</tr>
				<tr>
					<td width="50" height="30">3&deg; EJE</td>
					<td width="120">
					<table cellpadding="0" cellspacing="1">
					<tr>
						<td>EFICIENCIA</td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>	  				
	  				</tr></table>
					</td>
					<td>
					<table cellpadding="0" cellspacing="1">
					<tr>
						<td>DIFERENCIA ENTRE RUEDAS</td>
						<td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>	  				
	  				</tr></table>
					</td>
				</tr>
				<tr>
					<td width="50" height="30">4&deg; EJE</td>
					<td width="120">
					<table cellpadding="0" cellspacing="1">
					<tr>
						<td>EFICIENCIA</td><td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>	  				
	  				</tr></table>
					</td>
					<td>
					<table cellpadding="0" cellspacing="1">
					<tr>
						<td>DIFERENCIA ENTRE RUEDAS</td>
						<td style="border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</td>	  				
	  				</tr>
	  				</table>
					</td>
				</tr>
			</table>
			</td>
			</tr>
			<tr>
				<td style="border: 1px solid;" height="50">NEUMATICOS Y LLANTAS</td>
			</tr>		
			<tr>
				<td style="border: 1px solid;" height="50">ELEMENTOS DE EMERGENCIA</td>
				<td style="border: 1px solid;" height="50" rowspan="2"> 
				ELEMENTOS DE UNI&Oacute;N - OTRAS ANOMALIAS
				</td>
			</tr>
			<tr>
				<td style="border: 1px solid;">
				<table style="margin:0px;padding:0px;" cellpadding="0" cellspacing="0">
				 <tr>
					<td valign="middle" width="90">SUSPENSI&Oacute;N</td>
					<td>
						<table style="margin:0px;padding:0px;" cellpadding="0"
					 		cellspacing="0">
					 	<tr style="font-size:7pt;">
					 		<td style="border: 1px solid;" width="55">&nbsp;</td>
					 		<td style="border: 1px solid;" width="55">Izquierda</td>
					 		<td style="border: 1px solid;" width="55">DIF.(%)</td>
					 		<td style="border: 1px solid;" width="57">Derecha</td>
					 	</tr>	
					 	<tr>
					 		<td style="border: 1px solid;">Del</td>
					 		<td style="border: 1px solid;">&nbsp;</td>
					 		<td style="border: 1px solid;">&nbsp;</td>
					 		<td style="border: 1px solid;">&nbsp;</td>
					 	</tr>
					 	<tr>
					 		<td style="border: 1px solid;">Tras</td>
					 		<td style="border: 1px solid;">&nbsp;</td>
					 		<td style="border: 1px solid;">&nbsp;</td>
					 		<td style="border: 1px solid;">&nbsp;</td>
					 	</tr>
					 	</table>
					</td>
				</tr>
				</table>
				</td>
			</tr>
    	</table>
</div>';
  
    $html2pdf = new HTML2PDF('P','A4','es',true,'UTF-8', array(5, 5, 5, 5));
    $html2pdf->WriteHTML($content);
    $nomArchi = "prueba.pdf";
    $html2pdf->Output($nomArchi);

echo $content;
}
else{
	
}

