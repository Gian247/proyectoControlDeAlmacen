<?php
if ($_SESSION["perfil"]!="1" && $_SESSION["perfil"]!="2" && $_SESSION["perfil"]!="3") {
  echo '<script>
      window.location="inicio";
    </script>';
  return;
  }
?>
<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar Salidas

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar Salidas</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <a href="crear-salida">

          <button class="btn btn-primary">

            Agregar Salida

          </button>

        </a>
        <div class="box-tools pull-right">
          

            <a href="vistas/modulos/descargar-reporte.php?reporte=reporte">
              <button class="btn btn-success" style="margin-top:5px">Descargar reporte en Excel</button>
            </a>

          </div>

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

                  <td>' . ($key + 1) . '</td>

                  <td>' . $value["codigo_salida"] . '</td>';

              $itemSolicitante = "id_solicitante";
              $valorSolicitante = $value["id_solicitante"];

              $respuestaSolicitante = ControladorSolicitantes::ctrMostrarSolicitantes($itemSolicitante, $valorSolicitante);

              echo '<td>' . $respuestaSolicitante["nombres"] . $respuestaSolicitante["apellidos"] . '</td>';

              $itemUsuario = "id_usuario";
              $valorUsuario = $value["id_usuario"];

              $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

              echo '<td>' . $respuestaUsuario["nombres"] . '</td>


                  <td>S/. ' . number_format($value["total_valor_salida"], 2) . '</td>

                  <td>' . $value["fecha_salida"] . '</td>

                  <td>

                    <div class="btn-group">
                        
                      <button class="btn btn-info btnImprimirFactura" codigoSalida="' . $value["id_salida"] . '">
                        <i class="fa fa-print">
                      </i></button>
                      <button title="Visualizar Productos asignados" class="btn btn-success   btnVisualizarSalida" data-toggle="modal" data-target="#modalVisualizarProductos" idSalida="' . $value["id_salida"] . '"><i class="fa fa-eye"></i></button>';
                      if($_SESSION["perfil"]=="1"){
                        echo '<button class="btn btn-warning btnEditarSalida" idSalida="' . $value["id_salida"] . '"><i class="fa fa-pencil"></i></button>';
                      }
                      

              
              echo '</div>  

                  </td>

                </tr>';
            }


            $envioDeNotificacionCorreo=ControladorProductos::ctrMostrarProductos("producto",null,"id_producto");
            foreach ($envioDeNotificacionCorreo as $key => $value) {
              if($value["stockDisponible"]==0 && $value["envio_alerta"]==0){


                $para= "caguilar@limavillacollege.edu.pe".', ';
                $para.='gflores@limavillacollege.edu.pe';
                $titulo='Alerta de Productos Sistema LVC';
                $mensaje= '
                <html>
                  <head>
                    <title>Recordatorio de cumpleaños para Agosto</title>
                  </head>
                  <body>
                    <h3>Estimado usuario te informamos que el producto ya acabo su stock disponible</h3>
                    <br><br>
                    <table style="text-align:center; margin-left: auto; margin-right: auto; border-collapse: collapse;">
                      <tr>
                        <th>Código Único </th><th>Lote Ingreso </th><th>Descripción </th><th>Stock Disponible </th>
                      </tr>
                      <tr>
                        <td >'.$value["id_producto"].'</td><td>'.$value["codigo_ingreso"].'</td><td>'.$value["descripcion"].'</td><td>'.$value["stockDisponible"].'</td>
                      </tr>
                      
                    </table>
                  </body>
                  </html>
                ';

                $cabeceras = 'MIME-Version: 1.0'."\r\n";
                $cabeceras.='Content-type: text/html; charset=iso-8859-1'."\r\n";
                
                mail($para,$titulo,$mensaje,$cabeceras);

                $ActualizarAlertaProducto=ControladorProductos::ctrEditarAlertaStockAgotado($value["id_producto"], $value["envio_alerta"]);

              }
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



<!-- **********************************************
          MODAL VISUALIZAR PRODUCTOS ENTREGADOS
 **************************************************-->

<div id="modalVisualizarProductos" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <!-- -->
    <div class="modal-content">

      <form role="form" method="post">


        <!-- **********************************
                CABEZA DEL MODAL
      **************************************-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title tituloModalVisualizar" ></h4>

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