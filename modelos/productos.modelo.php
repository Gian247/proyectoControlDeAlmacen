<?php

require_once "conexion.php";
class ModeloProductos{
    static public function mdlMostrarProductos($tabla,$item,$valor){
        
        if($valor != null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = $valor");
            $stmt->execute();
            return $stmt->fetch();
            
        }else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt->close();
        $stmt = null;

    }
}