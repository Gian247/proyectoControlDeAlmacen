<?php

class ControladorSolicitantes{

    /*=============================================
	            MOSTRAR SOLICITANTE
	=============================================*/
    static public function ctrMostrarSolicitantes($item,$valor){
        $tabla = "solicitante";
        $respuesta = ModeloSolicitante::mdlMostrarSolicitantes($tabla, $item, $valor);
        return $respuesta;

    }
    /*=============================================
	            AGREGAR SOLICITANTE
	=============================================*/
    static public function ctrAgregarSolicitante(){
        if(isset($_POST["nuevoNombreSolicitante"])){
            
            $tabla = "solicitante";
            $datos=array("nombre"=>$_POST["nuevoNombreSolicitante"],
                        "apellido"=>$_POST["nuevoApellidoSolicitante"],
                        "documento"=>$_POST["nuevaDocumentoSolicitante"],
                        
                        "correo"=>$_POST["nuevoCorreoSolicitante"],
                        "perfil"=>$_POST["nuevoPerfilSolicitante"],
                        "area"=>$_POST["nuevaAreaSolicitante"]);
                        
            $respuesta = ModeloSolicitante::mdlAgregrSolicitante($tabla,$datos);
            if($respuesta=="ok"){
                echo'<script>

                    swal({
                        type: "success",
                        title: "El solicitante ha sido borrada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "solicitantes";

                                    }
                                })

                    </script>';
            }
        
        }

    }
    /*=============================================
	            EDITAR SOLICITANTE
	=============================================*/
    static public function ctrEditarSolicitante(){
        if (isset($_POST["editarNombreSolicitante"])) {
            
                $tabla = "solicitante";
                $datos = array(
                    "nombre" => $_POST["editarNombreSolicitante"],
                    "apellido" => $_POST["editarApellidoSolicitante"],
                    "documento" => $_POST["editarDocumentoSolicitante"],
                    "correo" => $_POST["editarCorreoSolicitante"],
                    "perfil" => $_POST["editarPerfilSolicitante"],
                    "area" => $_POST["editarAreaSolicitante"],
                    "id" => $_POST["idSolicitante"]
                );
                $respuesta = ModeloSolicitante::mdlEditarSolicitante($tabla, $datos);
                if ($respuesta == "ok") {
                    echo '<script>

                    swal({
                        type: "success",
                        title: "Los datos del solicitante has sido actualizados correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "solicitantes";

                                    }
                                })

                    </script>';
                }




            
        }
    }


     /*=============================================
	            BORRAR SOLICITANTE
	=============================================*/
    
    static public function ctrBorrarSolicitante(){
        if(isset($_GET["idSolicitante"])){
            
            
            $tabla="solicitante";
            $datos=$_GET["idSolicitante"];

            $respuesta=ModeloSolicitante::mdlBorrarSolicitante($tabla,$datos);
            if($respuesta=="ok"){
                echo'<script>

                swal({
                    type: "success",
                    title: "El registro del solicitante ha sido borrado correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                    }).then(function(result){
                                if (result.value) {

                                window.location = "solicitantes";

                                }
                            })

                </script>';
            }


            
            

        }
    }
}