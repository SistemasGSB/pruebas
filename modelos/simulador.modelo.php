<?php

require_once "conexion.php";

class ModeloSimulador{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	static public function mdlIngresarSimulador($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(dni_cliente,id_proyecto,tipo_cambio,id_reserva,sim_cot_pfd,sim_periocidad,sim_cot_tcea,sim_per_gracia,sim_cot_tasa,sim_cot_tci_usd,sim_cot_mfd,sim_total_interes,asesor) VALUES (:dni_cliente,:id_proyecto,:tipo_cambio,:id_reserva,:sim_cot_pfd,:sim_periocidad,:sim_cot_tcea,:sim_per_gracia,:sim_cot_tasa,:sim_cot_tci_usd,:sim_cot_mfd,:sim_total_interes,:asesor)");

		$stmt->bindParam(":dni_cliente", $datos["dni"], PDO::PARAM_STR);
		$stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_cambio", $datos["tipo_cambio"], PDO::PARAM_STR);
		$stmt->bindParam(":id_reserva", $datos["id_reserva"], PDO::PARAM_STR);
		$stmt->bindParam(":sim_cot_pfd", $datos["sim_cot_pfd"], PDO::PARAM_STR);
		$stmt->bindParam(":sim_periocidad", $datos["sim_periocidad"], PDO::PARAM_STR);
		$stmt->bindParam(":sim_cot_tcea", $datos["sim_cot_tcea"], PDO::PARAM_STR);
		$stmt->bindParam(":sim_per_gracia", $datos["sim_per_gracia"], PDO::PARAM_STR);
		$stmt->bindParam(":sim_cot_tasa", $datos["sim_cot_tasa"], PDO::PARAM_STR);
		$stmt->bindParam(":sim_cot_tci_usd", $datos["sim_cot_tci_usd"], PDO::PARAM_STR);
		$stmt->bindParam(":sim_cot_mfd", $datos["sim_cot_mfd"], PDO::PARAM_STR);
		$stmt->bindParam(":sim_total_interes", $datos["sim_total_interes"], PDO::PARAM_STR);
		$stmt->bindParam(":asesor", $_SESSION["usuario"], PDO::PARAM_STR);


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

	static public function mdlMostrarSimulador($tabla, $item, $valor){

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

	static public function mdlEditarProyecto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET proyecto = :proyecto WHERE id_proyecto = :id_proyecto");

		$stmt -> bindParam(":proyecto", $datos["proyecto"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_INT);

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

	static public function mdlBorrarSimulacion($tabla, $datos){

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

