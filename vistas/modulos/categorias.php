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
       Gestión de Categorias
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
        <li class="active">Administrar Categorias</li>
      </ol>
    </section>



    

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">

        <div class="box-header with-border">

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">Agregar Categoria</button>

         

        </div>


        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" >

            <thead>
              
              <tr>
                <th>#</th>
                <th>Categoria</th>
                <th>Acciones</th>
              </tr>

            </thead>
            <tbody>
            <?php 
              $item=null;
              $valor=null;
              $categorias =ControladorCategorias::ctrMostrarCategorias($item,$valor); 
             
              foreach($categorias as $key=>$value):?>

                <tr>
                  <td><?php echo ($key+1); ?></td>
                  <td><?php echo $value["categoria"]; ?></td>
                  <td>

                    <div class="btn-group">
                      <button class="btn btn-warning btnEditarCategoria" idCategoria="<?php echo $value["id_categoria"];?>" data-toggle="modal" data-target="#modalEditarCategoria"><i class="fa fa-pencil"></i></button>
                      <?//php if($_SESSION["perfil"]=="Administrador"):?>
                        <button class="btn btn-danger btnEliminarCategoria" idCategoria="<?php echo $value["id_categoria"];?>"><i class="fa fa-times"></i></button>
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
          MODAL AGREGAR CATEGORIA
 **************************************-->

  <div id="modalAgregarCategoria" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <!-- -->
      <div class="modal-content">

      <form role="form" method="post">


          <!-- **********************************
                    CABEZA DEL MODAL
          **************************************-->

          <div class="modal-header" style="background:#3c8dbc; color:white">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <h4 class="modal-title">Agregar Categoría</h4>

          </div>
          <!-- **********************************
                  CUERPO DEL MODAL
          **************************************-->

          <div class="modal-body">

            <div class="box-body">
              <!--Entrada de nombre-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <input type="text" class="form-control input-lg" name="nuevaCategoria" placeholder="Ingresar Categoria" required>
                </div>
              </div>

              

            </div>

          </div>
          <!-- **********************************
                    PIE DEL MODAL
          **************************************-->
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary ">Guardar Categoría</button>
          </div>
        </div>
        <?php 
          $crearCategoria = new ControladorCategorias();
          $crearCategoria->ctrCrearCategoria();
        ?>
      </form>

    </div>
  </div>

  <!-- **********************************
          MODAL EDITAR CATEGORIA
 **************************************-->

 <div id="modalEditarCategoria" class="modal fade" role="dialog">

<div class="modal-dialog">

  <!-- -->
  <div class="modal-content">

  <form role="form" method="post">


      <!-- **********************************
                CABEZA DEL MODAL
      **************************************-->

      <div class="modal-header" style="background:#3c8dbc; color:white">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Editar Categoría</h4>

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
              <input type="text" class="form-control input-lg" name="editarCategoria"  id="editarCategoria" required>
              <input type="hidden" name="idCategoria" id="idCategoria" >
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
       $editarCategoria = new ControladorCategorias();
       $editarCategoria->ctrEditarCategoria();
    ?>
  </form>

</div>
</div>

<?php 
       $borrarCategoria = new ControladorCategorias();
       $borrarCategoria->ctrBorrarCategoria();
    ?>

