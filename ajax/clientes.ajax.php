<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

class AjaxClientes{

	/*=============================================
	EDITAR CLIENTE
	=============================================*/	


	public function ajaxEditarCliente($valor){

		$item = "dni";
    	$orden = "id_cliente";

		$clientes = ControladorClientes::ctrBuscarClientes($item, $valor, $orden);

		echo json_encode($clientes);


	}

}

/*=============================================
EDITAR CLIENTE
=============================================*/	

$dni_cliente = $_POST["dni_cliente"];
if(isset($dni_cliente))
{
$cliente = new AjaxClientes();
$cliente -> ajaxEditarCliente($dni_cliente);
}



