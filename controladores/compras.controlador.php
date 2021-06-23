<?php

class ControladorCompras{

    //REGISTRO DE COMPRA
	static public function ctrCrearCompras(){

		if(isset($_POST["nuevaDescripcion"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"])){

				$tabla = "compra";

				$datos = array("descripcion"=>$_POST["nuevaDescripcion"],
								"id_proveedor"=>$_POST["seleccionarProveedor"],
								"id_usuario"=>$_SESSION["id"],
								"gasto"=>$_POST["IngresoDeGasto"]);

				$respuesta = ModeloCompras::mdlIngresarCompras($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El gasto ha sido registrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "compras";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El registro del gasto no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "compras";

							}
						})

			  	</script>';

			}

		}
	}

	/*=============================================
	MOSTRAR COMPRAR
	=============================================*/

	static public function ctrMostrarCompras($item, $valor){

		$tabla = "compra";

		$respuesta = ModeloCompras::mdlMostrarCompras($tabla, $item, $valor);

		return $respuesta;
	}

	//EDITAR COMPRAS
	static public function ctrEditarCompras(){

		if(isset($_POST["editarDescripcion"])){

			if($_POST["editarDescripcion"]){

				$tabla = "compra";

				$datos = array("descripcion" => $_POST["editarDescripcion"],
								"id_proveedor"=>$_POST["editarSeleccionarProveedor"],
								"gasto"=>$_POST["editarGasto"],
								"id"=>$_POST["idCompras"]);

				$respuesta = ModeloCompras::mdlEditarCompras($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El gasto ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "compras";

									}
								})

					</script>';
				}

			}else{

				echo'<script>
					swal({
						  type: "error",
						  title: "¡La edicion del gasto no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {
							window.location = "compras";
							}
						})
			  	</script>';
			}
		}
	}

	//DESCARGAR EXCEL
	public function ctrDescargarReporteCompras(){

		if(isset($_GET["compras"])){

			$tabla = "compra";

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$compras = ModeloCompras::mdlRangoFechasCompras($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$compras = ModeloCompras::mdlMostrarCompras($tabla, $item, $valor);

			}
			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/
			$Name = $_GET["compras"].'.xls';

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
					<td style='font-weight:bold; border:1px solid #eee;'>DESCRIPCIÓNn</td> 		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach($compras as $row => $item){

				$proveedores = ControladorProveedor::ctrMostrarProveedor("id", $item["id_proveedor"]);

			echo utf8_decode("<tr>
						 <td style='border:1px solid #eee;>".$proveedores["empresa"]."</td>
						 <td style='border:1px solid #eee;'>".$item["descripcion"]."</td>
						 <td style='border:1px solid #eee;'>$ ".number_format($item["gasto"],2)."</td>	
						 <td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>		
						</tr>");
		 		}
				echo "</table>";
			}
		}


	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasCompras($fechaInicial, $fechaFinal){

		$tabla = "compra";

		$respuesta = ModeloCompras::mdlRangoFechasCompras($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	//SUMA VALORES DE GASTOS

	static public function ctrSumarTotalGasto($item, $valor){

		$tabla = "compra";

		$respuesta = ModeloCompras::mdlSumaTotalCompras($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	BORRAR COMPRAS
	=============================================*/
	static public function ctrBorrarCompras(){

		if(isset($_GET["idCompras"])){

			$tabla ="Compra";
			$datos = $_GET["idCompras"];

			$respuesta = ModeloCompras::mdlBorrarCompras($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>
						swal({
					  		type: "success",
					  		title: "El gasto ha sido borrado correctamente",
					  		showConfirmButton: true,
					  		confirmButtonText: "Cerrar",
					  		closeOnConfirm: false
					  		}).then(function(result) {
								if (result.value) {
								window.location = "compras";
								}
							})
					 </script>';
			}		
		}
	}
}
	