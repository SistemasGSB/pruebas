<?php
require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";
require_once "../../../controladores/proyectos.controlador.php";
require_once "../../../modelos/proyectos.modelo.php";
require_once "../../../controladores/simulador.controlador.php";
require_once "../../../modelos/simulador.modelo.php";
require_once "../../../controladores/cotizador.controlador.php";
require_once "../../../modelos/cotizador.modelo.php";
class facturas{

	public function imprimir_facturas(){
	require_once('tcpdf_include.php');
	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->AddPage();	
	//*Formato de Fecha
	date_default_timezone_set('America/Los_Angeles');
	$fecha = date('d')."/".date('n'). "/".date('Y') ;
	$ahora = time();
	//**Obteniendo el ID
	$item_principal = "id";
	$valor_principal = $_GET["id"];
	$respuesta_principal = ControladorSimulador::ctrMostrarSimulador($item_principal, $valor_principal);
	//**	
	//**Fin Formato Fecha
	//** Obteniendo los datos DNI 
	$item = "dni";
	$valor = $respuesta_principal["dni_cliente"];
	$orden = "id_cliente";	
	//**Fin de obtener DNI
	//**
	$cliente_prospeccion = ControladorClientes::ctrBuscarClientes($item, $valor, $orden);
	$apellidos_completos = $cliente_prospeccion["apellido"];
	$nombres_completos = $cliente_prospeccion["nombre"];
	//**
	//**
	$obtener_proyecto = ControladorProyectos::ctrMostrarProyectos("id_proyecto",$respuesta_principal["id_proyecto"]);
	$producto = $obtener_proyecto["proyecto"];
	

	$obtener_simulacion = ControladorSimulador::ctrMostrarSimulador("id",$_GET["id"]);
	$tipo_cambio = $obtener_simulacion["tipo_cambio"];
	$precio = $obtener_proyecto["precio_lista"]*$tipo_cambio;
	$sim_cot_pfd = $obtener_simulacion["sim_cot_pfd"];
	$sim_cot_mfd =  $obtener_simulacion["sim_cot_mfd"]*$tipo_cambio;
	$sim_periocidad = $obtener_simulacion['sim_periocidad'];
	$sim_cot_tcea = $obtener_simulacion['sim_cot_tcea'];
	$sim_per_gracia = $obtener_simulacion['sim_per_gracia'];
	/*TASA , INICIAL*/
	$sim_cot_tasa = $obtener_simulacion['sim_cot_tasa'];
	$sim_cot_tci_usd = $obtener_simulacion['sim_cot_tci_usd']*$tipo_cambio;
	//**
	//**
	function payment($apr,$n,$pv,$fv=0.0,$prec=2){
	    
	    if ($apr !=0) {
	        $alpha = 1/(1+$apr);
	        $retval =  round($pv * (1 - $alpha) / $alpha / (1 - pow($alpha,$n)),$prec) ;
	    } else {
	        $retval = round($pv / $n, $prec);
	    }
	    return($retval);

	}
	$calculo_tasa = pow((1+($sim_cot_tcea/100)),($sim_periocidad/12))-1;
	$saldo_estable = payment($calculo_tasa,($sim_cot_pfd-$sim_per_gracia),$sim_cot_mfd,$fv=0.0,$prec=2);
	//**
	$html = <<<EOF
	<table  style="border: 2px solid #ffffff;line-height: 5px; font-size:10px">
		<tr>
			<td width="460px" style="border: 1px solid #ffffff; background-color:white;"><b>N° 0000$valor_principal</b></td>
			<td width="140px"><img src="../images/logoalma.jpg" width="80px"></td>		
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">-</td>
		</tr>
	</table>
	<table style="border: 1px solid #ffffff; text-align:center; line-height: 20px; font-size:14px">
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;"><b>SIMULADOR PARA OTORGAMIENTO DE CRÉDITO DIRECTO</b></td>			
		</tr>
	</table>
	<br><br>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
		
		<tr>
			<td width="100px" style="border: 1px solid #666;">CLIENTE</td>
			<td width="240px" style="border: 1px solid #666;">$nombres_completos $apellidos_completos</td>
			<td width="100px" style="border: 1px solid #666;">Arequipa</td>
			<td width="100px" style="border: 1px solid #666;">$fecha</td>
		</tr>
	</table>
	<table style="border: 1px solid #ffffff;line-height: 20px; font-size:12px">
	<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;"><b>TIPO DE CAMBIO: $tipo_cambio</b></td>			
		</tr>
</table>
<br><br>

EOF;
$precio_c = number_format($precio,2);
$sim_cot_tci_usd_c = number_format($sim_cot_tci_usd,2);
$sim_cot_mfd_c = number_format($sim_cot_mfd,2);

$pdf->writeHTML($html, false, false, false, false, '');
$html2 = <<<EOF
	<table style="border: 1px solid #ffffff; text-align:center; font-size:10px">
		<tr>
			<td width="150px" style="border: 1px solid #666; background-color:#00B050;color:#fff">IMPORTE DEL CREDITO</td>
			<td width="100px" style="border: 1px solid #666; background-color:#BBFBC1;">(S/.) $precio_c</td>
			<td width="50px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>		
			<td width="100px" style="border: 1px solid #666; background-color:#00B050;color:#fff">CUOTA INICIAL</td>		
			<td width="140px" style="border: 1px solid #666; background-color:#BBFBC1;"> (S/.) $sim_cot_tci_usd_c </td>				
		</tr>
		<tr>
			<td width="150px" style="border: 1px solid #666; background-color:#00B050;color:#fff">MONTO FINANCIAR SOLES</td>
			<td width="100px" style="border: 1px solid #666; background-color:#BBFBC1;"> (S/.) $sim_cot_mfd_c</td>
			<td width="50px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>		
			<td width="100px" style="border: 1px solid #666; background-color:#00B050;color:#fff">N° CUOTAS</td>		
			<td width="140px" style="border: 1px solid #666; background-color:#BBFBC1;"> $sim_cot_pfd</td>				
		</tr>
		<tr>
			<td width="150px" style="border: 1px solid #666; background-color:#00B050;color:#fff">PERIOCIDAD</td>
			<td width="100px" style="border: 1px solid #666; background-color:#BBFBC1;">$sim_periocidad</td>
			<td width="50px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>		
			<td width="100px" style="border: 1px solid #666; background-color:#00B050;color:#fff">PERIODO GRACIA</td>		
			<td width="140px" style="border: 1px solid #666; background-color:#BBFBC1;"> $sim_per_gracia </td>				
		</tr>
		<tr>
			<td width="150px" style="border: 1px solid #666; background-color:#00B050;color:#fff">TCEA</td>
			<td width="100px" style="border: 1px solid #666; background-color:#BBFBC1;"> $sim_cot_tcea</td>
			<td width="50px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>		
			<td width="100px" style="border: 1px solid #666; background-color:#00B050;color:#fff">TASA</td>		
			<td width="140px" style="border: 1px solid #666; background-color:#BBFBC1;"> $sim_cot_tasa </td>				
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
            <tr>
              <td width="100px"style="border: 1px solid #666">Plazo</td>
              <td width="100px"style="border: 1px solid #666">Interes (S/.)</td>
              <td width="100px" style="border: 1px solid #666">Amortizacion (S/.)</td>
              <td width="100px" style="border: 1px solid #666">Cuota (S/.)</td>
              <td width="140px" style="border: 1px solid #666">Saldo Capital (S/.)</td>
            </tr>
    </table>
EOF;
$pdf->writeHTML($html2, false, false, false, false, '');
for($i=0;$i<=$sim_cot_pfd;$i++) {
if ($i<=$sim_per_gracia) {
if ($i == 0){
$sim_cot_mfd_c = number_format($sim_cot_mfd,2);
$html3 = <<<EOF
	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
            <tr>
              <td width="100px"style="border: 1px solid #666">0</td>
              <td width="100px" style="border: 1px solid #666">--</td>
              <td width="100px" style="border: 1px solid #666">--</td>
              <td width="100px" style="border: 1px solid #666">--</td>
              <td width="140px" style="border: 1px solid #666">$sim_cot_mfd_c</td>
            </tr>
    </table>
EOF;

$pdf->writeHTML($html3, false, false, false, false, '');
}
else
{
$interes = number_format($sim_cot_mfd * $calculo_tasa,2);
$sim_cot_mfd_c = number_format($sim_cot_mfd,2);
$html4 = <<<EOF
<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
					<tr>
                <td width="100px"style="border: 1px solid #666">$i</td>
                <td width="100px" style="border: 1px solid #666">$interes</td>
                <td width="100px" style="border: 1px solid #666">--</td>
                <td width="100px" style="border: 1px solid #666">$interes</td>
                <td width="140px" style="border: 1px solid #666">$sim_cot_mfd_c</td>
                    </tr>
</table>

EOF;
$pdf->writeHTML($html4, false, false, false, false, '');	
}
}
else
{
$interes = number_format(($sim_cot_mfd * $calculo_tasa),2);
$amortizacion =  number_format($saldo_estable - $interes,2);
$sim_cot_mfd = $sim_cot_mfd - ($saldo_estable - $interes);
if ($i == $sim_cot_pfd) {
	$sim_cot_mfd = number_format(0,2);
}
$sim_cot_mfd_c = number_format($sim_cot_mfd,2);
$saldo_estable_c = number_format($saldo_estable,2);
$html5 = <<<EOF
<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
					<tr>
                <td width="100px"style="border: 1px solid #666">$i</td>
                <td width="100px" style="border: 1px solid #666">$interes</td>
                <td width="100px" style="border: 1px solid #666">$amortizacion</td>
                <td width="100px" style="border: 1px solid #666">$saldo_estable_c</td>
                <td width="140px" style="border: 1px solid #666">$sim_cot_mfd_c</td>
                    </tr>
</table>

EOF;
$pdf->writeHTML($html5, false, false, false, false, '');
}
}
$pdf->Output('simulacion_soles.pdf', 'I');
	}
}

$prueba = new facturas();

$prueba -> imprimir_facturas();

?>