<?php


require_once "../tools/NumerosLetras.php";
require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";
require_once "../../../controladores/proyectos.controlador.php";
require_once "../../../modelos/proyectos.modelo.php";
require_once "../../../controladores/prospeccion.controlador.php";
require_once "../../../modelos/prospeccion.modelo.php";
require_once "../../../controladores/simulador.controlador.php";
require_once "../../../modelos/simulador.modelo.php";
require_once "../../../controladores/reserva.controlador.php";
require_once "../../../modelos/reserva.modelo.php";
require_once "../../../modelos/proforma.modelo.php";
require_once "../../../controladores/proforma.controlador.php";
class contrato{

	public function imprimir_contrato(){
	require_once('tcpdf_include.php');
	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$pdf->AddPage();
	//*Formato de Fecha
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$fecha = date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
	$dia = date('d');
	$mes =$meses[date('n')-1];
	$anho=date('Y');
	//**Fin Formato Fecha 
	$item_principal = "id";
	$valor_principal = $_GET["id"];
	$obtener_prospeccion = ControladorProforma::ctrMostrarProforma($item_principal, $valor_principal);
	$tipo_cambio = $obtener_prospeccion["tipo_cambio"];
	$item = "dni";
	$valor = $obtener_prospeccion["dni_cliente"];
	$orden = "id_cliente";	
	$cliente_prospeccion = ControladorClientes::ctrBuscarClientes($item, $valor, $orden);
	$nombres_completos = $cliente_prospeccion["nombre"].' '. $cliente_prospeccion["apellido"];
	$direccion_completa = $cliente_prospeccion["direccion"];
	$distrito =$cliente_prospeccion["distrito"];

	$obtener_proyecto = ControladorProyectos::ctrMostrarProyectos("id_proyecto",$obtener_prospeccion["id_proyecto"]);
	$producto = $obtener_proyecto["proyecto"];
	$orden = $obtener_proyecto["etapa"];
	$metraje = $obtener_proyecto["area"];
	$terreno = $obtener_proyecto["terreno"];
	$precio = $obtener_proyecto["precio_lista"] * $tipo_cambio;
	$NombreTerre = strtoupper($producto);
	$obtener_simulacion = ControladorSimulador::ctrMostrarSimulador("id",$_GET["id"]);
	$sim_cot_pfd = $obtener_simulacion["sim_cot_pfd"];
	$sim_cot_mfd =  $obtener_simulacion["sim_cot_mfd"]* $tipo_cambio;
	$sim_periocidad = $obtener_simulacion['sim_periocidad'];
	$sim_cot_tcea = $obtener_simulacion['sim_cot_tcea'];
	$sim_per_gracia = $obtener_simulacion['sim_per_gracia'];
	/*TASA , INICIAL*/

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

	$sim_cot_tasa = $obtener_simulacion['sim_cot_tasa'];
	$sim_cot_tci_usd = $obtener_simulacion['sim_cot_tci_usd']* $tipo_cambio;

	$obtener_reserva = ControladorReserva::ctrMostrarReserva("id",$obtener_simulacion["id_reserva"]);
	$fecha_deposito = $obtener_reserva["fecha_deposito"];
$html = <<<EOF
<table >
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>

		<tr>			

		   <td width="400px"></td>
			<td width="100px"><img src="../images/logoalma.jpg"></td>
			
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
	</table>
	
<table style="border: 1px solid #ffffff; text-align:center; line-height: 20px; font-size:12px">
		<tr>
			<td width="540px" style="border: 1px solid #ffffff;font-weight:bold; background-color:white;">CONTRATO DE COMPRA VENTA DE BIEN FUTURO</td>			
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
	</table>
	<table style="border: 1px solid #ffffff; text-align:justify; line-height: 15px; font-size:11px">
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">Conste por el presente documento de <b>COMPRAVENTA DE BIEN FUTURO A PLAZOS</b> que celebran las siguientes partes:</td>			
		</tr>
		
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;">
		<ol style="text-align:justify;">

		<li>De una parte, <b>ALMA PERÚ E.I.R.L.</b>, con Registro Único de Contribuyente N° 20602144969, con domicilio en Avenida Víctor Andrés Belaunde N°241, Interior N°304, urbanización Primavera, Distrito de Yanahuara, Provincia y Departamento de Arequipa, debidamente representado por su Gerente, señor William Lavalle Mauricio, con DNI. Nº 40675674; a quien en adelante se denominará <b>LA VENDEDORA;</b></li><br>
		<li>De la otra parte el señor $nombres_completos, identificado con Documento Nacional de Identidad N° $valor, con domicilio en $direccion_completa,  Distrito $distrito, Provincia y Departamento de Arequipa; a quien en lo sucesivo se le(s) denominará (n) <b>EL (LA/LOS) COMPRADOR (A/ES).</b> </li>

		</ol>
		</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">
		Los términos y condiciones que se detallan por escrito a continuación, prevalecen respecto de cualquier comunicación verbal o escrita anterior que pudiera haberse dado entre las partes durante la negociación previa a la firma del presente documento, declarando ambas partes que el presente documento refleja el acuerdo final al que han llegado las partes.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">
		Asimismo, <b>EL (LA/LOS) COMPRADOR (A/ES) </b>indica expresamente que ha recibido de <b>LA VENDEDORA</b>, de manera gratuita y previa a la firma del presente contrato, la información necesaria para la decisión de firma del mismo, por lo que declara tener conocimiento de las características del inmueble y del financiamiento de la operación.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		El contrato se celebra en los términos siguientes: </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>PRIMERA: ANTECEDENTES</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">
		Mediante Contrato Privado de Asociación en Participación de fecha 08 de enero de 2018, celebrado entre la empresa <b>ALMA PERÚ E.I.R.L.</b> y el señor <b>VICTOR WILBERT BEJARANO AGUILAR,</b> propietario del inmueble denominado San José, signado con Unidad Catastral N°10053, ubicado en el distrito de Mollendo, provincia y departamento de Arequipa, se facultó a la empresa <b>ALMA PERU E.I.R.L. </b>, a suscribir; entre otros documentos, los contratos de Compra Venta de Bienes Futuros del proyecto <b>"<b>$NombreTerre</b>"</b>. En tal sentido, <b>ALMA PERÚ E.I.R.L.</b>, a partir de dicha fecha será considerada como <b>LA VENDEDORA</b>.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">
		<b>LA VENDEDORA</b> se encuentra facultada para desarrollar un proyecto de habilitación urbana de tipo urbanización denominada <b>$NombreTerre</b>, sobre el inmueble ubicado en el distrito de Mollendo, provincia y departamento de Arequipa, que cuenta con un área de 25.50 Hás, cuyos linderos y medidas perimétricas se encuentran detalladas en la Partida Electrónica N°0400834 del Registro de Predio de la Zona Registral de No XII – Sede Arequipa.</td>
		</tr>
	</table>
	<table>

		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="530px" style="border: 1px solid #ffffff;text-align:center">1</td>
		</tr>
		
		
	</table>

EOF;

$pdf->writeHTML($html, false, false, false, false, '');


$sim_cot_tci_usd_c = number_format($sim_cot_tci_usd,2);

$l_sim_cot_tci_usd_c = NumeroALetras::convertir($sim_cot_tci_usd_c, "SOLES");
$PreciFin = $precio - $sim_cot_tci_usd;
$PreciFin_c = number_format($PreciFin,2);
$l_PreciFin = NumeroALetras::convertir($PreciFin_c, "SOLES");

$l_precio = NumeroALetras::convertir($precio,"SOLES");
$Porcen = ( $sim_cot_tci_usd * 100)/$precio;
$html2 = <<<EOF
<table style="border: 5px solid #ffffff; background-color:white;color:white">
<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
			<tr>
		   <td width="400px"></td>
			<td width="100px"><img src="../images/logoalma.jpg"></td>
			
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
	</table>

	<table style="border: 1px solid #ffffff; text-align:justify; line-height: 15px; font-size:11px">
		
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>SEGUNDA: DEL LOTE MATERIA DE VENTA </b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">
		Dentro del proyecto inmobiliario <b>"<b>$NombreTerre</b>"</b>, se encuentra <b>el lote</b> $terreno el mismo que cuenta con $metraje m2 ($metraje/100 metros cuadrados), como se detalla en el plano que figura como <b>Anexo A</b> y que forma parte integrante del presente contrato, el mismo que se ubica en la Primera Etapa, que cuenta con 117 lotes aproximadamente; al cual se le denominará en adelante <b>EL LOTE</b>.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Por medio del presente contrato, <b>LA VENDEDORA</b> se compromete a realizar la independización respectiva del inmueble materia de compraventa conforme al detalle del Plano de Ubicación (Anexo A) del contrato. </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;"><b>EL (LA/LOS) COMPRADOR (A/ES)</b> declara (n) conocer a cabalidad el estado de conservación y situación del inmueble, motivo por el cual no se aceptarán reclamos en lo posterior, ni por cualquier otra circunstancia o aspecto, ni ajustes de valor, en razón de transferirse el inmueble en la condición de “cómo está” y “ad-corpus”. </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Una vez realizada la independización se perfeccionará la compraventa con la correspondiente Minuta y Escritura Pública. <b>EL (LA/LOS) COMPRADOR (A/ES)</b> acepta que el área exacta de <b>EL LOTE</b>, numeración, medidas perimétricas, serán los que consten en la inscripción de Registros Públicos correspondiente; o en su defecto <b>LA VENDEDORA</b> entregará a favor de <b>EL (LA/LOS) COMPRADOR (A/ES)</b> una Escritura Pública de compraventa de acciones y derechos en razón al metraje adquirido por <b>EL (LA/LOS) COMPRADOR (A/ES)</b>.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>TERCERA: OBJETO DEL CONTRATO </b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Por el presente contrato, <b>LA VENDEDORA</b> da en venta real y enajenación perpetua a favor de <b>EL (LA/LOS) COMPRADOR (A/ES)</b>, <b>EL LOTE</b>, bajo la condición de bien futuro, con todo lo que de hecho o por derecho le corresponda o le es inherente, como son: sus construcciones, usos, costumbres, aires, servidumbres, entradas, salidas, así como también las obras ejecutadas. Dejándose constancia que serán de cuenta de <b>EL (LA/LOS) COMPRADOR (A/ES)</b>, las conexiones domiciliarias de los servicios de agua, desagüe hacia un biodigestor común y luz eléctrica de los ramales generales al interior de EL LOTE no siendo responsabilidad de <b>LA VENDEDORA</b> la instalación de medidores de energía y agua, en coordinación con las entidades prestadoras de los servicios.
		</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>CUARTA: PRECIO</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">El precio de venta estipulado de común acuerdo es de $precio ($l_precio), en adelante <b>EL PRECIO DE VENTA</b>.
		</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Las partes declaran que entre <b>EL LOTE</b> y el precio libremente pactado en la presente compra venta de bien futuro existe total equivalencia. Conforme a lo señalado, <b>EL (LA/LOS) COMPRADOR (A/ES)</b> declara conocer que al finalizar la ejecución de las obras, quedará definida el área final exacta de <b>EL LOTE</b>, pudiendo existir una diferencia entre el área real de <b>EL LOTE</b> y la señalada en la cláusula segunda, la que no deberá exceder el 3%. 
		</td>
		</tr>

	</table>
	<table>

		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="530px" style="border: 1px solid #ffffff;text-align:center">2</td>
		</tr>
		
		
	</table>
EOF;

$pdf->writeHTML($html2, false, false, false, false, '');

$sim_cot_mfd_c = number_format($sim_cot_mfd,2);
$saldo_estable_c = number_format($saldo_estable,2);

$l_saldo_estable_c = NumeroALetras::convertir($saldo_estable_c,"SOLES");

$html23 = <<<EOF
<table style="border: 5px solid #ffffff; background-color:white;color:white">
		
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>			

		   <td style="width:400px"></td>
			<td width="100px"><img src="../images/logoalma.jpg"></td>
			
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
	</table>

	<table style="border: 1px solid #ffffff; text-align:justify; line-height: 15px; font-size:11px">
		
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Las partes dejan constancia y declaran que existe perfecta equivalencia entre el precio pactado y <b>EL LOTE</b>, haciéndose, sin embargo mutua y recíproca concesión de cualquier exceso o diferencia que pudiera existir y que ahora no perciben, que no deberá exceder del 3%. De superar dicho porcentaje, se realizará el reajuste correspondiente a favor de <b>EL (LA/LOS) COMPRADOR (A/ES)</b> o <b>LA VENDEDORA</b>. 
		  </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>QUINTA: DEL PAGO </b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">El precio de venta será pagado por <b>EL (LA/LOS) COMPRADOR (A/ES)</b> a <b>LA VENDEDORA</b> de la siguiente manera: 
		</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;">
		<ol style="text-align:justify;">

		<li>La suma de $sim_cot_tci_usd_c ($l_sim_cot_tci_usd_c), o su equivalente en moneda nacional, por concepto del $Porcen % de cuota inicial, la misma que ya se encuentra cancelada a la firma del presente contrato;</li><br>
		<li>La suma de $PreciFin_c ($l_PreciFin), por concepto del saldo de la cuota inicial, la misma que será cancelada el $dia de $mes;</li><br>
		<li>El saldo correspondiente será financiado en $sim_cot_pfd cuotas, cada una equivalente a $saldo_estable_c ($l_saldo_estable_c), las cuales serán canceladas por <b>EL (LA/LOS) COMPRADOR (A/ES)</b> mediante depósito en cuenta o transferencia bancaria a favor de <b>LA VENDEDORA</b>, los $dia días de cada mes; como consta en el Anexo B (Cronograma de Pagos).</li>
		</ol>
		</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Del mismo modo las partes convienen en representar la deuda referida en el <b>Anexo B</b> en Letras de Cambio. En ese sentido, <b>EL (LA/LOS) COMPRADOR (A/ES)</b> acepta en este acto y entrega a <b>LA VENDEDORA</b>, Letras de Cambio por el importe de cada cuota señalada en el <b>CRONOGRAMA DE PAGOS</b>, con la fecha de vencimiento de cada cuota.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;"><b>EL (LA/LOS) COMPRADOR (A/ES)</b> debe hacerse cargo de los pagos que efectúa y deberá poner en conocimiento de <b>LA VENDEDORA</b> en forma satisfactoria, mediante comunicaciones expresas (copia de los vouchers o depósitos bancarios o mediante comunicaciones vía electrónica al correo de <b>LA VENDEDORA</b>).
		</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Asimismo, <b>EL (LA/LOS) COMPRADOR (A/ES)</b> se compromete de manera expresa, incondicional e irrevocable a efectuar el pago del precio de venta en la moneda en que se encuentre pactada, de acuerdo a lo establecido en el segundo párrafo del artículo 1237 del Código Civil.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Por otro lado, las partes acuerdan que en caso <b>EL (LA/LOS) COMPRADOR (A/ES)</b> se retrasen en el pago de cualquier cuota, a partir del séptimo (7) día, incurrirá automáticamente en mora, sin necesidad de intimación previa, quedando en consecuencia obligado a reconocer a favor de <b>LA VENDEDORA</b> por concepto de penalidad el importe correspondiente al 0.5% diario del monto total devengado y no pagado.</td>
		</tr>
	

		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Las partes acuerdan que en caso <b>EL (LA/LOS) COMPRADOR (A/ES)</b> incumpla total o parcialmente con el pago de tres o más cuotas consecutivas, establecidas en <b>EL CRONOGRAMA</b>, <b>LA VENDEDORA</b> contará con la facultad de dar automáticamente por vencidos todos los plazos y podrá solicitar el pago del <b>MONTO TOTAL ADEUDADO</b>, otorgándole 72 horas hábiles para la cancelación del monto total adeudado lo que será comunicado mediante carta notarial, bajo apercibimiento de resolver el presente contrato. </td>
		</tr>
	</table>
	<table>

		
		<tr>
		<td width="530px" style="border: 1px solid #ffffff;text-align:center">3</td>
		</tr>
		
		
	</table>
EOF;

$pdf->writeHTML($html23, false, false, false, false, '');


$html234 = <<<EOF
<table style="border: 5px solid #ffffff; background-color:white;color:white">
		
<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>			
		   <td style="width:400px"></td>
			<td width="100px"><img src="../images/logoalma.jpg"></td>
			
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
	</table>

	<table style="border: 1px solid #ffffff; text-align:justify; line-height: 15px; font-size:11px">
		
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">En ese sentido, si vencido el plazo otorgado en el requerimiento notarial <b>EL (LA/LOS) COMPRADOR (A/ES)</b> no cumpliera con el pago íntegro del <b>MONTO TOTAL ADEUDADO</b> quedará resuelto automáticamente el presente contrato, sin necesidad de remitir ninguna comunicación adicional para dichos efectos. Para estos efectos, el <b>MONTO TOTAL ADEUDADO</b>, comprenderá la sumatoria de: i) el saldo pendiente de pago del <b>PRECIO DE VENTA</b>; y ii) la penalidad considerada en el párrafo precedente.  
		  </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>SEXTA: RESERVA DE PROPIEDAD </b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
			<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Queda expresamente establecido que <b>LA VENDEDORA</b> se reserva la propiedad sobre el inmueble materia de este contrato hasta que <b>EL (LA/LOS) COMPRADOR (A/ES)</b> haya cumplido con su obligación de pagar el íntegro del monto total adeudado pactado en la cláusula cuarta y quinta del presente contrato, más los gastos, costos, cargos, moras y cualquier penalidad que pudiera existir.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">En consecuencia <b>EL (LA/LOS) COMPRADOR (A/ES)</b> no podrá gravar, vender, transferir ni afectar en forma alguna el inmueble materia del presente contrato, salvo autorización expresa y por escrito de <b>LA VENDEDORA</b>.
			</td></tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>SETIMA: ENTREGA DEL LOTE </b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">La entrega de la posesión de <b>EL LOTE</b> por parte de <b>LA VENDEDORA</b> a <b>EL (LA/LOS) COMPRADOR (A/ES)</b> se efectuará como máximo dentro de los 24 meses de firmado el presente documento, siempre y cuando, <b>EL (LA/LOS) COMPRADOR (A/ES)</b> se encuentre al día en el pago de sus cuotas señaladas en la cláusula Quinta¸ y haya cancelado como mínimo el 60% de las cuotas pactadas. 
</td></tr>
	<tr>
				<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
			</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;"><b>EL LOTE</b> se entregará dentro del Proyecto <b>$NombreTerre</b>, con las redes de luz, agua y desagüe hacia un biodigestor común, pistas y veredas en general, así como áreas verdes y pórtico de ingreso a la urbanización. Cabe precisar que estos trabajos están considerados en el precio de venta establecido en la cláusula cuarta del presente documento.</td></tr>
			<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">El plazo previsto en la presente cláusula para la entrega oportuna de <b>EL LOTE</b> podrá ser prorrogado, cuando medie caso fortuito, fuerza mayor o cualquier evento debidamente justificado por <b>LA VENDEDORA</b>. El nuevo plazo de entrega deberá ser debidamente comunicado por escrito por <b>LA VENDEDORA</b> a <b>EL (LA/LOS) COMPRADOR (A/ES)</b>, con una anticipación no menor a 30 días calendario a la fecha de entrega correspondiente.</td></tr>
			<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">A fin de formalizar la entrega de <b>EL LOTE</b>, <b>LA VENDEDORA</b> citará por escrito a <b>EL (LA/LOS) COMPRADOR (A/ES)</b>, señalando día, hora y lugar de reunión para el acto de entrega. Para tales efectos se levantará un acta, la que será firmada por las partes en señal de aceptación y conformidad. </td></tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Si <b>EL (LA/LOS) COMPRADOR (A/ES)</b> no concurriera a la reunión, para todos los efectos del presente contrato se considerará que <b>EL LOTE</b> ha sido debidamente entregado por <b>LA VENDEDORA</b> y recibido por <b>EL (LA/LOS) COMPRADOR (A/ES)</b> conforme a lo pactado, y debiendo éste asumir la responsabilidad del caso. </td></tr>

		</table>
		<table>

		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="530px" style="border: 1px solid #ffffff;text-align:center">4</td>
		</tr>
		
		
	</table>
EOF;

$pdf->writeHTML($html234, false, false, false, false, '');


$html2345 = <<<EOF
<table style="border: 5px solid #ffffff; background-color:white;color:white">
		
<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>			
		   <td style="width:400px"></td>
			<td width="100px"><img src="../images/logoalma.jpg"></td>
			
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
	</table>

	<table style="border: 1px solid #ffffff; text-align:justify; line-height: 15px; font-size:11px">
		
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Salvo comunicación por escrito enviada por <b>EL (LA/LOS) COMPRADOR (A/ES)</b>, con 10 (diez) días de anticipación a la fecha programada para la entrega del lote, indicando la imposibilidad de asistir a la reunión, en cuyo caso las partes acordarán nueva fecha para la entrega del respectivo lote, la misma que no deberá exceder los 30 (treinta) días luego de la primera citación. Luego de entregado <b>EL LOTE, EL (LA/LOS) COMPRADOR (A/ES)</b> será responsable de su cuidado y mantenimiento. 
		  </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;"><b>EL (LA/LOS) COMPRADOR (A/ES)</b>, declara tener conocimiento que <b>LA VENDEDORA</b> seguirá construyendo en el terreno matriz lo correspondiente a las obras generales del Proyecto, para lo cual no será necesaria autorización alguna por parte de <b>EL (LA/LOS) COMPRADOR (A/ES)</b> a efecto que <b>LA VENDEDORA</b> o terceros a quien éste designe, pueda ingresar y ejecutar la integridad de los trabajos que resulten pertinentes hasta la terminación total del Proyecto, y de ser necesario, hasta la recepción o transferencia de las obras a las entidades y/o personas correspondientes.  </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>OCTAVA: TRIBUTOS Y SERVICIOS</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;"><b>LA VENDEDORA</b>, declara no adeudar monto alguno por concepto de impuesto predial, arbitrios municipales, mejoras u otros conceptos. No obstante serán de cuenta y cargo de <b>LA VENDEDORA</b> los montos que se puedan adeudar por tributos municipales hasta la entrega física de <b>EL LOTE</b>.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">A partir de la entrega física de <b>EL LOTE</b> toda obligación tributaria exigible y que sea posterior a la entrega física del <b>EL LOTE</b>, por concepto del Impuesto Predial o cualquier otro exigible en su lugar correspondiente al inmueble, será de cuenta y cargo de <b>EL (LA/LOS) COMPRADOR (A/ES)</b>.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Asimismo, los arbitrios municipales, tasas, impuestos y demás contribuciones que exija la Municipalidad por <b>EL LOTE</b>, con posterioridad a la entrega física del mismo, serán de cuenta y cargo de <b>EL (LA/LOS) COMPRADOR (A/ES)</b>.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>NOVENA: CARGAS Y GRAVÁMENES</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;"><b>LA VENDEDORA</b> declara que no pesan cargas y gravámenes, medida judicial, medida extrajudicial o medida cautelar, sobre el inmueble materia de Compraventa que puedan limitar o restringir su dominio, a favor de <b>EL (LA/LOS) COMPRADOR (A/ES)</b>.  </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>DECIMA: CONDICION SUSPENSIVA</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">La presente compra venta está sometida a la condición suspensiva de que el bien materia de venta llegue a existir, de conformidad con los artículos 1534, 1535 y demás del Código Civil.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>DECIMA PRIMERA: PENALIDADES</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">En el caso que <b>EL (LA/LOS) COMPRADOR (A/ES)</b> desistieran de proseguir con la presente compraventa, el presente contrato se resolverá, devengándose de forma automática a favor de <b>LA VENDEDORA</b> una penalidad ascendente al 10% del <b>PRECIO DE VENTA</b>, el monto de la penalidad será deducido del monto pagado por <b>EL (LA/LOS) COMPRADOR (A/ES)</b> a <b>LA VENDEDORA</b>. 
</td>
		</tr>

		</table>
	<table>

		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		
		<tr>
		<td width="530px" style="border: 1px solid #ffffff;text-align:center">5</td>
		</tr>
		
		
	</table>
EOF;

$pdf->writeHTML($html2345, false, false, false, false, '');


$html23456 = <<<EOF
<table style="border: 5px solid #ffffff; background-color:white;color:white">
		
<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>			
		   <td style="width:400px"></td>
			<td width="100px"><img src="../images/logoalma.jpg"></td>
			
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
	</table>

	<table style="border: 1px solid #ffffff; text-align:justify; line-height: 15px; font-size:11px">
		
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Asimismo, <b>LA VENDEDORA</b> deberá proceder a devolver el saldo correspondiente de ser el caso; y, por su parte <b>EL (LA/LOS) COMPRADOR (A/ES)</b> debe cumplir con entregar la posesión de <b>EL LOTE</b>, en un plazo de 24 horas de resuelto el presente contrato.
		  </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;"><b>LA VENDEDORA</b> retendrá el saldo correspondiente a <b>EL (LA/LOS) COMPRADOR (A/ES)</b>, hasta que éste cumpla con entregar la posesión de <b>EL LOTE</b> a favor de <b>LA VENDEDORA</b>, autorizando <b>EL (LA/LOS) COMPRADOR (A/ES)</b> a <b>LA VENDEDORA</b> a tomar posesión de <b>EL LOTE</b>. En el supuesto que <b>EL (LA/LOS) COMPRADOR (A/ES)</b> no haga entrega de la posesión o no permita que <b>LA VENDEDORA</b> tome posesión de <b>EL LOTE</b>, se devengará en forma automática a favor de <b>LA VENDEDORA</b> una penalidad adicional, por retraso en la entrega de posesión, ascendente a US$.5.00 (Cinco y 00/100 Dólares Americanos) diarios, hasta la fecha de entrega de posesión de <b>EL LOTE</b>. El monto de la penalidad por retraso en la entrega de posesión de <b>EL LOTE</b> será descontado por <b>LA VENDEDORA</b> del saldo correspondiente a <b>EL (LA/LOS) COMPRADOR (A/ES)</b>.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">De no cumplir <b>LA VENDEDORA</b> con las obligaciones que asume en el presente contrato, en particular la entrega de la posesión de <b>EL LOTE</b>  en el plazo estipulado en la cláusula sétima, incluyendo la prórroga, <b>EL (LA/LOS) COMPRADOR (A/ES)</b> deberá comunicar, por escrito, dicho incumplimiento a <b>LA VENDEDORA</b>, para que subsane en un plazo no mayor a 60 días calendario; caso contrario, el presente contrato podrá ser resuelto y en forma automática y sin necesidad de declaración judicial previa, bastando para ello que <b>EL (LA/LOS) COMPRADOR (A/ES)</b> envíe una comunicación notarial, en tal sentido, a <b>LA VENDEDORA</b>. Producida la resolución del Contrato conforme a lo indicado precedentemente, <b>LA VENDEDORA</b> deberá devolver en un plazo de 30 días calendario el íntegro del dinero entregado (este monto a devolver no incluye en ninguna circunstancia las penalidades por mora responsabilidad de <b>EL (LA/LOS) COMPRADOR (A/ES)</b>, conceptos que no serán devueltos a <b>EL (LA/LOS) COMPRADOR (A/ES)</b>, más el interés legal vigente en el Banco Central de Reserva del Perú a la fecha de producida la resolución.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>DECIMA SEGUNDA: REGLAMENTO INTERNO</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;"><b>EL (LA/LOS) COMPRADOR (A/ES)</b> declara conocer que <b>EL LOTE</b> que adquiere estará sujeto a los estatutos y reglamento general que se apruebe para tal efecto. </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>DECIMA TERCERA: GASTOS</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Será de cuenta de <b>EL (LA/LOS) COMPRADOR (A/ES)</b> el pago de los derechos notariales y registrales que origine la presente. </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>DECIMA CUARTA: SOBRE LA POSICIÓN CONTRACTUAL</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;"><b>EL (LA/LOS) COMPRADOR (A/ES)</b> declara (n) autorizar de manera irrevocable a <b>LA VENDEDORA</b> a ceder su Posición Contractual de éste contrato, a una tercera persona natural o jurídica, así también cedería toda obligación para con <b>EL (LA/LOS) COMPRADOR (A/ES)</b>, no pudiendo <b>EL (LA/LOS) COMPRADOR (A/ES)</b> ser afectado de alguna manera, ni las condiciones del presente contrato podrán variar de alguna manera.
 </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		</table>
<table>

		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		
		<tr>
		<td width="530px" style="border: 1px solid #ffffff;text-align:center">6</td>
		</tr>
		
		
	</table>
EOF;

$pdf->writeHTML($html23456, false, false, false, false, '');


$html234567 = <<<EOF
<table style="border: 5px solid #ffffff; background-color:white;color:white">
		
<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>			
		   <td style="width:400px"></td>
			<td width="100px"><img src="../images/logoalma.jpg"></td>
			
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
	</table>

	<table style="border: 1px solid #ffffff; text-align:justify; line-height: 15px; font-size:11px">
		
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;"><b>EL (LA/LOS) COMPRADOR (A/ES)</b> declara conocer y aceptar que no podrá ceder total o parcialmente su posición contractual en la presente relación jurídica, ni podrá transferir los derechos que adquiere por la celebración del presente contrato, sin contar con la intervención y el consentimiento previo y expreso y por escrito de <b>LA VENDEDORA</b>.
		  </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>DECIMA QUINTA: DOMICILIO Y NOTIFICACIONES</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Las partes señalan sus domicilios en los lugares indicados en la introducción del presente contrato. Cualquier comunicación o notificación deberá ser cursada a dichos domicilios por escrito. En caso de cambio de domicilio, éste tendrá efecto legal a partir de la comunicación a la otra parte por escrito con cargo de constancia de recepción.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">En caso contrario, cualquier comunicación hecha al anterior domicilio se entenderá válidamente efectuada y surtirá plenos efectos legales.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>DECIMA SEXTA: JURISDICCIÓN</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Cualquier controversia derivada de la celebración, ejecución y/o interpretación del presente contrato, las partes resolverán dichas discrepancias o controversias de mutuo acuerdo y mediante el diálogo directo, aplicando las reglas de la buena fe.
</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">De no llegar a un acuerdo, ambas partes se reunirán, en un plazo de 15 días hábiles, en una segunda oportunidad a efectos de proponer una segunda alternativa de solución, mediante el diálogo directo, aplicando las reglas de la buena fe.
</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">En el caso que no puedan resolver dicha controversia en trato directo, será sometida a la Competencia Arbitral y se llevará a cabo en la ciudad de Arequipa, conforme al Reglamento del Centro de Conciliación y Arbitraje de la Cámara de Comercio e Industria de Arequipa, por un arbitro único designado de común acuerdo o en su defecto, designado según su Reglamento, cuyo laudo será final e inapelable.
</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
		<b>DECIMA SETIMA</b></td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Forma parte integrante e indesligable del presente contrato el siguiente documento, que <b>EL (LA/LOS) COMPRADOR (A/ES)</b> declara conocer y aceptar:</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;">
		<ol style="text-align:justify;">

		<li><b>Anexo A:</b> Plano del lote con indicación de: ubicación, área y medidas perimétricas</li><br>
		<li><b>Anexo B:</b> Proforma de Venta de contiene el Cronograma de Pagos.</li><br>
		<li><b>Anexo C:</b> Resolución emitida por la Municipalidad correspondiente y Plano de la aprobación del proyecto de Habilitación Urbana (*).</li><br>
		<li><b>Anexo D:</b> Proforma de Venta de contiene el Cronograma de Pagos.</li>

		</ol>
		</td>
		</tr>


		</table>

		<table>

		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
		<td width="530px" style="border: 1px solid #ffffff;text-align:center">7</td>
		</tr>
		
		
	</table>
EOF;

$pdf->writeHTML($html234567, false, false, false, false, '');



$html2345678 = <<<EOF
<table style="border: 5px solid #ffffff; background-color:white;color:white">
		
<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>			
		   <td style="width:400px"></td>
			<td width="100px"><img src="../images/logoalma.jpg"></td>
			
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
	</table>
	<table style="border: 1px solid #ffffff; text-align:justify; line-height: 15px; font-size:11px">
		
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">(*) Se deja constancia que la aprobación de la Habilitación Urbana se encuentra en vías de regularización, comprometiéndose <b>LA VENDEDORA</b> en hacerle llegar dichos documentos a <b>EL (LA/LOS) COMPRADOR (A/ES)</b> en su oportunidad. </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:justify; background-color:white;">Las partes dejan constancia que en la redacción y suscripción del presente documento no ha mediado error, lesión o vicio de voluntad alguno capaz de invalidarlo de forma parcial o total, ratificándose en los términos del mismo, procediendo a firmarlo en señal de confirmada en Arequipa a los $dia días del mes de $mes del año $anho. </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>

		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:center; background-color:white;">.......................................................... </td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:center; background-color:white;"><b>ALMA PERÚ E.I.R.L. 	</b> </td>
		</tr>
<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>

		
		<tr>
			<td width="35px" style="border: 1px solid #ffffff;"></td>
			<td width="280px" style="border: 1px solid #ffffff;">....................................................................</td>
			<td width="280px" style="border: 1px solid #ffffff;">....................................................................</td>
		</tr>
<tr>
			
			<td width="280px" style="border: 1px solid #ffffff;text-align:center"><b>EL (LA/LOS) COMPRADOR (A/ES)</b></td>
			<td width="280px" style="border: 1px solid #ffffff;text-align:center"><b>EL (LA/LOS) COMPRADOR (A/ES) </b></td>
		</tr>


		</table>

		<table>

		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr><tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr><tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr><tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 5px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		
		<tr>
		<td width="530px" style="border: 1px solid #ffffff;text-align:center">8</td>
		</tr>
		
		
	</table>
EOF;

$pdf->writeHTML($html2345678, false, false, false, false, '');



$pdf->Output('factura.pdf', 'I');
	}
}

$prueba = new contrato();

$prueba -> imprimir_contrato();

?>