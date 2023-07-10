/*=============================================
Variable localstorage
=============================================*/
if(localStorage.getItem("capturarRango3")!=null){
	$("#daterange-btn3 span").html(localStorage.getItem("capturarRango3"));
}else{
	$("#daterange-btn3 span").html('<i class="fa fa-calendar"></i> Rango de fecha');
}




/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/

//  $.ajax({
    
// 	url: "ajax/datatable-salidas.ajax.php",
//  	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

//  })

//Llena la tabla de salidas con los productos que se tienen de la base de datoss
$('.tablaSalidas').DataTable( {
    "ajax": "ajax/datatable-salidas.ajax.php",
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

} );


/*=============================================
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/
//EVENTO HACER CLICK EN EL BOTON DE AGREGAR PRODUCTO

$(".tablaSalidas tbody").on("click", "button.agregarProducto", function(){
	
    //Almaceno en una variable el valor del id del producto que viene  incrustado en la etiqueta
	var idProducto = $(this).attr("idProducto");
    
	//Remuevo la clase que le da el color azul y le quito la clase agregar producto
	$(this).removeClass("btn-primary agregarProducto");
	//Le agrego a boton la clase default que le asigana un color gris
	$(this).addClass("btn-default");

	var datos = new FormData();
    datos.append("idProducto", idProducto);

     $.ajax({
		//Se le envia por ajax a consultar los datos del producto
     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
			//En la respuesta que nos da la clase ajax  almacenamos en variables
      	    var descripcion = respuesta["descripcion"];
          	var stock = respuesta["stockDisponible"];
          	var precio = respuesta["costo_unitario"];
			  

          	/*=============================================
          	EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
          	=============================================*/
			//Si el stock disponible es 0 no deja agregar el producto mostrando un modal de error
			//y restableciendo el boton
			  if(stock == 0){

				swal({
				title: "No hay stock disponible",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			  	});
				//
			  	$("button[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto");
				//Termina la ejecucion
			  	return;

			}


			$(".nuevoProducto").append(

				'<div class="row activarBoton" style="padding:5px 15px">'+
  
				'<!-- Descripción del producto -->'+
				
				'<div class="col-xs-6" style="padding-right:0px">'+
				
				  '<div class="input-group">'+
					
					'<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
  
					'<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+
  
				  '</div>'+
  
				'</div>'+
  
				'<!-- Cantidad del producto -->'+
  
				'<div class="col-xs-3">'+
				  
				   '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock="'+stock+'" nuevoStock="'+Number(stock-1)+'" required>'+
  
				'</div>' +
  
				'<!-- Precio del producto -->'+
  
				'<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+
  
				  '<div class="input-group">'+
  
					'<span class="input-group-addon"><i class="fa fa-money"></i></span>'+
					   
					'<input type="text" class="form-control nuevoPrecioProducto" precioReal="'+precio+'" name="nuevoPrecioProducto" value="'+precio+'" readonly required>'+
	   
				  '</div>'+
				   
				'</div>'+
  
			  '</div>') 

          	// SUMAR TOTAL DE PRECIOS

	        sumarTotalPrecios()

	        

	        // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductos()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProducto").number(true, 2);
			desbilitarBotonGuardarSalida();

      	}

     })

});





/*======================================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=========================================================*/
//Funcion recomendada cada vez que estemos navegando en una tabla
$(".tablaSalidas").on("draw.dt", function(){
	//Preguntamos si en el localstorage existe el item quitar producto
	if(localStorage.getItem("quitarProducto") != null){
		//Se almacena lo que viene en string en forma de JSON
		var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
		//Rrecorremos el objeto json
		for(var i = 0; i < listaIdProductos.length; i++){
			//Explicando lo que hace esta tabla basicamente modificar todos los clases
			//de los campos que tienen el id almacenado en el array, pero esto genera un error ya que
			// si se agrega  y elimina varios peroductos estos se quedan alcemados en el array
			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');
			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');

		}

		localStorage.removeItem("quitarProducto");


	}


})




/*=============================================
SELECCIONAR PRODUCTO RESPONSIVE VERSION
=============================================*/

