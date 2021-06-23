/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/

// $.ajax({

// 	url: "ajax/datatable-ventas.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })// 
/*=============================================
CAMBIO DE STATUS
=============================================

$('.tablaVentas').DataTable( {
    "ajax": "ajax/datatable-corte-caja.ajax.php",
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

	}

} );*/

/*=============================================
RANGO DE FECHAS
=============================================*/

$('#daterange-btnCorteCaja').daterangepicker(
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
	  $('#daterange-btnCorteCaja span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  
	  var fechaInicial = start.format('YYYY-MM-DD');
  
	  var fechaFinal = end.format('YYYY-MM-DD');
  
	  var capturarRango3 = $("#daterange-btnCorteCaja span").html();
	 
		 localStorage.setItem("capturarRango3", capturarRango3);
  
		 window.location = "index.php?ruta=corte-caja&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  
	}
  
  )
  
  /*=============================================
  CANCELAR RANGO DE FECHAS
  =============================================*/
  
  $(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){
  
	  localStorage.removeItem("capturarRango3");
	  localStorage.clear();
	  window.location = "ventas";
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
  
		  localStorage.setItem("capturarRango3", "Hoy");
  
		  window.location = "index.php?ruta=corte-caja&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  
	  }
  
  })

  /*=============================================

IMPRIMIR MODAL BALANCE DÍA

=============================================*/



document.getElementById("btnPrint").onclick = function () {

    printElement(document.getElementById("printThis"));

}



function printElement(elem) {

    var domClone = elem.cloneNode(true);

    

    var $printSection = document.getElementById("printSection");

    

    if (!$printSection) {

        var $printSection = document.createElement("div");

        $printSection.id = "printSection";

        document.body.appendChild($printSection);

    }

    

    $printSection.innerHTML = "";

    $printSection.appendChild(domClone);

    window.print();

}



/*=============================================

IMPRIMIR MODAL BALANCE HISTORICO

=============================================*/



document.getElementById("btnPrintHistorico").onclick = function () {

    printElement(document.getElementById("printThisHistorico"));

}



function printElement(elem) {

    var domClone = elem.cloneNode(true);

    

    var $printSection = document.getElementById("printSection");

    

    if (!$printSection) {

        var $printSection = document.createElement("div");

        $printSection.id = "printSection";

        document.body.appendChild($printSection);

    }

    

    $printSection.innerHTML = "";

    $printSection.appendChild(domClone);

    window.print();

}



/*=============================================

MOSTRAR DETALLES CORTE CAJA

=============================================*/

$(".tablas").on("click", ".btnDetallesCorteCaja", function(){



	//Obtenemos los valores a través del atributo

	var id_corte = $(this).attr("id_corte");

	var fecha = $(this).attr("fecha");



	//Dividimos la cadena de la fecha para quitar la hora

	var fechaSinHora = fecha.split(" ");

	

	var datos = new FormData();

	datos.append("id_corte", id_corte);

	datos.append("fecha", fechaSinHora[0]);



	$.ajax({



		url:"ajax/corte-caja.ajax.php",

		method:"POST",

		data: datos,

		cache: false,

		contentType: false,

		processData: false,

		dataType: "html",

		success: function(respuesta){



			console.log(respuesta);



			$("#responsecontainer").html(respuesta);



		}



	});



})
  
/*=============================================
MOSTRAR U OCULTAR MODALES CAJA NOOOOO BOOORRAAAAARR!!!
=============================================

$(".botones").on("click", ".inicioCaja", function(){

	$("#egresoEfectivo").remove();
	$("#cierreCaja").remove();
	$("#usuario").parent().after('<input type="hidden" id="inicioCaja" value="1">');

});
$(".botones").on("click", ".egresoEfectivo", function(){

	$("#inicioCaja").remove();
	$("#cierreCaja").remove();
	$("#usuario").parent().after('<input type="hidden" id="egresoEfectivo" value="2">');

});
$(".botones").on("click", ".cierreCaja", function(){

	$("#inicioCaja").remove();
	$("#egresoEfectivo").remove();
    $("#usuario").parent().after('<input type="hidden" id="cierreCaja" value="3">');

});

/*=============================================
LOGIN PERMISOS CAJA
=============================================

$(".accesos").on("click", ".btnAccesosCorteCaja", function(){

	var usuario = $('#usuario').val();  
	var contrasena = $('#contrasena').val(); 
	var inicioCaja = $('#inicioCaja').val();
	var egresoEfectivo = $('#egresoEfectivo').val();
	var cierreCaja = $('#cierreCaja').val();

	if(usuario != '' && contrasena != '')  
	{  
	    $.ajax({  
	         url:"ajax/loginCaja.ajax.php",  
	         method:"POST",  
	         data: {usuario:usuario, contrasena:contrasena},  
	         success:function(data)  
	         {  
	              if(data == 'No')  
	              {  
               			$("#contrasena").parent().after('<div class="alert alert-danger text-center" id="divAlertError">Error al ingresar, vuelve a intentarlo</div>'); 

						$("#contrasena").val("");

						$("#divAlertError").hide(5000, function() {

							$("#divAlertError").remove();
						}); 
	              }else if(data == 'permisos'){   

	              		$("#contrasena").parent().after('<div class="alert alert-danger text-center" id="divAlertNoAdmin">No tienes permisos para ingresar, sólo administrador!</div>'); 

						$("#contrasena").val("");

						$("#divAlertNoAdmin").hide(5000, function() {

							$("#divAlertNoAdmin").remove();
						}); 

	              	
	              }else{

						if (inicioCaja == 1) {

							//Esconder modal de accesos.	
							$('#loginModal').modal('hide');
							$('#modalCierreCaja').modal('hide');
							$('#modalEgresoCaja').modal('hide');
							$("#usuario").val("");
							$("#contrasena").val("");

							//Mostrar modal de monto inicio de caja.   
							$('#montoInicioModal').modal('show');
						}
						if (egresoEfectivo == 2) {

							//Esconder modal de accesos.	
							$('#loginModal').modal('hide');
							$('#montoInicioModal').modal('hide');
							$('#modalCierreCaja').modal('hide');
							$("#usuario").val("");
							$("#contrasena").val("");

							//Mostrar modal de monto egreso de caja.   
							$('#modalEgresoCaja').modal('show');
						}

						if (cierreCaja == 3) {

							//Esconder modal de accesos.	
							$('#loginModal').modal('hide');
							$('#montoInicioModal').modal('hide');
							$('#modalEgresoCaja').modal('hide');
							$("#usuario").val("");
							$("#contrasena").val("");

							//Mostrar modal de cierre de caja.   
							$('#modalCierreCaja').modal('show');
						}
	              }
	         }  
	    });  
	}  
	else  
	{  
	    $("#contrasena").parent().after('<div class="alert alert-danger text-center" id="divAlert">Ingrese, usuario y contraseña</div>'); 

	    $("#contrasena").val("");

		$("#divAlert").hide(6000, function() {

			$("#divAlert").remove();
	  	});
	}  

})*/