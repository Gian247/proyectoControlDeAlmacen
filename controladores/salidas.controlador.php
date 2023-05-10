<?php

class ControladorSalidas{
    static public function ctrMostrarSalidas($item,$valor){
        $tabla = "salidas";
        $respuesta = ModeloSalidas::mdlMostrarSalidas($tabla,$item,$valor);
        return $respuesta;

    }
    /*=============================================
	CREAR VENTA
	=============================================*/

	static public function ctrCrearSalida(){

		if(isset($_POST["nuevaSalida"])){

			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/
			//Decodificamos a un formato que php entiende el archivo json
			$listaProductos = json_decode($_POST["listaProductos"], true);
			//Declaramos un array
			$totalProductosComprados = array();
			var_dump($listaProductos);
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
				$orden = "id";

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
						   "id_solicitante"=>$_POST["seleccionarCliente"],
						   "codigo"=>$_POST["nuevaSalida"],
						   "productos"=>$_POST["listaProductos"],
						   "total"=>$_POST["nuevoTotalVenta"]);

			$respuesta = ModeloSalidas::mdlIngresarSalida($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La venta ha sido guardada correctamente",
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

    }
    static public function ctrBorrarSalida(){
        
    }
}