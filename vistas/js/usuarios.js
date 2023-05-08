/*-------------------------------
    SUBIENDO LA FOTO DEL USUARIO
--------------------------------- */
$(".nuevaFoto").change(function(){
    var imagen=this.files[0];

    /*---------------------------------------
        VALIDANDO EL FORMATO DE LA IMAGEN 
                    (JPG O PNG)
    ---------------------------------------- */
    if(imagen["type"]!="image/jpeg" && imagen["type"]!="image/png"){
        $(".nuevaFoto").val("");
        swal({
            title:"Error al subir la imagen",
            text:"!La imagen debe estar en formato JPG o PNG",
            confirmButtonText:"!Cerrar!"
        });
    }else if(imagen["size"]>2000000){
        $(".nuevaFoto").val("");
        swal({
            title:"Error al subir la imagen",
            text:"!La imagen no debe pesar mas de 2 MB!",
            confirmButtonText:"!Cerrar!"
        });
    }else{
        var datosImagen=new FileReader;
        datosImagen.readAsDataURL(imagen);
        $(datosImagen).on("load",function(event){
            var rutaImagen=event.target.result;
            $(".previsualizar").attr("src",rutaImagen);
        });
    }



})

/*---------------------------------------
                EDITAR USUARIO
    ---------------------------------------- */
$(document).on("click",".btnEditarUsuario",function(){
    var idUsuario=$(this).attr("idUsuario");
    
    var datos = new FormData();
    
    datos.append("idUsuario",idUsuario);
    
    $.ajax({

		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data:datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
    
		success: function(respuesta){
            
            console.log(respuesta);
            
             $("#editarNombre").val(respuesta["nombres"]);
             $("#editarApellido").val(respuesta["apellidos"]);
             $("#editarCorreo").val(respuesta["correo"]);
			 $("#editarUsuario").val(respuesta["user"]);
			 $("#editarPerfil").html(respuesta["id_perfil"]);
             $("#editarPerfil").val(respuesta["id_perfil"]);
             $("#passwordActual").val(respuesta["contra"]);

             $("#fotoActual").val(respuesta["foto"]);

             //Validamos si la foto viene vacia
             if(respuesta["foto"]!=""){
                 //Insertamos al elemento con la clase previasualizar la foto que viene de la base de datos
                 $(".previsualizar").attr("src",respuesta["foto"]);
             }


        }

    });
   
})

/*---------------------------------------
                ACTIVAR USUARIO
    ---------------------------------------- */

    $(document).on("click",".btnActivar",function(){
    
        var idUsuario = $(this).attr("idUsuario");
        var estadoUsuario = $(this).attr("estadoUsuario");
        console.log(idUsuario);
        console.log(estadoUsuario);

        var datos = new FormData();
        datos.append("activarId", idUsuario);
        datos.append("activarUsuario", estadoUsuario);

        $.ajax({

            url:"ajax/usuarios.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function(respuesta){
                if(window.matchMedia("(max-width:767px)").matches){
                    swal({
                        title:"El usuario ha sido actualizado",
                        type: 'success',
                        
                        confirmButtonText: 'Cerrar'
                    }).then(function(result){
                        if(result.value){
                            window.location="usuarios";
                        }
                    });

                }
            }
        })
        if(estadoUsuario==0){
            $(this).removeClass('btn-success');
            $(this).addClass('btn-danger');
            $(this).html('Desactivado');
            $(this).attr('estadoUsuario',1);
        }else{
            $(this).removeClass('btn-danger');
            $(this).addClass('btn-success');
            $(this).html('Activado');
            $(this).attr('estadoUsuario',0);
        }


    })

    /*---------------------------------------
                Revisar usuario registrido
    ---------------------------------------- */

    $("#nuevoUsuario").change(function(){

        $(".alert").remove();
    
        var usuario = $(this).val();
    
        var datos = new FormData();
        datos.append("validarUsuario", usuario);
    
         $.ajax({
            url:"ajax/usuarios.ajax.php",
            method:"POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(respuesta){
                
                if(respuesta){
    
                    $("#nuevoUsuario").parent().after('<div class="alert alert-warning">Este usuario ya existe en la base de datos</div>');
    
                    $("#nuevoUsuario").val("");
    
                }
    
            }
    
        })
    })

    /*---------------------------------------
               Eliminar Usuario
    ---------------------------------------- */

    $(document).on("click",".btnEliminarUsuario",function(){
    
        let idUsuario=$(this).attr("idUsuario");
        let fotoUsuario=$(this).attr("fotoUsuario");
        let usuario=$(this).attr("usuario");

        swal({
            title:"¿Estas seguro que desea borrar al usuario?",
            text:"!Si no esta seguro puede cancelar la acción¡",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, borrar usuario'
        }).then(function(result){
            if(result.value){
                window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario;
            }
        })
    })


    