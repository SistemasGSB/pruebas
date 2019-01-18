<?php
class ControladorProforma{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearProforma(){

		if(isset($_POST["dni_cliente"])){

				/*=============================================
				variables para agregar cotizaciones
				=============================================*/

				$datos = array("dni" => $_POST["dni_cliente"],
					       	     "id_proyecto" => $_POST["id_proyecto"],
                       "tipo_cambio" => $_POST["tipo_cambio"],
                       "id_simulacion" => $_POST["id_simulacion"],
                       "fecha_inicial" => $_POST["fecha_dos"],
                       "fecha_pago" => $_POST["fecha_tres"],
                       "amortizacion_dos" => $_POST["amortizacion_dos"],
                       "valor_final_lote" => $_POST["cot_pv"],
                       "cot_sci_usd" => $_POST["cot_sci_usd"],
                       "asesor" => $_SESSION["usuario"],
                       "asesor_telefono" => $_SESSION["telefono"]);
				$tabla = "proforma";

        if(!isset($_POST['aviso'])){
          echo '<script>

              swal({

                type: "error",
                title: "¡Haga la Busqueda entre Fechas para Continuar!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

              }).then(function(result){

                if(result.value){
                

                }

              });
            

            </script>';
        }
        else{

    				$respuesta = ModeloProforma::mdlIngresarProforma($tabla, $datos);
            $tabla2 = "proyectos";
            $item1 = "estado";
            $valor1 = 2;
            $item2 = "id_proyecto";
            $valor2 = $_POST["id_proyecto"];
            $item3 = "dni_cliente";
            $valor3 = $_POST["dni_cliente"];
            $vender_proyecto = ModeloProyectos::mdlVenderProyectos($tabla2, $item1, $valor1, $item2, $valor2,$item3,$valor3);
            /*$tabla3 = "simulacion";
            $datos3 = array("id"=>$_POST["id_simulacion"]);
            $ocultar_simulacion = ModeloProyectos::mdlOcultarItem($tabla3,$datos3);*/

    				if($respuesta == "ok"){

    					echo'<script>  

    					swal({
    						  type: "success",
    						  title: "La Proforma ha sido guardada correctamente",
    						  showConfirmButton: true,
    						  confirmButtonText: "Cerrar"
    						  }).then(function(result){
    									if (result.value) {

    									window.location = "rep-proforma";

    									}
    								})

    					</script>';

    				}	
          }		

		}

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarProforma($item, $valor){

		$tabla = "proforma";

		$respuesta = ModeloProforma::mdlMostrarProforma($tabla, $item, $valor);

		return $respuesta;
	
	}

  static public function ctrDatosGrafico(){
      $respuesta = ModeloProforma::mdlDatosGrafico();
      return $respuesta;
  }

  /*=============================================
  MOSTRAR TABLA COTIZACION
  =============================================*/

  static public function ctrMostrarProformaTabla($item, $valor){

    $tabla = "proforma";
    $tabla2 = "proyectos";
    $tabla3 = "clientes";

    $respuesta = ModeloProspeccion::mdlMostrarVista($tabla,$tabla2,$tabla3,$item, $valor);

    return $respuesta;
  
  }


	/*=============================================
	MOSTRAR COTIZACION CON URL
	=============================================*/

