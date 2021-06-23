<?php 

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class AjaxVentas{

	/*=============================================
	EDITAR VENTAS
	=============================================*/ 
	public $idVenta;

	public function ajaxEditarVenta(){

		$item = "id";
		$valor = $this->idVenta;

		$respuesta = ControladorVentas::ctrEditarVenta($item, $valor);

		echo json_decode($respuesta);
	}
			
	/*=============================================
	EDITAR STATUS
	=============================================*/ 
	
	public $activarVenta;
	public $activarId;

	public function ajaxActivarVenta(){

		$tabla = "ventas";

		$item1 = "status";
		$valor1 = $this->activarVenta;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloVentas::mdlActualizarVenta($tabla, $item1, $valor1, $item2, $valor2);
	}

}

/*=============================================
EDITAR VENTAS
=============================================*/ 
if(isset($_POST["idVenta"])){

	$ventas = new AjaxVentas();
	$ventas -> idVenta = $_POST["idVenta"];
	$ventas -> ajaxEditarVenta();
}

/*=============================================
EDITAR STATUS
=============================================*/ 
if(isset($_POST["activarVenta"])){
	
	$activarVenta = new AjaxVentas();
	$activarVenta -> activarVenta = $_POST["activarVenta"];
	$activarVenta -> activarId = $_POST["activarId"];
	$activarVenta -> ajaxActivarVenta();
}
?>