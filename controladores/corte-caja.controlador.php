<?php

class ControladorCorteCaja{
     
    /*=============================================
	MOSTRAR CORTE CAJA
	=============================================*/	
    static public function ctrMostrarCorteCaja($item, $valor){
        
        $tabla = "corte_caja";

        $respuesta = ModeloCorteCaja::mdlMostrarCorteCaja($tabla, $item, $valor);

        return $respuesta;
    }

    /*=============================================
	MOSTRAR HISTORIAL PARA CAJA
	=============================================*/

    static public function ctrMostrarCajaHistorial($item, $valor){

        $tabla = "historial_pagos";

		$respuesta = ModeloCorteCaja::mdlSumaCajaTotalHistorial($tabla, $item, $valor);

		return $respuesta;
        
    }

     /*=============================================
	MOSTRAR CAJA INGRESOS
	=============================================*/

    static public function ctrMostrarCajaIngresos($item, $valor){

        $tabla = "historial_pagos";

        $tabla2 = "usuarios";

        $tabla3 = "ventas";

        $tabla4 = "clientes";

		$respuesta = ModeloCorteCaja::mdlMostrarCajaIngresos($tabla, $tabla2, $tabla3, $tabla4, $item, $valor);

		return $respuesta;
        
    }

    /*=============================================
	MOSTRAR CAJA EGRESOS
	=============================================*/

    static public function ctrMostrarCajaEgresos($item, $valor){

        $tabla = "compra";

        $tabla2 = "proveedor";

        $tabla3 = "usuarios";

		$respuesta = ModeloCorteCaja::mdlMostrarCajaEgresos($tabla, $tabla2, $tabla3, $item, $valor);

		return $respuesta;
        
    }

    /*=============================================
	MOSTRAR INICIO DE CAJA
	=============================================*/

    static public function ctrMostrarInicioCaja($item, $valor, $item2, $valor2){

        $tabla = "corte_caja";

        $tabla2 = "usuarios";

		$respuesta = ModeloCorteCaja::mdlMostrarInicioCaja($tabla, $tabla2, $item, $valor, $item2, $valor2);

		return $respuesta;
        
    }

	/*=============================================
	INGRESO INICIO DE CAJA
	=============================================*/	
	static public function ctrIngresarInicioCaja(){

		if(isset($_POST["nuevoMonto"])){

		   	$tabla = "corte_caja";

		   	$datos = array("ingresos" => $_POST["nuevoMonto"],
							"valance" => $_POST["nuevoMonto"],
							"id_historial" => $_POST["id_historial"],
							"id_vendedor" => $_POST["id_vendedor"],
							"caja" => $_POST["caja"],
							"egresos" => $_POST["egresos"],
						   "concepto" => $_POST["concepto"]);
						   

		   	$respuesta = ModeloCorteCaja::mdlRealizarCorteCaja($tabla, $datos);

		   	if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El monto se generó correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "corte-caja";

								}
							})

				</script>';

			}

		}
		
	}

	/*=============================================
	INGRESO EGRESO DE CAJA
	=============================================*/	
	static public function ctrIngresarEgresoCaja(){


		if(isset($_POST["montoEgreso"])){

		   	$tabla = "caja_egresos";

		   	$datos = array("egreso" => $_POST["montoEgreso"],
							"concepto" => $_POST["nuevaDescripcion"],
							"id_usuario" => $_POST["id_historial"],
							"id_caja" => $_POST["caja"]);

		   	$respuesta = ModeloCorteCaja::mdlRealizarEgresoCaja($tabla, $datos);

		   	if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El monto de egreso se generó correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "corte-caja";

								}
							})

				</script>';

			}

		}
		
	}

	/*=============================================
	INGRESAR CORTE CAJA
	=============================================*/	
    static public function ctrIngresarCorteCaja(){

		if(isset($_POST["cobrado"])){

		   	$tabla = "corte_caja";

		   	$datos = array("valance" => $_POST["balance"],
		   				   "id_historial" => $_POST["id_historial"],
		   				   "concepto" => $_POST["concepto"],
		   				   "caja" => $_POST["caja"],
		   				   "fecha" => $_POST["fecha"],
						   "ingresos" => $_POST["cobrado"],
						   "egresos" => $_POST["faltante"],
						   "id_vendedor" => $_POST["id_vendedor"]);

		   	$respuesta = ModeloCorteCaja::mdlRealizarCorteCaja($tabla, $datos);

		   	if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El corte se generó correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "corte-caja";

								}
							})

				</script>';

			}
		}
	}

	/*=============================================
	RANGO FECHAS CORTE CAJA
	=============================================*/	
	static public function ctrRangoFechasCorteCaja($fechaInicial, $fechaFinal){

        $tabla = "corte_caja";

		$respuesta = ModeloCorteCaja::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}
}