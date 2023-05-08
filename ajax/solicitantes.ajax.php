<?php
require_once "../controladores/solicitantes.controlador.php";
require_once "../modelos/solicitantes.modelo.php";

class AjaxSolicitantes{

	/*=============================================
	        EDITAR SOLICITANTES
	=============================================*/

    public $idSolicitante;

    public function ajaxEditarSolicitante(){
        $item = "id_solicitante";
        $valor = $this->idSolicitante;
        $respuesta = ControladorSolicitantes::ctrMostrarSolicitantes($item,$valor);
        echo json_encode($respuesta);


    }
}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idSolicitante"])){

	$categoria = new AjaxSolicitantes();
	$categoria -> idSolicitante = $_POST["idSolicitante"];
	$categoria -> ajaxEditarSolicitante();
}