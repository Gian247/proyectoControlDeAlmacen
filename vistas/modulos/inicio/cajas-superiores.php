<?php
$item = null;
$valor = null;
$orden = "id";



$salidas=ControladorSalidas::ctrSumaTotalSalidas();

$ingresos=ControladorEntradasAlmacen::ctrSumaTotalIngresos();

$solicitantes=ControladorSolicitantes::ctrMostrarSolicitantes($item,$valor);
$totalSolicitantes=count($solicitantes);
?>
<div class="col-lg-4 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>S/. <?php echo number_format($salidas["total"],2); ?></h3>

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


<div class="col-lg-4 col-xs-6">

  <div class="small-box bg-yellow">
    
    <div class="inner">
    
    <h3>S/. <?php echo number_format($ingresos["total"],2); ?></h3>

      <p>INVERSIÓN EN PRODUCTOS</p>
  
    </div>
    
    <div class="icon">
    
      <i class="fa fa-arrow-down"></i>
    
    </div>
    
    <a href="productos" class="small-box-footer">

      Más info <i class="fa fa-arrow-circle-right"></i>

    </a>

  </div>

</div>



<div class="col-lg-4 col-xs-6">

  <div class="small-box bg-green">
    
    <div class="inner">
    
      <h3><?php echo number_format($totalSolicitantes); ?></h3>

      <p>SOLICITANTES</p>
    
    </div>
    
    <div class="icon">
    
      <i class="fa fa-user"></i>
    
    </div>
    
    <a href="solicitantes" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

