$(".btnEditarProveedor").click(function(){
    
    let idProveedor = $(this).attr("idProveedor");
    
    let datos = new FormData();
    datos.append("idProveedor",idProveedor);
    $.ajax({
        url:"ajax/proveedor.ajax.php",
        method:"POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(respuesta){
            
            $("#editarProveedor").val(respuesta["nombre_proveedor"]);
            $("#editarRubro").val(respuesta["rubro"]);
            $("#editarContactoEmpresa").val(respuesta["contacto"]);
            $("#editarTelefono").val(respuesta["telefono"]);
            $("#editarRuc").val(respuesta["ruc"]);
            $("#editarCorreoEmpresa").val(respuesta["correo"]);
            $("#idProveedor").val(respuesta["id_proveedor"]);
            //$("#idCategoria").val(respuesta["id_categoria"]);



        }
    })
})
/*---------------------------------------
            ELIMINAR SOLICITANTE
    ---------------------------------------- */

    $(".tablas").on("click", ".btnEliminarProveedor",function(){
    let idProveedor = $(this).attr("idProveedor");
    swal({
        title:"¿ Está seguro que desea borrar el registro de Proveedor ?",
        text:"! Si no esta seguro puede cancelar la acción ¡",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar'
    }).then(function(result){
          if(result.value){
              window.location = "index.php?ruta=proveedores&idProveedor="+idProveedor;
          }
      })
})