<?php

require_once "conexion.php";
class ModeloProveedor{
    static public function mdlMostrarProveedor($tabla,$item,$valor){
        if($item!=null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");
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
    static public function mdlIngresarProveedores($tabla,$datos){
        $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(nombre_proveedor, rubro, contacto, telefono, ruc, correo) VALUES (:nombre_proveedor, :rubro, :contacto, :telefono, :ruc, :correo)");
        $stmt->bindParam(":nombre_proveedor", $datos["nombre"],PDO::PARAM_STR);
        $stmt->bindParam(":rubro", $datos["rubro"],PDO::PARAM_STR);
        $stmt->bindParam(":contacto", $datos["contacto"],PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"],PDO::PARAM_STR);
        $stmt->bindParam(":ruc", $datos["ruc"],PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"],PDO::PARAM_STR);
        if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
    }
}