<?php
  /*if ($_SESSION["perfil"]=="Vendedor" || $_SESSION["perfil"]=="Especial") {
  echo '<script>
      window.location="inicio";
    </script>';
  return;
  }*/
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Reportes de ventas
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
        <li class="active">Reportes de ventas</li>
      </ol>
    </section>



    

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <div class="input-group">
            <button type="button" class="btn btn-default " id="daterange-btn2">
              <span>
                <i class="fa fa-calendar"></i> Rango de fecha
              </span>
              <i class="fa fa-caret-down"></i>
            </button>
          </div>
          
          
        </div>
        <div class="box-body">
          <!-- Creamos una fila -->
          <div class="row">
            <!-- Desde dispositivo pequeño hacia dispositivo grande que ocupe 12 columnas -->
            <div class="col-xs-12">
              <?php
                include "reportes/grafico-ventas.php";
              ?>
            </div>
            <!-- La mitad de la pagina de escritorio mediano hacia arriba -->
            <!-- Y que ocuoe las 12 columnas de dispositivos moviles-->
            <div class="col-md-6 col-xs-12">
              <?php
                include "reportes/productos-mas-solicitados.php";
              ?>
            </div>

            <div class="col-md-6 col-xs-12">
              <?php
                //include "reportes/vendedores.php";
              ?>
            </div>
            <div class="col-md-6 col-xs-12">
              <?php
                include "reportes/grafico-solicitantes.php";
              ?>
            </div>

          </div>
        </div>
       
      </div>

    </section>
  </div>