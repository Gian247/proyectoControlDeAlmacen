<?php
  if ($_SESSION["perfil"]=="Especial") {
  echo '<script>
      window.location="inicio";
    </script>';
  return;
  }
?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar ventas
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar ventas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="crear-salida">

          <button class="btn btn-primary">
            
            Agregar venta

          </button>

        </a>
        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
          <span>
            <i class="fa fa-calendar"></i> Rango de fecha
          </span>
          <i class="fa fa-caret-down"></i>
        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Código Salida</th>
           <th>Solicitante</th>
           <th>Recepción solicitud</th>
           
           <th>Valor Total Salida</th> 
           <th>Fecha Salida</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php
          /*if(isset($_GET["fechaInicial"])){
            $fechaInicial=$_GET["fechaInicial"];
            $fechaFinal=$_GET["fechaFinal"];
          }else{
            $fechaInicial=null;
            $fechaFinal=null;
          }*/
          $item = null;
          $valor = null;

          $respuesta = ControladorSalidas::ctrMostrarSalidas($item, $valor);

          foreach ($respuesta as $key => $value) {
           

           echo '<tr>

                  <td>'.($key+1).'</td>

                  <td>'.$value["codigo_salida"].'</td>';

                  $itemSolicitante = "id_solicitante";
                  $valorSolicitante = $value["id_solicitante"];

                  $respuestaSolicitante = ControladorSolicitantes::ctrMostrarSolicitantes($itemSolicitante, $valorSolicitante);

                  echo '<td>'.$respuestaSolicitante["nombres"].$respuestaSolicitante["apellidos"].'</td>';

                  $itemUsuario = "id_usuario";
                  $valorUsuario = $value["id_usuario"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                  echo '<td>'.$respuestaUsuario["nombres"].'</td>


                  <td>$ '.number_format($value["total_valor_salida"],2).'</td>

                  <td>'.$value["fecha_salida"].'</td>

                  <td>

                    <div class="btn-group">
                        
                      <button class="btn btn-info btnImprimirFactura" codigoVenta="'.$value["codigo_salida"].'">
                        <i class="fa fa-print">
                      </i></button>';
                      if($_SESSION["perfil"]=="Administrador"){
                        echo '<button class="btn btn-warning btnEditarVenta" idVenta="'.$value["id"].'"><i class="fa fa-pencil"></i></button>

                        <button class="btn btn-danger btnEliminarVenta" idVenta="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                      }
                      
                      

                    echo '</div>  

                  </td>

                </tr>';
            }

        ?>
               
        </tbody>

       </table>

       <?php

      /*$eliminarVenta = new ControladorVentas();
      $eliminarVenta -> ctrEliminarVenta();*/

      ?>
       

      </div>

    </div>

  </section>

</div>



