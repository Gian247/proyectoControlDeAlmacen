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
              Ingreso #<?php echo $_GET["ingreso"];  ?>

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

                  <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">Agregar
                      Productos</button>
                  <button class="btn btn-primary">Exportar</button>

                  <button class="btn btn-warning pull-right regresarEntradas">Regresar</button>
              </div>


              <div class="box-body">
                  <table class="table table-bordered table-striped tablas ">

                      <thead>

                          <tr>
                              <th>#</th>
                              <th>Codigo</th>
                              <th>Producto</th>
                              <th>Categoria</th>
                              <th>Stock</th>
                              <th>P.unitario</th>
                              <th>P.Lote</th>
                              <th>Ingreso</th>
                              <th>Acciones</th>

                          </tr>

                      </thead>
                      <tbody>
                          <?php 
                $item="codigo_ingreso";
                $valor=$_GET["ingreso"];
                  var_dump($valor);
                $filtroProducto = ControladorProductosEntradas::ctrMostrarProductosEntradas($item,$valor);
              
                foreach($filtroProducto as $key=>$value):?>
                          <?php
                  $itemCategoria = "id_categoria";
                  $valorCategoria = $value["id_categoria"];
                  $categoria=ControladorCategorias::ctrMostrarCategorias($itemCategoria,$valorCategoria)
                  ?>

                          <tr>
                              <td><?php echo ($key+1); ?></td>
                              <td><?php echo $value["codigo_producto"]; ?></td>
                              <td><?php echo $value["descripcion"]; ?></td>
                              <td><?php echo $categoria["categoria"]; ?></td>
                              <td><?php echo $value["stock"]; ?></td>
                              <td><?php echo $value["costo_unitario"]; ?></td>
                              <td><?php echo $value["costo_lote"]; ?></td>
                              <td><?php echo $value["fecha_ingreso"]; ?></td>

                              <td>
                                  <div class="btn-group">
                                  <button class="btn btn-warning btnEditarUsuario" data-toggle="modal" idEntradaProducto="<?php //echo $value["id_EntradaProducto"] ;?>" data-target="#modalEditarEntradaProducto"><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-danger"><i class="fa fa-times btnEliminarEntradaProducto" idEntradaProducto="<?php echo $value["id_producto"];?>" ingreso="<?php echo $_GET["ingreso"]; ?>" fecha="<?php echo $_GET["f"]; ?>"></i></button>

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
            MODAL AGREGAR PRODUCTOS
  **************************************-->

  <div id="modalAgregarProducto" class="modal fade" role="dialog">

      <div class="modal-dialog">

          <!-- -->
          <div class="modal-content">

              <form role="form" method="post">


                  <!-- **********************************
                      CABEZA DEL MODAL
            **************************************-->

                  <div class="modal-header" style="background:#3c8dbc; color:white">

                      <button type="button" class="close" data-dismiss="modal">&times;</button>

                      <h4 class="modal-title">REGISTRAR PRODUCTO</h4>

                  </div>
                  <!-- **********************************
                    CUERPO DEL MODAL
            **************************************-->

                  <div class="modal-body">

                      <div class="box-body">

                          <!--Entrada de codigo ingreso-->
                          <div class="form-group">
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                      <input type="number" class="form-control input-lg" name="nuevoCodigoEntrada" value="<?php echo $_GET["ingreso"];?>"readonly required>
                                  </div>
                          </div>
                         

                          <!--Entrada de nombre producto-->
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                  <input type="text" class="form-control input-lg" name="nuevoProductoEntrada"
                                      placeholder="PRODUCTO" required>
                              </div>
                          </div>

                          <!--Entrada de codigo producto-->
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                  <input type="text" class="form-control input-lg" name="nuevoCodigo"
                                      placeholder="CODIGO" required>
                              </div>
                          </div>

                          <!--Entrada de categoria-->
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                  <select class="form-control input-lg" name="nuevoProductoCategoria">
                                      <option value="">SELECCIONE CATEGORIA</option>
                                      <?php
                                         $item = null;
                                         $valor = null;
                                         $cate=ControladorCategorias::ctrMostrarCategorias($item,$valor);
                                         foreach ($cate as $key => $value):?>
                                        <option value="<?php echo $value["id_categoria"];?>"><?php echo $value["categoria"];?></option> 

                                      <?php endforeach;?>

                                  </select>
                              </div>
                          </div>
                          <!--Entrada de stock-->
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                  <input type="number" class="form-control input-lg" name="nuevoStock"
                                      placeholder="STOCK" required>
                              </div>
                          </div>
                          <!--Entrada de precio unitario-->
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                  <input type="number" step="any" class="form-control input-lg" name="nuevoPrecioUnitario"
                                      placeholder="PRECIO UNITARIO" required>
                              </div>
                          </div>

                          <!--Entrada de fecha ingreso-->
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                  <input type="text" class="form-control input-lg" name="nuevaFechaIngreso" value="<?php echo $_GET["f"]; ?>" readonly required>
                              </div>
                          </div>
                          

                      </div>

                  </div>
                  <!-- **********************************
                      PIE DEL MODAL
            **************************************-->
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                      <button type="submit" ingreso="<?php echo $_GET["ingreso"]; ?>" fecha="<?php echo $_GET["f"]; ?>" class="btn btn-primary botonGuia">Guardar Entrada</button>
                  </div>
          </div>
          <?php
          $nuevaEntradaProducto = new ControladorProductosEntradas;
          $nuevaEntradaProducto->ctrIngresarProductoEntradas();
          ?>
          </form>

      </div>
  </div>

  <!-- **********************************
            MODAL EDITAR PERFIL
  **************************************-->

  <div id="modalEditarEntradaProducto" class="modal fade" role="dialog">

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
                                  <input type="text" class="form-control input-lg" name="editarPerfil" id="editarPerfil"
                                      required>
                                  <input type="hidden" name="idPerfil" id="idPerfil">
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
          $editarCategoria = new ControladorPerfil();
          $editarCategoria->ctrEditarPerfil();
      ?>
          </form>

      </div>
  </div>

  <?php
  $borrarEntradaProducto = new ControladorProductosEntradas();
        $borrarEntradaProducto->ctrBorrarProductosEntradas();
      ?>