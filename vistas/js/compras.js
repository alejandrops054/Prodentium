
/*=============================================
CAMBIAR ESADO PAGO
=============================================*/
/*
$(".tablas").on("click", ".btnEstado", function(){

	var idCompras = $(this).attr("idCompras");
	var estadoCompras = $(this).attr("estadoCompras");

	var datos = new FormData();
    datos.append("activarId", idCompras);
    datos.append("activarCompras", estadoCompras);

  	$.ajax({
	  url:"ajax/compras.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

      		if(window.matchMedia("(max-width:767px)").matches){

	      		 swal({
			      title: "El estado ha sido actualizado",
			      type: "success",
			      confirmButtonText: "¡Cerrar!"
			    }).then(function(result) {
			        if (result.value) {
			        	window.location = "compras";
			        }
				});
	      	}
      }
  	})

  	if(estadoCompras == 0){

  		$(this).removeClass('btn-warning');
  		$(this).addClass('btn-danger');
  		$(this).html('Pendiente');
        $(this).attr('estadoCompras',1);
        window.location = "compras";
  	}else{

  		$(this).addClass('btn-success');
  		$(this).removeClass('btn-danger');
  		$(this).html('Pagado');
        $(this).attr('estadoCompras',0);
        window.location = "compras";
  	}
})
*/

//validamos que no se duplica
$("#nuevaDescripcion").change(function(){

	$(".alert").remove();
	var descripcion = $(this).val();
	var datos = new FormData();

	datos.append("validarCompras", descripcion);

	 $.ajax({
	    url:"ajax/compras.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){
				
	    		$("#nuevaDescripcion").parent().after('<div class="alert alert-warning">Este gasto ya fue registrado ya existe en la base de datos</div>');
	    		$("#nuevaDescripcion").val("");
	    	}
	    }

	})
})

/*=============================================
EDITAR COMPRA
=============================================*/
$(".tablas").on("click", ".btnEditarCompras", function(){

	var idCompras = $(this).attr("idCompras");
	
	var datos = new FormData();
	datos.append("idCompras", idCompras);

	$.ajax({

		url:"ajax/compras.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			$("#idCompras").val(respuesta["id"]);
			$("#editarSeleccionarProveedor").val(respuesta["id_proveedor"]);
			$("#editarDescripcion").val(respuesta["descripcion"]);
			$("#editarGasto").val(respuesta["gasto"]);
		}
	});
})

if(localStorage.getItem("ReporteGasto") != null){

	$("#gasto-btn span").html(localStorage.getItem("ReporteGasto"));


}else{

	$("#gasto-btn span").html('<i class="fa fa-calendar"></i> Rango de fecha')

}
/*=============================================
RANGO DE FECHAS
=============================================*/

$('#gasto-btn').daterangepicker(
	{
	  ranges   : {
		'Hoy'       : [moment(), moment()],
		'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
		'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
		'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
		'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	  },
	  startDate: moment(),
	  endDate  : moment()
	},
	function (start, end) {
	  $('#gasto-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  
	  var fechaInicial = start.format('YYYY-MM-DD');
  
	  var fechaFinal = end.format('YYYY-MM-DD');
  
	  var ReporteGasto = $("#gasto-btn span").html();
	 
		 localStorage.setItem("ReporteGasto", ReporteGasto);
  
		 window.location = "index.php?ruta=compras&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  
	}
  
  )
  
  /*=============================================
  CANCELAR RANGO DE FECHAS
  =============================================*/
  
  $(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){
  
	  localStorage.removeItem("ReporteGasto");
	  localStorage.clear();
	  window.location = "compras";
  })
  
  /*=============================================
  CAPTURAR HOY
  =============================================*/
  
  $(".daterangepicker.opensleft .ranges li").on("click", function(){
  
	  var textoHoy = $(this).attr("data-range-key");
  
	  if(textoHoy == "Hoy"){
  
		  var d = new Date();
		  
		  var dia = d.getDate();
		  var mes = d.getMonth()+1;
		  var año = d.getFullYear();
  
		  // if(mes < 10){
  
		  // 	var fechaInicial = año+"-0"+mes+"-"+dia;
		  // 	var fechaFinal = año+"-0"+mes+"-"+dia;
  
		  // }else if(dia < 10){
  
		  // 	var fechaInicial = año+"-"+mes+"-0"+dia;
		  // 	var fechaFinal = año+"-"+mes+"-0"+dia;
  
		  // }else if(mes < 10 && dia < 10){
  
		  // 	var fechaInicial = año+"-0"+mes+"-0"+dia;
		  // 	var fechaFinal = año+"-0"+mes+"-0"+dia;
  
		  // }else{
  
		  // 	var fechaInicial = año+"-"+mes+"-"+dia;
	   //    	var fechaFinal = año+"-"+mes+"-"+dia;
  
		  // }
  
		  dia = ("0"+dia).slice(-2);
		  mes = ("0"+mes).slice(-2);
  
		  var fechaInicial = año+"-"+mes+"-"+dia;
		  var fechaFinal = año+"-"+mes+"-"+dia;	
  
		  localStorage.setItem("ReporteGasto", "Hoy");
  
		  window.location = "index.php?ruta=compras&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  
	  }
  
  })

//Eliminar compra

$(".tablas").on("click", ".btnEliminarCompra", function(){

	var idCompras = $(this).attr("idCompras");
	
	swal({
        title: '¿Está seguro de borrar el gasto?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar gasto!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=compras&idCompras="+idCompras;
        }

  })

})