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
    static public function mdlAgregarSalida(){

    }
    static public function mdlEditarSalida(){

    }
    static public function mdlBorrarSalida(){
        
    }
}