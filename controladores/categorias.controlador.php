<?php 

class ControladorCategorias{
     /*=============================================
	            Mostrar Categorias
	=============================================*/

    static public function ctrMostrarCategorias($item,$valor){
        $tabla="categoria";
        $respuesta=ModeloCategorias::mdlMostrarCategorias($tabla,$item,$valor);
        return $respuesta;
    }
    /*<!-- **********************************
                    CREAR CATEGORIA
    **************************************-->*/
    static public function ctrCrearCategoria(){
        if(isset($_POST["nuevaCategoria"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["nuevaCategoria"])){
                $tabla = "categoria";
                $datos=$_POST["nuevaCategoria"];
                $respuesta=ModeloCategorias::mdlIngresarCategoria($tabla,$datos);
                if($respuesta== "ok"){
                    echo'<script>

                    swal({
                        type: "success",
                        title: "La categoria ha sido guardada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "categorias";

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
        }
    }

    /*<!-- **********************************
                    EDITAR CATEGORIA
    **************************************-->*/
    static public function ctrEditarCategoria(){
        if(isset($_POST["editarCategoria"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["editarCategoria"])){
                $tabla = "categoria";
                $datos= array("categoria"=>$_POST["editarCategoria"],"id"=>$_POST["idCategoria"]);
                $respuesta=ModeloCategorias::mdlEditarCategoria($tabla,$datos);
                if($respuesta== "ok"){
                    echo'<script>

                    swal({
                        type: "success",
                        title: "La categoria ha sido modificada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "categorias";

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
        }
    }

    /*=============================================
	            BORRAR Categorias
	=============================================*/
    
    static public function ctrBorrarCategoria(){
        if(isset($_GET["idCategoria"])){
            
            $tabla="categoria";
            $datos=$_GET["idCategoria"];

            $respuesta=ModeloCategorias::mdlBorrarCategorias($tabla,$datos);
            if($respuesta=="ok"){
                echo'<script>

                swal({
                    type: "success",
                    title: "La categoria ha sido borrada correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                    }).then(function(result){
                                if (result.value) {

                                window.location = "categorias";

                                }
                            })

                </script>';
            }


            
            

        }
    }

}