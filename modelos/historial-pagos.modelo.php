<?php 

require_once "conexion.php";

class ModeloHistorial{
 
    /*=============================================
	MOSTRAR HISTORIAL
	=============================================*/
	static public function mdlMostrarHistorial($tabla, $item, $valor){

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
	INGRESAMOS HISTORIAL
	=============================================*/
	static public function mdlIngresarHistorialPagos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_cliente, id_usuario, codigo, paciente, cobrado, faltante, total, metodo_pago) VALUES (:id_cliente, :id_usuario, :codigo, :paciente, :cobrado, :faltante, :total, :metodo_pago)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
		$stmt->bindParam(":paciente", $datos["paciente"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":cobrado", $datos["cobrado"], PDO::PARAM_INT);
		$stmt->bindParam(":faltante", $datos["faltante"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);

		if($stmt->execute()){

			//Selecciona el último id de la tabla ventas
			$stmt = Conexion::conectar()->prepare("SELECT MAX(id) as last_id FROM $tabla");

			$stmt->execute();

			$lastId = $stmt->fetchAll();

			foreach ($lastId as $key => $value){

				$id = $value['last_id'];

			}

			return $id;

		}else{

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}	
	
    /*=============================================
	MOSTRAR SUMAR 
	=============================================*/
	static public function mdlSumaTotalHistorial($tabla, $item, $valor){	

			$stmt = Conexion::conectar()->prepare("SELECT SUM(cobrado) as cobrado, paciente, fecha, SUM(faltante) as faltante, id FROM $tabla WHERE fecha like '%$valor%'");

			$stmt -> execute();

			return $stmt -> fetch();

			$stmt -> close();

			$stmt = null;

	}

	/*=============================================
	MOSTRAR PAGOS BALANCE CORTE CAJA 
	=============================================*/
	static public function mdlPagosBalance($tabla, $tabla2, $tabla3, $item, $valor){	

			//$stmt = Conexion::conectar()->prepare("SELECT $tabla.*, $tabla2.* FROM $tabla INNER JOIN $tabla2 ON $tabla.id_usuario = $tabla2.id WHERE $tabla.fecha like '%$valor%' AND $tabla.cobrado > 0");

			$stmt = Conexion::conectar()->prepare("SELECT $tabla.*, $tabla.fecha as fecha, $tabla2.*, $tabla3.* FROM $tabla INNER JOIN $tabla2 INNER JOIN $tabla3 ON $tabla.id_usuario = $tabla2.id AND $tabla.id = $tabla3.id_historial WHERE $tabla.fecha LIKE '%$valor%' AND $tabla.cobrado > 0");

			$stmt -> execute();

			return $stmt -> fetchAll();

			$stmt -> close();

			$stmt = null;

	}

	/*=============================================
	MOSTRAR PAGOS EN EL BALANCE DEL DÍA CORTE CAJA 
	=============================================*/
	static public function mdlPagosBalanceHoy($tabla, $tabla2, $tabla3, $tabla4, $item, $valor){	

		$stmt = Conexion::conectar()->prepare("SELECT $tabla.*, $tabla2.*, $tabla3.*, $tabla4.*, $tabla4.nombre as nombreDoctor, $tabla2.nombre as nombreUsuario FROM $tabla INNER JOIN $tabla2 INNER JOIN $tabla3 INNER JOIN $tabla4 ON $tabla.id_usuario = $tabla2.id AND $tabla.id = $tabla3.id_historial AND $tabla3.id_cliente = $tabla4.id WHERE $tabla.fecha LIKE '%$valor%' AND $tabla.cobrado > 0");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

}

	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function mdlEliminarHistorial($tabla2, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla2 WHERE id_ventas = :id_ventas");

		$stmt -> bindParam(":id_ventas", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

}