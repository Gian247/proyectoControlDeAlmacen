<?php

error_reporting(0);

if(isset($_GET["fechaInicial"])){

    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];

}else{

$fechaInicial = null;
$fechaFinal = null;

}

$respuesta = ControladorSalidas::ctrRangoFechasSalidas($fechaInicial, $fechaFinal);

$arrayFechas = array();
$arrayVentas = array();
$sumaPagosMes = array();

foreach ($respuesta as $key => $value) {

	#Capturamos sólo el año y el mes
    //sustraemos 7 unidades para que me quite la hora y el dia
	$fecha = substr($value["fecha_salida"],0,7);

	#Introducir las fechas en arrayFechas
	array_push($arrayFechas, $fecha);
    
	#Capturamos las ventas
	$arrayVentas = array($fecha => $value["total_valor_salida"]);
    
	#Sumamos los pagos que ocurrieron el mismo mes
	foreach ($arrayVentas as $key => $value) {

		$sumaPagosMes[$key] += $value;
	}
    


}


$noRepetirFechas = array_unique($arrayFechas);


?>

<!--=====================================
GRÁFICO DE VENTAS
======================================-->


<div class="box box-solid bg-teal-gradient">
	
	<div class="box-header">
		
 		<i class="fa fa-th"></i>

  		<h3 class="box-title">Gráfico de Salidas de Almacén</h3>

	</div>

	<div class="box-body border-radius-none nuevoGraficoVentas">

		<div class="chart" id="line-chart-ventas" style="height: 250px;"></div>

  </div>

</div>


<script>
var line = new Morris.Line({
    element          : 'line-chart-ventas',
    resize           : true,
    data             : [
        <?php
        if($noRepetirFechas!=null){
            foreach($noRepetirFechas as $key){
                echo "{ y: '".$key."', ventas: ".$sumaPagosMes[$key]."},";
            }
            echo "{ y: '".$key."', ventas: ".$sumaPagosMes[$key]." }";
          
        }else{
            echo "{ y: '0', ventas: '0' }";
        }
        
      ?>
    ],
    xkey             : 'y',
    ykeys            : ['ventas'],
    labels           : ['Total Salidas'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits         : 'S/. ',
    gridTextSize     : 15
  });
	

</script>