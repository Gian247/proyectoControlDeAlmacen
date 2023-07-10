<?php

require_once "conexion.php";

class ModeloProductosEntradas{
    static public function mdlMostrarProductosEntradas($tabla,$item,$valor){
        
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = $valor");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
        $stmt = null;

    }

    static public function mdlIngresarProductosEntrada($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_categoria, descripcion,stock, unidad_medida, stockDisponible, costo_unitario, costo_lote, fecha_ingreso, codigo_ingreso) VALUES (:categoria, :descripcion, :stock, :unidad_medida, :stockDisponible, :unitario, :lote, :fecha, :codigoIngreso)");
        $stmt->bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $datos["nombreProducto"], PDO::PARAM_STR);
        
        $stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
        $stmt->bindParam(":unidad_medida", $datos["unidad_medida"], PDO::PARAM_STR);
        $stmt->bindParam(":stockDisponible", $datos["stockDisponible"], PDO::PARAM_STR);
        $stmt->bindParam(":unitario", $datos["unitario"], PDO::PARAM_STR);
        $stmt->bindParam(":lote", $datos["lote"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
        $stmt->bindParam(":codigoIngreso", $datos["codigoIngreso"], PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";

        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;



    }

    static public function mdlEliminarProductosEntradas($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_producto=:producto");
        $stmt->bindParam(":producto", $datos, PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;

    }
    static public function mdlSumarProductosLote($tabla,$item,$valor){
        $stmt = Conexion::conectar()->prepare("SELECT SUM(costo_lote) AS total FROM $tabla WHERE $item = :valor");
        $stmt->bindParam(":valor", $valor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
        $stmt->close();
        $stmt = null;


    }
}






