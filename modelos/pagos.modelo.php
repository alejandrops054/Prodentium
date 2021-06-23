<?php 

require_once "conexion.php";

class ModeloPagos{

	/*=============================================
	REGISTRO DE PAGOS POR ODT(Orden de Trabajo)
	=============================================*/

	/*static public function mdlIngresarHistorialPagos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_ventas, id_cliente, id_usuario, paciente, cobrado, faltante, total, metodo_pago) VALUES (:id_ventas, :id_cliente, :id_usuario, :paciente, :cobrado, :faltante, :total, :metodo_pago)");

		$stmt->bindParam(":id_ventas", $datos["id_ventas"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
		$stmt->bindParam(":paciente", $datos["paciente"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":cobrado", $datos["cobrado"], PDO::PARAM_INT);
		$stmt->bindParam(":faltante", $datos["faltante"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);

		if($stmt->execute()){

			//Retornamos el último id insertado de la tabla ventas
			$stmt = Conexion::conectar()->prepare("SELECT id_ventas, faltante FROM historial_pagos WHERE id=(SELECT MAX(id) FROM historial_pagos)");
			$stmt->execute();
			$lastId = $stmt->fetchAll();

			foreach ($lastId as $key => $value){

				$id = $value['.']."-".$value['faltante'];

			}

			return $id;

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
	}*/

	/*=============================================
	MOSTRAR NOMBRES DE LA TABLA STATUS_ORDEN_TRABAJO
	=============================================*/

    static public function mdlMostrarNombreStatusPagos($tabla, $item, $valor){

        if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT MAX(fecha) as fecha FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			foreach ($lastId as $key => $value){

				$id = $value['id']."-".$value['id_historial'];

			}

			return $id;
		

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();

			return $stmt -> fetchAll();
		}

		$stmt -> close();
		$stmt = null;
        
    }
}
?>