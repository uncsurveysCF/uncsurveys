<?php
header('Content-type: text/html; charset=utf-8');
require_once("html2pdf.class.php");
require_once('../libs/PDOConfig.php');
require_once('../Negocios/utilidades.php');
require_once("../libs/Login.php");

 $oLogin=new Login();
 if(!$oLogin->activa()){
 header('location:index.php');
 }
if($_GET){
	$idV = $_GET["id"];
	$idT = $_GET["idT"];
	$base = new PDOConfig();
		
	$sql = " SELECT * FROM vw_verificaciones WHERE idVerificacion = $idV AND idTaller = $idT";
	//echo $sql;
	$resp = $base->query($sql);

	if($row = $resp->fetch(PDO::FETCH_ASSOC))
	{
		$fecha 		= formatFecha($row["Fecha"]);
		$hora 		= substr($row["Hora"],0,5);
		
		$dominio = $row["DominioVehiculo"];
		$idTipoVe = $row["idTipoVehiculo"];
		$idTipoUso = $row["idTipoUso"];
		$TipoVe = $row["tipoVehiculo"];
		$TipoUso = $row["tipoUso"];
		$marca = $row["VMarca"];
		$modelo = $row["VModelo"];
		$anio = $row["VAnio"];
		$motorMarca = $row["MotorMarca"];
		$MotorNro = $row["MotorNumero"];
		$MotorAnio = $row["MotorAnio"];
		
		$tipoDoc = $row["PTipoDoc"];
		$nroDoc = $row["PNroDoc"];
		$cuit = $row["PCuit"];
		$DescTitular = $row["DescripcionTitular"];		
		$domicilio = $row["PDomicilio"];
		$telefono = $row["PTelefono"];
		$tipoPer = $row["PTipoPersona"];
		$email = $row["PEmail"];
		$idLocT = $row["LocalidadTitular"];
		$codigoTitular = $row["CodigoTitular"];
		$ChasisMarca = $row["ChasisMarca"];
		$ChasisNro = $row["ChasisNro"];
		$ChasisAnio = $row["ChasisAnio"];
		
		$tipoDocC = $row["TipoDocConductor"];
		$nroDocC = $row["NroDocConductor"];
		$apellidoC = $row["NombreConductor"];
		$nombreC = $row["ApellidoConductor"];
		
		
	}

$content = '
<div style="background-color: #fff;font-family: Arial, Geneva, sans-serif;font-size: 9pt;">
  		<table align="center" cellpadding="0" width="700" cellspacing="0" style="border: 1px solid;">
  			<tr>
  				<td style="border-bottom: 1px solid;text-align: left;" width="350" ><b>REVISION TECNICA VEHICULOS</b></td>
  				<td style="border-bottom: 1px solid;text-align: right;" width="350">'._toUp($TipoUso).'&nbsp;&nbsp;&nbsp;</td>
  			</tr> 
  			<tr>
  				<td colspan="2" align="right" border: 1px solid;text-align:center;font-weight: bold;">
  				<b>Fecha: '.$fecha.' &nbsp;&nbsp;&nbsp;&nbsp; Hora: '.$hora.'</b></td>
  			</tr>
  			<tr>
  				<td colspan="2">&nbsp;</td>
  			</tr> 
  			<tr>
  				<td align="center">'._toUp($DescTitular).'</td>
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
  				<table width="350" style="border: 1px solid;border-bottom:0px none;margin:0px;padding:0px;" cellpadding="0" cellspacing="0">
  					<tr><td style="border: 1px solid;" width="350" colspan="5">TACOGRAFO</td></tr>
  					<tr><td style="border: 1px solid;" colspan="5">MARCA</td></tr>
  					<tr><td style="border: 1px solid;" colspan="5">N&deg;</td></tr>
  					<tr>
  					<td style="border: 1px solid;" width="70"><span style="font-size: 7pt;">ASIENTOS</span><br /><br /></td>
  					<td style="border: 1px solid;" width="70"><span style="font-size: 7pt;">BAR</span><br /><br /></td>
  					<td style="border: 1px solid;" width="70"><span style="font-size: 7pt;">BA&Ntilde;O</span><br /><br /></td>
  					<td style="border: 1px solid;" width="70"><span style="font-size: 7pt;">REFR</span><br /><br /></td>
  					<td style="border: 1px solid;" width="70"><span style="font-size: 7pt;">CALEF</span><br /><br /></td>
  					</tr>
  				</table>
  				</td>
  			</tr> 
  			<tr>
  				<td colspan="2" style="margin:0px;padding:0px;">
  				<table width="700" style="border: 1px solid;margin:0px;padding:0px;" cellpadding="0" cellspacing="0">
  				<tr>
  					<td style="border: 1px solid;" width="160">ALINEACI&Oacute;N <span style="width:30pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> M/KM</td>
  					<td style="border: 1px solid;" width="70">CO</td>
  					<td style="border: 1px solid;" width="70">HC</td>
  					<td style="border: 1px solid;" width="70">HUMO</td>
  					<td style="border: 1px solid;" width="335">RUIDO<span style="width:30pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
  					INTERIOR<span style="width:30pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
  					DB/ESCAPE<span style="width:30pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>DB</td>
  				</tr>
  				</table>
  				</td>
  			</tr>
  			<tr>
  				<td style="margin:0px;padding:0px;border-rigth: 1px solid;">
  				SISTEMA DE DIRECCI&Oacute;N
  				</td>
  				<td style="margin:0px;padding:0px;border-rigth: 1px solid;">
  				SISTEMA DE ESCAPE
  				</td>
  			</tr>		
    	</table>
</div>';
  
    $html2pdf = new HTML2PDF('P','A4','es',true,'UTF-8', array(2, 2, 2, 2));
    $html2pdf->WriteHTML($content);
    $nomArchi = "prueba.pdf";
    $html2pdf->Output($nomArchi);

echo $content;
}
else{
	
}
