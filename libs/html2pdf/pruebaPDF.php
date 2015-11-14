<?php
header('Content-type: text/html; charset=utf-8');
require_once("html2pdf.class.php");

require_once("../libs/PDOConnRecibos.php");
require_once("../Negocios/utilidades.php");
require_once("../libs/Login.php");
$oLogin=new Login();
 if(!$oLogin->activa()){
 	header('location:../index.php');
}


	$baseRec = new PDOConnRecibos();
	$nroRec = 1;
	$cuil = $oLogin->getCuil();
	
	$sql = "SELECT * FROM empresa";
	
	$empresa = $baseRec->query($sql);
	if($emp = $empresa->fetch(PDO::FETCH_ASSOC)){
		$RazonSocial = _toUp($emp["RazonSocial"]);
		$provincia = $emp["Provincia"];
		$Localidad = $emp["Localidad"];
		$CodigoPostal = $emp["CodigoPostal"];
		$Direccion = $emp["Direccion"];
		$Cuit = $emp["Cuit"];
	}

	$sql = "SELECT * FROM recibos WHERE NroRecibo = $nroRec AND Cuil = '$cuil'";
	
	$recibo = $baseRec->query($sql);
	
	if($rec = $recibo->fetch(PDO::FETCH_ASSOC)){		
		
		$nroRec = formatNroRec($rec["NroRecibo"]);
		$fechaLiq = formatFecha($rec["FechaLiquidacion"]);
		$periodo = _toUp($rec["PeriodoLiquidado"]);
		$tipoDoc = _toUp($rec["TipoDoc"]);
		$nroDoc = $rec["NumeroDoc"]; 
		$apellido = _toUp($rec["Apellido"]); 
		$nombre = _toUp($rec["Nombre"]);
		$Legajo = $rec["Legajo"]; 
		$Cuil = $rec["Cuil"]; 
		$Cargo = $rec["Cargo"]; 
		$FuncCargo = $rec["FuncionCargo"]; 
		$FechaIng = formatFecha($rec["FechaIngreso"]); 
		$NroISSN = $rec["NumeroISSN"]; 
		$DiasLiq = $rec["DiasLiquidados"]; 
		$Destino = $rec["Destino"]; 
		$LugardePago = $rec["LugardePago"]; 
		$CBU = $rec["CBU"]; 
		$LeyendaAd = $rec["LeyendaAdicional"]; 
		$TotalRem = $rec["TotalRemuneraciones"]; 
		$TotalRet = $rec["TotalRetenciones"]; 
		$TotalNeto = $rec["TotalNeto"]; 
		$TotalenLetras = $rec["TotalenLetras"];
	}
	
	$sql = "SELECT * FROM recibosdetalle WHERE NumeroRecibo = $nroRec ORDER BY Tipo, Codigo";
	
	$reciboDet = $baseRec->query($sql);
	$detalle = "";
	foreach ($reciboDet as $row)
	{
		$detalle .= "<tr class='rowDist'>
		<td style='border-top:0px none;border-bottom:0px none;text-align: center;'>".formatCodigoI($row["Codigo"])."</td>
		<td colspan='4' style='text-align:left;border-top:0px none;border-bottom:0px none;'>".$row["Descripcion"]."</td>";		
		if(_toUp(quitarAcentos($row["Tipo"])) == "REMUNERACION"){
			$detalle .= "<td style='text-align:right;padding-right:5px;border-top:0px none;border-bottom:0px none;'> $ ".formatNumber($row["Importe"])."</td><td align='right' 
			style='border-top:0px none;border-bottom:0px none;'>&nbsp;</td>";
		}
		else{
			if(_toUp(quitarAcentos($row["Tipo"])) == "RETENCION")	
				$detalle .= "<td align='right' style='border-top:0px none;border-bottom:0px none;'>&nbsp;</td><td style='border-top:0px none;border-bottom:0px none;text-align:right;padding-right:5px;'> $ ".formatNumber($row["Importe"])."</td>";
		}
		$detalle .= "</tr>";
		
	}



