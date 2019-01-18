<?php

class ControladorSimulador{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearSimulacion(){

		if(isset($_POST["dni_cliente"])){

				/*=============================================
				variables para agregar cotizaciones
				=============================================*/

				$datos = array("dni" => $_POST["dni_cliente"],
                       "id_reserva" => $_POST["id_reserva"],
                       "sim_cot_pfd" => $_POST["sim_cot_pfd"],
                       "sim_periocidad" => $_POST["sim_periocidad"],
                       "sim_cot_tcea" => $_POST["sim_cot_tcea"],
                       "sim_per_gracia" => $_POST["sim_per_gracia"],
                       "sim_cot_tasa" => $_POST["sim_cot_tasa"],
                       "sim_cot_tci_usd" => $_POST["sim_cot_tci_usd"],
                       "sim_cot_mfd" => $_POST["sim_cot_mfd"],
                       "sim_total_interes" => $_POST["sim_total_interes"],
                       "tipo_cambio" => $_POST["tipo_cambio"],
					       	     "id_proyecto" => $_POST["id_proyecto"]);

				$tabla = "simulacion";

				$respuesta = ModeloSimulador::mdlIngresarSimulador($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>  

					swal({
						  type: "success",
						  title: "La simulacion ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "rep-simulador";

									}
								})

					</script>';

				}			

		}

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarSimulador($item, $valor){

		$tabla = "Simulacion";

		$respuesta = ModeloSimulador::mdlMostrarSimulador($tabla, $item, $valor);

		return $respuesta;
	
	}

  /*=============================================
  MOSTRAR TABLA COTIZACION
  =============================================*/

  static public function ctrMostrarSimuladorTabla($item, $valor){

    $tabla = "simulacion";
    $tabla2 = "proyectos";
    $tabla3 = "clientes";

    $respuesta = ModeloProspeccion::mdlMostrarVista($tabla,$tabla2,$tabla3,$item, $valor);

    return $respuesta;
  
  }


	/*=============================================
	MOSTRAR COTIZACION CON URL
	=============================================*/

	static public function ctrMostrarSimuladorUrl(){

    $item_reserva = "id";

    $valor_reserva = $_GET["id"];

    $tabla_reserva = "reserva";

    $respuesta_reserva = ModeloCotizador::mdlMostrarCotizador($tabla_reserva, $item_reserva, $valor_reserva);

    $item_principal = "id";

    $valor_principal = $respuesta_reserva["id_cotizacion"];

    $tabla_principal = "cotizacion";

    $respuesta_principal = ModeloCotizador::mdlMostrarCotizador($tabla_principal, $item_principal, $valor_principal);

		$item = "dni";

		$valor = $respuesta_principal["dni_cliente"];

		$tabla = "clientes";

		$respuesta = ModeloSimulador::mdlMostrarSimulador($tabla, $item, $valor);    
		
        $item2 = "id_proyecto";

		$valor2 = $respuesta_principal["id_proyecto"];

		$tabla2 = "proyectos";

		$respuesta2 = ModeloProyectos::mdlMostrarProyectos($tabla2, $item2, $valor2);
    if ($respuesta2["estado"] == 1 && $respuesta2["dni_cliente"] =  $respuesta_reserva["dni_cliente"])
    {
      echo'<div class="form-group col-sm-6" style="display:none;">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" value="'.$respuesta["dni"].'" name="dni_cliente">
                <input type="text" class="form-control" value="'.$respuesta_reserva["id"].'" name="id_reserva">
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
            <div class="form-group col-sm-4">
              <div class="input-group">              
                <span class="input-group-addon">Proyecto</span> 
                <input type="text" class="form-control" value="'.$respuesta2["proyecto"].'" readonly >
              </div>
            </div>
            <div class="form-group col-sm-2">
              <div class="input-group">              
                <span class="input-group-addon">Lote</span> 
                <input type="text" class="form-control" value="'.$respuesta2["terreno"].'" readonly>
              </div>
            </div>
            <div class="form-group col-sm-2">
              <div class="input-group">              
                <span class="input-group-addon">Etapa</span> 
                <input type="text" class="form-control" value="'.$respuesta2["etapa"].'" readonly>
              </div>
            </div>
            <div class="form-group col-sm-2">
              <div class="input-group">              
                <span class="input-group-addon">m<sub>2</sub></span> 
                <input type="text" class="form-control" value="'.$respuesta2["area"].'" readonly>
              </div>
            </div>            
            <div class="form-group col-sm-2">
              <div class="input-group">              
                <span class="input-group-addon">PL</span> 
                <input type="text" class="form-control" value="'.$respuesta2["precio_lista"].'" readonly>
              </div>
            </div>';

        echo '<!-- Datos del lote -->
            <div class="form-group col-sm-12">
              <center><h3>Datos a Simular</h3></center>
            </div>

            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">IMPORTE DEL CREDITO</span> 
                <input type="text" class="form-control" id="sim_importe" value="'.$respuesta2["precio_lista"].'" readonly name="sim_importe" placeholder="Importe del Credito" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">CUOTA INICIAL</span> 
                <input type="text" class="form-control" id="sim_cot_tci_usd" value="'.$respuesta_principal["cot_tci_usd"].'" readonly name="sim_cot_tci_usd" placeholder="Cuota Inicial" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">MONTO A FINANCIAR $</span> 
                <input type="text" class="form-control" id="sim_cot_mfd" value="'.$respuesta_principal["cot_mfd"].'" readonly name="sim_cot_mfd" placeholder="Monto a Financiar" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">NUM. CUOTAS</span> 
                <input type="text" class="form-control" id="sim_cot_pfd" value="'.$respuesta_principal["cot_pfd"].'" readonly name="sim_cot_pfd" placeholder="Cuotas" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">PERIOCIDAD</span> 
                <input type="text" class="form-control" autocomplete="off" id="sim_periocidad" name="sim_periocidad" placeholder="Periocidad" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">PERIODO DE GRACIA</span> 
                <input type="text" class="form-control" autocomplete="off" id="sim_per_gracia" name="sim_per_gracia" value="0" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">TCEA (%)</span> 
                <input type="text" class="form-control" autocomplete="off" id="sim_cot_tcea" name="sim_cot_tcea" placeholder="TCEA" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">TASA (%)</span> 
                <input type="text" class="form-control" id="sim_cot_tasa" readonly name="sim_cot_tasa" placeholder="TASA">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">             
                <button id="btn_simulacion" class="btn btn-primary"><i class="fa fa-fw fa-search"></i></button>
              </div>
            </div>
            <div id="tabla_precio_simulacion" class="form-group col-sm-12">
            </div>';
        echo'</div>';
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

                  window.location = "rep-reserva";

                  }
                  else
                  {
                    window.location = "rep-reserva";
                  }                  
                })            
          </script>';
    }
    else
    {
      echo'<script>          
          swal({
              type: "error",
              title: "El terreno esta reservado por otra persona",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                  if (result.value) {

                  window.location = "rep-reserva";

                  }
                  else
                  {
                    window.location = "rep-reserva";
                  }                  
                })            
          </script>'; 
    }          
	
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

	static public function ctrBorrarSimulacion(){

		if(isset($_GET["idSimulacion"])){

			$tabla ="simulacion";
			$datos = $_GET["idSimulacion"];

			$respuesta = ModeloSimulador::mdlBorrarSimulacion($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "Tu Simulacion ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "rep-simulador";

									}
								})

					</script>';
			}
      
		}
		
	}
}
