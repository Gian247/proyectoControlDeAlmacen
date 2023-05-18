<?php
$item=null;
$valor = null;
$salidas = ControladorSalidas::ctrMostrarSalidas($item,$valor);
$solicitantes = ControladorSolicitantes::ctrMostrarSolicitantes($item,$valor);

$arraySolicitantes = array();
$arrayListaSolicitantes = array();
$sumaTotalSolicitantes = array();

foreach($salidas as $key => $valueSalidas){
    foreach ($solicitantes as $key => $valueSolicitantes) {
        if($valueSolicitantes["id_solicitante"]==$valueSalidas["id_solicitante"]){
            #Capturamos los vendedores en un array
            
            array_push($arraySolicitantes, $valueSolicitantes["nombres"]);
            #Capturamos los nombres y lo valores netos en un mismo array
            $arrayListaSolicitantes = array($valueSolicitantes["nombres"] => $valueSalidas["total_valor_salida"]);
            #Sumamos los netos de cada vendedor
            foreach ($arrayListaSolicitantes as $key => $value) {
                # code...
                $sumaTotalSolicitantes[$key] += $value;
            }
        }
        
    }
}
# Evitamos repetir nombres
$noRepetirNombres = array_unique($arraySolicitantes);

?>
<!-- ========================================================
                    VENDEDORES
============================================================= -->

<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Valor salidas de Solicitantes</h3>
    </div>
    <div class="box-body">
        <div class="chart-responsive">
            <div class="chart" id="bar-chart1" style="height: 300px;"></div>
        </div>
    </div>
</div>
<script>
    //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart1',
      resize: true,
      data: [

        <?php
            foreach ($noRepetirNombres as $value) {

                # code...
        
            echo "{y: '".$value."', a: ".$sumaTotalSolicitantes[$value]."},";
            }
        ?>
        
        
      ],
      barColors: ['#AF0529'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['ventas'],
      preUnits: 'S/.',
      hideHover: 'auto'
    });
</script>