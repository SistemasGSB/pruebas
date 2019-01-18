<?php
require_once "../../controladores/clientes.controlador.php";
require_once "../../modelos/clientes.modelo.php";
require_once "../../controladores/proyectos.controlador.php";
require_once "../../modelos/proyectos.modelo.php";
require_once "../../controladores/cotizador.controlador.php";
require_once "../../modelos/cotizador.modelo.php";
require_once "../../controladores/prospeccion.controlador.php";
require_once "../../modelos/prospeccion.modelo.php";
class facturas{

	public function imprimir_facturas(){
	require_once('tcpdf_include.php');
	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->AddPage();	
	//*Formato de Fecha
	date_default_timezone_set('America/Los_Angeles');
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$fecha = date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
	$ahora = time();
	//**Obteniendo el ID
	$item_principal = "id";
	$valor_principal = $_GET["id"];
	$respuesta_principal = ControladorCotizador::ctrMostrarCotizador($item_principal, $valor_principal);
	//**	
	//**Fin Formato Fecha
	//** Obteniendo los datos DNI 
	$item = "dni";
	$valor = $respuesta_principal["dni_cliente"];
	$asesor_nombre = $respuesta_principal["asesor_nombre"];
	$orden = "id_cliente";

	$obtener_prospeccion = ControladorProspeccion::ctrBuscarProspeccion($item_principal, $valor_principal);
	$tipo_cambio = $obtener_prospeccion["tipo_cambio"];
	//**Fin de obtener DNI
	//**
	$cliente_prospeccion = ControladorClientes::ctrBuscarClientes($item, $valor, $orden);
	$apellidos_completos = $cliente_prospeccion["apellido"];
	$nombres_completos = $cliente_prospeccion["nombre"];
	$direccion_completa = $cliente_prospeccion["direccion"];
	$distrito_completo =  $cliente_prospeccion["distrito"];
	$celular = $cliente_prospeccion["celular"];
	$email = $cliente_prospeccion["email"];
	$dni_conyuge= $cliente_prospeccion["dni_conyuge"];
	//**
	//**
	$obtener_proyecto = ControladorProyectos::ctrMostrarProyectos("id_proyecto",$respuesta_principal["id_proyecto"]);
	$producto = $obtener_proyecto["proyecto"];
	$orden = $obtener_proyecto["etapa"];
	$metraje = $obtener_proyecto["area"];
	$terreno = $obtener_proyecto["terreno"];
	$precio = $obtener_proyecto["precio_lista"];

	$obtener_cotizacion = ControladorCotizador::ctrMostrarCotizador("id",$_GET["id"]);
	$pfd = $obtener_cotizacion["cot_pfd"];
	$sep_usd = $obtener_cotizacion["cot_sep_usd"];
	$cot_cis_usd = $obtener_cotizacion["cot_cis_usd"];
	$cot_mfd = $obtener_cotizacion["cot_mfd"];
	$cot_tci = $obtener_cotizacion["cot_tci"];
	$cot_tci_usd = $obtener_cotizacion["cot_tci_usd"];
	$cot_sci_usd= $cot_tci_usd-$cot_cis_usd-$sep_usd;
	$cot_sci = round(($cot_sci_usd/$precio)*100,2);
	$cot_cuotam = round($cot_mfd/$pfd,2);
	$cot_sep=round(($sep_usd/$precio)*100,2);
	$cot_cis=round(($cot_cis_usd/$precio)*100,2);
	$asesor = $obtener_cotizacion["asesor"];
	$telefono_asesor = $obtener_cotizacion["telefono_asesor"];

	//**
	$html = <<<EOF


	<table  style="border: 2px solid #ffffff;line-height: 5px; font-size:10px">
		<tr>
			<td width="460px" style="border: 1px solid #ffffff; background-color:white;"><b>N° 0000$valor_principal</b></td>
			<td width="140px"><img src="../images/logoalma.jpg" width="80px"></td>		
		</tr>
	</table>
		<table>
		<tr>
			<td width="540x" style="border: 1px solid #666; font-size:14px ; text-align:center;background-color:#006666; color:#fff"><b>COTIZACION</b></td>	
		</tr>
		</table>	

	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #666;"><b>FECHA</b></td>
			<td width="440px" style="border: 1px solid #666;"><b>$fecha</b></td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px;font-weight:700; font-size:12px">
		<tr>
			<td width="540x" style="border: 1px solid #666; background-color:#006666; color:#fff"><b>DATOS DEL CLIENTE</b></td>			
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 8px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #006666;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #006666;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Terreno</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666; background-color:white;"><b>Apellidos</b></td>
			<td width="440px" style="border: 1px solid #006666; background-color:white;">$apellidos_completos</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 8px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #006666;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #006666;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Terreno</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666; background-color:white;"><b>Nombres</b></td>
			<td width="440px" style="border: 1px solid #006666; background-color:white;">$nombres_completos</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 8px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #006666;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #006666;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Terreno</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666; background-color:white;"><b>DNI</b></td>
			<td width="170px" style="border: 1px solid #006666; background-color:white;">$valor</td>
			<td width="110px" style="border: 1px solid #006666; background-color:white;"><b>DNI CONYUGE</b></td>
			<td width="160px" style="border: 1px solid #006666; background-color:white;">$dni_conyuge</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 8px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #006666;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #006666;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Terreno</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666; background-color:white;"><b>DIRECCION</b></td>
			<td width="440px" style="border: 1px solid #006666; background-color:white;">$direccion_completa</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 8px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #006666;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #006666;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Terreno</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666; background-color:white;"><b>DISTRITO</b></td>
			<td width="170px" style="border: 1px solid #006666; background-color:white;">$distrito_completo</td>
			<td width="110px" style="border: 1px solid #006666; background-color:white;"><b>CIUDAD</b></td>
			<td width="160px" style="border: 1px solid #006666; background-color:white;">Arequipa</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 8px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #006666;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #006666;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Terreno</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666; background-color:white;"><b>TELEFONO</b></td>
			<td width="170px" style="border: 1px solid #006666; background-color:white;">--</td>
			<td width="110px" style="border: 1px solid #006666; background-color:white;"><b>CELULAR</b></td>
			<td width="160px" style="border: 1px solid #006666; background-color:white;">$celular</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 8px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #006666;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #006666;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #006666;color:#fff">Terreno</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #006666; background-color:white;"><b>CORREO</b></td>
			<td width="440px" style="border: 1px solid #006666; background-color:white;">$email</td>
		</tr>
	</table>
	
	<table style="border: 1px solid #333; text-align:center; line-height: 8px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #fff;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #fff;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Terreno</td>
		</tr>
	</table>

EOF;
$precio_c = number_format($precio,2);
$cot_sep_c = number_format($cot_sep,2);
$sep_usd_c = number_format($sep_usd,2);
$cot_cis_c = number_format($cot_cis,2);
$cot_cis_usd_c = number_format($cot_cis_usd,2);
$cot_sci_c = number_format($cot_sci,2);
$cot_sci_usd_c= number_format($cot_sci_usd,2);
$cot_tci_c = number_format($cot_tci,2);
$cot_tci_usd_c = number_format($cot_tci_usd,2);
$cot_mfd_c = number_format($cot_mfd,2);
$cot_cuotam_c = number_format($cot_cuotam,2);
$pdf->writeHTML($html, false, false, false, false, '');
$html2 = <<<EOF
	<table style="border: 1px solid #333; text-align:center; line-height: 20px;font-weight:700; font-size:11px">
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666; color:#fff"><b>MANZANA / LOTE</b></td>
			<td width="270x" style="border: 1px solid #666; background-color:#006666; color:#fff"><b>ÁREA TOTAL</b></td>			
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px;font-weight:700; font-size:11px">
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#fff;">$terreno</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">M2</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$metraje</td>		
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 8px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #fff;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #fff;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Terreno</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px;font-weight:700; font-size:11px">
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>PRECIO LISTA</b></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">US$</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$precio_c</td>		
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px;font-weight:700; font-size:11px">
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>PRECIO VENTA</b></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">US$</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$precio_c</td>		
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 8px; font-size:10px">
		<tr>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #fff;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #fff;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Terreno</td>
		</tr>
	</table>
	<table style="border: 1px solid #333; text-align:center; line-height: 20px;font-weight:700; font-size:11px">
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>SEPARACION</b></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">%</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$cot_sep_c</td>

		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">US$</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$sep_usd_c</td>		
		</tr>		
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>CUOTA INICIAL SEP.</b></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">%</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$cot_cis_c</td>

		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">US$</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$cot_cis_usd_c</td>		
		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>SALDO CUOTA INICIAL</b></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">%</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$cot_sci_c</td>

		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">US$</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$cot_sci_usd_c</td>		
		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>TOTAL CUOTA INICIAL</b></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">%</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$cot_tci_c</td>

		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">US$</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$cot_tci_usd_c</td>		
		</tr>
		<tr style="border: 0px solid #333; text-align:center; line-height: 8px; font-size:10px">
			<td width="100px" style="border: 1px solid #fff;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #fff;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #fff;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Terreno</td>
		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>MONTO FINANCIAMIENTO DIRECTO</b></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">US$</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$cot_mfd_c</td>

		</tr>
		<tr style="border: 0px solid #333; text-align:center; line-height: 8px; font-size:10px">
			<td width="100px" style="border: 1px solid #fff;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #fff;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #fff;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Terreno</td>
		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>PLAZO FINANCIAMIENTO DIRECTO</b></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">MESES</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$pfd</td>

		</tr>
		<tr style="border: 0px solid #333; text-align:center; line-height: 8px; font-size:10px">
			<td width="100px" style="border: 1px solid #fff;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #fff;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #fff;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Terreno</td>
		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>Nº CUOTAS</b></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">LETRAS</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$pfd</td>

		</tr>
		<tr style="border: 0px solid #333; text-align:center; line-height: 8px; font-size:10px">
			<td width="100px" style="border: 1px solid #fff;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #fff;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #fff;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Terreno</td>
		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>CUOTA MENSUAL (VALOR ESTIMADO)</b></td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">US$</td>
			<td width="135x" style="border: 1px solid #666; background-color:#fff;">$cot_cuotam_c</td>

		</tr>
		<tr style="border: 0px solid #333; text-align:center; line-height: 8px; font-size:10px">
			<td width="100px" style="border: 1px solid #fff;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #fff;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #fff;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Terreno</td>
		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>ASESOR DE VENTAS</b></td>
			<td width="270x" style="border: 1px solid #666; background-color:#fff;">$asesor_nombre</td>

		</tr>
		<tr style="border: 0px solid #333; text-align:center; line-height: 8px; font-size:10px">
			<td width="100px" style="border: 1px solid #fff;color:#fff">Producto</td>
			<td width="280px" style="border: 1px solid #fff;color:#fff">Etapa</td>
			<td width="60px" style="border: 1px solid #fff;color:#fff">Área</td>
			<td width="100px" style="border: 1px solid #fff;color:#fff">Terreno</td>
		</tr>
		<tr>
			<td width="270x" style="border: 1px solid #666; background-color:#006666;color:#fff"><b>TELEFONO ASESOR VENTAS</b></td>
			<td width="270x" style="border: 1px solid #666; background-color:#fff;">$telefono_asesor</td>

		</tr>
	</table>
	<p style="text-align:center;font-size:10px">Nota: La presente cotización tiene una vigencia de 03 días a partir de la fecha de emisión. No es una opción de venta, por lo que las condiciones y precios podrán variar en cualquier momento sin previo aviso.</p>
EOF;

$pdf->writeHTML($html2, false, false, false, false, '');
$pdf->Output('cotizador.pdf', 'I');
	}
}

$prueba = new facturas();

$prueba -> imprimir_facturas();

?>