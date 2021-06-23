<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ControladorVentas{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function ctrMostrarVentas($item, $valor){

		$tabla = "ventas";
		$tabla2 = "prioridad";
		$tabla3 = "status_orden_trabajo";

		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $tabla2, $tabla3, $item, $valor);

		return $respuesta;

	}
	
	/*=============================================
	CREAR VENTA
	=============================================*/

	static public function ctrCrearVenta(){

		if(isset($_POST["nuevaVenta"])){

			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/

			if($_POST["listaProductos"] == ""){

					echo'<script>

				swal({
					  type: "error",
					  title: "La venta no se ha ejecuta si no hay productos",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

				return;
			}


			$listaProductos = json_decode($_POST["listaProductos"], true);

			$totalProductosComprados = array();

			foreach ($listaProductos as $key => $value) {

			   array_push($totalProductosComprados, $value["cantidad"]);
				
			   $tablaProductos = "productos";

			    $item = "id";
			    $valor = $value["id"];
			    $orden = "id";

			    $traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

				$item1a = "ventas";
				$valor1a = $value["cantidad"] + $traerProducto["ventas"];

			    $nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

			}

			$tablaClientes = "clientes";

			$item = "id";
			$valor = $_POST["seleccionarCliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);

			$item1a = "compras";
				
			$valor1a = array_sum($totalProductosComprados) + $traerCliente["compras"];

			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);

			$item1b = "ultima_compra";

			date_default_timezone_set('America/mexico_city');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);

			/*=============================================
			GUARDAMOS HISTORIAL DE ODT
			=============================================*/	
			$tabla1 = "historial_pagos";

			$datos1 = array("codigo"=>$_POST["nuevaVenta"],
						   	"id_cliente"=>$_POST["seleccionarCliente"],
						   	"id_usuario"=>$_POST["idVendedor"],
						   	"paciente"=>$_POST["nuevoPaciente"],
						   	"cobrado"=>$_POST["cobrado"],
						   	"faltante"=>$_POST["cambioEfectivoValidado"],
						   	"total"=>$_POST["nuevoTotalVenta"],
						   	"metodo_pago"=>$_POST["nuevoMetodoPago"]);

			$respuestaHistorial = ModeloHistorial::mdlIngresarHistorialPagos($tabla1, $datos1);

			/*=============================================
			GUARDAMOS ODT
			=============================================*/	
			$tabla = "ventas";

			$datos = array("codigo"=>$_POST["nuevaVenta"],
						   "id_historial" => $respuestaHistorial,
						   "id_cliente"=>$_POST["seleccionarCliente"],
						   "id_vendedor"=>$_POST["idVendedor"],
						   "id_prioridad"=>$_POST["seleccionarPrioridad"],
						   "productos"=>$_POST["listaProductos"],
						   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   "status"=>$_POST["seleccionarStatus"],
						   "neto"=>$_POST["nuevoPrecioNeto"],
						   "total"=>$_POST["nuevoTotalVenta"],
						   "metodo_pago"=>$_POST["nuevoMetodoPago"],
						   "nota"=>$_POST["nuevaNota"]);
			
			$respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);

			/*=============================================
			GUARDAMOS COBRADO CAJA BALANCE
			=============================================*/

			$tablaCobrado = "cobrado_ventas";

			$datosCobrado = array("codigo"=>$_POST["nuevaVenta"],
								"paciente"=>$_POST["nuevoPaciente"],
								"cobrado"=>$_POST["cobrado"],
								"faltante"=>$_POST["cambioEfectivoValidado"],
								"total"=>$_POST["nuevoTotalVenta"],
								"metodo_pago"=>$_POST["nuevoMetodoPago"],
								"concepto"=>$_POST["nuevaNota"],
								"id_venta"=>$respuesta,
								"id_usuario"=>$_POST["idVendedor"],
								"id_caja"=>"1");

			$respuestaCobrado = ModeloCorteCaja::mdlIngresarCobradoCajaBalance($tablaCobrado, $datosCobrado);


			if($respuestaHistorial > 0 && $respuesta > 0  && $respuestaCobrado == "ok"){
	
				echo'<script>
						swal({
					  		type: "success",
					  		title: "La ODT ha sido guardada correctamente",
					  		showConfirmButton: true,
					  		confirmButtonText: "Cerrar"
					  			}).then(function(result){
									if (result.value) {
										window.location = "ventas";
									}
								})
					</script>';
			}

		}

	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function ctrEditarVenta(){

		if(isset($_POST["editarVenta"])){

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "ventas";
			$tabla2 = "prioridad";
			$tabla3 = "status_orden_trabajo";

			$item = "ventas.codigo";
			$valor = $_POST["editarVenta"];

			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $tabla2, $tabla3, $item, $valor);

			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/

			if($_POST["listaProductos"] == ""){

				$listaProductos = $traerVenta[0]["productos"];
				$cambioProducto = false;


			}else{

				$listaProductos = $_POST["listaProductos"];
				$cambioProducto = true;
			}

			if($cambioProducto){

				$productos =  json_decode($traerVenta["productos"], true);

				$totalProductosComprados = array();

				foreach ($productos as $key => $value) {

					array_push($totalProductosComprados, $value["cantidad"]);
					
					$tablaProductos = "productos";

					$item = "id";
					$valor = $value["id"];
					$orden = "id";

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

					$item1a = "ventas";
					$valor1a = $traerProducto["ventas"] - $value["cantidad"];

					$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

					$item1b = "stock";
					$valor1b = $value["cantidad"] + $traerProducto["stock"];

					$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

				}

				$tablaClientes = "clientes";

				$itemCliente = "id";
				$valorCliente = $_POST["seleccionarCliente"];

				$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

				$item1a = "compras";
				$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);		

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);

				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/

				$listaProductos_2 = json_decode($listaProductos, true);

				$totalProductosComprados_2 = array();

				foreach ($listaProductos_2 as $key => $value) {

					array_push($totalProductosComprados_2, $value["cantidad"]);
					
					$tablaProductos_2 = "productos";

					$item_2 = "id";
					$valor_2 = $value["id"];
					$orden = "id";

					$traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $item_2, $valor_2, $orden);

					$item1a_2 = "ventas";
					$valor1a_2 = $value["cantidad"] + $traerProducto_2["ventas"];

					$nuevasVentas_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);

					$item1b_2 = "stock";
					$valor1b_2 = $traerProducto_2["stock"] - $value["cantidad"];

					$nuevoStock_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);

				}

				$tablaClientes_2 = "clientes";

				$item_2 = "id";
				$valor_2 = $_POST["seleccionarCliente"];

				$traerCliente_2 = ModeloClientes::mdlMostrarClientes($tablaClientes_2, $item_2, $valor_2);

				$item1a_2 = "compras";

				$valor1a_2 = array_sum($totalProductosComprados_2) + $traerCliente_2["compras"];

				$comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1a_2, $valor1a_2, $valor_2);

				$item1b_2 = "ultima_compra";

				date_default_timezone_set('America/Mexico_City');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;

				$fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1b_2, $valor1b_2, $valor_2);

			}

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/
			$tabla1 = "historial_pagos";

			$datos1 = array("codigo"=>$_POST["editarVenta"],
						   	"id_cliente"=>$_POST["seleccionarCliente"],
						   	"id_usuario"=>$_POST["idVendedor"],
						   	"paciente"=>$_POST["nuevoPaciente"],
							"cobrado"=>$_POST["cobrado"],
						   	"faltante"=>$_POST["cambioEfectivoValidado"],
						   	"total"=>$_POST["nuevoTotalVenta"],
						   	"metodo_pago"=>$_POST["nuevoMetodoPago"]);

			$respuestaHistorial = ModeloHistorial::mdlIngresarHistorialPagos($tabla1, $datos1);
			
			$datos = array("id_historial"=> $respuestaHistorial,
							"id"=>$_GET["idVenta"]);

			$respuesta = ModeloVentas::mdlEditarVenta($tabla, $datos);
							
	
			if($respuesta >0 && $respuestaHistorial > 0){

				echo'<script>
						swal({
					  		type: "success",
					  		title: "EL movimiento de la ODT ser realizo correctamente",
					  		showConfirmButton: true,
					  		confirmButtonText: "Cerrar"
					  			}).then((result) => {
									if (result.value) {
										window.location = "ventas";
									}
								})
					</script>';

			}

		}

	}


	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function ctrEliminarVenta(){

		if(isset($_GET["idVenta"])){

			
			$tabla = "ventas";

			$datos = $_GET["idVenta"];
			/*=============================================
			ELIMINAR VENTA
			=============================================*/

			$respuesta = ModeloVentas::mdlEliminarVenta($tabla,$datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "La ODT ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}	
		}

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal){

		$tabla = "ventas";
		
		$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte(){

		if(isset($_GET["reporte"])){

			$tabla = "ventas";

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$ventas = ModeloVentas::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
			}

			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");
		
			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>FOLIO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>COBRADO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FALTANTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CREDITO NETO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CREDITO CON IVA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTA</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td>	
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($ventas as $row => $item){

				$cliente = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);
				$historial = ControladorHistorial::ctrMostrarHistorial("id_ventas", $item["id"]);

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
			 			<td style='border:1px solid #eee;'>".$cliente["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>".$vendedor["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>");

			 	$productos =  json_decode($item["productos"], true);

			 	foreach ($productos as $key => $valueProductos) {
			 			
			 			echo utf8_decode($valueProductos["cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

		 		foreach ($productos as $key => $valueProductos) {
			 			
		 			echo utf8_decode($valueProductos["descripcion"]."<br>");
		 		
				 }

				echo utf8_decode("</td><td style='border:1px solid #eee;'>");

				 echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ ".number_format($historial["cobrado"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($historial["faltante"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["neto"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["impuesto"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid #eee;'>".$item["nota"]."</td>	
					<td style='border:1px solid #eee;'>".$item["metodo_pago"]."</td>
					<td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>		
		 			</tr>");
			}
			echo "</table>";
		}
	}


	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/

	public function ctrSumaTotalVentas(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);

		return $respuesta;

	}

}