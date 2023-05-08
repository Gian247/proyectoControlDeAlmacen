<?php

class ControladorEntradasAlmacen{

    /*=============================================
	            Mostrar Entradas
    =============================================*/
    static public function ctrMostrarEntradas($item,$valor){
        $tabla = "ingreso_productos";
        $respuesta = ModeloEntradasAlmacen::mdlMostrarEntradas($tabla,$item,$valor);
        return $respuesta;
    }

     /*<!-- **********************************
                    CREAR CATEGORIA
    **************************************-->*/

    static public function ctrCrearEntrada(){
        if(isset($_POST["ingresoEntradaProveedor"])){
            if(preg_match('/^[0-9]+$/',$_POST["ingresoEntradaProveedor"])){
                $tabla = "ingreso_productos";
                $datos = $_POST["ingresoEntradaProveedor"];
                $respuesta = ModeloEntradasAlmacen::mdlCrearEntrada($tabla,$datos);
                if($respuesta=="ok"){
                    echo'<script>

                    swal({
                        type: "success",
                        title: "La entrada ha sido guardada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "entradas-almacen";

                                    }
                                })

                    </script>';
                }

            }else{
                echo'<script>

            swal({
                  type: "error",
                  title: "!La entrada no puede ir vacia o letras¡",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar",
                  closeOnConfirm: false
                  }).then(function(result){
                            if (result.value) {

                            window.location = "entradas-almacen";

                            }
                        })

            </script>';
            }
            

        }
    }

    static public function ctrActualizarTablaIngreso($campo,$datos){
        $tabla = "ingreso_productos";
        $respuesta = ModeloEntradasAlmacen::mdlActualizarTablaIngreso($tabla,$campo,$datos);
        if($respuesta=="ok"){
            echo'<script>

				swal({
					  type: "success",
					  title: "Registros Actualizados",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "entradas-almacen";

								}
							})

				</script>';
        }

        
    }


}
