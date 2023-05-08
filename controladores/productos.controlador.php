<?php

class ControladorProductos{
    static public function ctrMostrarProductos($item,$valor){
        //  var_dump($item, $valor);
        $tabla = "producto";
        $respuesta = ModeloProductos::mdlMostrarProductos($tabla,$item,$valor);
        return $respuesta;
        

    }
}