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
    /************************************
         EDITAR PROVEEDOR
     ************************************/
    /************************************
         ELIMINAR PROVEEDOR
     ************************************/

}