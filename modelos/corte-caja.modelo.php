<?php 

require_once "conexion.php";

class ModeloCorteCaja{

    /*=============================================
	MOSTRAR CORTE DE CAJA 
	=============================================*/   
	static public function mdlMostrarCorteCaja($tabla, $item, $valor){

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
	MOSTRAR CAJA INGRESOS
	=============================================*/
	static public function mdlMostrarCajaIngresos($tabla, $tabla2, $tabla3, $tabla4, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT $tabla.*, $tabla2.*, $tabla3.*, $tabla4.*, $tabla4.nombre as nombreDoctor, $tabla2.nombre as nombreUsuario FROM $tabla INNER JOIN $tabla2 INNER JOIN $tabla3 INNER JOIN $tabla4 ON $tabla.id_usuario = $tabla2.id AND $tabla.id = $tabla3.id_historial AND $tabla3.id_cliente = $tabla4.id WHERE $tabla.fecha LIKE '%$valor%' AND $tabla.cobrado > 0");

		$stmt -> execute();

		return $stmt -> fetchAll();
		
		$stmt -> close();
		$stmt = null;
    }

    /*=============================================
	MOSTRAR CAJA EGRESOS
	=============================================*/
	static public function mdlMostrarCajaEgresos($tabla, $tabla2, $tabla3, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT $tabla.*, $tabla.fecha as fechaCompra, $tabla.descripcion as descripcionCompra, $tabla2.*, $tabla2.nombre as nombreProveedor, $tabla3.*, $tabla3.nombre as nombreUsuario FROM $tabla INNER JOIN $tabla2 INNER JOIN $tabla3 ON $tabla.id_proveedor = $tabla2.id AND compra.id_usuario = $tabla3.id WHERE $tabla.fecha LIKE '%$valor%'");

		//$stmt = Conexion::conectar()->prepare("SELECT $tabla.*, $tabla.fecha as fechaCompra, $tabla.descripcion as descripcionCompra, $tabla2.* FROM $tabla INNER JOIN $tabla2 ON $tabla.id_proveedor = $tabla2.id WHERE $tabla.fecha LIKE '%$valor%'");

		$stmt -> execute();

		return $stmt -> fetchAll();
		
		$stmt -> close();
		$stmt = null;
    }

    /*=============================================
	MOSTRAR INICIO DE CAJA
	=============================================*/
	static public function mdlMostrarInicioCaja($tabla, $tabla2, $item, $valor, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("SELECT $tabla.*, $tabla2.*, $tabla.fecha as fechaInicioCaja FROM $tabla INNER JOIN $tabla2 ON $tabla.id_vendedor = $tabla2.id WHERE $tabla.concepto = '$valor' AND $tabla.fecha LIKE '%$valor2%'");

		$stmt -> execute();

		return $stmt -> fetch();
		
		$stmt -> close();
		$stmt = null;
    }


    /*=============================================
	MOSTRAR SUMA TOTAL HISTORIAL 
	=============================================*/
	static public function mdlSumaCajaTotalHistorial($tabla, $item, $valor){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(cobrado) as cobrado, paciente, fecha, SUM(faltante) as faltante, id FROM $tabla WHERE fecha like '%$valor%'");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
    
    /*=============================================
	INGRESAR VALORES CORTE DE CAJA 
	=============================================*/
    static public function mdlRealizarCorteCaja($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(valance, concepto, id_historial, caja, ingresos, egresos, id_vendedor) VALUES (:valance, :concepto, :id_historial, :caja, :ingresos, :egresos, :id_vendedor)");

		$stmt->bindParam(":valance", $datos["valance"], PDO::PARAM_STR);
		$stmt->bindParam(":concepto", $datos["concepto"], PDO::PARAM_STR);
		$stmt->bindParam(":id_historial", $datos["id_historial"], PDO::PARAM_INT);
        $stmt->bindParam(":caja", $datos["caja"], PDO::PARAM_STR);
        $stmt->bindParam(":ingresos", $datos["ingresos"], PDO::PARAM_STR);
        $stmt->bindParam(":egresos", $datos["egresos"], PDO::PARAM_STR);
        $stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";		
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	INGRESAR COBRADO CAJA BALANCE 
	=============================================*/
    static public function mdlIngresarCobradoCajaBalance($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, paciente, cobrado, faltante, total, metodo_pago, concepto, id_venta, id_usuario, id_caja) VALUES (:codigo, :paciente, :cobrado, :faltante, :total, :metodo_pago, :concepto, :id_venta, :id_usuario, :id_caja)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":paciente", $datos["paciente"], PDO::PARAM_STR);
		$stmt->bindParam(":cobrado", $datos["cobrado"], PDO::PARAM_STR);
		$stmt->bindParam(":faltante", $datos["faltante"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":concepto", $datos["concepto"], PDO::PARAM_STR);
		$stmt->bindParam(":id_venta", $datos["id_venta"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
		$stmt->bindParam(":id_caja", $datos["id_caja"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";		
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	INGRESAR INICIO DE CAJA 
	=============================================*/
    static public function mdlIngresarInicioCaja($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(valance, id_historial, caja, ingresos, id_vendedor) VALUES (:valance, :id_historial, :caja, :ingresos, :id_vendedor)");

		$stmt->bindParam(":valance", $datos["valance"], PDO::PARAM_STR);
		$stmt->bindParam(":id_historial", $datos["id_historial"], PDO::PARAM_INT);
        $stmt->bindParam(":caja", $datos["caja"], PDO::PARAM_STR);
        $stmt->bindParam(":ingresos", $datos["ingresos"], PDO::PARAM_STR);
        $stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";		
		}

		$stmt->close();
		$stmt = null;
	}

    /*=============================================
	RANGO FECHAS 
	=============================================*/	
	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal){

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%'");

			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

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

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");

			}else{


				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");
			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}
    }

    //SUMAR EL TOTAL DE VENTAS
    static public function mdlbalanceGeneral($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(valance) as total FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = null;

	}

	//REPORTE DE CORTE DE CAJA
}