/*=============================================
EDITAR HISTORIAL
=============================================*/
$("tabla").on("click", "btnEditarHistorial", function(){

    var idHistorial =  new FormData();
    datos.append("idHistorial", idHistorial);

    $.ajax({
        url: "ajax/historial.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){

             $("#editarPaciente").val(respuesta["paciente"]);
             $("#editarCobrado").val(respuesta["cobrado"]);
             $("#editarFaltante").val(respuesta["faltante"]);
             $("editarTotal").val(respuesta["total"]);
     		 $("#idHistorial").val(respuesta["id"]);

     	}
    })
})