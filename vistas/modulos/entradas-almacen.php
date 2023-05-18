<?php
//   if ($_SESSION["perfil"]=="Vendedor") {
//   echo '<script>
//       window.location="inicio";
//     </script>';
//   return;
//   }
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Gestión Entradas Almacén
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
        <li class="active">Gestion Entradas</li>
      </ol>
    </section>



    

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">

        <div class="box-header with-border">

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarEntrada">Agregar Entradas</button>

         

        </div>


        <div class="box-body">
          <table class="table table-bordered table-striped tablas " >

            <thead>
              
              <tr>
                <th>#</th>
                <th>Código Entrada Almacén</th>
                <th>Proveedor</th>
                <th>Fecha de Ingreso</th>
                <th>Productos</th>
                <th>Monto</th>
                <th>Acciones</th>
              </tr>

            </thead>
            <tbody>
            <?php 
              $item=null;
              $valor=null;
              $entradas = ControladorEntradasAlmacen::ctrMostrarEntradas($item, $valor);
              
             
              foreach($entradas as $key=>$value):?>
                <?php
                //Obteniendo los proveedores
                $itemProveedor = "id_proveedor";
                $valorProveedor = $value["id_proveedor"];
                $proveedores = ControladorProveedor::ctrMostrarProveedor($itemProveedor,$valorProveedor);
                //Obteniendo la cantidad de productos por ingreso y el total de la suma de los productos por ingreso
                $itemConsulta = "codigo_ingreso";
                $valorConsulta=$value["id_ingreso"];
                $productosCantidad = ControladorProductosEntradas::ctrMostrarProductosEntradas($itemConsulta, $valorConsulta);
                $totalProductoPorEntrada = count($productosCantidad);

                $sumaTotalProductos = ControladorProductosEntradas::ctrSumarProductosLote($itemConsulta,$valorConsulta);
                //Validando si se han realizado cambios actualizar la base de datos con los cambios
                if($value["total_productos"]!= $totalProductoPorEntrada){
                  $datos=array("id"=>$value["id_ingreso"],"nuevoValor"=>$totalProductoPorEntrada);
                  $campo = "total_productos";
                  
                 $actualizarTotalEntrada = new ControladorEntradasAlmacen();
                  $actualizarTotalEntrada->ctrActualizarTablaIngreso($campo, $datos);
                };
                if(round($value["monto_ingreso"],2) != round($sumaTotalProductos["total"],2)){
                  
                  $datos=array("id"=>$value["id_ingreso"],"nuevoValor"=>$sumaTotalProductos["total"]);
                  $campo = "monto_ingreso";
                  
                  $actualizarTotalEntrada = new ControladorEntradasAlmacen();
                  $actualizarTotalEntrada->ctrActualizarTablaIngreso($campo, $datos);

                };
                ?>

                <tr>
                  <td><?php echo ($key+1); ?></td>
                  <td><?php echo $value["id_ingreso"]; ?></td>
                  <td><?php echo $proveedores["nombre_proveedor"]; ?></td>
                  <td><?php echo $value["fecha_ingreso"]; ?></td>
                  <td><?php echo $value["total_productos"];?></td>
                  <td><?php echo number_format($sumaTotalProductos["total"],2);?></td>


                  <td>

                    <div class="btn-group">
                      <button title="Agregar Producto" class="btn btn-success btnVerSolicitados" idEntrada="<?php echo $value["id_ingreso"];?>" fEntrada="<?php echo $value["fecha_ingreso"]; ?>"><i class="fa fa-eye"></i></button>
                      <button class="btn btn-info btnImprimirProductosLoteEntrada" codigoEntradaAlmacen="<?php echo $value["id_ingreso"];?>" >
                        <i class="fa fa-print">
                      </i></button>
                      <!-- <button title="Editar Producto" class="btn btn-warning btnEditarPerfil" idPerfil="<?//php echo $value["id_ingreso"];?>" data-toggle="modal" data-target="#modalEditarPerfil"><i class="fa fa-pencil"></i></button> -->
                      <?//php if($_SESSION["perfil"]=="Administrador"):?>
                      <?//php endif; ?>
                    </div>
                  </td>

                </tr>
              <?php endforeach;?>
             

            </tbody>
          </table>
        </div>

       
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
</div>


<!-- **********************************
          MODAL AGREGAR ENTRADAS
 **************************************-->

  <div id="modalAgregarEntrada" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <!-- -->
      <div class="modal-content">

      <form role="form" method="post">


          <!-- **********************************
                    CABEZA DEL MODAL
          **************************************-->

          <div class="modal-header" style="background:#3c8dbc; color:white">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <h4 class="modal-title">Agregar Entrada</h4>

          </div>
          <!-- **********************************
                  CUERPO DEL MODAL
          **************************************-->

          <div class="modal-body">

            <div class="box-body">

              <!--Entrada de Proveedor-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <select class="form-control input-lg" name="ingresoEntradaProveedor" id="">
                    <option value="">Seleccione Proveedor</option>
                    <?php
                    $item = null;
                    $valor = null;
                    $proveedor = ControladorProveedor::ctrMostrarProveedor($item, $valor);
                    foreach ($proveedor as $key => $value):?>
                      <option value="<?php echo $value["id_proveedor"];?>"><?php echo $value["nombre_proveedor"];?></option>

                    <?php endforeach;?>

                  </select>
                </div>
              </div>
            
            </div>

          </div>
          <!-- **********************************
                    PIE DEL MODAL
          **************************************-->
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary ">Guardar Entrada</button>
          </div>
        </div>
        <?php 
          $crearPerfil = new ControladorEntradasAlmacen();
          $crearPerfil->ctrCrearEntrada();
        ?>
      </form>

    </div>
  </div>


<?php 
    //    $borrarCategoria = new ControladorCategorias();
    //    $borrarCategoria->ctrBorrarCategoria();
?>

