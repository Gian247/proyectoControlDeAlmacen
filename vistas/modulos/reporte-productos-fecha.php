<?php
//    if ($_SESSION["perfil"]!="1" && $_SESSION["perfil"]!="2" && $_SESSION["perfil"]!="3") {
//     echo '<script>
//         window.location="inicio";
//       </script>';
//     return;
//     }
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Reporte de salida de productos

    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Productos</li>
    </ol>
  </section>





  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">

      <div class="box-header with-border">
        <div class="input-group">
          <button type="button" class="btn btn-default " id="daterange-btn">
            <span>
              <i class="fa fa-calendar"></i> Rango de fecha
            </span>
            <i class="fa fa-caret-down"></i>
          </button>
        </div>

        
      </div>



      <div class="box-body">
        <div class="col-xs-12">
          <?php
          //include "reportesFiltrados/cajasSuperioresFiltradas.php";
          ?>
        </div>

        <br><br>     
        <div class="col-xs-12" style="text-align: center;">
          <h1 style="text-align: center;">REPORTE SALIDA DE PRODUCTOS X FECHA</h1>
          <br>
          <div class="box-tools pull-left">
            <?php

            if (isset($_GET["fechaInicial"])) {

              echo '<a href="vistas/modulos/descargarReporteDetalleSalidaProducto.php?reporte=reporte&fechaInicial=' . $_GET["fechaInicial"] . '&fechaFinal=' . $_GET["fechaFinal"] . '">';
            } else {

              echo '<a href="vistas/modulos/descargarReporteDetalleSalidaProducto.php?reporte=reporte">';
            }

            ?>
            <button class="btn btn-success" style="margin-top:5px">Descargar reporte en Excel</button>
            
            </a>
            <br><br> 
          </div>
        </div>

        <table class="table table-bordered table-striped tablas dt-responsive">

          <thead>

            <tr>
              <th>#</th>
              <th>Código Ingreso Almacén</th>
              <th>Código Único Producto</th>
              <th>Producto</th>
              <th>Cantidad Saliente</th>
              <th>Precio Unitario</th>



              <th>Total Salidas</th>
            </tr>

          </thead>
          <tbody>
            <?php
            if (isset($_GET["fechaInicial"])) {
              $fechaInicial = $_GET["fechaInicial"];
              $fechaFinal = $_GET["fechaFinal"];
            } else {
              $fechaInicial = null;
              $fechaFinal = null;
            }
            $item = null;
            $valor = null;

            $salidas = ControladorDetalleSalidaProductos::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

            foreach ($salidas as $key => $value) : ?>
              <?php

              ?>

              <tr>
                <td><?php echo ($key + 1); ?></td>
                <td><?php echo $value["codigoIngreso"]; ?></td>
                <td><?php echo $value["id_producto"]; ?></td>
                <td><?php echo $value["producto"]; ?></td>
                <td><?php echo $value["cantidad"]; ?></td>
                <td><?php echo "S/.".number_format($value["costo_unitario"],2); ?></td>

                <td><?php echo "S/. " . number_format($value["total"],2) ; ?></td>




              </tr>
            <?php endforeach; ?>


          </tbody>
        </table>
        <br><br>     
        <div class="col-xs-12" style="text-align: center;">
          <h1 style="text-align: center;">REPORTE SALIDA DE SOLICITANTES X FECHA</h1>
          <br>
          <div class="box-tools pull-left">
            <?php

            if (isset($_GET["fechaInicial"])) {

              echo '<a href="vistas/modulos/descargarReporteSalidaSolicitante.php?reporte=reporte&fechaInicial=' . $_GET["fechaInicial"] . '&fechaFinal=' . $_GET["fechaFinal"] . '">';
            } else {

              echo '<a href="vistas/modulos/descargarReporteSalidaSolicitante.php?reporte=reporte">';
            }

            ?>
            <button class="btn btn-success" style="margin-top:5px">Descargar reporte en Excel</button>
            
            </a>
            <br><br> 
          </div>
        </div>
        
        <table class="table table-bordered table-striped tablas dt-responsive">

          <thead>

            <tr>
              <th>#</th>

              <th>Id Solicitante</th>
              <th>Nombres</th>
              <th>Apellidos</th>

              <th>Total Valor Salidas</th>
            </tr>

          </thead>
          <tbody>
            <?php
            if (isset($_GET["fechaInicial"])) {
              $fechaInicial2 = $_GET["fechaInicial"];
              $fechaFinal2 = $_GET["fechaFinal"];
            } else {
              $fechaInicial2 = null;
              $fechaFinal2 = null;
            }
            $item = null;
            $valor = null;

            $salidas2 = ControladorDetalleSalidaUsuarios::ctrRangoFechasDetalleSalidasUsuarios($fechaInicial2, $fechaFinal2);

            foreach ($salidas2 as $key => $value) : ?>
              <?php

              ?>

              <tr>
                <td><?php echo ($key + 1); ?></td>
                <td><?php echo $value["id_solicitante"]; ?></td>
                <td><?php echo $value["nombres"]; ?></td>
                <td><?php echo $value["apellidos"]; ?></td>
                <td><?php echo "S/. " . $value["total"]; ?></td>




              </tr>
            <?php endforeach; ?>


          </tbody>
        </table>
         <br><br>     
        <div class="col-xs-12" style="text-align: center;">
          <h1 style="text-align: center;">REPORTE SALIDA DE ÁREAS X FECHA</h1>
          <br>
          <div class="box-tools pull-left">
            <?php

            if (isset($_GET["fechaInicial"])) {

              echo '<a href="vistas/modulos/descargarReporteDetalleSalidaArea.php?reporte=reporte&fechaInicial=' . $_GET["fechaInicial"] . '&fechaFinal=' . $_GET["fechaFinal"] . '">';
            } else {

              echo '<a href="vistas/modulos/descargarReporteDetalleSalidaArea.php?reporte=reporte">';
            }

            ?>
            <button class="btn btn-success" style="margin-top:5px">Descargar reporte en Excel</button>
            
            </a>
            <br><br> 
          </div>
        </div>
        

        <table class="table table-bordered table-striped tablas ">

          <thead>

            <tr>
              <th>#</th>

              <th>Id Area</th>
              <th>Nombre Area</th>
             
              <th>Total Salidas</th>
            </tr>

          </thead>
          <tbody>
            <?php
            if (isset($_GET["fechaInicial"])) {
              $fechaInicial3 = $_GET["fechaInicial"];
              $fechaFinal3 = $_GET["fechaFinal"];
            } else {
              $fechaInicial3 = null;
              $fechaFinal3 = null;
            }
            $item3 = null;
            $valor3 = null;

            $salidas3 = ControladorDetalleSalidaArea::ctrRangoFechasDetalleSalidasArea($fechaInicial3, $fechaFinal3);

            foreach ($salidas3 as $key => $value) : ?>
              <?php

              ?>

              <tr>
                <td><?php echo ($key + 1); ?></td>
                <td><?php echo $value["id_area"]; ?></td>
                <td><?php echo $value["nombre_area"]; ?></td>
                
                <td><?php echo "S/. " . $value["total"]; ?></td>




              </tr>
            <?php endforeach; ?>


          </tbody>
        </table>
      </div>


    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>




<!-- **********************************************
          MODAL VISUALIZAR PRODUCTOS ENTREGADOS
 **************************************************-->

 <div id="modalVisualizarProductosPorUsuario" class="modal fade" role="dialog">

<div class="modal-dialog">

  <!-- -->
  <div class="modal-content">

    <form role="form" method="post">


      <!-- **********************************
              CABEZA DEL MODAL
    **************************************-->

      <div class="modal-header" style="background:#3c8dbc; color:white">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title tituloModalVisualizar"></h4>

      </div>
      <!-- **********************************
            CUERPO DEL MODAL
    **************************************-->

      <div class="modal-body">

        <div class="box-body">


          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Productos Entregados</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table id="visualizarProd" class="table table-striped">
                <tr>
                  <th style="width: 10px">Codigo</th>
                  <th>Descripcion</th>
                  <th>Cantidad</th>
                  <th>Precio Unitario</th>
                </tr>




              </table>
            </div>
            <!-- /.box-body -->
          </div>





        </div>

      </div>
      <!-- **********************************
              PIE DEL MODAL
    **************************************-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

      </div>
  </div>
  <?php

  ?>
  </form>

</div>
</div>