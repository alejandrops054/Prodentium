<?php

//ventas
require_once "../../controladores/ventas.controlador.php";
require_once "../../modelos/ventas.modelo.php";
//clientes
require_once "../../controladores/clientes.controlador.php";
require_once "../../modelos/clientes.modelo.php";
//Usuarios
require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";
//HISTORIAL
require_once "../../controladores/historial-pagos.controlador.php";
require_once "../../modelos/historial-pagos.modelo.php";

$reporte = new ControladorVentas();
$reporte -> ctrDescargarReporte();

?>