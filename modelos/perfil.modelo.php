<?php
require_once "conexion.php";
class ModeloPerfil{
    /*---------------------------------------
            MOSTRAR PERFILES
    ---------------------------------------- */
    static public function mdlMostrarPerfil($tabla,$item,$valor){
        if($item !=null){

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
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
    /*---------------------------------------
            AGREGAR PERFILES
    ---------------------------------------- */
    static public function mdlAgregarPerfil($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(perfil) VALUES (:perfil)");
        $stmt->bindParam(":perfil", $datos, PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;

    }
    /*---------------------------------------
            EDITAR PERFILES
    ---------------------------------------- */
    static public function mdlEditarPerfil($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET perfil=:perfil WHERE id_perfil=:id");
        $stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
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
            ELIMINAR PERFILES
    ---------------------------------------- */

}