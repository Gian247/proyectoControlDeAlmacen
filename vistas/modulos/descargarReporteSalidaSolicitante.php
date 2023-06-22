<?php


//require_once "../../controladores/area.controlador.php";
//require_once "../../modelos/area.modelo.php";
require_once "../../controladores/detalleSalidasUsuario.controlador.php";
require_once "../../modelos/detalleSalidaUsuario.modelo.php";

$reporte = new ControladorDetalleSalidaUsuarios;
$reporte -> ctrDescargarReporteDetalleSolicitantes();