<?php
require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";
require_once "../../../controladores/proyectos.controlador.php";
require_once "../../../modelos/proyectos.modelo.php";
require_once "../../../controladores/simulador.controlador.php";
require_once "../../../modelos/simulador.modelo.php";
require_once "../../../controladores/cotizador.controlador.php";
require_once "../../../modelos/cotizador.modelo.php";
require_once "../../../controladores/reserva.controlador.php";
require_once "../../../modelos/reserva.modelo.php";
require_once "../../../controladores/prospeccion.controlador.php";
require_once "../../../modelos/prospeccion.modelo.php";
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
	$respuesta_principal = ControladorReserva::ctrMostrarReserva($item_principal, $valor_principal);
	//**	
	//**Fin Formato Fecha
	//** Obteniendo los datos DNI 
	$item = "dni";
	$valor = $respuesta_principal["dni_cliente"];
	$asesor_nombre = $respuesta_principal["asesor_nombre"];
	$orden = "id_cliente";	
	//**Fin de obtener DNI
	$fecha_deposito = $respuesta_principal["fecha_deposito"];
	$inicio_d = str_replace('/','-',$fecha_deposito);
	$nuevafecha = date("d/m/Y", strtotime(" +7 day " , strtotime($inicio_d)));

	$cliente_prospeccion = ControladorClientes::ctrBuscarClientes($item, $valor, $orden);
	$direccion_completa = $cliente_prospeccion["direccion"].','.$cliente_prospeccion["distrito"];
	$nombres_completos = $cliente_prospeccion["nombre"].' '.$cliente_prospeccion["apellido"];
	$medio_publicitario = $cliente_prospeccion["medio_captacion"];
	$celular_cliente = $cliente_prospeccion["celular"];
	$conyuge= $cliente_prospeccion["nombre_conyuge"].' '.$cliente_prospeccion["apellido_conyuge"];
	$dni_conyuge= $cliente_prospeccion["dni_conyuge"];
	
	$obtener_proyecto = ControladorProyectos::ctrMostrarProyectos("id_proyecto",$respuesta_principal["id_proyecto"]);
	$lote = $obtener_proyecto["terreno"];
	$proyecto = $obtener_proyecto["proyecto"];
	$etapa = $obtener_proyecto["etapa"];
	$area = $obtener_proyecto["area"];

	$obtener_cotizacion = ControladorCotizador::ctrMostrarCotizador("id",$respuesta_principal["id_cotizacion"]);
	$tipo_cambio = $respuesta_principal["tipo_cambio"];
	$precio_contado = $obtener_proyecto["precio_lista"] * $tipo_cambio;
	$precio_contado_c = number_format($precio_contado,2);

	$precio_metro = number_format($obtener_proyecto["precio_metro"] * $tipo_cambio, 2);
	$cuotas = $obtener_cotizacion["cot_pfd"];
	$primera_cuota = $obtener_cotizacion["cot_cis_usd"] * $tipo_cambio;
	$cot_mfd = $obtener_cotizacion["cot_mfd"]* $tipo_cambio;
	$cot_cuotam = round($cot_mfd/$cuotas,2);
	$cot_cuotam_c = number_format($cot_cuotam,2);
	$primera_cuota_c = number_format($primera_cuota,2);
	$telefono_asesor = $obtener_cotizacion["telefono_asesor"];
	//**
	$html = <<<EOF
	<table  style="border: 2px solid #ffffff;line-height: 5px; font-size:10px">
		<tr>
			<td width="460px" style="border: 1px solid #ffffff; background-color:white;"><b>N° 0000$valor_principal</b></td>
			<td width="140px"><img src="../images/logoalma.jpg" width="80px"></td>		
		</tr>
	</table>

	<table style="border: 1px solid #ffffff; text-align:center; line-height: 20px; font-size:14px">
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;"><b>RESERVA TEMPORAL DE LOTE</b></td>			
		</tr>
	</table>

	<table style="border: 1px solid #ffffff; line-height: 10px; font-size:8px">
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>			
		</tr>
		<tr>
			<td width="380px" style="border: 1px solid #ffffff; background-color:white;"><b>FECHA DE RESERVA: $fecha_deposito</b></td>	
			<td width="350px" style="border: 1px solid #ffffff; background-color:white;"><b>VENCIMIENTO DE RESERVA: $nuevafecha</b></td>	
		</tr>
		
		<tr>
			<td width="380px" style="border: 1px solid #ffffff; background-color:white;"><b>TIPO DE CAMBIO: $tipo_cambio</b></td>			
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>			
		</tr>
	</table>
	<table style="border: 1px solid #ffffff; line-height: 10px; font-size:8px">
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;">Se denominará EL INTERESADO a la(s) siguientes(es) persona(s):</td>

		</tr>

	</table>
	<br><br>	
	<table style="text-align:center;line-height: 10px; font-size:8px">

		<tr style="border: 1px solid #000000">
			<td width="300px" style="border: 1px solid #000000; background-color:white;">$nombres_completos</td>
			<td width="100px" style="border: 1px solid #000000; background-color:white;">D.N.I.</td>	
			<td width="140px" style="border: 1px solid #000000; background-color:white;"> $valor </td>				
		</tr>
		<tr>
			<td width="300px" style="border: 1px solid #000000; background-color:white;">$conyuge</td>
			<td width="100px" style="border: 1px solid #000000; background-color:white;">D.N.I.</td>	
			<td width="140px" style="border: 1px solid #000000; background-color:white;"> $dni_conyuge </td>				
		</tr>
		<tr>
			<td width="100px" style="border: 1px solid #000000; background-color:white;">Domicilio</td>
			<td width="440px" style="border: 1px solid #000000; background-color:white;">$direccion_completa</td>				
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left;background-color:white;">EL INTERESADO manifiesta su interés en comprar el lote (en adelante EL LOTE) de propiedad de ALMA PERU E.I.R.L  (en adelante LA EMPRESA) que se detalla a continuación:</td>			
		</tr>
	</table>
	<br><br>
	<table style="border: 1px solid #ffffff; text-align:center; line-height: 10px; font-size:8px">
		<tr>
			<td width="180px" style="border: 1px solid #000000; background-color:#D9D9D9;">Lote/Manzana</td>
			<td width="160px" style="border: 1px solid #000000; background-color:#D9D9D9;">Urbanización</td>
			<td width="100px" style="border: 1px solid #000000; background-color:#D9D9D9;">Etapa</td>
			<td width="100px" style="border: 1px solid #000000; background-color:#D9D9D9;">Área</td>				
		</tr>
		<tr>
			<td width="180px" style="border: 1px solid #000000; background-color:white;">$lote</td>	
			<td width="160px" style="border: 1px solid #000000; background-color:white;">$proyecto</td>
			<td width="100px" style="border: 1px solid #000000; background-color:white;">$etapa</td>
			<td width="100px" style="border: 1px solid #000000; background-color:white;">$area</td>				
		</tr>
		<tr>
			<td width="180px" style="border: 1px solid #000000; background-color:#D9D9D9;">Distrito</td>
			<td width="160px" style="border: 1px solid #000000; background-color:#D9D9D9;">Provincia</td>	
			<td width="200px" style="border: 1px solid #000000; background-color:#D9D9D9;">Departamento</td>				
		</tr>
		<tr>
			<td width="180px" style="border: 1px solid #000000; background-color:white;">Arequipa</td>
			<td width="160px" style="border: 1px solid #000000; background-color:white;">Arequipa</td>	
			<td width="200px" style="border: 1px solid #000000; background-color:white;">Arequipa</td>				
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">EL INTERESADO se obliga a suscribir el contrato de compraventa (en adelante EL CONTRATO) de EL LOTE en un plazo improrrogable de SIETE (7) días calendario, contados desde la fecha de este documento. LA EMPRESA reservará EL LOTE por dicho plazo improrrogable; es decir, no ofrecerá en venta EL LOTE a terceras personas durante el referido plazo.</td>			
		</tr>

	</table>
	<table style="border: 1px solid #ffffff; text-align:center; line-height: 10px; font-size:8px">
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>			
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">EL INTERESADO declara conocer y aceptar que las condiciones mínimas de EL CONTRATO serán:</td>	
		</tr>
		<br>	
		<tr>
			<td width="340px" style="border: 1px solid #000000;text-align:left; background-color:white;">Precio por metro cuadrado.</td>	
			<td width="100px" style="border: 1px solid #000000; background-color:white;">S/.</td>
			<td width="100px" style="border: 1px solid #000000; background-color:white;">$precio_metro</td>				
		</tr>
		<tr>
			<td width="340px" style="border: 1px solid #000000;text-align:left; background-color:white;">Precio de venta (al contado).</td>	
			<td width="100px" style="border: 1px solid #000000; background-color:white;">S/.</td>
			<td width="100px" style="border: 1px solid #000000; background-color:white;">$precio_contado_c</td>				
		</tr>
		<tr>
			<td width="340px" style="border: 1px solid #000000;text-align:left; background-color:white;">Precio de venta fraccionado (comprende el precio más los intereses).</td>	
			<td width="100px" style="border: 1px solid #000000; background-color:white;">S/.</td>
			<td width="100px" style="border: 1px solid #000000; background-color:white;">$precio_contado_c</td>				
		</tr>
		<tr>
			<td width="340px" style="border: 1px solid #000000;text-align:left; background-color:white;">Primera cuota.</td>	
			<td width="100px" style="border: 1px solid #000000; background-color:white;">S/. </td>
			<td width="100px" style="border: 1px solid #000000; background-color:white;">$primera_cuota_c</td>				
		</tr>
		<tr>
			<td width="340px" style="border: 1px solid #000000;text-align:left; background-color:white;">Número de cuotas mensuales del saldo de precio.</td>
			<td width="200px" style="border: 1px solid #000000; background-color:white;">$cuotas</td>				
		</tr>
		<tr>
			<td width="340px" style="border: 1px solid #000000;text-align:left; background-color:white;">Importe de cada cuota (incluye capital e intereses).</td>	
			<td width="100px" style="border: 1px solid #000000; background-color:white;">S/.</td>
			<td width="100px" style="border: 1px solid #000000; background-color:white;">$cot_cuotam_c</td>				
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">Si en el plazo establecido EL INTERESADO no firma EL CONTRATO, la reserva de EL LOTE quedará automáticamente sin efecto alguno, y LA EMPRESA podrá libremente ofrecer en venta EL LOTE.</td>			
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
Se precisa que el presente documento no es una compraventa, una opción de compraventa a favor de EL INTERESADO, ni un compromiso de contratar una compraventa. Asimismo, se deja constancia que las condiciones mínimas de EL CONTRATO únicamente se mantendrán vigentes durante el plazo establecido en el presente documento.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
Queda expresamente establecido que el único documento que LA EMPRESA reconoce para la reserva de EL LOTE es el presente documento, por lo que cualquier pago o documento distinto al presente, carece de valor. Asimismo se precisa que TODO pago del precio de venta de EL LOTE deberá efectuarse mediante depósito en la cuenta bancaria indicada por LA EMPRESA.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
En caso que EL INTERESADO no cumpla con suscribir EL CONTRATO en el plazo establecido, según las “Instrucciones para la firma de EL CONTRATO” previstas en este documento, deberá pagar a LA EMPRESA el importe de S/. 50.00 (CINCUENTA Y 00/100  SOLES) por concepto de penalidad por el incumplimiento de la obligación a su cargo.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
Con la finalidad de garantizar el pago de la penalidad pactada, EL INTERESADO entrega a LA  EMPRESA el importe de S/. 50.00 (CINCUENTA Y 00/100 SOLES) en calidad de garantía; estableciéndose lo siguiente:</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
a)	Si EL INTERESADO cumple  con suscribir EL CONTRATO en el plazo establecido, el importe de la garantía, sin intereses ni concepto adicional alguno, se aplicará como parte de pago del importe de la primera cuota del precio de venta.:</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
b)	Si EL INTERESADO no cumple con suscribir EL CONTRATO en el plazo establecido, el importe de la garantía se aplicará automáticamente, sin necesidad de acto o declaración adicional que la contenida en este documento, al pago de la penalidad pactada a cargo de EL INTERESADO.</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
			Medio Publicitario: $medio_publicitario 
			</td>
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>	
		</tr>
		<tr>
			<td width="540px" style="border: 1px solid #ffffff; text-align:left; background-color:white;">
			Observaciones: ______________________________________________________________
			</td>
		</tr>
	</table>
	<table style="border: 1px solid #ffffff; text-align:center; line-height: 10px; font-size:8px">
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
		<br>
		<tr>
			<td width="60px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>
			<td width="190px">_____________________________________</td>	
			<td width="40px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>
			<td width="190px">_____________________________________</td>
			<td width="60px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>				
		</tr>
		<tr>
			<td width="60px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>
			<td width="190px">EL INTERESADO</td>	
			<td width="40px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>
			<td width="190px">$asesor_nombre</td>
			<td width="60px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>				
		</tr>
		<tr>
			<td width="60px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>
			<td width="190px">Teléfono:$celular_cliente</td>	
			<td width="40px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>
			<td width="190px">Teléfono:$telefono_asesor</td>
			<td width="60px" style="border: 1px solid #ffffff; background-color:white;color:white">BLANCO</td>				
		</tr>
	</table>
	<table style="border: 1px solid #ffffff; text-align:center; line-height: 10px; font-size:8px">
		<br><br><br>
		<tr>
			<td width="540px" style="border: 1px solid #000000;text-align:center; background-color:white;">INSTRUCCIONES PARA LA FIRMA DE EL CONTRATO<br>NO OLVIDAR llevar fotocopia y original del D.N.I. y recibo de luz o agua cancelado y Voucher de depósito</td>				
		</tr>
	</table>

EOF;

$pdf->writeHTML($html, false, false, false, false, '');

$pdf->Output('reserva_soles.pdf', 'I');
	}
}

$prueba = new facturas();

$prueba -> imprimir_facturas();

?>