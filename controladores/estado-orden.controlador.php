<?php

class ControladorEstado{

    static public function ctrMostrarEstadoDeOrden(){

        $tabla = "status_orden_trabajo";

        $respuesta = ModeloEstado::mdlEstadoDeOrden($item, $value);

        return $respuesta;
    }
}