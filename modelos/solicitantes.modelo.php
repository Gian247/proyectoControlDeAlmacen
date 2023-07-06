<?php
require_once "conexion.php";

class ModeloSolicitante{
    static public function mdlMostrarSolicitantes($tabla,$item,$valor){
        if($item!=null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:item");
            $stmt->bindParam(":item", $valor, PDO::PARAM_STR);
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
    static public function mdlAgregrSolicitante($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombres, apellidos, documento, correo, id_perfil, id_area) VALUES (:nombres, :apellidos, :documento, :correo, :perfil, :area)");
        $stmt->bindParam(":nombres",$datos["nombre"],PDO::PARAM_STR);
        $stmt->bindParam(":apellidos",$datos["apellido"],PDO::PARAM_STR);
        $stmt->bindParam(":documento",$datos["documento"],PDO::PARAM_STR);
        $stmt->bindParam(":correo",$datos["correo"],PDO::PARAM_STR);
        $stmt->bindParam(":perfil",$datos["perfil"],PDO::PARAM_INT);
        $stmt->bindParam(":area",$datos["area"],PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";

        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;

    }
    static public function mdlEditarSolicitante($tabla,$datos){
        $stmt=Conexion::conectar()->prepare("UPDATE $tabla SET nombres = :nombres, apellidos=:apellidos, documento = :documento, correo=:correo, id_perfil=:perfil, id_area=:area WHERE id_solicitante=:id");
        $stmt->bindParam(":nombres",$datos["nombre"],PDO::PARAM_STR);
        $stmt->bindParam(":apellidos",$datos["apellido"],PDO::PARAM_STR);
        $stmt->bindParam(":documento",$datos["documento"],PDO::PARAM_STR);
        $stmt->bindParam(":correo",$datos["correo"],PDO::PARAM_STR);
        $stmt->bindParam(":perfil",$datos["perfil"],PDO::PARAM_INT);
        $stmt->bindParam(":area",$datos["area"],PDO::PARAM_INT);
        $stmt->bindParam(":id",$datos["id"],PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";

        }else {
            return "error";
        }
        $stmt->close();
        $stmt = null;
        
    }
    static public function mdlBorrarSolicitante($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_solicitante=:id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }
    /*=============================================
	ACTUALIZAR SOLICITANTE
	=============================================*/

	static public function mdlActualizarSolicitante($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id_solicitante = :id");

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
}