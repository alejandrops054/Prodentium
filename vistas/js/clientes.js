/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarCliente", function(){

	var idCliente = $(this).attr("idCliente");

	var datos = new FormData();
    datos.append("idCliente", idCliente);

    $.ajax({

      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      
      	 $("#idCliente").val(respuesta["id"]);
	       $("#editarCliente").val(respuesta["nombre"]);
	       $("#editarRfc").val(respuesta["rfc"]);
	       $("#editarEmail").val(respuesta["email"]);
	       $("#editarTelefono").val(respuesta["telefono"]);
         $("#editarDireccion").val(respuesta["direccion"]);
         $('#editarRazonSocial').val(respuesta["razon_social"]);
         $('#editarCP').val(respuesta["cp"]);
         $('#editarColonia').val(respuesta["colonia"]);
         $('#editarMunicio').val(respuesta["municipio"]);
         $('#editarEntidad').val(respuesta["entidad"]);
         $('#editarpais').val(respuesta["pais"]);
	  }

  	})

})

/*=============================================
REVISAR SI EL CLIENTE YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoCliente" || "#nuevoRfc").change(function(){

	$(".alert").remove();

	var cliente = $(this).val();

	var datos = new FormData();
	datos.append("validarCliente", cliente);

	 $.ajax({
	    url:"ajax/cliente.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

          $("#nuevoCliente").parent().after('<div class="alert alert-warning">Este cliente ya existe en la base de datos</div>');
          $("#nuevoRfc").parent().after('<div class="alert alert-warning">Este cliente ya existe en la base de datos</div>');

          $("#nuevoCliente").val("");
          $("#nuevoRfc").val("");

	    	}
	    }
	})
})

/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarCliente", function(){

	var idCliente = $(this).attr("idCliente");
	
	swal({
        title: '¿Está seguro de borrar el doctor?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar doctor!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=clientes&idCliente="+idCliente;
        }

  })

})