$content = '
<div style="background-color: #fff;font-family: Arial, Geneva, sans-serif;font-size: 9pt;">
  <div id="container">  
  		<table aling="center" cellpadding="0" cellspacing="0">
  			<tr>
  				<td rowspan="4"><img src="../images/ProvNeuq.png" align="middle" /></td>
  				<td rowspan="4">
  					<b> '.$RazonSocial.'</b><br />
  					'.$Direccion.' <br />
  					('.$CodigoPostal.') '.$Localidad.'<br />
  					 '.$provincia.'<br />
  					 <b>CUIT '.$Cuit.'</b><br />
  				</td>
  				<td style="background-color: #cccccc;border: 1px solid;text-align: center;font-weight: bold;" >RECIBO DE HABERES N&deg; </td>
  				<td style="border: 1px solid;text-align: center;">'.$nroRec.'</td>
  			</tr> 
  			<tr>
  				<td colspan="2">&nbsp;</td>
  			</tr> 
  			<tr>
  				<td style="background-color: #cccccc;border: 1px solid;text-align: center;font-weight: bold;" >PERIODO LIQUIDADO</td>
  				<td style="border: 1px solid;text-align: center;">'._toUp($periodo).'</td>
  			</tr>  	
  			<tr>
  				<td colspan="2">&nbsp;</td>
  			</tr> 		
  			<tr>
  				<td colspan="4">&nbsp;</td>
  			</tr> 
  			<tr>
  				<td colspan="4">&nbsp;</td>
  			</tr> 
  			<tr>
  				<td colspan="4" aling="center">
  				<table style="text-align:center;" border="1" style="width:100%;" cellpadding="0" cellspacing="0">
  				<tr>
  					<td style="background-color: #cccccc;width: 2cm;text-align: center;font-weight: bold;" colspan="4">APELLIDO Y NOMBRE</td>
  					<td style="background-color: #cccccc;width: 3cm;text-align: center;font-weight: bold;">LEGAJO N&deg;</td>
  					<td style="background-color: #cccccc;text-align: center;font-weight: bold;" colspan="2" width="100px">CUIL</td>
  				</tr>
  				<tr>
  					<td colspan="4" style="text-align: center;">'.$apellido.', '.$nombre.'</td>
  					<td style="text-align: center;">'.$Legajo.'</td>
  					<td colspan="2" style="text-align: center;">'.formatCuil($Cuil).'</td>
  				</tr>
  				<tr>
  					<td width="85" style="background-color: #cccccc;width: 2cm;text-align: center;font-weight: bold;">Tipo Documento</td>
  					<td width="60" style="background-color: #cccccc;width: 2cm;text-align: center;font-weight: bold;">Documento</td>
  					<td style="background-color: #cccccc;width: 2cm;text-align: center;font-weight: bold;">Cargo</td>
  					<td colspan="3" width="300" style="width: 7cm;background-color: #cccccc;text-align: center;font-weight: bold;" >Funci&oacute;n Cargo</td>
  					<td style="background-color: #cccccc;text-align: center;font-weight: bold;">Fecha Ingreso</td>
  				</tr>
  				<tr>
  					<td style="text-align: center;">'.$tipoDoc.'</td>
  					<td style="text-align: center;">'.$nroDoc.'</td>
  					<td style="text-align: center;">'.$Cargo.'</td>
  					<td colspan="3" width="280" style="text-align: center;">'.$FuncCargo.'</td>
  					<td style="text-align: center;">'.$FechaIng.'</td>
  				</tr>
  				<tr>
  					<td style="text-align: center;font-weight: bold;background-color: #cccccc;">ISSN</td>
  					<td style="text-align: center;font-weight: bold;background-color: #cccccc;">Lugar de pago</td>
  					<td style="text-align: center;font-weight: bold;background-color: #cccccc;" colspan="4">Destino</td>
  					<td style="text-align: center;font-weight: bold;background-color: #cccccc;">D&iacute;as Liquidados</td>
  				</tr>
  				<tr>
  					<td style="text-align: center;">'.$NroISSN.'</td>
  					<td style="text-align: center;">'.$LugardePago.'</td>
  					<td colspan="4" style="text-align: center;">'.$Destino.'</td>
  					<td style="text-align: center;">'.$DiasLiq.'</td>
  				</tr>
  				<tr>
  					<td colspan="7" style="background-color: #cccccc;text-aling:center;"><b>DETALLE LIQUIDACI&Oacute;N</b></td>
  				</tr>
  				<tr>
  					<td style="width: 10cm;text-align: center;"><b>C&oacute;digo</b></td>
  					<td colspan="4" width="300" style="width: 10cm;text-align: center;"><b>Descripci&oacute;n</b></td>
  					<td width="80" style="width: 120px;text-align: center;"><b>Remuneraciones</b></td>
  					<td width="80" style="width: 120px;text-align: center;"><b>Retenciones</b></td>
  				</tr>
  				'.$detalle.'
  				<tr>
  					<td style="border-top: 0px none;">&nbsp;</td>
  					<td colspan="4" style="border-top: 0px none;">&nbsp;</td>
  					<td style="border-top: 0px none;">&nbsp;</td>
  					<td style="border-top: 0px none;">&nbsp;</td>
  				</tr> 
  				<tr>
  					<td>&nbsp;</td>
  					<td colspan="4">&nbsp;</td>
  					<td style="text-align: right;padding-right: 5px;">$ '.formatNumber($TotalRem).'</td>
  					<td style="text-align: right;padding-right: 5px;">$ '.formatNumber($TotalRet).'</td>
  				</tr>  
  				<tr>
  					<td colspan="6" style="background-color: #cccccc;text-align: center;font-weight: bold;">DEPOSITO EN CBU</td>
  					<td style="background-color: #cccccc;text-align: right;padding-right: 5px;font-weight: bold;">TOTAL NETO</td>
  				</tr>	
  				<tr>
  					<td colspan="6" style="background-color: #cccccc;text-align: center;">'. $CBU.'</td>
  					<td style="background-color: #cccccc;text-align: right;padding-right: 5px;">$ '.formatNumber($TotalNeto).'</td>
  				</tr>
  				<tr>
  					<td style="background-color: #cccccc;font-weight: bold;">SON PESOS:</td>
  					<td colspan="6">&nbsp;&nbsp;'.ucfirst($TotalenLetras).'</td>
  				</tr>				
  				</table>
  				</td>
  			</tr>  
  			<tr>
  				<td colspan="4">&nbsp;</td>
  			</tr> 
  			<tr>
  				<td colspan="4" style="font-size:8pt;">
  				<b><i>El presente recibo se emite de conformidad con lo establecido en el acuerdo N&deg; 4995 Punto 4 del Tribunal Superior de Justicia.-</i></b></td>
  			</tr> 
  			<tr>
  				<td colspan="4">&nbsp;</td>
  			</tr>  	
  			<tr>
  				<td colspan="4" style="border: 1px solid;text-align: center;background-color: #cccccc;font-weight: bold;">INFORMACI&Oacute;N SALARIAL</td>
  			</tr> 
  			<tr>
  				<td colspan="4" style="border: 1px solid;" >
  				<p style="margin: 5px;"><i>'.$LeyendaAd.'</i></p>
  				</td>
  			</tr> 
  			<tr>
  				<td colspan="4">&nbsp;</td>
  			</tr> 
  			<tr>
  				<td colspan="2" align="right">C&Oacute;DIGO SEGURIDAD IMPRESI&Oacute;N &nbsp;&nbsp;&nbsp;</td>
  				<td colspan="2" class="Fondo" style="border: 1px solid;text-align: center;background-color: #cccccc;">
  					'.md5($nroRec.$cuil.$TotalNeto.$periodo).'
  				</td>
  			</tr> 	
    	</table>
    <br class="clear" />
    <br class="clear" />
    <br class="clear" />
  </div>
</div>';
  
    $html2pdf = new HTML2PDF('P','A4','es',true,'UTF-8', array(15, 15, 15, 8));
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('exemple.pdf');