<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

class AjaxClientes{

	/*=============================================
	EDITAR CLIENTE
	=============================================*/	

	public $idCliente;

	public function ajaxEditarCliente(){
 
		$item = "id";
		$valor = $this->idCliente;

		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

		echo json_encode($respuesta);

	}
	/*=============================================
	VALIDAMOS QUE EL CLIENTE NO SE EXISTA
	=============================================*/	
	public $validarCliente;

	public function ajaxValidarCliente(){

		$item = "nombre";
		$item2 = "rfc";
		$valor = $this->validarCliente;

		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $item2, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
EDITAR CLIENTE
=============================================*/	

if(isset($_POST["idCliente"])){

	$cliente = new AjaxClientes();
	$cliente -> idCliente = $_POST["idCliente"];
	$cliente -> ajaxEditarCliente();

}
/*=============================================
VALIDAR NO REPETIR CLIENTE
=============================================*/

if(isset( $_POST["validarCliente"])){

	$valCliente = new AjaxCliente();
	$valCliente -> validarCliente = $_POST["validarCliente"];
	$valCliente -> ajaxValidarCliente();

}