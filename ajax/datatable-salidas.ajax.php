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
        $orden="id_producto";

        $productos = ControladorProductos::ctrMostrarProductos($item, $valor,$orden);
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
  			if($productos[$i]["stockDisponible"] <= 10){

                $stock = "<button class='btn btn-danger'>".$productos[$i]["stockDisponible"]."</button>";

            }else if($productos[$i]["stockDisponible"] > 11 && $productos[$i]["stockDisponible"] <= 15){

                $stock = "<button class='btn btn-warning'>".$productos[$i]["stockDisponible"]."</button>";

            }else{

                $stock = "<button class='btn btn-success'>".$productos[$i]["stockDisponible"]."</button>";

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
        //Quitando la coma al ultimo elemento
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
