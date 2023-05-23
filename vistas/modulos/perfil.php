<?php
   if ($_SESSION["perfil"]!="1") {
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
       Gestión de Perfiles
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
        <li class="active">Gestion Perfil</li>
      </ol>
    </section>



    

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">

        <div class="box-header with-border">

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarPerfil">Agregar Perfil de Usuario</button>

         

        </div>


        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" >

            <thead>
              
              <tr>
                <th>#</th>
                <th>Perfil de Usuarios</th>
                <th>Accionesn</th>
              </tr>

            </thead>
            <tbody>
            <?php 
              $item=null;
              $valor=null;
              $perfiles =ControladorPerfil::ctrMostrarPerfil($item,$valor); 
             
              foreach($perfiles as $key=>$value):?>

                <tr>
                  <td><?php echo ($key+1); ?></td>
                  <td><?php echo $value["perfil"]; ?></td>
                  <td>

                    <div class="btn-group">
                      
                      <?php if($_SESSION["perfil"]="1"):?>
                        <button class="btn btn-warning btnEditarPerfil" idPerfil="<?php echo $value["id_perfil"];?>" data-toggle="modal" data-target="#modalEditarPerfil"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btnEliminarPerfil" idPerfil="<?php echo $value["id_perfil"];?>"><i class="fa fa-times"></i></button>
                      <?php else:?>
                        <button class="btn btn-default">No Autorizado</button>
                      <?php endif; ?>
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
          MODAL AGREGAR PERFIL
 **************************************-->

  <div id="modalAgregarPerfil" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <!-- -->
      <div class="modal-content">

      <form role="form" method="post">


          <!-- **********************************
                    CABEZA DEL MODAL
          **************************************-->

          <div class="modal-header" style="background:#3c8dbc; color:white">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <h4 class="modal-title">Agregar Perfil</h4>

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
                  <input type="text" class="form-control input-lg" name="nuevoPerfil" placeholder="Ingresar Perfil" required>
                </div>
              </div>

              

            </div>

          </div>
          <!-- **********************************
                    PIE DEL MODAL
          **************************************-->
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary ">Guardar Perfil</button>
          </div>
        </div>
        <?php 
          $crearPerfil = new ControladorPerfil();
          $crearPerfil->ctrAgregarPerfil();
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
        $editarCategoria = new ControladorPerfil();
        $editarCategoria->ctrEditarPerfil();
    ?>
  </form>

</div>
</div>

<?php 
        $borrarCategoria = new ControladorPerfil();
        $borrarCategoria->ctrEliminarPerfil();
    ?>

