<?php

class ControladorSalidas{
    static public function ctrMostrarSalidas($item,$valor){
        $tabla = "salidas";
        $respuesta = ModeloSalidas::mdlMostrarSalidas($tabla,$item,$valor);
        return $respuesta;

    }
    /*=============================================
	CREAR SALIDA
	=============================================*/

	static public function ctrCrearSalida(){

		if(isset($_POST["nuevaSalida"])){

			/*=============================================
			REGISTRAMOS EL PRODUCTO EN LA TABLA DETALLE DE PRODUCTOS
			=============================================*/

			$ingresarTablaDetalles=	ControladorDetalleSalidaProductos::ctrIngresarDetalleProducto($_POST["listaProductos"],$_POST["areaSolicitante"]);


			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/
			//Decodificamos a un formato que php entiende el archivo json


			$listaProductos = json_decode($_POST["listaProductos"], true);
			//Declaramos un array
			$totalProductosComprados = array();
			
			//Recorremos el arreglo
			foreach ($listaProductos as $key => $value) {
				//Almacenamos en el arreglo creado la cantidad solicitada de cada elemento
			   array_push($totalProductosComprados, $value["cantidad"]);
				//Invocamos a la tabla productos
			   $tablaProductos = "producto";
				//Establecemos el campo de busqueda
			    $item = "id_producto";
				//Almacenamos en la variable el valor del id del producto
			    $valor = $value["id"];
				//Campo para ordenar la consulta en este caso por el id
				$orden = "id_producto";

				//Consultamos al metodo statico que muestra los productos pasandole los parametros indicados
				//El resultado nos deberia mostrar los datos del producto que coincide con el id
			    $traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor,$orden);
				
				$item1a = "salidas";
				//Sumamos la cantidad de productos que solicito y lo sumamos al campo de salidas de la bd
				$valor1a = $value["cantidad"] + $traerProducto["salidas"];

			    $nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				$item1b = "stockDisponible";
				$valor1b = $value["stockDisponible"];

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

			}
			//Alistando la tabla que queremos consultar
			$tablaClientes = "solicitante";
			//Campo de busqueda
			$item = "id_solicitante";
			//Valor a buscar, en este caso el id del usuario
			$valor = $_POST["seleccionarCliente"];
			
			$traerCliente = ModeloSolicitante::mdlMostrarSolicitantes($tablaClientes, $item, $valor);

			$item1a = "solicitudes";
			//Aumentamos la cantidad de productos solicitados por el usuario
			$valor1a = array_sum($totalProductosComprados) + $traerCliente["solicitudes"];

			$comprasCliente = ModeloSolicitante::mdlActualizarSolicitante($tablaClientes, $item1a, $valor1a, $valor);

			$item1b = "ultima_solicitud";

			date_default_timezone_set('America/Bogota');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaCliente = ModeloSolicitante::mdlActualizarSolicitante($tablaClientes, $item1b, $valor1b, $valor);

			/*=============================================
			GUARDAR LA COMPRA
			=============================================*/	

			$tabla = "salidas";

			$datos = array("id_usuario"=>$_POST["idUsuario"],
						   "id_solicitante"=>$_POST["idJaladoSolicitante"],
						   "codigo"=>$_POST["nuevaSalida"],
						   "area"=>$_POST["areaSolicitante"],
						   "productos"=>$_POST["listaProductos"],
						   "total"=>$_POST["nuevoTotalVenta"]);

			$respuesta = ModeloSalidas::mdlIngresarSalida($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La Salida ha sido guardada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "salidas";

								}
							})

				</script>';

			}

		}

	}

    static public function ctrEditarSalida(){

		if(isset($_POST["nuevaSalida"])){
			
			$borrarDatosPuestos=ControladorDetalleSalidaProductos::ctrBorrarDetalleProducto($_POST["nuevaSalida"]);
			

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "salidas";

			$item = "codigo_salida";
			$valor = $_POST["nuevaSalida"];
			//Traer la salida que se va a editar
			$traerSalida = ModeloSalidas::mdlMostrarSalidas($tabla, $item, $valor);

			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/
			//Si los productos vienen vacios
			if($_POST["listaProductos"] == ""){
				//La lista de productos es igual a la que viene originalmente
				$listaProductos = $traerSalida["productos"];
				$cambioProducto = false;

			//Caso contrario
			}else{
				//La lista de productos es igual a lo que viene via post
				$listaProductos = $_POST["listaProductos"];
				$cambioProducto = true;
			}





			if($cambioProducto){
				//Decodificamos lo que viene del array 
				$productos =  json_decode($traerSalida["productos"], true);
				
				//Creamos un nuevo array
				$totalProductosComprados = array();

				foreach ($productos as $key => $value) {
					//Almaacena las cantidades del productos 
					array_push($totalProductosComprados, $value["cantidad"]);
					
					$tablaProductos = "producto";
					$item = "id_producto";
					$valor = $value["id"];
					$orden = "id_producto";

					//Consulta para traer productos con el id obtenido
					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor,$orden);
					/*-----------------------------------------------------------------
					    Regresar a sus estados anteriores las ventas y el stock 
					--------------------------------------------------------------------*/
					//Restamos la cantidada que se estaban vendiendo
					$item1a = "salidas";
					$valor1a = $traerProducto["salidas"] - $value["cantidad"];

					$nuevaSalidas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);
					//Sumamas la cantidad de stock que se estaba sale del almacen
					$item1b = "stockDisponible";
					$valor1b = $value["cantidad"] + $traerProducto["stockDisponible"];

					$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

				}

				$tablaSolicitantes = "solicitante";
				$itemSolicitante = "id_solicitante";
				$valorSolicitante = $_POST["seleccionarSolicitante"];
				$traerSolicitante = ModeloSolicitante::mdlMostrarSolicitantes($tablaSolicitantes, $itemSolicitante, $valorSolicitante);
				//Reestableciendo la salida
				//Si el cliente ntes de la compra llevaba 5 salidas esta se tiene que resstablecer
				$item1a = "solicitudes";
				//Se le resta la suma de los valores del array que contiene los totales de los productos comprados
				$valor1a = $traerSolicitante["solicitudes"] - array_sum($totalProductosComprados);
				$comprasSolicitante_2 = ModeloSolicitante::mdlActualizarSolicitante($tablaSolicitantes, $item1a, $valor1a, $valorSolicitante);

				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/

				$listaProductos_2 = json_decode($listaProductos, true);

				$totalProductosComprados_2 = array();

				foreach ($listaProductos_2 as $key => $value) {

					array_push($totalProductosComprados_2, $value["cantidad"]);
					
					$tablaProductos_2 = "producto";

					$item_2 = "id_producto";
					$valor_2 = $value["id"];
					$orden = "id_producto";

					$traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $item_2, $valor_2,$orden);

					$item1a_2 = "salidas";
					$valor1a_2 = $value["cantidad"] + $traerProducto_2["salidas"];

					$nuevasVentas_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);

					$item1b_2 = "stockDisponible";
					$valor1b_2 = $traerProducto_2["stockDisponible"] - $value["cantidad"];

					$nuevoStock_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);

				}

				$tablaSolicitantes_2 = "solicitante";

				$item_2 = "id_solicitante";
				$valor_2 = $_POST["seleccionarSolicitante"];

				$traerSolicitante_2 = ModeloSolicitante::mdlMostrarSolicitantes($tablaSolicitantes_2, $item_2, $valor_2);

				$item1a_2 = "solicitudes";
				$valor1a_2 = array_sum($totalProductosComprados_2) + $traerSolicitante_2["solicitudes"];

				$comprasSolicitante_2 = ModeloSolicitante::mdlActualizarSolicitante($tablaSolicitantes_2, $item1a_2, $valor1a_2, $valor_2);

				$item1b_2 = "ultima_solicitud";

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;

				

				$fechaSolicitante_2 = ModeloSolicitante::mdlActualizarSolicitante($tablaSolicitantes_2, $item1b_2, $valor1b_2, $valor_2);

			}


			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/	

			$tabla = "salidas";

			$datos = array("id_usuario"=>$_POST["idUsuario"],
						   "id_solicitante"=>$_POST["seleccionarSolicitante"],
						   "codigo"=>$_POST["nuevaSalida"],
						   "productos"=>$_POST["listaProductos"],
						   "total"=>$_POST["nuevoTotalVenta"]);

			$respuesta = ModeloSalidas::mdlEditarSalida($tabla, $datos);
			$dataActualSalida=array("area"=>$_POST["areaSolicitante"],
							"fecha"=>$_POST["fechaSalidaDB"]);
			$actualizarRegistro=ControladorDetalleSalidaProductos::ctrIngresarDetalleProducto($_POST["listaProductos"],$dataActualSalida);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La Salida ha sido guardada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "salidas";

								}
							})

				</script>';

			}

		}

    }
    static public function ctrBorrarSalida(){
        
    }
	/*=============================================
				RANGO FECHAS
	=============================================*/

	static public function ctrRangoFechasSalidas($fechaInicial,$fechaFinal){
		$tabla="salidas";
		$respuesta=ModeloSalidas::mdlRangoFechasSalidas($tabla,$fechaInicial,$fechaFinal);
		return $respuesta;
	}








	/*=============================================
					DESCARGAR EXCEL
	=============================================*/


	public function ctrDescargarReporte(){

		if(isset($_GET["reporte"])){

			$tabla = "salidas";

			

			$item = null;
			$valor = null;

			$salidas= ModeloSalidas::mdlMostrarSalidas($tabla, $item, $valor);
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
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>SOLICITANTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>USUARIO ENCARGADO ENTREGA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>	
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
							
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>",'ISO-8859-1','UTF-8');

			foreach ($salidas as $row => $item){

				$solicitante = ControladorSolicitantes::ctrMostrarSolicitantes("id_solicitante", $item["id_solicitante"]);
				$usuario = ControladorUsuarios::ctrMostrarUsuarios("id_usuario", $item["id_usuario"]);

			 echo mb_convert_encoding("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo_salida"]."</td> 
			 			<td style='border:1px solid #eee;'>".$solicitante["nombres"]."</td>
			 			<td style='border:1px solid #eee;'>".$usuario["nombres"]."</td>
			 			<td style='border:1px solid #eee;'>",'ISO-8859-1','UTF-8');

				//Para que todos las compras del cliente esten en su misma celda

				//Creamos una variable de productos que trae los datos decodificados de productos
			 	$productos =  json_decode($item["productos"], true);

			 	foreach ($productos as $key => $valueProductos) {
			 			
			 			echo mb_convert_encoding($valueProductos["cantidad"]."<br>",'ISO-8859-1','UTF-8');
			 		}

				//Lo mismo aplica para la descripcion

			 	echo mb_convert_encoding("</td><td style='border:1px solid #eee;'>",'ISO-8859-1','UTF-8');	

		 		foreach ($productos as $key => $valueProductos) {
			 			
		 			echo mb_convert_encoding($valueProductos["descripcion"]."<br>",'ISO-8859-1','UTF-8');
		 		
		 		}

		 		echo mb_convert_encoding("</td>
					
					
					<td style='border:1px solid #eee;'>S/. ".number_format($item["total_valor_salida"],2)."</td>
					
					<td style='border:1px solid #eee;'>".substr($item["fecha_salida"],0,10)."</td>		
		 			</tr>",'ISO-8859-1','UTF-8');


			}


			echo "</table>";

		}

	}
	/*=============================================
	SUMA TOTAL SALIDAS
	=============================================*/

	static public function ctrSumaTotalSalidas(){

		$tabla = "salidas";

		$respuesta = ModeloSalidas::mdlSumaTotalSalidas($tabla);

		return $respuesta;

	}	


}