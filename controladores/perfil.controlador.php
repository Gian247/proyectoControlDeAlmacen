<?php

class ControladorPerfil{
    /*---------------------------------------
            MOSTRAR PERFILES
    ---------------------------------------- */
    static public function ctrMostrarPerfil($item,$valor){
        $tabla = "perfil";
        $respuesta=ModeloPerfil::mdlMostrarPerfil($tabla,$item,$valor);
        return $respuesta;

    }
    /*---------------------------------------
            AGREGAR PERFILES
    ---------------------------------------- */
    static public function ctrAgregarPerfil(){
        //Comprobamos si existe la variable enviadad via post por el fomulario
        if(isset($_POST["nuevoPerfil"])){
            //Comprobamos que no se ingresen caracteres especiales en el input
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["nuevoPerfil"])){
                //Definimos la tabla
                $tabla = "perfil";
                //Creamos el array de datos para enviar la consulta
                $datos = $_POST["nuevoPerfil"];
                $respuesta = ModeloPerfil::mdlAgregarPerfil($tabla,$datos);
                if($respuesta== "ok"){
                    echo'<script>

                    swal({
                        type: "success",
                        title: "La categoria ha sido guardada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "perfil";

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

								window.location = "perfil";

								}
							})

				</script>';
            }

        }

    }
    /*---------------------------------------
            EDITAR PERFILES
    ---------------------------------------- */
    static public function ctrEditarPerfil(){
        //Comprobar si esta definida la variable POST
        if(isset($_POST["editarPerfil"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["editarPerfil"])){
                $tabla = "perfil";
                $datos = array("perfil" => $_POST["editarPerfil"], "id" => $_POST["idPerfil"]);
                $respuesta = ModeloPerfil::mdlEditarPerfil($tabla,$datos);
                if($respuesta== "ok"){
                    echo'<script>

                    swal({
                        type: "success",
                        title: "La categoria ha sido modificada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "perfil";

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

								window.location = "perfil";

								}
							})

				</script>';
            }
        }

    }
    /*---------------------------------------
            ELIMINAR PERFILES
    ---------------------------------------- */
    static public function ctrEliminarPerfil(){

    }
}