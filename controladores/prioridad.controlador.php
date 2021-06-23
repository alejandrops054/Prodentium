<?php 

class ControladorPrioridad{

	/*=============================================
	MOSTRAR PRIORIDAD
	=============================================*/

    static public function ctrMostrarPrioridad($item, $valor){

		$tabla = "prioridad";

		$respuesta = ModeloPrioridad::mdlMostrarPrioridad($tabla, $item, $valor);

		return $respuesta;
	
	}
}