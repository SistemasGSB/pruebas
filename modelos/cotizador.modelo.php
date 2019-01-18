<?php

require_once "conexion.php";

class ModeloCotizador{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	static public function mdlIngresarCotizador($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(dni_cliente,id_proyecto,tipo_cambio,cot_sep_usd,cot_cis_usd,cot_sci_usd,cot_tci,cot_pfd,cot_mfd,cot_tci_usd,asesor,asesor_nombre,telefono_asesor) VALUES (:dni_cliente,:id_proyecto,:tipo_cambio,:cot_sep_usd,:cot_cis_usd,:cot_sci_usd,:cot_tci,:cot_pfd,:cot_mfd,:cot_tci_usd,:asesor,:asesor_nombre,:asesor_telefono)");

		$stmt->bindParam(":dni_cliente", $datos["dni"], PDO::PARAM_STR);
		$stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_cambio", $datos["tipo_cambio"], PDO::PARAM_STR);
		$stmt->bindParam(":cot_sep_usd", $datos["cot_sep_usd"], PDO::PARAM_STR);
		$stmt->bindParam(":cot_cis_usd", $datos["cot_cis_usd"], PDO::PARAM_STR);
		$stmt->bindParam(":cot_sci_usd", $datos["cot_sci_usd"], PDO::PARAM_STR);
		$stmt->bindParam(":cot_tci", $datos["cot_tci"], PDO::PARAM_STR);
		$stmt->bindParam(":cot_pfd", $datos["cot_pfd"], PDO::PARAM_STR);
		$stmt->bindParam(":cot_mfd", $datos["cot_mfd"], PDO::PARAM_STR);
		$stmt->bindParam(":cot_tci_usd", $datos["cot_tci_usd"], PDO::PARAM_STR);
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
	MOSTRAR DATOS
	=============================================*/

	static public function mdlDatosCotizador($tabla, $item, $valor , $item2 , $valor2){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item2 = :$item2");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function mdlMostrarCotizador($tabla, $item, $valor){

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

	static public function mdlBorrarCotizacion($tabla, $datos){

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

