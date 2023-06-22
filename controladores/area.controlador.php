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





}