<?php
require_once "conexion.php";
class ModeloDetalleSalidaProducto{

    /*=============================================
	            Mostrar Detalle Salidas
	=============================================*/
    static public function mdlMostrarDetallesSalida($tabla,$item,$valor){
        if($item!=null){
            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt->execute();
			
            return $stmt->fetch();
        }else{
            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();
        }
        $stmt->close();
        $stmt=null;
    }
	
	
	/*=============================================
	             CREAR REGISTRO DE SALIDA
	=============================================*/
    static public function mdlIngresarDetalleSalida($tabla, $datos,$accion){
		if($accion=="editar"){
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_salida, id_producto, descripcion ,area , cantidad, precio, total, fecha) VALUES (:id_salida, :id_producto,:descripcion, :area, :cantidad, :precio, :total,:fecha)");

			$stmt->bindParam(":id_salida", $datos["id_salida"], PDO::PARAM_INT);
			$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_INT);
			$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
			$stmt->bindParam(":area", $datos["area"], PDO::PARAM_INT);
			$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
			$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
			$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		}elseif($accion=="crear"){

			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_salida, id_producto, descripcion ,area , cantidad, precio, total) VALUES (:id_salida, :id_producto,:descripcion, :area, :cantidad, :precio, :total)");

			$stmt->bindParam(":id_salida", $datos["id_salida"], PDO::PARAM_INT);
			$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_INT);
			$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
			$stmt->bindParam(":area", $datos["area"], PDO::PARAM_INT);
			$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
			$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
			$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
        
		}
		
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

    /*=============================================
	    ELIMINAR REGISTROS PARA PODER EDITARLOS
	=============================================*/

	static public function mdlEliminarDetalleProducto($tabla,$datos){
		
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_salida = :salidda");
        $stmt->bindParam(":salidda", $datos, PDO::PARAM_INT);
		
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;

    }

    /*=============================================
	            RANGO DE FECHAS
	=============================================*/
	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal){
		if($fechaInicial == null){
			$stmt = Conexion::conectar()->prepare("SELECT producto.id_producto ,producto.descripcion as 'producto',producto.codigo_ingreso as 'codigoIngreso',SUM(detalleSalidaProductos.cantidad) as 'cantidad', producto.costo_unitario, SUM(detalleSalidaProductos.total) as 'total' FROM detalleSalidaProductos INNER JOIN producto ON detalleSalidaProductos.id_producto=producto.id_producto  GROUP BY id_producto ");
			//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();
		}else if($fechaInicial == $fechaFinal){
			$stmt = Conexion::conectar()->prepare("SELECT producto.id_producto ,producto.descripcion as 'producto',producto.codigo_ingreso as 'codigoIngreso',SUM(detalleSalidaProductos.cantidad) as 'cantidad', producto.costo_unitario, SUM(detalleSalidaProductos.total) as 'total' FROM detalleSalidaProductos INNER JOIN producto ON detalleSalidaProductos.id_producto=producto.id_producto WHERE detalleSalidaProductos.fecha LIKE '%$fechaFinal%' GROUP BY id_producto ");
			//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%' ORDER BY fecha DESC");
			

			$stmt -> execute();

			return $stmt -> fetchAll();
		}else {
			//Actualmente el plugin me toma los ultimos 7 dias hasta el dia de ayer
			//LO que se hace es incrementar el uno para que tome hasta el dia de hoy
			$fechaActual= new DateTime();
			

			//Adicionamos 1 dia mas
			$fechaActual->add(new DateInterval("P1D"));
	
			
			$fechaActualMasUno=$fechaActual->format("Y-m-d");
			

			$fechaFinal2=new DateTime($fechaFinal);
			
		
			$fechaFinal2->add(new DateInterval("P1D"));
			

			$fechaFinalMasUno=$fechaFinal2->format("Y-m-d");


			if($fechaFinalMasUno == $fechaActualMasUno){
				$stmt = Conexion::conectar()->prepare("SELECT producto.id_producto ,producto.descripcion as 'producto',producto.codigo_ingreso as 'codigoIngreso',SUM(detalleSalidaProductos.cantidad) as 'cantidad', producto.costo_unitario, SUM(detalleSalidaProductos.total) as 'total' FROM detalleSalidaProductos INNER JOIN producto ON detalleSalidaProductos.id_producto=producto.id_producto WHERE detalleSalidaProductos.fecha BETWEEN '$fechaInicial' AND '$fechaActualMasUno' GROUP BY id_producto ");
				//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ORDER BY fecha DESC");

			}else{
				$fechaInicial=$fechaInicial." 00:00:00";
				$fechaFinal=$fechaFinal." 23:59:59";
				$stmt = Conexion::conectar()->prepare("SELECT producto.id_producto ,producto.descripcion as 'producto',producto.codigo_ingreso as 'codigoIngreso',SUM(detalleSalidaProductos.cantidad) as 'cantidad', producto.costo_unitario, SUM(detalleSalidaProductos.total) as 'total' FROM detalleSalidaProductos INNER JOIN producto ON detalleSalidaProductos.id_producto=producto.id_producto WHERE detalleSalidaProductos.fecha BETWEEN '$fechaInicial' AND '$fechaFinal' GROUP BY id_producto ");
				//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY fecha DESC");

			}


			$stmt -> execute();

			return $stmt -> fetchAll();
		}
	}


	/*=============================================
				SUMAR EL TOTAL DE SALIDAS
	=============================================*/
	// static public function mdlSumaTotalSalidasProductosFecha($tabla,$fechaInicial,$fechaFinal){
		
	// 	if($fechaInicial == null){

	// 		$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as totalValor FROM $tabla ORDER BY fecha DESC");

	// 		$stmt -> execute();

	// 		return $stmt -> fetchAll();
	// 	}else if($fechaInicial == $fechaFinal){
			
	// 		$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as totalValor FROM $tabla WHERE fecha like '%$fechaFinal%' ORDER BY fecha DESC");
			

	// 		$stmt -> execute();

	// 		return $stmt -> fetch();
	// 	}else {
	// 		//Actualmente el plugin me toma los ultimos 7 dias hasta el dia de ayer
	// 		//LO que se hace es incrementar el uno para que tome hasta el dia de hoy
	// 		$fechaActual= new DateTime();
			

	// 		//Adicionamos 1 dia mas
	// 		$fechaActual->add(new DateInterval("P1D"));
	
			
	// 		$fechaActualMasUno=$fechaActual->format("Y-m-d");
			

	// 		$fechaFinal2=new DateTime($fechaFinal);
			
		
	// 		$fechaFinal2->add(new DateInterval("P1D"));
			

	// 		$fechaFinalMasUno=$fechaFinal2->format("Y-m-d");


	// 		if($fechaFinalMasUno == $fechaActualMasUno){

	// 			$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as totalValor FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ORDER BY fecha DESC");

	// 		}else{
				
	// 			$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as totalValor FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY fecha DESC");

	// 		}


	// 		$stmt -> execute();

	// 		return $stmt -> fetchAll();
	// 	}
	// }
}