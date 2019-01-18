<?php

class ControladorCotizador{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearCotizador(){

		if(isset($_POST["dni_cliente"])){

				/*=============================================
				variables para agregar cotizaciones
				=============================================*/

				$datos = array("dni" => $_POST["dni_cliente"],
                       "cot_sep_usd" => $_POST["cot_sep_usd"],
                       "cot_cis_usd" => $_POST["cot_cis_usd"],
                       "cot_sci_usd" => $_POST["cot_sci_usd"],
                       "cot_tci" => $_POST["cot_tci"],
                       "cot_pfd" => $_POST["cot_pfd"],
                       "cot_mfd" => $_POST["cot_mfd"],
                       "cot_tci_usd" => $_POST["cot_tci_usd"],
					       	     "id_proyecto" => $_POST["id_proyecto"],
                       "tipo_cambio" => $_POST["tipo_cambio"],
                       "asesor" => $_SESSION["usuario"],
                       "asesor_nombre" => $_SESSION["nombre"],
                       "asesor_telefono" => $_SESSION["telefono"]);

				$tabla = "cotizacion";

				$respuesta = ModeloCotizador::mdlIngresarCotizador($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>  

					swal({
						  type: "success",
						  title: "La cotizacion ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "rep-cotizador";

									}
								})

					</script>';

				}			

		}

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarCotizador($item, $valor){

		$tabla = "cotizacion";

		$respuesta = ModeloCotizador::mdlMostrarCotizador($tabla, $item, $valor);

		return $respuesta;
	
	}


  /*=============================================
  MOSTRAR TABLA COTIZACION
  =============================================*/

  static public function ctrMostrarCotizadorTabla($item, $valor){

    $tabla = "cotizacion";
    $tabla2 = "proyectos";
    $tabla3 = "clientes";

    $respuesta = ModeloProspeccion::mdlMostrarVista($tabla,$tabla2,$tabla3,$item, $valor);

    return $respuesta;
  
  }


	/*=============================================
	MOSTRAR COTIZACION CON URL
	=============================================*/

	static public function ctrMostrarCotizadorUrl(){

		$item_principal = "id";

		$valor_principal = $_GET["id"];

		$tabla_principal = "prospeccion";

		$respuesta_principal = ModeloCotizador::mdlMostrarCotizador($tabla_principal, $item_principal, $valor_principal);

		$item = "dni";

		$valor = $respuesta_principal["dni_cliente"];

		$tabla = "clientes";

		$respuesta = ModeloCotizador::mdlMostrarCotizador($tabla, $item, $valor);

		echo'<div class="form-group col-sm-6" style="display:none;">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" value="'.$respuesta["dni"].'" name="dni_cliente">
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

                  window.location = "rep-prospeccion";

                  }
                  else
                  {
                    window.location = "rep-prospeccion";
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

                  window.location = "rep-prospeccion";

                  }
                  else
                  {
                    window.location = "rep-prospeccion";
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
            <div class="form-group col-sm-3">
            	<center><label>Separacion</label></center>   
              <div class="input-group">              	                         
                <span class="input-group-addon">%</span> 
                <input type="text" class="form-control" id="cot_sep" name="cot_sep" value="0" readonly placeholder="Separacion" required>
              </div>
            </div>
            <div class="form-group col-sm-3">
            	<center><label>Cuota Inicial Separacion</label></center>
              <div class="input-group">              
                <span class="input-group-addon">%</span> 
                <input type="text" class="form-control" id="cot_cis" name="cot_cis" value="0" readonly placeholder="Cuota Inicial Separacion" required>
              </div>
            </div>
            <div class="form-group col-sm-3">
            	<center><label>Saldo Cuota Inicial</label></center>   
              <div class="input-group">              
                <span class="input-group-addon">%</span> 
                <input type="text" class="form-control" id="cot_sci" name="cot_sci" value="0" readonly placeholder="Saldo Cuota Inicial" required>
              </div>
            </div>
            <div class="form-group col-sm-3">
            	<center><label>Total de Cuota Inicial</label></center>   
              <div class="input-group">              
                <span class="input-group-addon">%</span> 
                <input type="text" class="form-control" autocomplete="off" id="cot_tci" name="cot_tci" value="0" maxlength="2" placeholder="Total de Cuota Inicial" required>
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">US$</span> 
                <input type="text" autocomplete="off" class="form-control" id="cot_sep_usd" name="cot_sep_usd" maxlength="5" placeholder="0.00" required>
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">US$</span> 
                <input type="text" class="form-control" autocomplete="off" id="cot_cis_usd" name="cot_cis_usd" placeholder="0.00" maxlength="4" required>
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">US$</span> 
                <input type="text" autocomplete="off" class="form-control" id="cot_sci_usd" name="cot_sci_usd" readonly placeholder="0.00" >
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">US$</span> 
                <input type="text" autocomplete="off" class="form-control" id="cot_tci_usd" name="cot_tci_usd" readonly placeholder="Total de Cuota Inicial">
              </div>
            </div>
            <div class="form-group col-sm-12">
              <center><h3>Adicionales</h3></center>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">MFD</span> 
                <input type="text" class="form-control" id="cot_mfd" name="cot_mfd" readonly placeholder="Monto Financiamiento Directo">
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">PFD</span> 
                <input type="text" autocomplete="off" class="form-control" id="cot_pfd" maxlength="2" name="cot_pfd" placeholder="Plazo  Financiamiento Directo" required>
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">Cuotas</span> 
                <input type="text" class="form-control" id="cot_cuota" name="cot_cuota" readonly placeholder="Cuotas" >
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">Cuot M(Aprox)</span> 
                <input type="text" class="form-control" id="cot_cuotam" name="cot_cuotam" readonly placeholder="Cuota Mensual">
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

	static public function ctrBorrarCotizacion(){

		if(isset($_GET["idCotizacion"])){

			$tabla ="cotizacion";
			$datos = $_GET["idCotizacion"];

			$respuesta = ModeloCotizador::mdlBorrarCotizacion($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "Tu Cotizacion ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "rep-cotizador";

									}
								})

					</script>';
			}
		}
		
	}
}
