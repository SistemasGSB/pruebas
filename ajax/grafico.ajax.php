<?php

require_once "../controladores/proforma.controlador.php";
require_once "../modelos/proforma.modelo.php";

class AjaxGraficos{

	/*=============================================
	EDITAR CLIENTE
	=============================================*/	


	public function ajaxGraficoProformas(){

		$respuesta = ControladorProforma::ctrDatosGrafico();
		echo json_encode($respuesta);

	}

}

/*=============================================
EDITAR CLIENTE
=============================================*/	

$cliente = new AjaxGraficos();
$cliente -> ajaxGraficoProformas();



