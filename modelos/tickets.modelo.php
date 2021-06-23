<?php

require_once "conexion.php";

class ModeloTickets{

	/*=============================================
	MOSTRAR TICKETS
	=============================================*/
	static public function mdlMostrarTickets($tabla, $tabla2, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT $tabla.*, $tabla2.* FROM $tabla INNER JOIN $tabla2 ON $tabla.id_prioridad = $tabla2.id WHERE $tabla.$item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;
	}

	/*=============================================
	CREAR TICKETS
	=============================================*/
	static public function mdlIngresarTickets($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(folio, titulo, asunto, descripcion, id_prioridad, status) VALUES(:folio, :titulo, :asunto, :descripcion, :id_prioridad, :status)");

		$stmt->bindParam(":folio", $datos["folio"], PDO::PARAM_INT);
		$stmt->bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
		$stmt->bindParam(":asunto", $datos["asunto"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":id_prioridad", $datos["id_prioridad"], PDO::PARAM_INT);
		$stmt->bindParam(":status", $datos["status"], PDO::PARAM_STR);

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
	EDITAR TICKETS
	=============================================*/

	static public function mdlEditarTickets($tabla, $datos){

		echo $tabla;

		echo "<pre>";
		print_r($datos);
		echo "</pre>";

		/*$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET titulo = :titulo, asunto = :asunto, descripcion = :descripcion, id_prioridad = :id_prioridad, status = :status WHERE id = :id");

		$stmt->bindParam(":titulo", $datos["titulo"], PDO::PARAM_INT);
		$stmt->bindParam(":asunto", $datos["asunto"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":id_prioridad", $datos["id_prioridad"], PDO::PARAM_INT);
		$stmt->bindParam(":status", $datos["status"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;*/
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlRangoFechasTickets($tabla, $fechaInicial, $fechaFinal){

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha_alta like '%$fechaFinal%'");

			$stmt -> bindParam(":fecha_alta", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha_alta BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");

			}else{


				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha_alta BETWEEN '$fechaInicial' AND '$fechaFinal'");

			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

}

?>