<?php

require_once "conexion.php";

class ModeloProspeccion{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	static public function mdlIngresarProspeccion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(dni_cliente,id_proyecto,tipo_cambio,asesor) VALUES (:dni_cliente,:id_proyecto,:tipo_cambio,:asesor)");

		$stmt->bindParam(":dni_cliente", $datos["dni"], PDO::PARAM_STR);
		$stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_cambio", $datos["tipo_cambio"], PDO::PARAM_STR);
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

	static public function mdlMostrarProspeccion($tabla, $item, $valor){

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
	MOSTRAR CATEGORIAS
	=============================================*/
	static public function mdlEditPros($valor){
		$stmt = Conexion::conectar()->prepare("SELECT prospeccion.tipo_cambio as 'tipo_cambio',prospeccion.dni_cliente as 'dni_cliente',proyectos.proyecto as 'proyecto', proyectos.etapa as 'etapa_proyecto', proyectos.terreno as 'lotes_proyecto' FROM prospeccion INNER JOIN proyectos ON prospeccion.id_proyecto=proyectos.id_proyecto WHERE prospeccion.id=".$valor);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}


	static public function mdlMostrarVista($tabla, $tabla2, $tabla3, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla, $tabla2, $tabla3 WHERE $tabla2.id_proyecto = $tabla.id_proyecto AND $tabla3.dni = $tabla.dni_cliente AND $tabla.asesor = :$item ORDER BY $tabla.id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla, $tabla2, $tabla3 WHERE $tabla2.id_proyecto = $tabla.id_proyecto AND $tabla3.dni = $tabla.dni_cliente ORDER BY $tabla.id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function mdlEditarProspeccion($tabla, $datos){

		$proyecto = $datos['proyecto'];
		$etapa = $datos['etapa'];
		$terreno = $datos['lote'];
		$stmtb = Conexion::conectar()->prepare("SELECT * FROM proyectos WHERE proyecto = '$proyecto' AND etapa ='$etapa' AND terreno ='$terreno' ");
		$stmtb -> execute();

		$row = $stmtb->fetch(); 


		echo json_encode($row);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_proyecto = :proyecto WHERE id = :id_pros");

		$stmt -> bindParam(":proyecto", $row["id_proyecto"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_pros", $datos["id"], PDO::PARAM_STR);

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

	static public function mdlBorrarProspeccion($tabla, $datos){

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

