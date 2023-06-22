<?php


class ControladorDetalleSalidaProductos{


    /*=============================================
	    Mostrar Detalle Salida Productos
	=============================================*/

    static public function ctrMostrarDetalleSalidas($item,$valor){
        $tabla="detalleSalidaProductos";
        $respuesta=ModeloDetalleSalidaProducto::mdlMostrarDetallesSalida($tabla,$item,$valor);
        return $respuesta;
    }

    /*************************************
    INGRESAR DETALLE DE PRODUCTOS
************************************/

    static public function ctrIngresarDetalleProducto($arregloProductosSalida,$area)
    {

		$tabla = "detalleSalidaProductos";
		if(is_array($area)){
			$accion="editar";
			$listaProductos = json_decode($arregloProductosSalida, true);
			foreach ($listaProductos as $key => $value) {
				# code...

				$datos = array(
					"id_salida" => $value["id_salida"],
					"id_producto" => $value["id"],
					"descripcion" => $value["descripcion"],
					"area" => $area["area"],
					"fecha" => $area["fecha"],
					"cantidad" => $value["cantidad"],
					"precio" => $value["precio"],
					"total" => $value["total"]
				);
				
				$respuesta = ModeloDetalleSalidaProducto::mdlIngresarDetalleSalida($tabla, $datos,$accion);
				$datos = array();
			}
			

		}else{
			$accion="crear";
			$listaProductos = json_decode($arregloProductosSalida, true);
			foreach ($listaProductos as $key => $value) {
				# code...

				$datos = array(
					"id_salida" => $value["id_salida"],
					"id_producto" => $value["id"],
					"descripcion" => $value["descripcion"],
					"area" => $area,
					"cantidad" => $value["cantidad"],
					"precio" => $value["precio"],
					"total" => $value["total"]
				);
				
				$respuesta = ModeloDetalleSalidaProducto::mdlIngresarDetalleSalida($tabla, $datos,$accion);
				$datos = array();
			}
			
		}
        
        
        


    
    }


     /************************************
         BORRAR DETALLE DE PRODUCTOS
    ************************************/

    static public function ctrBorrarDetalleProducto($valorIdSalida){

        $tabla = "detalleSalidaProductos";
        $repuesta = ModeloDetalleSalidaProducto::mdlEliminarDetalleProducto($tabla, (int)$valorIdSalida);
        

        

        
    }
    /*=============================================
				RANGO FECHAS
	=============================================*/

	static public function ctrRangoFechasVentas($fechaInicial,$fechaFinal){
		$tabla="detalleSalidaProductos";
		$respuesta=ModeloDetalleSalidaProducto::mdlRangoFechasVentas($tabla,$fechaInicial,$fechaFinal);
		return $respuesta;
	}





    /*=============================================
					DESCARGAR EXCEL
	=============================================*/


	public function ctrDescargarReporteDetalleProducto(){

		if(isset($_GET["reporte"])){

            $tabla = "detalleSalidaProductos";

            if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$salidas = ModeloDetalleSalidaProducto::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$salidas = ModeloDetalleSalidaProducto::mdlRangoFechasVentas($tabla, $item, $valor);

			}

			
			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");

			echo mb_convert_encoding("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO INGRESO ALMACEN</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CODIGO UNICO PRODUCTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD SALIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRECIO UNITARIO</td>	
                    <td style='font-weight:bold; border:1px solid #eee;'>TOTAL SALIDAS</td>
					</tr>",'ISO-8859-1','UTF-8');

			foreach ($salidas as $row => $item){

				
				//$usuario = ControladorUsuarios::ctrMostrarUsuarios("id_usuario", $item["id_usuario"]);

			 echo mb_convert_encoding("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigoIngreso"]."</td> 
                         <td style='border:1px solid #eee;'>".$item["id_producto"]."</td> 
                         <td style='border:1px solid #eee;'>".$item["producto"]."</td> 
                         
                         <td style='border:1px solid #eee;'>".$item["cantidad"]."</td> 
                         <td style='border:1px solid #eee;'>S/. ".number_format($item["costo_unitario"],2)."</td>
						 <td style='border:1px solid #eee;'>S/. ".number_format($item["total"],2)."</td>
			 			<td style='border:1px solid #eee;'>",'ISO-8859-1','UTF-8');

				//Para que todos las compras del cliente esten en su misma celda

				//Creamos una variable de productos que trae los datos decodificados de productos
			 	//$productos =  json_decode($item["productos"], true);

			 	// foreach ($productos as $key => $valueProductos) {
			 			
			 	// 		echo mb_convert_encoding($valueProductos["cantidad"]."<br>",'ISO-8859-1','UTF-8');
			 	// 	}

				//Lo mismo aplica para la descripcion

			 	// echo mb_convert_encoding("</td><td style='border:1px solid #eee;'>",'ISO-8859-1','UTF-8');	

		 		// foreach ($productos as $key => $valueProductos) {
			 			
		 		// 	echo mb_convert_encoding($valueProductos["descripcion"]."<br>",'ISO-8859-1','UTF-8');
		 		
		 		// }

		 		// echo mb_convert_encoding("</td>
					
					
				// 	<td style='border:1px solid #eee;'>S/. ".number_format($item["total_valor_salida"],2)."</td>
					
				// 	<td style='border:1px solid #eee;'>".substr($item["fecha_salida"],0,10)."</td>		
		 		// 	</tr>",'ISO-8859-1','UTF-8');


			}


			echo "</table>";

		}

	}
        
	/*=============================================
			SUMA TOTAL SALIDAS FILTRADO POR MES
	=============================================*/

	static public function ctrSumaTotalSalidasFiltradoFecha(){
		$tabla = "detalleSalidaProductos";

		if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){
			
			$fechaInicial=$_GET["fechaInicial"];
			$fechaFinal=$_GET["fechaFinal"];
			
		}else{

			
			$fechaInicial=null;
			$fechaFinal=null;
			
		}
		$respuesta=ModeloDetalleSalidaProducto::mdlSumaTotalSalidasProductosFecha($tabla,$fechaInicial,$fechaFinal);
		
		return $respuesta;

	}	

        

        
    

}


