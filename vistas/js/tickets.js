/*=============================================
EDITAR TICKET
=============================================*/
$(".tablas").on("click", ".btnEditarTickets", function(){

	var idTicket = $(this).attr("idTicket");

	var datos = new FormData();
	datos.append("idTicket", idTicket);

	$.ajax({
		url: "ajax/tickets.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){

     		alert(respuesta["nombre"]);

     		$("#editarTitulo").val(respuesta["titulo"]);
     		$("#editarFolio").val(respuesta["folio"]);
     		$("#editarAsunto").val(respuesta["asunto"]);
     		$("#editarPrioridad").val(respuesta[10]);
     		$("#editarDescripcion").val(respuesta["descripcion"]);

     	}

	})

})

/*=============================================
ELIMINAR TICKET
=============================================*/
$(".tablas").on("click", ".btnEliminarTickets", function(){

	 var idTicket = $(this).attr("idTicket");

	 swal({
	 	title: '¿Está seguro de borrar el ticket?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar ticket!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = "index.php?ruta=tickets&idTicket="+idTicket;

	 	}

	 })

})