/*$(".formularioSalida").on("change", "select.nuevaDescripcionProducto", function(){

	var nombreProducto = $(this).val();

	var nuevaDescripcionProducto = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionProducto");

	var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");

	var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);


	  $.ajax({

     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	     $(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
      	    $(nuevaCantidadProducto).attr("stock", respuesta["stock"]);
      	    $(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["stock"])-1);
      	    $(nuevoPrecioProducto).val(respuesta["precio_venta"]);
      	    $(nuevoPrecioProducto).attr("precioReal", respuesta["precio_venta"]);

  	      // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductos()

      	}

      })
})*/



/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioSalida").on("change", "input.nuevaCantidadProducto", function(){
	//OBTENEMOS EL VALOR DEL CAMPO DE PRECIO QUE VIENE YA EN EL CAMPO
	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
	desbilitarBotonGuardarSalida();
	//Almacenamos el valor del total(cantidad*precio)
	//De esta estiqueta obtenermos el valor * y utilizamos el parametro incrustado en la etuqeta desde la base de datos
	var precioFinal = $(this).val() * precio.attr("precioreal");
	//Enviamos el valor al campo del precio final del producto
	precio.val(precioFinal);
	//En la variable que viene de de stock incrustado en la etiqueta se le resta lo que el usuario solicita
	var nuevoStock = Number($(this).attr("stock")) - $(this).val();
	//Se actualiza el atributo incrustado con el stock restante de lo solicitado
	$(this).attr("nuevoStock", nuevoStock);

	//Parseamos los datos a numericos
	if(Number($(this).val()) > Number($(this).attr("stock"))){

		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/
		//El valor del campo cantidad lo regresa a 1
		$(this).val(1);
		//El valor de la suma del stock por el precio lo restaura como si se solicitara 1 unidad
		var precioFinal = $(this).val() * precio.attr("precioReal");
		//Restablece el stock
		precio.val(precioFinal);
		var nuevoStock = Number($(this).attr("stock")) - 1;
		$(this).attr("nuevoStock", nuevoStock);
		sumarTotalPrecios();

		swal({
	      title: "La cantidad supera el Stock",
	      text: "¡Sólo hay "+$(this).attr("stock")+" unidades!",
	      type: "error",
	      confirmButtonText: "¡Cerrar!"
	    });

		//Termina la ejecución
	    return;

	}

	// SUMAR TOTAL DE PRECIOS

	sumarTotalPrecios()

	

    // AGRUPAR PRODUCTOS EN FORMATO JSON

    listarProductos()

})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPrecios(){
	
	//Obtiene el valor del precio del producto
	var precioItem = $(".nuevoPrecioProducto");
	var arraySumaPrecio = [];  

	for(var i = 0; i < precioItem.length; i++){
		 //Almacena los valores del los presicion de los productos
		 arraySumaPrecio.push(Number($(precioItem[i]).val()));
		 
	}

	function sumaArrayPrecios(total, numero){

		return total + numero;

	}
	//Suma todos los valores del arreglo
	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	
	//Muestra el resultado total en el campo 
	$("#nuevoTotalVenta").val(sumaTotalPrecio);
	//Muestra el valor de la multiplicacion del producto*cantiadSolicitada
	$("#totalVenta").val(sumaTotalPrecio);
	//Añadimos un parametro a la etiqueta con el valor total del pedido
	$("#nuevoTotalVenta").attr("total",sumaTotalPrecio);


};

/*=========================================================================================
	DETECTA CUANDO SE LE HACE UNA CAMBIO AL SELECT Y OBTIENE SU VALOR PARA AGREGARLO AL JSON
============================================================================================*/
$(".formularioSalida").on("change", "select#seleccionarSolicitante", function(){
	
	var area = $('#seleccionarSolicitante>option:selected').attr("areaPerteneciente");
	var idSol = $('#seleccionarSolicitante>option:selected').val();
	$("#idJaladoSolicitante").val(idSol);
	$("#areaSolicitante").val(area);
	//$(".agregarProducto").removeAttr('disabled');
	//	$("#seleccionarSolicitante").attr('disabled','disabled');
	

});



