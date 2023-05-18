
/*---------------------------------------
         Captuara elevento delbton regresar
    ---------------------------------------- */
$(".regresarEntradas").click(function(){
    window.location="entradas-almacen";
});


/*---------------------------------------
               Eliminar ProductoEntrada
    ---------------------------------------- */

$(document).on("click",".btnEliminarEntradaProducto",function(){
    let idProducto=$(this).attr("idEntradaProducto");
    let identificador= $(this).attr("ingreso");
    let fecha= $(this).attr("fecha");

    swal({
        title:"¿Estas seguro que desea borrar el producto ?",
        text:"!Si no esta seguro puede cancelar la acción¡",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar'
    }).then(function(result){
        if(result.value){
            window.location="index.php?ruta=productoss&ingreso="+identificador+"&f="+fecha+"&idProducto="+idProducto;
        }
    })
})


/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click",".btnImprimirProductosLoteEntrada", function(){
	
	//Almacenamos en la variable que envia en boton
	var codigoEntradaAlmacen=$(this).attr("codigoEntradaAlmacen");
	//Solicitos a windows que me habra una nueva ventana
	//haciendo la ruta donde esta la extension TCPDF
    
	window.open("extensiones/tcpdf/pdf/ingresoProductosLote.php?codigoIngresoProd="+codigoEntradaAlmacen,"_blank");
})
