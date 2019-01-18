<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";



class TablaClientes{

 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

	public function mostrarTablaClientes(){

		$item = null;
    	$valor = null;
    	$orden = "id_cliente";

  		$clientes = ControladorClientes::ctrMostrarClientes($item, $valor, $orden);	
		
  		if(count($clientes) == 0){

  			echo '{"data": []}';

		  	return;
  		}
		
  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($clientes); $i++){

		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 

  			if(isset($_SESSION["perfil"]) && $_SESSION["perfil"] == "Administrador"){

  				$botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='A' data-toggle='modal' data-target='#modalEditarProducto'>LOL</button></div>"; 

  			}else{

  				 $botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='B' data-toggle='modal' data-target='#modalEditarProducto'>COTI</div>"; 

  			}

		 
		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$clientes[$i]["nombre"].'",
			      "'.$clientes[$i]["apellido"].'",
			      "'.$clientes[$i]["dni"].'",
			      "'.$clientes[$i]["celular"].'",
			      "'.$clientes[$i]["email"].'",
			      "'.$clientes[$i]["direccion"].'",
			      "'.$clientes[$i]["distrito"].'",
			      "'.$botones.'"
			    ],';

		  }

		  $datosJson = substr($datosJson, 0, -1);

		 $datosJson .=   '] 

		 }';
		
		echo $datosJson;


	}


}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarClientes = new TablaClientes();
$activarClientes -> mostrarTablaClientes();

