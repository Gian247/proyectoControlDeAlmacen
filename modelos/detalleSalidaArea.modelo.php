<?php
require_once "conexion.php";

class ModeloDetalleSalidaArea{

    /*=============================================
	            RANGO DE FECHAS
	=============================================*/
	static public function mdlRangoFechasDetalleSalidasArea($tabla, $fechaInicial, $fechaFinal){
		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT s.id_area,a.nombre_area,SUM(s.total_valor_salida)AS 'total' FROM salidas s INNER JOIN areas a ON s.id_area=a.id_area  GROUP BY s.id_area;");
			//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();
		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT s.id_area,a.nombre_area,SUM(s.total_valor_salida)AS 'total' FROM salidas s INNER JOIN areas a ON s.id_area=a.id_area  WHERE s.fecha_salida like '%$fechaFinal%' GROUP BY s.id_area;");
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
                $fechaInicial=$fechaInicial." 00:00:00";
                $fechaFinalMasUno=$fechaFinalMasUno." 23:59:59";
				$stmt = Conexion::conectar()->prepare("SELECT s.id_area,a.nombre_area,SUM(s.total_valor_salida)AS 'total' FROM salidas s INNER JOIN areas a ON s.id_area=a.id_area  WHERE s.fecha_salida BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' GROUP BY s.id_area;");
				//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ORDER BY fecha DESC");

			}else{
				$fechaInicial=$fechaInicial." 00:00:00";
				$fechaFinal=$fechaFinal." 23:59:59";
				$stmt = Conexion::conectar()->prepare("SELECT s.id_area,a.nombre_area,SUM(s.total_valor_salida)AS 'total' FROM salidas s INNER JOIN areas a ON s.id_area=a.id_area  WHERE s.fecha_salida BETWEEN '$fechaInicial' AND '$fechaFinal' GROUP BY s.id_area;");
				//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY fecha DESC");

			}


			$stmt -> execute();

			return $stmt -> fetchAll();
		}
	}
}