	static public function ctrMostrarProformaUrl(){

		$item_principal = "id";

		$valor_principal = $_GET["id"];

		$tabla_principal = "simulacion";

		$respuesta_principal = ModeloCotizador::mdlMostrarCotizador($tabla_principal, $item_principal, $valor_principal);

    $item_reserva = "id";

    $valor_reserva = $respuesta_principal["id_reserva"];

    $tabla_reserva = "reserva";

    $respuesta_reserva = ModeloCotizador::mdlMostrarCotizador($tabla_reserva, $item_reserva, $valor_reserva);

    /**TRAEMOS EL VALOR DE AMORTIZACION DE LA COTIZACION EN BASE A LA RESERVA**/
    $item_cotizacion = "id";

    $valor_cotizacion = $respuesta_reserva["id_cotizacion"];

    $tabla_cotizacion = "cotizacion";

    $respuesta_cotizacion = ModeloCotizador::mdlMostrarCotizador($tabla_cotizacion, $item_cotizacion, $valor_cotizacion);

    echo'<div class="form-group col-sm-6" style="display:none;">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" value="'.$respuesta_cotizacion["cot_sci_usd"].'" id="cot_sci_usd" name="cot_sci_usd">
              </div>          
            </div>';
    echo'<div class="form-group col-sm-6" style="display:none;">
              <div class="input-group">
                <input type="text" class="form-control" value="'.$respuesta_principal["sim_cot_pfd"].'" id="sim_cot_pfd" name="sim_cot_pfd">
                <input type="text" class="form-control" value="'.$respuesta_principal["sim_cot_mfd"].'" id="sim_cot_mfd" name="sim_cot_mfd">
                <input type="text" class="form-control" value="'.$respuesta_principal["sim_periocidad"].'" id="sim_periocidad" name="sim_periocidad">
                <input type="text" class="form-control" value="'.$respuesta_principal["sim_cot_tcea"].'" id="sim_cot_tcea" name="sim_cot_tcea">
                <input type="text" class="form-control" value="'.$respuesta_principal["sim_per_gracia"].'" id="sim_per_gracia" name="sim_per_gracia">
              </div>          
            </div>';
    /**FIN*/        

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
    echo'<div class="form-group col-sm-6" style="display:none;">
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" value="'.$valor_principal.'" name="id_simulacion">
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
		$valor_final_lote = $respuesta_principal["sim_total_interes"] + $respuesta_principal["sim_cot_mfd"] + $respuesta_principal["sim_cot_tci_usd"] ;
    $amortizacion_dos = $respuesta_cotizacion["cot_cis_usd"]-$respuesta_reserva["res_sep"];


		$tabla2 = "proyectos";

		$respuesta2 = ModeloProyectos::mdlMostrarProyectos($tabla2, $item2, $valor2);
		if ($respuesta2["estado"] == 1 && $respuesta2["dni_cliente"] = $valor_principal)
    {
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

            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">Lote</span> 
                <input type="text" class="form-control" id="cot_lote" value="'.$respuesta2["terreno"].'" readonly name="cot_lote" placeholder="Lote" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">m<sub>2</sub></span> 
                <input type="text" class="form-control" id="cot_metraje" value="'.$respuesta2["area"].'" readonly name="cot_metraje" placeholder="Metraje" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">Precio Contado</span> 
                <input type="text" class="form-control" id="proforma_pc" value="'.$respuesta2["precio_lista"].'" readonly name="proforma_pc" placeholder="Precio Contado" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">Cuota Inicial</span> 
                <input type="text" class="form-control" id="cot_pv" value="'.$respuesta_principal["sim_cot_tci_usd"].'" readonly name="cot_pv" placeholder="Cuota Inicial" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">Saldo a Financiar</span> 
                <input type="text" class="form-control" id="cot_pl" value="'.$respuesta_principal["sim_cot_mfd"].'" readonly name="cot_pl" placeholder="Precio Contado" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">Intereses</span> 
                <input type="text" class="form-control" id="cot_pvi" value="'.$respuesta_principal["sim_total_interes"].'" readonly name="cot_pv" placeholder="Cuota Inicial" required>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="input-group">              
                <span class="input-group-addon">Valor Final del Lote</span> 
                <input type="text" class="form-control" id="cot_pv" value="'.$valor_final_lote.'" readonly name="cot_pv" placeholder="Cuota Inicial" required>
              </div>
            </div>
            <div class="form-group col-sm-6">               
              <center><h4>* Calculos realizados en base a año de 360 dias</h4></center>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">Fecha Deposito</span> 
                <input type="text" class="form-control pull-right" disabled value="'.$respuesta_reserva["fecha_deposito"].'" id="fecha_uno" name="fecha_uno">
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">Amortizacion</span> 
                <input type="text" class="form-control pull-right" readonly value="'.$respuesta_reserva["res_sep"].'" id="amortizacion_uno" name="amortizacion_uno">
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">Fecha Inicial</span> 
                <input type="text" autocomplete="off" class="form-control pull-right" id="fecha_dos" name="fecha_dos">
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">Fecha Pago</span> 
                <input type="text" autocomplete="off" class="form-control pull-right" id="fecha_tres" name="fecha_tres">
              </div>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group">              
                <span class="input-group-addon">Amortizacion</span> 
                <input type="text" class="form-control pull-right" readonly value="'.$amortizacion_dos.'" id="amortizacion_dos" name="amortizacion_dos">
              </div>
            </div>
            <div class="form-group col-sm-2">
              <div class="input-group">             
                <button id="btn_proforma" class="btn btn-primary"><i class="fa fa-fw fa-search"></i></button>
            </div>            
            </div>
            <div id="tabla_precio_proforma" class="form-group col-sm-12">            
            </div>';
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

                  window.location = "rep-simulador";

                  }
                  else
                  {
                    window.location = "rep-simulador";
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

                  window.location = "rep-simulador";

                  }
                  else
                  {
                    window.location = "rep-simulador";
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

	static public function ctrBorrarProforma(){

		if(isset($_GET["idProforma"])){

			$tabla ="proforma";
			$datos = $_GET["idProforma"];

			$respuesta = ModeloProforma::mdlBorrarProforma($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "Tu Proforma ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "rep-proforma";

									}
								})

					</script>';
			}
		}
		
	}
}
