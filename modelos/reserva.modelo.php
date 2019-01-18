<?php

require_once "conexion.php";

class ModeloReserva{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	static public function mdlIngresarReserva($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(dni_cliente,id_proyecto,tipo_cambio,id_cotizacion,res_sep,fecha_deposito,res_operacion,asesor,asesor_nombre,asesor_telefono) VALUES (:dni_cliente,:id_proyecto,:tipo_cambio,:id_cotizacion,:res_sep,:fecha_deposito,:res_operacion,:asesor,:asesor_nombre,:asesor_telefono)");

		$stmt->bindParam(":dni_cliente", $datos["dni"], PDO::PARAM_STR);
		$stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_cambio", $datos["tipo_cambio"], PDO::PARAM_STR);
		$stmt->bindParam(":id_cotizacion",$datos["id_cotizacion"],PDO::PARAM_STR);
		$stmt->bindParam(":res_sep", $datos["res_sep"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_deposito", $datos["fecha_deposito"], PDO::PARAM_STR);
		$stmt->bindParam(":res_operacion", $datos["res_operacion"], PDO::PARAM_STR);
		$stmt->bindParam(":asesor", $_SESSION["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":asesor_nombre", $_SESSION["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":asesor_telefono", $datos["asesor_telefono"], PDO::PARAM_STR);



		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function mdlMostrarReserva($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function mdlReservarProyecto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 1 , dni_cliente = :dni_cliente , vendedor=:vendedor WHERE id_proyecto = :id_proyecto");

		$stmt -> bindParam(":dni_cliente", $datos["dni"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_INT);
		$stmt -> bindParam(":vendedor", $_SESSION["usuario"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function mdlBorrarReserva($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

}

