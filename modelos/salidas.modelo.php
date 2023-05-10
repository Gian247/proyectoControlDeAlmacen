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

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo_salida, id_solicitante, id_usuario, productos, total_valor_salida) VALUES (:codigo, :id_solicitante, :id_usuario, :productos, :total)");

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

    
    static public function mdlEditarSalida(){

    }
    static public function mdlBorrarSalida(){
        
    }
}