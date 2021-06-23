<?php 

class ControladorHistorial{


	/*=============================================
	MOSTRAR HISTORIAL
	=============================================*/
    static public function ctrMostrarHistorial($item, $valor){

		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		$valor1b = $fecha.' '.$hora;

        $tabla = "historial_pagos";

		$respuesta = ModeloHistorial::mdlMostrarHistorial($tabla, $item, $valor, $valor1b);

		return $respuesta;
        
    }

    /*=============================================
	MOSTRAR HABITACIONES
	=============================================*/
    
    static public function ctrMostrarHabitaciones($valor){

		$tabla1 = "categorias";
		$tabla2 = "habitaciones";

		$respuesta = ModeloHabitaciones::mdlMostrarHabitaciones($tabla1, $tabla2, $valor);

		return $respuesta;

	}
	
	/*=============================================
	MOSTRAR SUMA TOTAL HISTORIAL
	=============================================*/

	public function ctrSumaTotalHistorial($item, $valor){

		$tabla = "historial_pagos";

		$respuesta = ModeloHistorial::mdlSumaTotalHistorial($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR PAGOS BALANCE CORTE CAJA
	=============================================*/

	public function ctrPagosBalance($item, $valor){

		$tabla = "historial_pagos";

		$tabla2 = "usuarios";

		$tabla3 = "ventas";

		$respuesta = ModeloHistorial::mdlPagosBalance($tabla, $tabla2, $tabla3, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR PAGOS EN EL BALANCE DEL DÍA CORTE CAJA
	=============================================*/

	public function ctrPagosBalanceHoy($item, $valor){

		$tabla = "historial_pagos";

		$tabla2 = "usuarios";

		$tabla3 = "ventas";

		$tabla4 = "clientes";

		$respuesta = ModeloHistorial::mdlPagosBalanceHoy($tabla, $tabla2, $tabla3, $tabla4, $item, $valor);

		return $respuesta;

	}

}