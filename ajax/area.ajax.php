<?php

require_once "../controladores/area.controlador.php";
require_once "../modelos/area.modelo.php";

class AjaxArea{

	/*=============================================
	EDITAR AREA
	=============================================*/

    public $idArea;

	public function ajaxEditarArea(){

		$item = "id_area";
		$valor = $this->idArea;

        
		$respuesta2 = ControladorArea::ctrMostrarAreas($item, $valor);
        
		echo json_encode($respuesta2);

	}
}

/*=============================================
EDITAR AREA
=============================================*/	
if(isset($_POST["idArea"])){
    
	$categoria = new AjaxArea();
	$categoria -> idArea = $_POST["idArea"];
	$categoria -> ajaxEditarArea();
    
}