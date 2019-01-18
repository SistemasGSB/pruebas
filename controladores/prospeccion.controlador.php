<?php

class ControladorProspeccion{

	static public function ctrBuscarProspeccion($item, $valor){

		$tabla = "prospeccion";

		$respuesta = ModeloProspeccion::mdlMostrarProspeccion($tabla, $item, $valor);

		return $respuesta;
	
	}

	static public function ctrEditPros($valor){

		$respuesta = ModeloProspeccion::mdlEditPros($valor);

		return $respuesta;
	
	}
	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarProspeccion($item, $valor){

		$tabla = "prospeccion";
		$tabla2 = "proyectos";
		$tabla3 = "clientes";

		$respuesta = ModeloProspeccion::mdlMostrarVista($tabla,$tabla2,$tabla3,$item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarProspeccion(){
		if(isset($_GET['id_c'])){
			$datos = array('proyecto' => $_POST['proyectos'],'etapa' =>$_POST['etapa_proyecto'] ,'lote' => $_POST['lotes_proyecto'],'id' => $_POST['id_pro'] );
			$tabla = "prospeccion";

			$respuesta = ModeloProspeccion::mdlEditarProspeccion($tabla,$datos);
			if($respuesta == "ok"){
				echo'<script>

					swal({
						  type: "success",
						  title: "Tu Prospeccion ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "rep-prospeccion";

									}
								})

					</script>';

			}
		}
	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function ctrBorrarProspeccion(){

		if(isset($_GET["idProspeccion"])){

			$tabla ="prospeccion";
			$datos = $_GET["idProspeccion"];

			$respuesta = ModeloProspeccion::mdlBorrarProspeccion($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "Tu Prospeccion ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "rep-prospeccion";

									}
								})

					</script>';
			}
		}
		
	}
}
