<?php

require_once "conexion.php";

class ModeloProyectos{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	static public function mdlIngresarProyecto($tabla, $datos){

		$stmtb = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE proyecto = :proyecto AND etapa=:etapa AND terreno = :terreno");
		$stmtb->bindParam(":proyecto", $datos["proyecto"], PDO::PARAM_STR);
		$stmtb->bindParam(":etapa", $datos["etapa"], PDO::PARAM_STR);
		$stmtb->bindParam(":terreno", $datos["terreno"], PDO::PARAM_STR);
		
		$stmtb->execute();
		$row=$stmtb->fetch();
		echo $row;
		if($stmtb->rowCount() > 0){
			return "exi";
		}
		else{
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(proyecto,etapa,terreno,precio_lista,precio_metro,area,estado,fecha_separacion,dni_cliente,vendedor) VALUES (:proyecto,:etapa,:terreno,:precio_lista,:precio_metro,:area,0,'0000-00-00 00:00:00',0,'h')");

			$stmt->bindParam(":proyecto", $datos["proyecto"], PDO::PARAM_STR);
			$stmt->bindParam(":etapa", $datos["etapa"], PDO::PARAM_STR);
			$stmt->bindParam(":terreno", $datos["terreno"], PDO::PARAM_STR);
			$stmt->bindParam(":precio_lista", $datos["precio_lista"], PDO::PARAM_STR);
			$stmt->bindParam(":precio_metro", $datos["precioM"], PDO::PARAM_STR);
			$stmt->bindParam(":area", $datos["area"], PDO::PARAM_STR);

			if($stmt->execute()){

				return "ok";

			}else{

				return "error";
			
			}

			$stmt->close();
			$stmt = null;
	
		}
		
	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function mdlMostrarProyectos($tabla, $item, $valor){

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
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarProyectos($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 , dni_cliente = 0 , vendedor=null ,fecha_separacion = '0000-00-00 00:00:00' WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	VENDER TERRENO
	=============================================*/

	static public function mdlVenderProyectos($tabla, $item1, $valor1, $item2, $valor2 ,$item3,$valor3){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 , $item3 = :$item3 , vendedor=:vendedor WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item3, $valor3, PDO::PARAM_STR);
		$stmt -> bindParam(":vendedor", $_SESSION["usuario"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	OCULTAR ITEM
	=============================================*/

	static public function mdlOcultarItem($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET oculto = 1 WHERE id = :id");

		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_STR);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function mdlEditarProyecto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET proyecto = :proyecto, etapa = :etapa, terreno = :terreno, precio_lista = :precio_lista, precio_metro = :precio_metro, area = :area WHERE id_proyecto = :id_proyecto");

		$stmt -> bindParam(":proyecto", $datos["proyecto"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_INT);
		$stmt -> bindParam(":etapa", $datos["etapa"], PDO::PARAM_STR);
		$stmt -> bindParam(":terreno", $datos["terreno"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio_lista", $datos["precio_lista"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio_metro", $datos["precio_metro"], PDO::PARAM_STR);

		$stmt -> bindParam(":area", $datos["area"], PDO::PARAM_STR);

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

	static public function mdlBorrarProyecto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_proyecto = :id_proyecto");

		$stmt -> bindParam(":id_proyecto", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}


	static public function mdlCategoriaP($columna){
		$stmt = Conexion::conectar()->prepare("SELECT DISTINCT ".$columna." FROM proyectos");
		$stmt -> execute();

		return $stmt -> fetchAll();

	}



}

