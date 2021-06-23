<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxAccesosCaja{

	/*=============================================
	VALIDAR ACCESOS CAJA
	=============================================*/

	public $usuario;
	public $contrasena;

	public function ajaxValidarAcceso(){

		$item = "usuario";
		$item2 = "contrasena";
		$valor = $this->usuario;
		$valor2 = $this->contrasena;

		$respuesta = ControladorUsuarios::ctrIngresoUsuarioCaja($item, $valor, $item2, $valor2);

		return $respuesta;

	}
}

/*=============================================
VALIDAR ACCESOS CAJA
=============================================*/

if(isset($_POST["usuario"])){

	$valUsuario = new AjaxAccesosCaja();
	$valUsuario -> usuario = $_POST["usuario"];
	$valUsuario -> contrasena = $_POST["contrasena"];
	$valUsuario -> ajaxValidarAcceso();

}