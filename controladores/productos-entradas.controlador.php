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
                
            
                $tabla = "producto";
                $calculoTotal=((float)$_POST["nuevoStock"] * (float)$_POST["nuevoPrecioUnitario"]);
                
                $datos = array("categoria"=>$_POST["nuevoProductoCategoria"],
                                "codigoIngreso"=>$_POST["nuevoCodigoEntrada"],
                                "nombreProducto"=>$_POST["nuevoProductoEntrada"],
                                "stock"=>$_POST["nuevoStock"],
                                "unidad_medida"=>$_POST["nuevaUnidadMed"],
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