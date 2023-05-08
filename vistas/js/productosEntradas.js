
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