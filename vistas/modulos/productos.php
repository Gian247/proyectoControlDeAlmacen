<?php
   if ($_SESSION["perfil"]!="1" && $_SESSION["perfil"]!="2" && $_SESSION["perfil"]!="3") {
    echo '<script>
        window.location="inicio";
      </script>';
    return;
    }
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Almacén Productos
        
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
        <a href="vistas/modulos/descargarExcelProductos.php?reporteProductos=reporteOk">
              <button class="btn btn-success" style="margin-top:5px">Exportar Excel</button>
            </a>

          <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarEntrada">Agregar Productos</button> -->
          <div class="box-tools pull-right">
          

            

          </div>
        </div>
        


        <div class="box-body">
          <table class="table table-bordered table-striped tablas " >

            <thead>
              
              <tr>
                <th>#</th>
                <th>Lote Ingreso</th>
                <th>Código Único Producto</th>
                <th>Producto</th>
                <th>Utilidad Producto</th>
                <th>Stock Entrante Almacén</th>
                <th>Stock Disponible</th>
                <th>P.unitario</th>
                <th>P.Lote</th>
                <th>Ingreso</th>
               
                
              </tr>

            </thead>
            <tbody>
            <?php 
              $item=null;
              $valor=null;
              $orden="id_producto";
              $productos = ControladorProductos::ctrMostrarProductos($item, $valor,$orden);
              
             
              foreach($productos as $key=>$value):?>
                <?php
                $itemCategoria = "id_categoria";
                $valorCategoria = $value["id_categoria"];
                $categoria=ControladorCategorias::ctrMostrarCategorias($itemCategoria,$valorCategoria)
                ?>

                <tr>
                  <td><?php echo ($key+1); ?></td>
                  <td><?php echo $value["codigo_ingreso"]; ?></td>
                  <td><?php echo $value["id_producto"]; ?></td>
                  <td><?php echo $value["descripcion"]; ?></td>
                  <td><?php echo $categoria["categoria"]; ?></td>
                  <td><?php echo $value["stock"]; ?></td>
                  <td><?php echo $value["stockDisponible"]; ?></td>
                  <td><?php echo "S/. ".$value["costo_unitario"]; ?></td>
                  <td><?php echo "S/. ".$value["costo_lote"]; ?></td>
                  <td><?php echo $value["fecha_ingreso"]; ?></td>

                 
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
            <button type="submit"  class="btn btn-primary">Guardar Entrada</button>
          </div>
        </div>
        <?php 
          $crearPerfil = new ControladorEntradasAlmacen();
          $crearPerfil->ctrCrearEntrada();
        ?>
      </form>

    </div>
  </div>

  <!-- **********************************
          MODAL EDITAR PERFIL
 **************************************-->

 <div id="modalEditarPerfil" class="modal fade" role="dialog">

<div class="modal-dialog">

  <!-- -->
  <div class="modal-content">

  <form role="form" method="post">


      <!-- **********************************
                CABEZA DEL MODAL
      **************************************-->

      <div class="modal-header" style="background:#3c8dbc; color:white">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Editar Perfil de Usuario</h4>

      </div>
      <!-- **********************************
              CUERPO DEL MODAL
      **************************************-->

      <div class="modal-body">

        <div class="box-body">
          <!--Entrada el nombre de la categoria-->
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-th"></i></span>
              <input type="text" class="form-control input-lg" name="editarPerfil"  id="editarPerfil" required>
              <input type="hidden" name="idPerfil" id="idPerfil" >
            </div>
          </div>

          

        </div>

      </div>
      <!-- **********************************
                PIE DEL MODAL
      **************************************-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary ">Guardar Cambios</button>
      </div>
    </div>
    <?php 
        // $editarCategoria = new ControladorPerfil();
        // $editarCategoria->ctrEditarPerfil();
    ?>
  </form>

</div>
</div>

<?php 
    //    $borrarCategoria = new ControladorCategorias();
    //    $borrarCategoria->ctrBorrarCategoria();
    ?>

