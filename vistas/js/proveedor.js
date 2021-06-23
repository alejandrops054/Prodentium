/*=============================================
EDITAR PERFILES
=============================================*/
$(".tablas").on("click", ".btnEditarProveedor", function(){

	var idProveedor = $(this).attr("idProveedor");
	
	var datos = new FormData();
	datos.append("idProveedor", idProveedor);

	$.ajax({
		url:"ajax/proveedor.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			$("#idProveedor").val(["id"]);
			$("#editarEmpresa").val(respuesta["empresa"]);
			$("#editarProveedo").val(respuesta["nombre"]);
			$("#editarCorreo").val(respuesta["correo"]);
			$("#editarTelefono").val(respuesta["telefono"]);
			$("#editarDescripcion").val(respuesta["descripcion"]);
		}
	});
})
/*=============================================
REVISAR SI EL PROVEEDOR YA ESTÁ REGISTRADO
=============================================*/
$("#nuevaEmpresa").change(function(){

	$(".alert").remove();
	var empresa = $(this).val();
	var datos = new FormData();

	datos.append("validarProveedor", empresa);

	 $.ajax({
	    url:"ajax/proveedor.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){
	    		$("#nuevaEmpresa").parent().after('<div class="alert alert-warning">Este proveedor ya existe en la base de datos</div>');
	    		$("#nuevaEmpresa").val("");
	    	}
	    }

	})
})

/*=============================================
ELIMINAR PROVEEDOR
=============================================*/
$(".tablas").on("click", ".btnEliminarProveedor", function(){

    var idProveedor = $(this).attr("idProveedor");

    swal({
        title: '¿Está seguro de borrar el proveedor?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar proveedor!'
    }).then(function(result){

        if(result.value){

            window.location = "index.php?ruta=proveedor&idProveedor="+idProveedor;

        }

    })

})
