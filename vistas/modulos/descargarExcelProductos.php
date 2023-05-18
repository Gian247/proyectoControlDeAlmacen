<?php




require_once "../../controladores/categorias.controlador.php";
require_once "../../modelos/categorias.modelo.php";
require_once "../../controladores/productos.controlador.php";
require_once "../../modelos/productos.modelo.php";

$reporte = new ControladorProductos;
$reporte -> ctrDescargarReporteExcel();