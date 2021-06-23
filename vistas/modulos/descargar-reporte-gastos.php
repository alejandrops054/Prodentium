<?php 

//requerimos gastos
require_once "../../controladores/compras.controlador.php";
require_once "../../modelos/compras.modelo.php";

//requerimos proveedor
require_once "../../controladores/proveedor.controlador.php";
require_once "../../modelos/proveedor.modelos.php";

$reportes = new ControladorCompras();
$reportes -> ctrDescargarReporteCompras();
?>