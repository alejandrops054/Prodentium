<?php

require_once "../controladores/compras.controlador.php";
require_once "../modelos/compras.modelo.php";

class AjaxCompras{

	/*=============================================
	EDITAR COMPRAS
	=============================================*/	

	public $idCompras;

	public function ajaxEditarCompras(){

		$item = "id";
		$valor = $this->idCompras;

		$respuesta = ControladorCompras::ctrMostrarCompras($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	ACTIVAR COMPRAS
	=============================================*/	
/*
	public $activarCompras;
	public $activarId;


	public function ajaxActivarCompras(){

		$tabla = "compra";

		$item1 = "status";
		$valor1 = $this->activarCompras;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloCompras::mdlActualizarCompras($tabla, $item1, $valor1, $item2, $valor2);

	}
*/
	/*=============================================
	VALIDAR NO REPETIR COMPRAS
	=============================================*/	

	public $validarCompras;

	public function ajaxValidarCompras(){

		$item = "descripcion";
		$valor = $this->validarCompras;

		$respuesta = ControladorCompras::ctrMostrarCompras($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR COMPRAS
=============================================*/
if(isset($_POST["idCompras"])){

	$editar = new AjaxCompras();
	$editar -> idCompras = $_POST["idCompras"];
	$editar -> ajaxEditarCompras();

}

/*=============================================
ACTIVAR COMPRAS
=============================================*/	
/*
if(isset($_POST["activarCompras"])){

	$activarUsuario = new AjaxCompras();
	$activarUsuario -> activarCompras = $_POST["activarCompras"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarCompras();

}
*/
/*=============================================
VALIDAR NO REPETIR COMPRAS
=============================================*/

if(isset( $_POST["nuevaDescripcion"])){

	$valUsuario = new AjaxCompras();
	$valUsuario -> validarCompras = $_POST["nuevaDescripcion"];
	$valUsuario -> ajaxValidarCompras();

}