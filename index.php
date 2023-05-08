<?php

//Reporte de errores
ini_set('display_errors', 1);
ini_set('log_errors',1);
ini_set("error_log","/var/www/html/lvclogistica/php_error_log");

//Requiere al los controladores
require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/perfil.controlador.php";
require_once "controladores/proveedor.controlador.php";
require_once "controladores/entradas-almacen.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/productos-entradas.controlador.php";
require_once "controladores/solicitantes.controlador.php";
require_once "controladores/salidas.controlador.php";



//Requiere a los modelos

require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/perfil.modelo.php";
require_once "modelos/proveedor.modelo.php";
require_once "modelos/entradas-almacen.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/solicitantes.modelo.php";

require_once "modelos/productos-entradas.modelo.php";
require_once "modelos/salidas.modelo.php";





$plantilla = new ControladorPlantilla();
$plantilla->ctrPlantilla();