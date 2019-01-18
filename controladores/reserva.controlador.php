<?php

class ControladorReserva{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearReserva(){

		if(isset($_POST["dni_cliente"])){

				/*=============================================
				variables para agregar cotizaciones
				=============================================*/

				$datos = array("dni" => $_POST["dni_cliente"],
                       "res_sep" => $_POST["res_sep"],
                       "fecha_deposito" => $_POST["fecha_deposito"],
                       "res_operacion" => $_POST["res_operacion"],
                       "id_cotizacion" => $_POST["id_cotizacion"],
					    "id_proyecto" => $_POST["id_proyecto"],
					    "tipo_cambio" => $_POST["tipo_cambio"],
						"asesor" => $_SESSION["usuario"],
						"asesor_nombre" =>$_SESSION["nombre"],
                       "asesor_telefono" => $_SESSION["telefono"]);

				$tabla = "reserva";

				$respuesta = ModeloReserva::mdlIngresarReserva($tabla, $datos);

				$tabla2 = "proyectos";

				$respuesta2 = ModeloReserva::mdlReservarProyecto($tabla2, $datos);

				if($respuesta == "ok"){

					echo'<script>  

					swal({
						  type: "success",
						  title: "La reserva ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "rep-reserva";

									}
								})

					</script>';

				}			

		}

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarReserva($item, $valor){

		$tabla = "reserva";

		$respuesta = ModeloReserva::mdlMostrarReserva($tabla, $item, $valor);

		return $respuesta;
	
	}

  /*=============================================
  MOSTRAR TABLA COTIZACION
  =============================================*/

  static public function ctrMostrarReservaTabla($item, $valor){

    $tabla = "reserva";
    $tabla2 = "proyectos";
    $tabla3 = "clientes";

    $respuesta = ModeloProspeccion::mdlMostrarVista($tabla,$tabla2,$tabla3,$item, $valor);

    return $respuesta;
  
  }


	/*=============================================
	MOSTRAR COTIZACION CON URL
	=============================================*/

	static public function ctrMostrarReservaUrl(){

		$item_principal = "id";

		$valor_principal = $_GET["id"];

		$tabla_principal = "cotizacion";

		$respuesta_principal = ModeloCotizador::mdlMostrarCotizador($tabla_principal, $item_principal, $valor_principal);

		$item = "dni";

		$valor = $respuesta_principal["dni_cliente"];

		$tabla = "clientes";

		$respuesta = ModeloCotizador::mdlMostrarCotizador($tabla, $item, $valor);

		echo'<div class="form-group col-sm-6" style="display:none;">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" value="'.$respuesta["dni"].'" name="dni_cliente">
                <input type="text" class="form-control" value="'.$respuesta_principal["id"].'" name="id_cotizacion">
              </div>          
            </div>';

		echo'<div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" value="'.$respuesta["nombre"].'" readonly id="nombre_cliente" name="nombre_cliente" placeholder="Nombre del Cliente" required>
              </div>          
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="text" class="form-control" value="'.$respuesta["apellido"].'" readonly id="apellido_cliente" name="apellido_cliente" placeholder="Apellido del Cliente" required>
              </div>
            </div>';
        $item2 = "id_proyecto";

		$valor2 = $respuesta_principal["id_proyecto"];

		$tabla2 = "proyectos";

		$respuesta2 = ModeloProyectos::mdlMostrarProyectos($tabla2, $item2, $valor2);
    if ($respuesta2["estado"] == 1)
    {
      echo'<script>          
          swal({
              type: "error",
              title: "El terreno esta reservado",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                  if (result.value) {

                  window.location = "rep-cotizador";

                  }
                  else
                  {
                    window.location = "rep-cotizador";
                  }                  
                })            
          </script>';
    }
    else if ($respuesta2["estado"] == 2)
    {
      echo'<script>          
          swal({
              type: "error",
              title: "El terreno esta vendido",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                  if (result.value) {

                  window.location = "rep-cotizador";

                  }
                  else
                  {
                    window.location = "rep-cotizador";
                  }                  
                })            
          </script>';
    }
		echo'<div class="form-group col-sm-6" style="display:none;">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" value="'.$respuesta2["id_proyecto"].'" name="id_proyecto">
              </div>          
            </div>';

        echo '<!-- Datos del lote -->
            <div class="form-group col-sm-12">
              <center><h3>Datos de Terreno</h3></center>
            </div>

            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">Lt</span> 
                <input type="text" class="form-control" id="cot_lote" value="'.$respuesta2["terreno"].'" readonly name="cot_lote" placeholder="Lote" required>
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">m<sub>2</sub></span> 
                <input type="text" class="form-control" id="cot_metraje" value="'.$respuesta2["area"].'" readonly name="cot_metraje" placeholder="Metraje" required>
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">PL</span> 
                <input type="text" class="form-control" id="cot_pl" value="'.$respuesta2["precio_lista"].'" readonly name="cot_pl" placeholder="Precio Lista" required>
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">PV</span> 
                <input type="text" class="form-control" id="cot_pv" value="'.$respuesta2["precio_lista"].'" readonly name="cot_pv" placeholder="Precio Venta" required>
              </div>
            </div>
            <div class="form-group col-sm-4">
            	<center><label>Separacion</label></center>   
              <div class="input-group">              	                         
                <span class="input-group-addon"><i class="fa fa-dollar"></i></span> 
                <input type="text" class="form-control" id="res_sep" value="'.$respuesta_principal["cot_sep_usd"].'" readonly name="res_sep" placeholder="Separacion" required>
              </div>
            </div>
            <div class="form-group col-sm-4">
            	<center><label>Fecha Operacion</label></center>
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                <input type="text" class="form-control" autocomplete="off" id="fecha_deposito" name="fecha_deposito" required>
              </div>
            </div>
            <div class="form-group col-sm-4">
            	<center><label>N° Operacion</label></center>   
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span> 
                <input type="text" autocomplete="off" class="form-control" id="res_operacion" name="res_operacion" value="0" maxlength="10" placeholder="N° Operacion" required>
              </div>
            </div>';
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarProyecto(){

		if(isset($_POST["editarProyecto"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarProyecto"])){

				$tabla = "proyectos";

				$datos = array("proyecto"=>$_POST["editarProyecto"],
							   "id_proyecto"=>$_POST["idProyecto"]);

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

	static public function ctrBorrarReserva(){

		if(isset($_GET["idReserva"])){

			$tabla ="reserva";
			$datos = $_GET["idReserva"];

			$respuesta = ModeloReserva::mdlBorrarReserva($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "Tu Reserva ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "rep-reserva";

									}
								})

					</script>';
			}
		}
		
	}
}
