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
    

     static public function ctrEditarProveedor(){
        //Comprobar si esta definida la variable POST
        if(isset($_POST["editarProveedor"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["editarRubro"])&&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["editarContactoEmpresa"])&&
            preg_match('/^[0-9 ]+$/',$_POST["editarTelefono"])&&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["editarRuc"])){

                $tabla = "proveedor";
                $datos=array(
                    "id"=>$_POST["idProveedor"],
                    "nombre" => $_POST["editarProveedor"],
                    "rubro" => $_POST["editarRubro"],
                    "contacto" => $_POST["editarContactoEmpresa"],
                    "telefono" => $_POST["editarTelefono"],
                    "ruc" => $_POST["editarRuc"],
                    "correo" => $_POST["editarCorreoEmpresa"]);
                $respuesta = ModeloProveedor::mdlEditarProveedor($tabla,$datos);
                if($respuesta== "ok"){
                    echo'<script>

                    swal({
                        type: "success",
                        title: "La categoria ha sido modificada correctamente",
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

								window.location = "proveedores";

								}
							})

				</script>';
            }
        }

    }
     /*=============================================
	            BORRAR PROVEEDOR
	=============================================*/
    
    static public function ctrBorrarProveedor(){
        if(isset($_GET["idProveedor"])){
            $respuesta = ModeloEntradasAlmacen::mdlMostrarEntradas("ingreso_productos", "id_proveedor", $_GET["idProveedor"]);
            if(!$respuesta){
                $tabla="proveedor";
                $datos=$_GET["idProveedor"];

                $respuesta=ModeloProveedor::mdlBorrarProveedor($tabla,$datos);
                if($respuesta=="ok"){
                    echo'<script>

                    swal({
                        type: "success",
                        title: "La categoria ha sido borrada correctamente",
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
                        title: "El proveedor no se puede eliminar, contiene un registro de ingreso",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "proveedores";

                                    }
                                })

                    </script>';

            }
            

        }
    }

}