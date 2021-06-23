
/*=============================================
EDITAR AJUSTES
=============================================*/
$(".tablas").on("click", ".btnEditarEmpresa", function(){

	var idAjustes = $(this).attr("idAjustes");

	var datos = new FormData();
	datos.append("idAjustes", idAjustes);

	$.ajax({
		url: "ajax/ajustes.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){

			 $("#idAjustes").val(respuesta["id"]);
			 $("#editarEmpresa").val(respuesta["empresa"]);
			 $("#editarDireccion").val(respuesta["direccion"]);
			 $("#editarColonia").val(respuesta["colonia"]);
			 $("#editarAlcaldia").val(respuesta["alcaldia"]);
			 $("#editarCp").val(respuesta["cp"]);
			 $("#editarEstado").val(respuesta["estado"]);
			 $("#editarCorreo").val(respuesta["correo"]);
			 $("#editarTelefono").val(respuesta["telefono"]);

     	}

	});


})


