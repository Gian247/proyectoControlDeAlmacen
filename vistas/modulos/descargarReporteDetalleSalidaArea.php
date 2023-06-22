<?php



require_once "../../controladores/detalleSalidaArea.controlar.php";
require_once "../../modelos/detalleSalidaArea.modelo.php";

$reporte = new ControladorDetalleSalidaArea;
$reporte -> ctrDescargarReporteDetalleArea();