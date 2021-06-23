<?php

class ControladorClientes{

	/*=============================================
	CREAR CLIENTES
	=============================================*/
	static public function ctrCrearCliente(){

		if(isset($_POST["nuevoCliente"])){

			if(preg_match('/^[?\\¿\\!\\¡\\:\\,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCliente"])){


			   	$tabla = "clientes";

			   	$datos = array("nombre" => $_POST["nuevoCliente"],
							   "rfc" => $_POST["nuevoRfc"],
							   "razon_social" => $_POST["nuevaRazonSocial"],
							   "direccion" => $_POST["nuevaDireccion"],
							   "cp" => $_POST["nuevoCP"],
							   "municipio" => $_POST["nuevoMunicio"],
							   "colonia" => $_POST["nuevaColonia"],
							   "entidad" => $_POST["nuevaEntidad"],
					           "email" => $_POST["nuevoEmail"],
							   "telefono" => $_POST["nuevoTelefono"]);

			   	$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El doctor ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "clientes";

									}
								})
					</script>';
				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El doctor no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "clientes";

							}
						})

			  	</script>';

			}
		}
	}

	/*=============================================
	CREAR ALTA DE CLIENTE
	=============================================*/
	static public function ctrCrearClienteVentas(){

		if(isset($_POST["nuevoCliente"])){

			if(preg_match('/^[?\\¿\\!\\¡\\:\\,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCliente"]) &&
				preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["nuevoEmail"]) && 
				preg_match('/^[()\-0-9 ]+$/', $_POST["nuevoTelefono"]) &&
				preg_match('/^[()\-0-9 ]+$/', $_POST["nuevoCP"])){

			   	$tabla = "clientes";

			   	$datos = array("nombre" => $_POST["nuevoCliente"],
							   "rfc" => $_POST["nuevoRfc"],
							   "razon_social" => $_POST["nuevaRazonSocial"],
							   "direccion" => $_POST["nuevaDireccion"],
							   "cp" => $_POST["nuevoCP"],
							   "municipio" => $_POST["nuevoMunicio"],
							   "colonia" => $_POST["nuevaColonia"],
							   "entidad" => $_POST["nuevaEntidad"],
					           "email" => $_POST["nuevoEmail"],
							   "telefono" => $_POST["nuevoTelefono"]);
							   


			   	$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El doctor ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "ventas";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El doctor no puede ir vacío o llevar caracteres especiales!",
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
	MOSTRAR CLIENTES
	=============================================*/

	static public function ctrMostrarClientes($item, $valor){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function ctrEditarCliente(){

		if(isset($_POST["editarCliente"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCliente"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["editarEmail"]) && 
			   preg_match('/^[()\-0-9 ]+$/', $_POST["editarTelefono"])){ 

			   	$tabla = "clientes";

			   	$datos = array("id"=>$_POST["idCliente"],
			   				   "nombre"=>$_POST["editarCliente"],
					           "email"=>$_POST["editarEmail"],
					           "telefono"=>$_POST["editarTelefono"],
							   "direccion"=>$_POST["editarDireccion"],
							   "rfc" => $_POST["editarRfc"],
							   "colonia"=>$_POST["editarColonia"],
							   "razon_social" => $_POST["editarRazonSocial"],
							   "cp" => $_POST["editarCP"],
							   "municipio" => $_POST["editarMunicio"],
							   "entidad" => $_POST["editarEntidad"]);

			   	$respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El doctor ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "clientes";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El doctor no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "clientes";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/

	static public function ctrEliminarCliente(){

		if(isset($_GET["idCliente"])){

			$tabla ="clientes";
			$datos = $_GET["idCliente"];

			$respuesta = ModeloClientes::mdlEliminarCliente($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El doctor ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result){
								if (result.value){
								window.location = "clientes";

								}
							})

				</script>';

			}		

		}

	}

}

