<?php

class ControladorProductos{
    static public function ctrMostrarProductos($item,$valor,$orden){
        
        $tabla = "producto";
        $respuesta = ModeloProductos::mdlMostrarProductos($tabla,$item,$valor,$orden);
        return $respuesta;
        

    }
    /*=============================================
				MOSTRAR SUMA VENTAS
	=============================================*/
	static public function ctrMostrarSumaSalidas()
	{
		$tabla = 'producto';
		$respuesta = ModeloProductos::mdlMostrarSumaSalidas($tabla);
		return $respuesta;
	}


	/*=============================================
					DESCARGAR EXCEL
	=============================================*/
    static public function ctrDescargarReporteExcel(){
        if(isset($_GET["reporteProductos"])){

			$tabla = "producto";

			

			$item = null;
			$valor = null;
            $orden="fecha_ingreso";

			$respuestaProductos= ModeloProductos::mdlMostrarProductos($tabla, $item, $valor,$orden);
			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporteProductos"].'.xls';

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
					<td style='font-weight:bold; border:1px solid #eee;'>ID</td> 
                    <td style='font-weight:bold; border:1px solid #eee;'>CODIGO LOTE</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CATEGORIA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO PRODUCTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DESCRIPCIÓN</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD LOTE</td>	
					<td style='font-weight:bold; border:1px solid #eee;'>STOCK DISPONIBLE</td>	
                    <td style='font-weight:bold; border:1px solid #eee;'>COSTO UNITARIO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>COSTO LOTE</td>	
					<td style='font-weight:bold; border:1px solid #eee;'>SALIDAS REGISTRADAS</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA INGRESO</td>		
					</tr>",'ISO-8859-1','UTF-8');

			foreach ($respuestaProductos as $row => $item){

				$categorias = ControladorCategorias::ctrMostrarCategorias("id_categoria", $item["id_categoria"]);
			 	echo mb_convert_encoding("<tr>
			 			<td style='border:1px solid #eee;'>".$item["id_producto"]."</td> 
			 			<td style='border:1px solid #eee;'>".$item["codigo_ingreso"]."</td>
			 			<td style='border:1px solid #eee;'>".$categorias["categoria"]."</td>
						<td style='border:1px solid #eee;'>".$item["codigo_producto"]."</td> 
			 			<td style='border:1px solid #eee;'>".$item["descripcion"]."</td>
			 			<td style='border:1px solid #eee;'>".$item["stock"]."</td>
						<td style='border:1px solid #eee;'>".$item["stockDisponible"]."</td> 
			 			<td style='border:1px solid #eee;'>".$item["costo_unitario"]."</td>
			 			<td style='border:1px solid #eee;'>".$item["costo_lote"]."</td>
						 <td style='border:1px solid #eee;'>".$item["salidas"]."</td>
			 			<td style='border:1px solid #eee;'>".$item["fecha_ingreso"]."</td>
			 			<td style='border:1px solid #eee;'>",'ISO-8859-1','UTF-8');
			}
			echo "</table>";

		}
    }

	/*=============================================
		ACTUALIZAR REPORTE DE ALERTA DE PRODUCTO
	=============================================*/
	static function ctrEditarAlertaStockAgotado($idProducto ,$valorActual){
		$tabla="producto";
		$nuevoValor=$valorActual+1;
		$datos=array("idProducto"=>$idProducto,
					"nuevoValorEstadoEnvio"=>$nuevoValor);
		$respuesta=ModeloProductos::mdlActualizarAlertaEnvio($tabla,$datos);
		if($respuesta=="ok"){
			echo'<script>

						swal({
							  type: "info",
							  title: "Alerta: Se ha enviado un correo con el detalle del producto agotado",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "salidas";

										}
									})

						</script>';
		}
	}
    

}