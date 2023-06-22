<?php
$item = null;
$valor = null;
$orden = "id";



$salidas=ControladorDetalleSalidaProductos::ctrSumaTotalSalidasFiltradoFecha();
// $ingresos=ControladorEntradasAlmacen::ctrSumaTotalIngresos();

// $solicitantes=ControladorSolicitantes::ctrMostrarSolicitantes($item,$valor);
//$totalSolicitantes=count($solicitantes);
?>
<div class="col-lg-4 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>S/. <?php echo number_format($salidas["0"]["totalValor"],2); ?></h3>

      <p>SALIDAS PRODUCTOS</p>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-arrow-up"></i>
    
    </div>
    
    <a href="salidas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>








