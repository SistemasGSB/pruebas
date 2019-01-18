<?php

require_once "conexion.php";

class ModeloProforma{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	static public function mdlIngresarProforma($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(dni_cliente,id_proyecto,tipo_cambio,id_simulacion,fecha_inicial,fecha_pago,amortizacion_dos,valor_final_lote,cot_sci_usd,asesor,asesor_telefono) VALUES (:dni_cliente,:id_proyecto,:tipo_cambio,:id_simulacion,:fecha_inicial,:fecha_pago,:amortizacion_dos,:valor_final_lote,:cot_sci_usd,:asesor,:asesor_telefono)");

		$stmt->bindParam(":dni_cliente", $datos["dni"], PDO::PARAM_STR);
		$stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_cambio", $datos["tipo_cambio"], PDO::PARAM_STR);
		$stmt->bindParam(":id_simulacion", $datos["id_simulacion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_inicial", $datos["fecha_inicial"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_pago", $datos["fecha_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":amortizacion_dos", $datos["amortizacion_dos"], PDO::PARAM_STR);
		$stmt->bindParam(":valor_final_lote", $datos["valor_final_lote"], PDO::PARAM_STR);
		$stmt->bindParam(":cot_sci_usd", $datos["cot_sci_usd"], PDO::PARAM_STR);
		$stmt->bindParam(":asesor", $_SESSION["usuario"], PDO::PARAM_STR);
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

	static public function mdlMostrarProforma($tabla, $item, $valor){

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

	static public function mdlBorrarProforma($tabla, $datos){

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
	static public function mdlDatosGrafico(){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(asesor) as rep,asesor,MONTH(fecha_creacion) as mes FROM proforma WHERE YEAR(fecha_creacion)='".date("Y")."' GROUP BY asesor,MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
		$stmt->execute();
		return $stmt->fetchAll();
	}

}

