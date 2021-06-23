<?php

class ControladorTickets{

	/*=============================================
	MOSTRAR TICKETS
	=============================================*/

	static public function ctrMostrarTickets($item, $valor){

		$tabla = "tickets";

		$tabla2 = "prioridad";

		$respuesta = ModeloTickets::mdlMostrarTickets($tabla, $tabla2, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR TICKETS
	=============================================*/

	static public function ctrCrearTickets(){

		$tabla = "tickets";

		$datos = array("titulo"=>$_POST['titulo'],
						"folio"=>$_POST['folio'],
						"asunto"=>$_POST['asunto'],
						"id_prioridad"=>$_POST['seleccionarPrioridad'],
						"status"=>$_POST['seleccionarStatus'],
						"descripcion"=>$_POST['descripcion']);

		$respuesta = ModeloTickets::mdlIngresarTickets($tabla, $datos);

		if($respuesta > 0){

					echo'<script>

					swal({
						  type: "success",
						  title: "El ticket ha sido generado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "tickets";

									}
								})

					</script>';

		}

	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarTickets(){

		$tabla = "tickets";

		$datos = array("id"=>$_POST["idTicket"]);

		$respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $datos);

		if($respuesta == "ok"){

			echo'<script>

			swal({
				  type: "success",
				  title: "El material ha sido cambiado correctamente",
				  showConfirmButton: true,
				  confirmButtonText: "Cerrar"
				  }).then(function(result){
							if (result.value) {

							window.location = "categorias";

							}
						})

			</script>';

		}

	}

	/*=============================================
	RANGO FECHAS TICKETS
	=============================================*/	

	static public function ctrRangoFechasTickets($fechaInicial, $fechaFinal){

		$tabla = "tickets";

		$respuesta = ModeloTickets::mdlRangoFechasTickets($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}
	
}
?>