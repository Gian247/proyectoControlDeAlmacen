<?php


class ControladorDetalleSalidaUsuarios{
    static public function ctrRangoFechasDetalleSalidasUsuarios($fechaInicial,$fechaFinal){
		$tabla="detalleSalidaProductos";
		$respuesta=ModeloDetalleSalidaUsuarios::mdlRangoFechasDetalleSalidasUsuario($tabla,$fechaInicial,$fechaFinal);
		return $respuesta;
	}

	/*=============================================
					DESCARGAR EXCEL
	=============================================*/


	public function ctrDescargarReporteDetalleSolicitantes(){

		if(isset($_GET["reporte"])){

            $tabla = "detalleSalidaProductos";

            if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$salidas = ModeloDetalleSalidaUsuarios::mdlRangoFechasDetalleSalidasUsuario($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$salidas = ModeloDetalleSalidaUsuarios::mdlRangoFechasDetalleSalidasUsuario($tabla, $item, $valor);

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
					<td style='font-weight:bold; border:1px solid #eee;'>ID SOLICITANTE</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>NOMBRE SOLICITANTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>APELLIDO SOLICITANTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL VALOR SALIDAS</td>
					</tr>",'ISO-8859-1','UTF-8');

			foreach ($salidas as $row => $item){

				

			 echo mb_convert_encoding("<tr>
			 			<td style='border:1px solid #eee;'>".$item["id_solicitante"]."</td> 
                         <td style='border:1px solid #eee;'>".$item["nombres"]."</td> 
                         <td style='border:1px solid #eee;'>".$item["apellidos"]."</td> 
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
    
}