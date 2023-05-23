<?php
require_once "conexion.php";

class ModeloEntradasAlmacen{

     /*<!-- **********************************
                    MOSTRAR ENTRADA
    **************************************-->*/
    static public function mdlMostrarEntradas($tabla,$item,$valor){
        
        if($item!=null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valorDeseado");
            
            $stmt->bindParam(":valorDeseado", $valor, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt->close();
        $stmt = null;

    } 

     /*<!-- **********************************
                    CREAR ENTRADA
    **************************************-->*/
    static public function mdlCrearEntrada($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_proveedor) VALUES (:ingreso)");
        $stmt->bindParam(":ingreso", $datos, PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }
    static public function mdlActualizarTablaIngreso($tabla,$campo,$datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $campo = :cantidad WHERE id_ingreso = :ingreso");
        $stmt->bindParam(":ingreso", $datos["id"],PDO::PARAM_INT);
        $stmt->bindParam(":cantidad", $datos["nuevoValor"],PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        };

    }

    /*=============================================
				SUMAR EL TOTAL DE INGRESOS
	=============================================*/
	static public function mdlSumaTotalIngresos($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT SUM(monto_ingreso) as total FROM $tabla");
		$stmt->execute();
		return $stmt->fetch();
		$stmt->close();
		$stmt = null;
	}
}