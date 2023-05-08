<?php

require_once "../controladores/perfil.controlador.php";
require_once "../modelos/perfil.modelo.php";

class AjaxPerfil{

	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/

    public $idPerfil;

	public function ajaxEditarPerfil(){

		$item = "id_perfil";
		$valor = $this->idPerfil;

		$respuesta = ControladorPerfil::ctrMostrarPerfil($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idPerfil"])){

	$categoria = new AjaxPerfil();
	$categoria -> idPerfil = $_POST["idPerfil"];
	$categoria -> ajaxEditarPerfil();
}