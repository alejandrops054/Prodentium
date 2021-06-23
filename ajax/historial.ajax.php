<?php

require_once "../controladores/historial-pagos.controlador.php";
require_once "../modelos/historial-pagos.modelo.php";

class AjaxHisotiral{

    public function ajaxEditarHistorial(){

        $item = "id";
        $valor = $this->$idHisotrial;

        $respuesta = ControladorHistorial::mdlMostrarHistorial($item, $valor);

        echo json_encode($respuesta);
    }
}

if(isset($_POST["idHistorial"])){

    $historial = new AjaxHisotiral();
    $historial -> idHistorial = $_POST["idHistorial"];
    $historial -> ajaxEditarHistorial();
}