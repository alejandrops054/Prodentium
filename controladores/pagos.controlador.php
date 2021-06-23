<?php 
class ControladorPagos{

	/*=============================================
	MOSTRAR NOMBRES DE LA TABLA STATUS_ORDEN_TRABAJO
	=============================================*/

    static public function ctrMostrarNombreStatusPagos($item, $valor){

		$tabla = "status_orden_trabajo";

		$respuesta = ModeloPagos::mdlMostrarNombreStatusPagos($tabla, $item, $valor);

		return $respuesta;
	
	}
}
?>