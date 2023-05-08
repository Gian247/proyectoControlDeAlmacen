/*=============================================
Variable localstorage
=============================================*/
if(localStorage.getItem("capturarRango")!=null){
	$("#daterange-btn span").html(localStorage.getItem("capturarRango"));
}else{
	$("#daterange-btn span").html('<i class="fa fa-calendar"></i> Rango de fecha');
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

$(".tablaSalidas tbody").on("click", "button.agregarProducto", function(){
    
	var idProducto = $(this).attr("idProducto");
    

	$(this).removeClass("btn-primary agregarProducto");

	$(this).addClass("btn-default");

	var datos = new FormData();
    datos.append("idProducto", idProducto);

     $.ajax({
     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
			
      	    var descripcion = respuesta["descripcion"];
          	var stock = respuesta["stock"];
          	var precio = respuesta["costo_unitario"];
			  

          	/*=============================================
          	EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
          	=============================================*/

			  if(stock == 0){

				swal({
				title: "No hay stock disponible",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			  });

			  $("button[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto");

			  return;

			}
			$(".nuevoProducto").append(

				'<div class="row" style="padding:5px 15px">'+
  
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

	        // AGREGAR IMPUESTO

	        agregarImpuesto()

	        // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductos()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProducto").number(true, 2);

      	}

     })

});



/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/
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
SELECCIONAR PRODUCTO
=============================================*/

$(".formularioSalida").on("change", "select.nuevaDescripcionProducto", function(){

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
})



/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioSalida").on("change", "input.nuevaCantidadProducto", function(){

	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var precioFinal = $(this).val() * precio.attr("precioReal");
	
	precio.val(precioFinal);

	var nuevoStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("nuevoStock", nuevoStock);

	if(Number($(this).val()) > Number($(this).attr("stock"))){

		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/
		//El valor del campo stock lo regresa a 1
		$(this).val(1);
		//El valor de la suma del stock por el precio lo restaura como si se solicitara 1 unidad
		var precioFinal = $(this).val() * precio.attr("precioReal");
		
		precio.val(precioFinal);

		sumarTotalPrecios();

		swal({
	      title: "La cantidad supera el Stock",
	      text: "¡Sólo hay "+$(this).attr("stock")+" unidades!",
	      type: "error",
	      confirmButtonText: "¡Cerrar!"
	    });

	    return;

	}

	// SUMAR TOTAL DE PRECIOS

	sumarTotalPrecios()

	// AGREGAR IMPUESTO
	        
    agregarImpuesto()

    // AGRUPAR PRODUCTOS EN FORMATO JSON

    listarProductos()

})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPrecios(){
	

	var precioItem = $(".nuevoPrecioProducto");
	var arraySumaPrecio = [];  

	for(var i = 0; i < precioItem.length; i++){

		 arraySumaPrecio.push(Number($(precioItem[i]).val()));
		 
	}

	function sumaArrayPrecios(total, numero){

		return total + numero;

	}

	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	
	
	$("#nuevoTotalVenta").val(sumaTotalPrecio);
	$("#totalVenta").val(sumaTotalPrecio);
	$("#nuevoTotalVenta").attr("total",sumaTotalPrecio);


};



/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductos(){
	

	var listaProductos = [];

	var descripcion = $(".nuevaDescripcionProducto");

	var cantidad = $(".nuevaCantidadProducto");

	var precio = $(".nuevoPrecioProducto");

	for(var i = 0; i < descripcion.length; i++){

		listaProductos.push({ "id" : $(descripcion[i]).attr("idProducto"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
							  "stock" : $(cantidad[i]).attr("nuevoStock"),
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
	        
        agregarImpuesto()

        // AGRUPAR PRODUCTOS EN FORMATO JSON

        listarProductos()

	} 
	


})


/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/

function quitarAgregarProducto(){

	//Capturamos todos los id de productos que fueron elegidos en la venta
	var idProductos = $(".quitarProducto");

	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaVentas tbody button.agregarProducto");

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