<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

//Esta clase recibe lo que se esta enviando por medio de AJAX mediante post

class AjaxUsuarios{

	/*=============================================
	EDITAR USUARIO
	=============================================*/	

	//Sirve para recoger el id usuario que enviara javascript
	public $idUsuario;
	//Cuando se ejecuta captura el idUsuario
	public function ajaxEditarUsuario(){
		//Para evaluar en la base de datos en el where
		$item = "id_usuario";
		//El valor buscado en la base de datos
		$valor = $this->idUsuario;
		//Solicita al controlador que muestre los usuarios
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		//Retornamos un echo codificado en json
		echo json_encode($respuesta);

	}

	/*=============================================
	ACTIVAR USUARIO
	=============================================*/	

	public $activarUsuario;
	public $activarId;


	public function ajaxActivarUsuario(){

		$tabla = "usuario";

		$item1 = "estado";
		$valor1 = $this->activarUsuario;

		$item2 = "id_usuario";
		$valor2 = $this->activarId;

		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
		return $respuesta;

	}

	/*=============================================
	VALIDAR NO REPETIR USUARIO
	=============================================*/	

	public $validarUsuario;

	public function ajaxValidarUsuario(){

		//Para evaluar en la base de datos
		$item = "user";
		$valor = $this->validarUsuario;
		//Solicita al controlador que muestre los usuarios
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR USUARIO
=============================================*/
//Validamos que la variable post venga con informacion
if(isset($_POST["idUsuario"])){
    //0bjeto de la clase AjaxUsuarios
	$editar = new AjaxUsuarios();
	//Enlaza el atributo de idUsuario con lo que venga mediante POST con AJAX
	$editar -> idUsuario = $_POST["idUsuario"];
	//Se ejecuta el metodo 
	$editar -> ajaxEditarUsuario();

}

/*=============================================
ACTIVAR USUARIO
=============================================*/	

if(isset($_POST["activarUsuario"])){

	$activarUsuario = new AjaxUsuarios();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario();

}

/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/
//
if(isset( $_POST["validarUsuario"])){
	//0bjeto de la clase AjaxUsuarios
	$valUsuario = new AjaxUsuarios();

	$valUsuario -> validarUsuario = $_POST["validarUsuario"];
	$valUsuario -> ajaxValidarUsuario();

}