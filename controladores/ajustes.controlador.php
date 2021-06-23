<?php

class ControladorAjustes{

    //Mostrar Ajustes
	static public function ctrMostrarAjusteControlador($item, $valor){

		$tabla = "ajustes";

		$respuesta = ModeloAjustes::mdlMostrarAjustes($tabla, $item, $valor);

		return $respuesta;
	}
    /*=============================================
	EDITAR AJUSTES
	=============================================*/

	static public function ctrEditarAjustes(){

		if(isset($_POST["editarEmpresa"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarEmpresa"])){

				$tabla = "ajustes";

				$datos = array("empresa" => $_POST["editarEmpresa"],
							   "direccion" => $_POST["editarDireccion"],
							   "colonia" => $_POST["editarColonia"],
                               "alcaldia" => $_POST["editarAlcaldia"],
                               "cp" => $_POST["editarCp"],
                               "estado" => $_POST["editarEstado"],
                               "correo" => $_POST["editarCorreo"],
                               "telefono" => $_POST["editarTelefono"]);
 
				$respuesta = ModeloAjustes::mdlEditarAjustes($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Los ajustes ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "ajustes";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡Los ajustes no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {

							window.location = "ajustes";

							}
						})

			  	</script>';

			}

		}

	}
}