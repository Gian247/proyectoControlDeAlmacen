<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class AjaxProductos{
    /*=============================================
            EDITAR PRODUCTO
    =============================================*/

    public $idProducto;

    public function ajaxEditarProducto(){
        $item = "id_producto";
        $valor = $this->idProducto;

        $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);
        echo json_encode($respuesta);
    }

}


/*=============================================
EDITAR PRODUCTO
=============================================*/ 

if(isset($_POST["idProducto"])){

    $editarProducto = new AjaxProductos();
    $editarProducto->idProducto=$_POST["idProducto"];
    $editarProducto->ajaxEditarProducto();
  
  }