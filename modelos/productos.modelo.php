<?php

require_once "conexion.php";
class ModeloProductos{

    /*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/
    static public function mdlMostrarProductos($tabla,$item,$valor,$orden){
        
        if($valor != null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = $valor ORDER BY $orden DESC");
            $stmt->execute();
            return $stmt->fetch();
            
        }else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt->close();
        $stmt = null;

    }
    /*=============================================
	ACTUALIZAR PRODUCTO
	=============================================*/

	static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id_producto = :id");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}


	static public function mdlMostrarSumaSalidas($tabla)
	{
		$stmt = Conexion::conectar()->prepare("SELECT SUM(salidas) as total FROM $tabla");
		$stmt->execute();
		return $stmt->fetch();
		$stmt->close();
		$stmt = null;
	}

}