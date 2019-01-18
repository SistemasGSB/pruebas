<?php

require_once "../controladores/proyectos.controlador.php";
require_once "../modelos/proyectos.modelo.php";


class AjaxProyectos{

	/*=============================================
	EDITAR Proyectos
	=============================================*/	

	public $idProyecto;

	public function ajaxEditarProyecto(){

		$item = "id_proyecto";
		$valor = $this->idProyecto;

		$respuesta = ControladorProyectos::ctrMostrarProyectos($item, $valor);

		echo json_encode($respuesta);

	}
	/*=============================================
	ACTIVAR USUARIO
	=============================================*/	

	public $activarProyecto;
	public $activarId;


	public function ajaxActivarProyecto(){

		$tabla = "proyectos";

		$item1 = "estado";
		$valor1 = $this->activarProyecto;

		$item2 = "id_proyecto";
		$valor2 = $this->activarId;
		$respuesta = ModeloProyectos::mdlActualizarProyectos($tabla, $item1, $valor1, $item2, $valor2);
		ModeloProyectos::mdlBorrarProyecto("prospeccion",$valor2);
		ModeloProyectos::mdlBorrarProyecto("cotizacion",$valor2);
		ModeloProyectos::mdlBorrarProyecto("reserva",$valor2);
		ModeloProyectos::mdlBorrarProyecto("simulacion",$valor2);
		ModeloProyectos::mdlBorrarProyecto("proforma",$valor2);
	}
}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idProyecto"])){

	$proyecto = new AjaxProyectos();
	$proyecto -> idProyecto = $_POST["idProyecto"];
	$proyecto-> ajaxEditarProyecto();
}
/*=============================================
ACTIVAR USUARIO
=============================================*/	

if(isset($_POST["activarProyecto"])){

	$activarProyecto = new AjaxProyectos();
	$activarProyecto -> activarProyecto = $_POST["activarProyecto"];
	$activarProyecto -> activarId = $_POST["activarId"];
	$activarProyecto -> ajaxActivarProyecto();

}
