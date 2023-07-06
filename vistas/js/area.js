/*---------------------------------------
            EDITAR AREA
    ---------------------------------------- */
    $(".tablas").on("click", ".btnEditarArea",function(){
    
        
    
        let idArea = $(this).attr("idArea");
        
        let datos = new FormData();
        datos.append("idArea",idArea)
        $.ajax({
            url:"ajax/area.ajax.php",
            method:"POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success:function(respuesta){      
                $("#editarArea").val(respuesta["nombre_area"]);
                $("#idArea").val(respuesta["id_area"]);
                
                 
    
    
    
            }
        })
    })


    /*---------------------------------------
            ELIMINAR AREA
    ---------------------------------------- */
    $(".tablas").on("click", ".btnEliminarArea",function(){

    let idArea = $(this).attr("idArea");
    swal({
        title:"¿ Está seguro que desea borrar el area ?",
        text:"! Si no esta seguro puede cancelar la acción ¡",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar Area'
    }).then(function(result){
        if(result.value){
            window.location = "index.php?ruta=area&idArea="+idArea;
        }
    })
})
