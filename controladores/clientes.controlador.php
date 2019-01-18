<?php

class ControladorClientes{

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function ctrCrearCliente(){

		if(isset($_POST["dni_cliente"])){

			if(preg_match('/^[0-9]+$/', $_POST["dni_cliente"])){

			   	/*=============================================
				variables para agregar usuarios
				=============================================*/
				

				$tabla = "clientes";
				$existe = ModeloClientes::mdlComprobarCliente($tabla,$_POST["dni_cliente"]);
				$datos = array("nombre" => $_POST["nombre_cliente"],
					           "apellido" => $_POST["apellido_cliente"],
					           "dni" => $_POST["dni_cliente"],
					       	   "celular" => $_POST["celular_cliente"],
					       	   "email" => $_POST["email_cliente"],
					       	   "direccion" => $_POST["direccion_cliente"],
					       	   "distrito" => $_POST["distrito_cliente"],
					       	   "id_proyecto" => $_POST["id_proyecto"],
					       	   "tipo_cambio" => $_POST["tipo_cambio"],
					       	   "medio_captacion"=> $_POST["medio_captacion"],
					       		"nombre_conyuge"=> $_POST["nombre_conyuge"],
					       		"apellido_conyuge"=> $_POST["apellido_conyuge"],
					       		"dni_conyuge"=> $_POST["dni_conyuge"]);
				$tabla_prospeccion = "prospeccion";
				if( is_null($_POST["id_proyecto"]) ){
						echo '<script>

						swal({

							type: "error",
							title: "¡Busque el precio antes de continuar!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"

						}).then(function(result){

							if(result.value){
							
								window.location = "prospeccion";

							}

						});
					

					</script>';

				}
				else{
					if ($existe == 0)
	      			{				
						$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);
						$respuesta_prospeccion = ModeloProspeccion::mdlIngresarProspeccion($tabla_prospeccion, $datos);
					
						if($respuesta == "ok" ){

							echo '<script>

							swal({

								type: "success",
								title: "¡El cliente y Prospeccion correctamente!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"

							}).then(function(result){

								if(result.value){
								
									window.location = "rep-prospeccion";

								}

							});
						

							</script>';


						}
					}
					else
					{
							echo '<script>

								swal({

									type: "success",
									title: "¡El cliente ya esta registrado,se agregó una prospeccion!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"

								}).then(function(result){

									if(result.value){
									
										window.location = "rep-prospeccion";							

									}

								});
							

								</script>';
							$respuesta_prospeccion = ModeloProspeccion::mdlIngresarProspeccion($tabla_prospeccion, $datos);
							
					}

				}

			}else{

				echo '<script>

					swal({

						type: "error",
						title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "prospeccion";

						}

					});
				

				</script>';

			}


		}


	}
	static public function ctrBuscarClientes($item, $valor ,$orden){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlBuscarClientes($tabla, $item, $valor,$orden);

		return $respuesta;
	}
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function ctrMostrarClientes($item, $valor ,$orden){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor,$orden);

		return $respuesta;
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	/*static public function ctrEditarUsuario(){

		if(isset($_POST["editarUsuario"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				/*$ruta = $_POST["fotoActual"];

				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					/*$directorio = "vistas/img/usuarios/".$_POST["editarUsuario"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					/*if(!empty($_POST["fotoActual"])){

						unlink($_POST["fotoActual"]);

					}else{

						mkdir($directorio, 0755);

					}	

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					/*if($_FILES["editarFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						/*$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						/*$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "usuarios";

				if($_POST["editarPassword"] != ""){

					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){

						$encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

					}else{

						echo'<script>

								swal({
									  type: "error",
									  title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result){
										if (result.value) {

										window.location = "usuarios";

										}
									})

						  	</script>';

					}

				}else{

					$encriptar = $_POST["passwordActual"];

				}

				$datos = array("nombre" => $_POST["editarNombre"],
							   "usuario" => $_POST["editarUsuario"],
							   "password" => $encriptar,
							   "perfil" => $_POST["editarPerfil"],
							   "foto" => $ruta);

				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "usuarios";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "usuarios";

							}
						})

			  	</script>';

			}

		}

	}*/

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function ctrBorrarCliente(){

		if(isset($_GET["idUsuario"])){

			$tabla ="clientes";
			$datos = $_GET["idUsuario"];

			$respuesta = ModeloClientes::mdlBorrarCliente($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El cliente ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "clientes";

								}
							})

				</script>';

			}		

		}

	}


}
	


