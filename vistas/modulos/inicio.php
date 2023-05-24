<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Tablero
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
        <li class="active">Tablero</li>
      </ol>
    </section>



    

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <?php
        
        if($_SESSION["perfil"]=="1" || $_SESSION["perfil"]=="2" || $_SESSION["perfil"]=="3"){

           include "inicio/cajas-superiores.php";
         }
        ?>
      </div> 
      <div class="row">

        <div class="col-lg-12">
          <?php

          if($_SESSION["perfil"]=="1" || $_SESSION["perfil"]=="2" || $_SESSION["perfil"]=="3"){
            include "reportes/grafico-ventas.php";
          }
          ?>
        </div> 
        <div class="col-lg-6">
          <?php 
           if($_SESSION["perfil"]=="1" || $_SESSION["perfil"]=="2" || $_SESSION["perfil"]=="3"){

             include "reportes/productos-mas-solicitados.php";


           }
            
        ?>
        </div> 

        <div class="col-lg-6">
          <?php
           if($_SESSION["perfil"]=="1" || $_SESSION["perfil"]=="2" || $_SESSION["perfil"]=="3"){

             include "inicio/productos-recientes.php";


           }
          
          ?>
        </div> 
        <div class="col-lg-12">
          
          <?php
            /*if($_SESSION["perfil"]==1||$_SESSION["perfil"]== "Vendedor"){
            echo '<div class="box box-success">
              <div class=box-header>
                <h1>Bienvenid@ ' . $_SESSION["nombre"] .' '.$_SESSION["apellido"]. '</h1>
              </div>
            </div>';
            }*/

          ?>
        </div>


      <!-- </div> -->
     

    </section>
    <!-- /.content -->
  </div>