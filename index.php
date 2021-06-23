<?php

require_once "controladores/ajustes.controlador.php";
require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/compras.controlador.php";
require_once "controladores/corte-caja.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/proveedor.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once "controladores/plantilla.controlador.php";
require_once "controladores/prioridad.controlador.php";
require_once "controladores/pagos.controlador.php";
require_once "controladores/historial-pagos.controlador.php";
require_once "controladores/tickets.controlador.php";

require_once "modelos/ajustes.modelo.php";
require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/compras.modelo.php";
require_once "modelos/corte-caja.modelo.php";
require_once "modelos/proveedor.modelos.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "modelos/prioridad.modelo.php";
require_once "modelos/pagos.modelo.php";
require_once "modelos/historial-pagos.modelo.php";
require_once "modelos/tickets.modelo.php";

require_once "extensiones/vendor/autoload.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();