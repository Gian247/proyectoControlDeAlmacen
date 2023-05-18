<?php

class ControladorProveedor{
    /************************************
         MOSTRAR PROVEEDOR
     ************************************/
    static public function ctrMostrarProveedor($item,$valor){
        $tabla = "proveedor";
        $respuesta = ModeloProveedor::mdlMostrarProveedor($tabla,$item,$valor);
        return $respuesta;

    }
    /************************************
         INGRESAR PROVEEDOR
     ************************************/
    static public function ctrIngresarProveedores(){
        if(isset($_POST["nuevoRubro"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["nuevoRubro"])&&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["nuevoContactoEmpresa"])&&
            preg_match('/^[0-9 ]+$/',$_POST["nuevoTelefono"])&&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["nuevoRuc"])){
                $tabla = "proveedor";
                $datos=array(
                "nombre" => $_POST["nuevoProveedor"],
                "rubro" => $_POST["nuevoRubro"],
                "contacto" => $_POST["nuevoContactoEmpresa"],
                "telefono" => $_POST["nuevoTelefono"],
                "ruc" => $_POST["nuevoRuc"],
                "correo" => $_POST["nuevoCorreoEmpresa"]);

                $respuesta=ModeloProveedor::mdlIngresarProveedores($tabla,$datos);
                if($respuesta== "ok"){
                    echo'<script>

                    swal({
                        type: "success",
                        title: "El proveedor ha sido guardada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "proveedores";

                                    }
                                })

                    </script>';
                }

            }else{
                echo'<script>

				swal({
					  type: "error",
					  title: "!La categoria no puede ir vacia o llevar caracteres especiales¡",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
                      closeOnConfirm: false
					  }).then(function(result){
								if (result.value) {

								window.location = "categorias";

								}
							})

				</script>';
            }
        }else{
            var_dump("Error desconocido");
        }
    }
    /************************************
         EDITAR PROVEEDOR
     ************************************/
    /************************************
         ELIMINAR PROVEEDOR
     ************************************/

}