<?php
require_once "conexion.php";

class ModeloSalidas{
    static public function mdlMostrarSalidas($tabla,$item,$valor){
        if($item !=null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");
            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();

        }else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id_salida ASC");
            $stmt->execute();
            return $stmt->fetchAll();
        }

        $stmt->close();
        $stmt = null;

    }

    /*=============================================
	REGISTRO DE Salida
	=============================================*/

	static public function mdlIngresarSalida($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo_salida, id_solicitante, id_usuario,id_area, productos, total_valor_salida) VALUES (:codigo, :id_solicitante, :id_usuario,:area, :productos, :total)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_solicitante", $datos["id_solicitante"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
		$stmt->bindParam(":area", $datos["area"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

    
    static public function mdlEditarSalida($tabla,$datos){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_solicitante = :id_solicitante, id_usuario= :id_usuario, productos = :productos, total_valor_salida= :total WHERE codigo_salida = :codigo");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_solicitante", $datos["id_solicitante"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;


    }
    static public function mdlBorrarSalida(){
        
    }
	/*=============================================
					RANGO DE FECHAS
	=============================================*/
	static public function mdlRangoFechasSalidas($tabla, $fechaInicial, $fechaFinal){
		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id_salida DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();
		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha_salida like '%$fechaFinal%' ORDER BY id_salida DESC");
			

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
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha_salida BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ORDER BY id_salida DESC");

			}else{
				$fechaInicial=$fechaInicial." 00:00:00";
				$fechaFinal=$fechaFinal." 23:59:59";
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha_salida BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY id_salida DESC");

			}


			$stmt -> execute();

			return $stmt -> fetchAll();
		}
	}
	/*=============================================
				SUMAR EL TOTAL DE SALIDAS
	=============================================*/
	static public function mdlSumaTotalSalidas($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT SUM(total_valor_salida) as total FROM $tabla");
		$stmt->execute();
		return $stmt->fetch();
		$stmt->close();
		$stmt = null;
	}

	
}