/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductos(){
	
	
	
	var listaProductos = [];
	
	var descripcion = $(".nuevaDescripcionProducto");

	
	var cantidad = $(".nuevaCantidadProducto");

	var precio = $(".nuevoPrecioProducto");

	for(var i = 0; i < descripcion.length; i++){
		
		listaProductos.push({ "id_salida" : $("input#nuevaSalida").val(), 
								"id" : $(descripcion[i]).attr("idProducto"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
							  "stockDisponible" : $(cantidad[i]).attr("nuevoStock"),
							  "precio" : $(precio[i]).attr("precioReal"),
							  "total" : $(precio[i]).val()})

	}

	$("#listaProductos").val(JSON.stringify(listaProductos)); 

}


/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/

//Definiendo la varialble de array quitar Producto
var idQuitarProducto = [];

//Elimina el item quitarProducto cada vez que se recargue la pagina
localStorage.removeItem("quitarProducto");

$(".formularioSalida").on("click", "button.quitarProducto", function(){

	$(this).parent().parent().parent().parent().remove();
	
	var idProducto = $(this).attr("idProducto");

	/*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
	=============================================*/
	//Si la variable en el local storage no existe o no tiene info
	if(localStorage.getItem("quitarProducto") == null){

		idQuitarProducto = [];
	
	}else{
		//Si la variable viene con informacion se le concatena lo que viene
		//del local storage en el item quitarProducto
		idQuitarProducto.concat(localStorage.getItem("quitarProducto"))

	}
	//Se le añade la propiedad idProducto y se le asigna el valor que pasa el boton de agregar con el id del producto
	idQuitarProducto.push({"idProducto":idProducto});
	//Almacenamos en el localstorage en la
	//variable quitarProducto adjuntadole el array en dato json convertido en string
	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

	$("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');
	desbilitarBotonGuardarSalida();

	$("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');
	//Si no exixten hijos, en el sistema seria que si no se han seleccionado productos
	if($(".nuevoProducto").children().length == 0){

		$("#nuevoImpuestoVenta").val(0);
		$("#nuevoTotalVenta").val(0);
		$("#totalVenta").val(0);
		$("#nuevoTotalVenta").attr("total",0);

	}else{

		// SUMAR TOTAL DE PRECIOS

    	sumarTotalPrecios()

    	// AGREGAR IMPUESTO
	        
        //	agregarImpuesto()

        // AGRUPAR PRODUCTOS EN FORMATO JSON

        listarProductos()
		
	} 
	


})

/*=============================================
BOTON EDITAR SALIDA
=============================================*/
$(".tablas").on("click", ".btnEditarSalida", function(){

	var idSalida = $(this).attr("idSalida");
	
	window.location = "index.php?ruta=editar-salida&idSalida="+idSalida;
	


})

/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/
//esta funcion sirve cuando editamos la tabla, bloquea los botones de los productos ya seleccionados
function quitarAgregarProducto(){

	//Capturamos todos los id de productos que fueron elegidos en la venta
	var idProductos = $(".quitarProducto");

	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaSalidas tbody button.agregarProducto");

	//Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
	for(var i = 0; i < idProductos.length; i++){

		//Capturamos los Id de los productos agregados a la venta
		var boton = $(idProductos[i]).attr("idProducto");
		
		//Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
		for(var j = 0; j < botonesTabla.length; j ++){

			if($(botonesTabla[j]).attr("idProducto") == boton){

				$(botonesTabla[j]).removeClass("btn-primary agregarProducto");
				$(botonesTabla[j]).addClass("btn-default");

			}
		}

	}
	
}

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaSalidas').on( 'draw.dt', function(){

	quitarAgregarProducto();

})




/*=========================================================================
MOSTRAR PRODUCTOS DE LA VENTA EN MODAL
===========================================================================*/
$(".tablas").on("click", ".btnVisualizarSalida", function(){

		let idSalida = $(this).attr("idSalida");
        //console.log(idSalida);
        let datos = new FormData();
        datos.append("idSalida",idSalida);
        $.ajax({
            url:"ajax/salida.ajax.php",
            method:"POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(respuesta){      
				//console.log(respuesta["productos"]);
				$(".visualizarTemporal").remove();
				$(".tituloModalVisualizar").text("");
				
				
				var productos=  JSON.parse(respuesta["productos"]);
				var filas='';
				$(".tituloModalVisualizar").append("Código Salida: "+respuesta["codigo_salida"] );
                for (let index = 0; index < productos.length; index++) {
					//const element = array[index];
					//console.log(respuesta["productos"]["id"]);
					
					filas=filas+"<tr class='visualizarTemporal'><td>"+productos[index]["id"]+"</td><td>"+productos[index]["descripcion"]+"</td><td>"+productos[index]["cantidad"]+"</td><td>"+productos[index]["precio"]+"</td></tr>";
					
				}
				$("#visualizarProd").append(filas);
				 
    
    
    
            }
        })


})


