
$(".tablas").on("click", ".btnEditarSolicitante",function(){
    let idSolitante = $(this).attr("idSolicitante");
    let datos=new FormData();
    datos.append("idSolicitante",idSolitante);

    $.ajax({

      url:"ajax/solicitantes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
        
      
      	   $("#idSolicitante").val(respuesta["id_solicitante"]);
	       $("#editarNombreSolicitante").val(respuesta["nombres"]);
	       $("#editarApellidoSolicitante").val(respuesta["apellidos"]);
	       $("#editarDocumentoSolicitante").val(respuesta["documento"]);
	       $("#editarCorreoSolicitante").val(respuesta["correo"]);
           $("#editarPerfilSolicitante").html(respuesta["id_perfil"]);
           $("#editarPerfilSolicitante").val(respuesta["id_perfil"]);
	       
	    }

  	})
});

/*---------------------------------------
            ELIMINAR SOLICITANTE
    ---------------------------------------- */

    $(".tablas").on("click", ".btnEliminarSolicitante",function(){
    let idSolicitante = $(this).attr("idSolicitante");
    swal({
        title:"¿ Está seguro que desea borrar el registro del solicitante ?",
        text:"! Si no esta seguro puede cancelar la acción ¡",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar'
    }).then(function(result){
          if(result.value){
              window.location = "index.php?ruta=solicitantes&idSolicitante="+idSolicitante;
          }
      })
})

$("#funciona").click(function(){
    alert("FD");
    $.ajax({

        url: "ajax/datatable-salidas.ajax.php",
        success:function(respuesta){
           
            
   
        }
   
    })
})
