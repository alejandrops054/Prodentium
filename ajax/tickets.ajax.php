<?php

require_once "../controladores/tickets.controlador.php";
require_once "../modelos/tickets.modelo.php";

class AjaxTickets{

	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	

	public $idTicket;

	public function ajaxEditarTickets(){

		$item = "id";
		$valor = $this->idTicket;

		$respuesta = ControladorTickets::ctrMostrarTickets($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idTicket"])){

	$categoria = new AjaxTickets();
	$categoria -> idTicket = $_POST["idTicket"];
	$categoria -> ajaxEditarTickets();
}
