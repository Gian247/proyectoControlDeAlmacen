<?php


class ControladorArea{
    /*=============================================
	            Mostrar Areas
	=============================================*/
    public static  function ctrMostrarAreas($item,$valor){
        $tabla="areas";
        $respuesta=ModeloAreas::mdlMostrarAreas($tabla,$item,$valor);
        return $respuesta;


    }




    /*---------------------------------------
            AGREGAR PERFILES
    ---------------------------------------- */
    static public function ctrAgregarArea(){
        //Comprobamos si existe la variable enviadad via post por el fomulario
        if(isset($_POST["nuevaArea"])){
            //Comprobamos que no se ingresen caracteres especiales en el input
            
                //Definimos la tabla
                $tabla = "areas";
                //Creamos el array de datos para enviar la consulta
                $datos = $_POST["nuevaArea"];
                $respuesta = ModeloAreas::mdlAgregarArea($tabla,$datos);
                if($respuesta== "ok"){
                    echo'<script>

                    swal({
                        type: "success",
                        title: "El area ha sido guardado correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "area";

                                    }
                                })

                    </script>';
                }

            

        }

    }
    /*---------------------------------------
            EDITAR AREAS
    ---------------------------------------- */
    static public function ctrEditarArea(){
        //Comprobar si esta definida la variable POST
        if(isset($_POST["editarArea"])){
            
                $tabla = "areas";
                $datos = array("area" => $_POST["editarArea"], "id" => $_POST["idArea"]);
                $respuesta = ModeloAreas::mdlEditarArea($tabla,$datos);
                if($respuesta== "ok"){
                    echo'<script>

                    swal({
                        type: "success",
                        title: "El area ha sido modificado correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "area";

                                    }
                                })

                    </script>';
                }
            
        }

    }
    /*---------------------------------------
            ELIMINAR AREAS
    ---------------------------------------- */
    static public function ctrEliminarArea(){
        if(isset($_GET["idArea"])){
            
            $tabla="areas";
            $datos=$_GET["idArea"];

            $respuesta=ModeloAreas::mdlBorrarArea($tabla,$datos);
            if($respuesta=="ok"){
                echo'<script>

                swal({
                    type: "success",
                    title: "El area ha sido borrado correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                    }).then(function(result){
                                if (result.value) {

                                window.location = "area";

                                }
                            })

                </script>';
            }


            
            

        }
    }





}