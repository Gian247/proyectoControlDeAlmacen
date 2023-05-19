<?php

require_once "../controladores/proveedor.controlador.php";
require_once "../modelos/proveedor.modelo.php";

class AjaxProveedor{

	/*=============================================
	EDITAR PROVEEDOR
	=============================================*/

    public $idProveedor;

	public function ajaxEditarProveedor(){

		$item = "id_proveedor";
		$valor = $this->idProveedor;

		$respuesta = ControladorProveedor::ctrMostrarProveedor($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idProveedor"])){

	$categoria = new AjaxProveedor();
	$categoria -> idProveedor = $_POST["idProveedor"];
	$categoria -> ajaxEditarProveedor();
}