/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click",".btnImprimirFactura", function(){
	
	//Almacenamos en la variable que envia en boton
	var codigoSalida=$(this).attr("codigoSalida");
	//Solicitos a windows que me habra una nueva ventana
	//haciendo la ruta donde esta la extension TCPDF
	window.open("extensiones/tcpdf/pdf/factura.php?codigo="+codigoSalida,"_blank");
})
/*=============================================
DESABILITAR BOTON DE GUARDAR SALIDA SI NO SE ENCUENTRA NINGUN SELECCIONADO
=============================================*/
var comrobar;
//console.log(comrobar);
function desbilitarBotonGuardarSalida(){
	comrobar=$(".activarBoton").length;
	
	if(comrobar>0){
		
		$(".botonGuardarSalida").removeAttr('disabled');
	
	}else if(comrobar==0){
		//console.log("iu");
		$(".botonGuardarSalida").attr('disabled','disabled');
	}
}
/*=============================================
BOTON DE REGRESAR DEL MENU DE EDITAR PEDIDO
=============================================*/

$(".regresarSalidas").click(function(){
    window.location="salidas";
});








/*=============================================
RANGO DE FECHAS
=============================================*/

$('#daterange-btn3').daterangepicker(
	
	{
		
		buttonClasses:'btn btn-sm btnSa',
	  ranges   : {
		'Hoy1'       : [moment(), moment()],
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
	  $('#daterange-btn3 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  
	  var fechaInicial = start.format('YYYY-MM-DD');
  
	  var fechaFinal = end.format('YYYY-MM-DD');
  
	  var capturarRango3 = $("#daterange-btn3 span").html();
	 
		 localStorage.setItem("capturarRango3", capturarRango3);
  
		 window.location = "index.php?ruta=salidas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  
	}
  
  )
  
  /*=============================================
  CANCELAR RANGO DE FECHAS
  =============================================*/
  
  $(".daterangepicker.opensright .range_inputs .btnSa").on("click", function(){
  
	  localStorage.removeItem("capturarRango3");
	  localStorage.clear();
	  
	  window.location = "salidas";
  })
  
  /*=============================================
  CAPTURAR HOY
  =============================================*/
  
  $(".daterangepicker.opensright .ranges li").on("click", function(){
  
	  var textoHoy = $(this).attr("data-range-key");
  
	  if(textoHoy == "Hoy1"){
  
		  var d = new Date();
		  
		  var dia = d.getDate();
		  var mes = d.getMonth()+1;
		  var año = d.getFullYear();
  
		  if(mes < 10){
  
			  var fechaInicial = año+"-0"+mes+"-"+dia;
			  var fechaFinal = año+"-0"+mes+"-"+dia;
  
		  }else if(dia < 10){
  
			  var fechaInicial = año+"-"+mes+"-0"+dia;
			  var fechaFinal = año+"-"+mes+"-0"+dia;
  
		  }else if(mes < 10 && dia < 10){
  
			  var fechaInicial = año+"-0"+mes+"-0"+dia;
			  var fechaFinal = año+"-0"+mes+"-0"+dia;
  
		  }else{
  
			  var fechaInicial = año+"-"+mes+"-"+dia;
			  var fechaFinal = año+"-"+mes+"-"+dia;
  
		  }	
  
		  localStorage.setItem("capturarRango3", "Hoy1");
  
		  window.location = "index.php?ruta=salidas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  
	  }
  
  })