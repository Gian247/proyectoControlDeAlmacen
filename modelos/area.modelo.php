<?php
require_once "conexion.php";
class ModeloAreas{


    /*---------------------------------------
            MOSTRAR AREAS
    ---------------------------------------- */
    public static function mdlMostrarAreas($tabla,$item,$valor){
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




    /*---------------------------------------
            AGREGAR AREAS
    ---------------------------------------- */
    static public function mdlAgregarArea($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre_area) VALUES (:area)");
        $stmt->bindParam(":area", $datos, PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;

    }
    /*---------------------------------------
            EDITAR AREAS
    ---------------------------------------- */
    static public function mdlEditarArea($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_area=:area WHERE id_area=:id");
        $stmt->bindParam(":area", $datos["area"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;

    }

    /*---------------------------------------
            ELIMINAR AREAS
    ---------------------------------------- */
    
    static public function mdlBorrarArea($tabla,$datos){
        $stmt=Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_area=:id");
        $stmt -> bindParam(":id",$datos,PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt=null;
    }
}