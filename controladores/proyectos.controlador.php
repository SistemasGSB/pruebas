<?php

class ControladorProyectos{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearProyecto(){

		if(isset($_POST["nuevoProyecto"]) || isset($_POST["nuevo_pro"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoProyecto"]) || preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevo_pro"]) ){

				$tabla = "proyectos";

				$datos = array("proyecto" => $_POST["nuevoProyecto"],
					           "etapa" => $_POST["etapaProyecto"],
					           "terreno" => $_POST["terrenoProyecto"],
					           "precio_lista" => $_POST["precioProyecto"],
					           "area" => $_POST["areaProyecto"],
					       		"precioM" => $_POST["precioMetro"]);
				if($_POST["nuevo_pro"]!=""){
					$datos['proyecto'] =$_POST["nuevo_pro"]; 
				}
				if($_POST["nueva_eta"]!=""){
					$datos['etapa'] =$_POST["nueva_eta"]; 
				}
				$respuesta = ModeloProyectos::mdlIngresarProyecto($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El proyecto ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "proyectos";

									}
								})

					</script>';

				}
				else{
					if($respuesta=="exi"){
								
						echo'<script>

							swal({
								  type: "error",
								  title: "¡El proyecto esta duplicado!",
								  showConfirmButton: true,
								  confirmButtonText: "Cerrar"
								  }).then(function(result){
									if (result.value) {

									window.location = "proyectos";

									}
								})

					  	</script>';

					}
				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El proyecto no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "proyectos";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarProyectos($item, $valor){

		$tabla = "proyectos";

		$respuesta = ModeloProyectos::mdlMostrarProyectos($tabla, $item, $valor);

		return $respuesta;
	
	}


	static public function ctrCategoriaP($columna){

		$respuesta = ModeloProyectos::mdlCategoriaP($columna);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarProyecto(){

		if(isset($_POST["editarProyecto"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarProyecto"])){

				$tabla = "proyectos";

				$datos = array("proyecto"=>$_POST["editarProyecto"],
							   "id_proyecto"=>$_POST["idProyecto"],
								"etapa"=>$_POST["editarEtapa"],
								"terreno"=>$_POST["editarTerreno"],
								"precio_lista"=>$_POST["editarPrecio"],
								"precio_metro"=>$_POST["editarMetro"],
								"area"=>$_POST["editarArea"]);

				$respuesta = ModeloProyectos::mdlEditarProyecto($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El proyecto ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "proyectos";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El proyecto no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "proyectos";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function ctrBorrarProyecto(){

		if(isset($_GET["idProyecto"])){

			$tabla ="proyectos";
			$datos = $_GET["idProyecto"];

			$respuesta = ModeloProyectos::mdlBorrarProyecto($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "Tu Proyecto ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "proyectos";

									}
								})

					</script>';
			}
		}
		
	}
}
