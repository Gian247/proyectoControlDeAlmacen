<?php

require_once "../controladores/salidas.controlador.php";
require_once "../modelos/salidas.modelo.php";

class AjaxSalida{

	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/

    public $idSalida;

	public function ajaxEditarSalida(){

		$item = "id_salida";
		$valor = $this->idSalida;

		$respuesta = ControladorSalidas::ctrMostrarSalidas($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idSalida"])){

	$categoria = new AjaxSalida();
	$categoria -> idSalida = $_POST["idSalida"];
	$categoria -> ajaxEditarSalida();
}