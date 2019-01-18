<?php

require_once "conexion.php";

class ModeloClientes{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function mdlBuscarClientes($tabla, $item, $valor ,$orden){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id_cliente DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			
			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarClientes($tabla, $item, $valor ,$orden){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id_cliente DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			
			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE USUARIOs
	=============================================*/

	static public function mdlIngresarCliente($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,apellido, dni , celular , email , direccion, distrito,medio_captacion,asesor,nombre_conyuge,apellido_conyuge,dni_conyuge) VALUES (:nombre, :apellido, :dni , :celular , :email , :direccion , :distrito , :medio_captacion,:asesor,:nombre_conyuge,:apellido_conyuge,:dni_conyuge)");
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt->bindParam(":dni", $datos["dni"], PDO::PARAM_STR);
		$stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":distrito", $datos["distrito"], PDO::PARAM_STR);
		$stmt->bindParam(":medio_captacion", $datos["medio_captacion"], PDO::PARAM_STR);
		$stmt->bindParam(":asesor", $_SESSION["usuario"], PDO::PARAM_STR);

		if( $datos["nombre_conyuge"]== ""){
			$stmt->bindValue(':nombre_conyuge', null, PDO::PARAM_INT);
		}
		else{
			$stmt->bindParam(":nombre_conyuge", $datos["nombre_conyuge"], PDO::PARAM_STR);	
		}
		if($datos["apellido_conyuge"] == ""){
			$stmt->bindValue(':apellido_conyuge', null, PDO::PARAM_INT);
		}
		else{
			$stmt->bindParam(":apellido_conyuge", $datos["apellido_conyuge"], PDO::PARAM_STR);
		}
		if($datos["dni_conyuge"]==""){
			$stmt->bindValue(':dni_conyuge', null, PDO::PARAM_INT);
		}
		else{
			$stmt->bindParam(":dni_conyuge", $datos["dni_conyuge"], PDO::PARAM_STR);
		}
		if($stmt->execute()){
			$informe= $stmt->errorInfo();
			echo "<script> console.log($informe) </script>"; 
			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}
	/*=============================================
	COMPROBAR USUARIO
	=============================================*/
	public function mdlComprobarCliente($tabla,$dni)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where dni = '$dni'");

		$stmt -> execute();

		return $stmt->rowCount(); 
		
		$stmt -> close();
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	/*static public function mdlEditarUsuario($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, password = :password, perfil = :perfil, foto = :foto WHERE usuario = :usuario");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}*/

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	/*static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}*/

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarCliente($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_cliente = :id_cliente");

		$stmt -> bindParam(":id_cliente", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;


	}

}