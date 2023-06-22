<?php



require_once "../../controladores/detalleSalidaProducto.controlador.php";
require_once "../../modelos/detalleSalidaProducto.modelo.php";

$reporte = new ControladorDetalleSalidaProductos;
$reporte -> ctrDescargarReporteDetalleProducto();