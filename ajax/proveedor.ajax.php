<?php

require_once "../controladores/proveedor.controlador.php";
require_once "../modelos/proveedor.modelos.php";

class AjaxProveedor{

	public $idProveedor;

	public function ajaxEditarProveedor(){

		$item = "id";
		$valor = $this->idProveedor;

		$respuesta = ControladorProveedor::ctrMostrarProveedor($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	VALIDAR NO REPETIR PROVEEDOR
	=============================================*/	

	public $validarProveedor;

	public function ajaxValidarProveedor(){

		$item = "empresa";
		$valor = $this->validarProveedor;

		$respuesta = ControladorProveedor::ctrMostrarProveedor($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR PROVEEDOR
=============================================*/
if(isset($_POST["idProveedor"])){

	$editar = new AjaxProveedor();
	$editar -> idProveedor = $_POST["idProveedor"];
	$editar -> ajaxEditarProveedor();
}

/*=============================================
VALIDAR NO REPETIR PROVEEDOR
=============================================*/

if(isset( $_POST["validarProveedor"])){

	$valUsuario = new AjaxProveedor();
	$valUsuario -> validarProveedor = $_POST["validarProveedor"];
	$valUsuario -> ajaxValidarProveedor();
}
