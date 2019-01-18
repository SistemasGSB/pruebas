<?php

require_once "../../controlador/facturaController.php";
require_once "../../modelo/facturaModel.php";
require_once('tcpdf_include.php');
date_default_timezone_set('America/Lima');
class ImpresionFactura{


public function imprimirFactura(){

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
ob_clean();
$pdf->AddPage();
#mis variables
$codigo= 35.54566221;
$hoy = date("Y-m-d");
$dueño= "Ccapa Nunonncca Emperatriz Paulina";
$rucUsuario = 10430064563;
$rucCliente =50141545456;
$cliente= " Chacon Chacon Carlos Adrian";
$guia= 154522;
$cantidad= 10;
$pu=15;
$dcto= 0.00;
$UDM= "UND";
$total = 6841.19;//$cantidad * $pu;
$subTotal = $total/1.18; 
$igv = $total-$subTotal;
$total1=round($total,2);
$subtotal1=round($subTotal,2);
$igv1=round($igv,2);
$numeroFactura= 15340;
#Fin mis variables
$html1 = <<<EOF
 

<table> 
<tr>
<td><H2 style="text-align:center;">Reporte de $dueño</H2></td>
</tr>
</table>
<br><br>

<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
		<tr>
      <td width="125px" style="border: 1px solid #666; background-color:#333; color:#fff">CODIGO</td>
			<td width="175px" style="border: 1px solid #666; background-color:#333; color:#fff">DESCRIPCIÓN</td>
      <td width="60px" style="border: 1px solid #666; background-color:#333; color:#fff">FECHA</td>
			<td width="70px" style="border: 1px solid #666; background-color:#333; color:#fff">P.C</td>
      <td width="50px" style="border: 1px solid #666; background-color:#333; color:#fff">P.V</td>
			<td width="60px" style="border: 1px solid #666; background-color:#333; color:#fff">P.S</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($html1, false, false, false, false, '');

#LLAMAR CLASES 
$consulta = boletaController::CargarProductosBoleta();

foreach ($consulta as $row => $item) {
$html2 = <<<EOF

	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:7px">
		<tr>
      <td width="125px" >$codigo</td>
      <td width="175px" >$item[descripcion_tmp]</td>
      <td width="60px" >$hoy</td>
      <td width="70px" >$item[precio_tmp]</td>
      <td width="50px" >$dcto</td>
      <td width="60px" >$total</td>
		</tr>
  </table>
  
EOF;

$pdf->writeHTML($html2, false, false, false, false, '');  
}

$html3=<<<EOF
  
 <h3>Balance General: </h3>
<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
    <tr>
      <td width="90px" style="border: 1px solid #666; background-color:#333; color:#fff">Cantidad</td>
      <td width="150px" style="border: 1px solid #666; background-color:#333; color:#fff">Precio Compra</td>
      <td width="150px" style="border: 1px solid #666; background-color:#333; color:#fff">Precio Venta</td>
      <td width="150px" style="border: 1px solid #666; background-color:#333; color:#fff">Precio Sugerido</td>
    </tr>
  </table>
<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
    <tr>
      <td width="90px" >$cantidad</td>
      <td width="150px" > 15000</td>
      <td width="150px" >$dcto</td>
      <td width="150px" >$total</td>
    </tr>
  </table>
EOF;
$pdf->writeHTML($html3, false, false, false, false, '');

$pdf->Output('reporte.pdf');
}
}
$a = new ImpresionFactura();
$a -> imprimirFactura();
?>