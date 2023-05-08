 /*---------------------------------------
            EDITAR CATEGORIA
    ---------------------------------------- */

    $(".btnEditarCategoria").click(function(){
    
        let idCategoria = $(this).attr("idCategoria");
        
        let datos = new FormData();
        datos.append("idCategoria",idCategoria);
        $.ajax({
            url:"ajax/categorias.ajax.php",
            method:"POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(respuesta){
                
                $("#editarCategoria").val(respuesta["categoria"]);
                $("#idCategoria").val(respuesta["id_categoria"]);
    
    
    
            }
        })
    })
    
    /*---------------------------------------
            ELIMINAR CATEGORIA
    ---------------------------------------- */

$(".btnEliminarCategoria").click(function(){
    let idCategoria = $(this).attr("idCategoria");
    swal({
        title:"¿ Está seguro que desea borrar la categoría ?",
        text:"! Si no esta seguro puede cancelar la acción ¡",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar usuario'
    }).then(function(result){
        if(result.value){
            window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;
        }
    })
})
