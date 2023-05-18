<?php


class ControladorProductosEntradas{
    /************************************
         MOSTRAR PRODUCTOS FILTRADOS
    ************************************/
    static public function ctrMostrarProductosEntradas($item,$valor){
        
        $tabla = "producto";
        $retorno = ModeloProductosEntradas::mdlMostrarProductosEntradas($tabla,$item,$valor);
        return $retorno;
    } 


    /************************************
         INGRESAR PRODUCTOS
    ************************************/

    static public function ctrIngresarProductoEntradas(){

        if(isset($_POST["nuevoCodigoEntrada"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoProductoEntrada"]) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ]+$/', $_POST["nuevoCodigo"]) &&
            preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) ){
                $tabla = "producto";
                $calculoTotal=((float)$_POST["nuevoStock"] * (float)$_POST["nuevoPrecioUnitario"]);
                
                $datos = array("categoria"=>$_POST["nuevoProductoCategoria"],
                                "codigoIngreso"=>$_POST["nuevoCodigoEntrada"],
                                "nombreProducto"=>$_POST["nuevoProductoEntrada"],
                                "codigoProducto"=>$_POST["nuevoCodigo"],
                                "stock"=>$_POST["nuevoStock"],
                                "stockDisponible"=>$_POST["nuevoStock"],
                                "unitario"=>$_POST["nuevoPrecioUnitario"],
                                "lote"=>$calculoTotal,
                                "fecha"=>$_POST["nuevaFechaIngreso"]
                                );
                
                $respuesta = ModeloProductosEntradas::mdlIngresarProductosEntrada($tabla,$datos);
                if($respuesta=="ok"){
                    echo '
                         <script>
                            let ingreso = $(".botonGuia").attr("ingreso"); 
                            let fecha = $(".botonGuia").attr("fecha"); 
                             swal({

                                 type: "success",
                                 title: "¡El usuario usuario ha sido guardado correctamente!",
                                 showConfirmButton: true,
                                 confirmButtonText: "Cerrar"

                             }).then(function(result){

                                 if(result.value){
                                
                                    window.location="index.php?ruta=productoss&ingreso="+ingreso+"&f="+fecha;

                                 }

                             });
                         </script>
                        
                         ';
                }

            }
            else{


                echo '<script>

                    let ingreso = $(".botonGuia").attr("ingreso"); 
                    let fecha = $(".botonGuia").attr("fecha"); 
                    swal({

                        type: "error",
                        title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"

                    }).then(function(result){

                        if(result.value){
                        
                            window.location="index.php?ruta=productoss&ingreso="+ingreso+"&f="+fecha;

                        }

                    });
            

                </script>';
            }
        }
        

    }
    /************************************
         BORRAR PRODUCTOS
    ************************************/

    static public function ctrBorrarProductosEntradas(){
        if(isset($_GET["idProducto"])){
            $tabla = "producto";
            $datos = $_GET["idProducto"];
            $repuesta = ModeloProductosEntradas::mdlEliminarProductosEntradas($tabla,$datos);

            if($repuesta=="ok"){
                echo'<script>
                        let ingreso = $(".botonGuia").attr("ingreso"); 
                        let fecha = $(".botonGuia").attr("fecha"); 
                        swal({
                            type: "success",
                            title: "El producto ha sido borrado correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                            }).then(function(result){
                                        if (result.value) {

                                            window.location="index.php?ruta=productoss&ingreso="+ingreso+"&f="+fecha;


                                        }
                                    })

                        </script>';
            }

        }
    }
    /*=============================================
		SUMA EL TOTAL DE PRODUCTOS DE UN LOTE
	=============================================*/
    static public function ctrSumarProductosLote($item,$valor){
        $tabla = "producto";
        $respuesta = ModeloProductosEntradas::mdlSumarProductosLote($tabla,$item,$valor);
        
        return $respuesta;
        

    }

    
}