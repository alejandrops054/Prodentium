<?php

require_once "../controladores/ajustes.controlador.php";
require_once "../modelos/ajustes.modelo.php";

class AjaxAjustes{

	/*=============================================
	EDITAR AJUSTES
	=============================================*/	
		public $idAjustes;
	
		public function ajaxEditarAjustes(){
	
			$item = "id";
			$valor = $this->idAjustes;
	
			$respuesta = ControladorAjustes::ctrMostrarAjusteControlador($item, $valor);
	
			echo json_encode($respuesta);
	
		}
	}
	
	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	
	if(isset($_POST["idAjustes"])){
	
		$ajustes = new AjaxAjustes();
		$ajustes -> idAjustes = $_POST["idAjustes"];
		$ajustes -> ajaxEditarAjustes();
	}