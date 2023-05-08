<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class TablaProductoSalidas{

    /*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 
    public function mostrarTablaProductosSalidas(){
        $item = null;
    	$valor = null;

        $productos = ControladorProductos::ctrMostrarProductos($item, $valor);
        if(count($productos)==0){
            echo '{"data": []}';
            return;
        }
        $datosJson = '{
            "data": [';
        for ($i = 0; $i < count($productos);$i++){

            /*=============================================
 	 		STOCK
  			=============================================*/ 

            //Poniendole colores indicadores dependiendo de la cantidad de stock
  			if($productos[$i]["stock"] <= 10){

                $stock = "<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";

            }else if($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 15){

                $stock = "<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";

            }else{

                $stock = "<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";

            }

            /*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 
              $botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$productos[$i]["id_producto"]."'>Agregar</button></div>"; 

		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$productos[$i]["codigo_producto"].'",
			      "'.$productos[$i]["descripcion"].'",
			      "'.$stock.'",
			      "'.$botones.'"
			    ],';


        }

        $datosJson = substr($datosJson, 0, -1);

		 $datosJson .=   '] 

		 }';
		
		echo $datosJson;
		

    }
}


/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarProductosSalidas = new TablaProductoSalidas();
$activarProductosSalidas -> mostrarTablaProductosSalidas();
