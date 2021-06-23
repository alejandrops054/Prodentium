<?php

class ControladorProveedor{

	//CREAR PROVEEDOR
	static public function ctrCrearProveedor(){

		if(isset($_POST["nuevoProveedo"])){

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoProveedo"]) &&
               preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["nuevoEmail"])){

				$tabla = "proveedor";

				$datos = array("empresa"=>$_POST["nuevaEmpresa"],
								"nombre"=>$_POST["nuevoProveedo"],
								"correo"=>$_POST["nuevoEmail"],
								"telefono"=>$_POST["nuevoTelefono"],
								"descripcion"=>$_POST["nuevaDescripcion"]);
                

				$respuesta = ModeloProveedor::mdlIngresarProveedor($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>	

					swal({
						  type: "success",
						  title: "El proveedor se ha guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "proveedor";
									}
								})
					</script>';
				}

			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El proveedor no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "proveedor";

							}
						})
			  	</script>';

			}

		}
	}

	//CREAR PROVEEDOR
	static public function ctrCrearProveedorGastos(){

		if(isset($_POST["nuevoProveedo"])){

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoProveedo"]) &&
               preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["nuevoEmail"])){

				$tabla = "proveedor";

				$datos = array("empresa"=>$_POST["nuevaEmpresa"],
								"nombre"=>$_POST["nuevoProveedo"],
								"correo"=>$_POST["nuevoEmail"],
								"telefono"=>$_POST["nuevoTelefono"],
								"descripcion"=>$_POST["nuevaDescripcion"]);
                

				$respuesta = ModeloProveedor::mdlIngresarProveedor($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>	

					swal({
						  type: "success",
						  title: "El proveedor se ha guardado correctamente",
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
						  title: "¡El proveedor no puede ir vacía o llevar caracteres especiales!",
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
	MOSTRAR PROVEEDOR
	=============================================*/

	static public function ctrMostrarProveedor($item, $valor){

		$tabla = "proveedor";

		$respuesta = ModeloProveedor::mdlMostrarProveedor($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR PROVEEDOR
	=============================================*/
	static public function ctrEditarProveedor(){

		if(isset($_POST["editarProveedo"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarProveedo"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["editarCorreo"]) && 
			   preg_match('/^[()\-0-9 ]+$/', $_POST["editarTelefono"])){ 

			   	$tabla = "proveedor";

			   	$datos = array("empresa"=>$_POST["editarEmpresa"],
				   				"nombre"=>$_POST["editarProveedo"],
				   				"correo"=>$_POST["editarCorreo"],
				   				"telefono"=>$_POST["editarTelefono"],
				   				"descripcion"=>$_POST["editarDescripcion"],
				   				"id"=>$_POST["idProveedor"]);
								

			   	$respuesta = ModeloProveedor::mdlEditarProveedor($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El proveedor ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "proveedor";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El proveedor no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "proveedor";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	BORRAR PROVEEDOR
	=============================================*/

	static public function ctrBorrarProveedor(){

		if(isset($_GET["idProveedor"])){

			$tabla = "proveedor";

			$datos = $_GET["idProveedor"];

			$respuesta = ModeloProveedor::mdlBorrarProveedor($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "El proveedor ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "proveedor";

									}
								})

					</script>';
			}
		}
		
	}
}