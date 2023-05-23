 /*---------------------------------------
            EDITAR PERFIL
    ---------------------------------------- */

    $(".btnEditarPerfil").click(function(){
        
    
        let idPerfil = $(this).attr("idPerfil");
        
        let datos = new FormData();
        datos.append("idPerfil",idPerfil);
        $.ajax({
            url:"ajax/perfil.ajax.php",
            method:"POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(respuesta){      
                 $("#editarPerfil").val(respuesta["perfil"]);
                 $("#idPerfil").val(respuesta["id_perfil"]);
    
    
    
            }
        })
    })
    
    /*---------------------------------------
                ELIMINAR Perfil
        ---------------------------------------- */
    
     $(".btnEliminarPerfil").click(function(){
        
         let idPerfil = $(this).attr("idPerfil");
         
         swal({
             title:"¿ Está seguro que desea borrar el perfil de Usuario ?",
             text:"! Si no esta seguro puede cancelar la acción ¡",
             type: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             cancelButtonText: 'Cancelar',
             confirmButtonText: 'Si, borrar usuario'
         }).then(function(result){
             if(result.value){
                 window.location = "index.php?ruta=perfil&idPerfil="+idPerfil;
             }
         })
     })