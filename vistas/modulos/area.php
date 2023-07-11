<?php
//    if ($_SESSION["perfil"]!="1") {
//    echo '<script>
//        window.location="inicio";
//      </script>';
//    return;
//    }
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Gestión de Áreas
        
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

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarArea">Agregar Area</button>

         

        </div>


        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" >

            <thead>
              
              <tr>
                <th>#</th>
                <th>AREA INSTITUCIONAL</th>
                <th>Acciones</th>
              </tr>

            </thead>
            <tbody>
            <?php 
              $item=null;
              $valor=null;
              $areas =ControladorArea::ctrMostrarAreas($item,$valor); 
             
              foreach($areas as $key=>$value):?>

                <tr>
                  <td><?php echo ($key+1); ?></td>
                  <td><?php echo $value["nombre_area"]; ?></td>
                  <td>

                    <div class="btn-group">
                      
                      <?php if($_SESSION["perfil"]="1"):?>
                        <button class="btn btn-warning btnEditarArea" idArea="<?php echo $value["id_area"];?>" data-toggle="modal" data-target="#modalEditarArea"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btnEliminarArea" idArea="<?php echo $value["id_area"];?>"><i class="fa fa-times"></i></button>
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
          MODAL AGREGAR AREA
 **************************************-->

  <div id="modalAgregarArea" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <!-- -->
      <div class="modal-content">

      <form role="form" method="post">


          <!-- **********************************
                    CABEZA DEL MODAL
          **************************************-->

          <div class="modal-header" style="background:#3c8dbc; color:white">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <h4 class="modal-title">Agregar Area</h4>

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
                  <input type="text" class="form-control input-lg" name="nuevaArea" placeholder="Ingresar Area" onkeyup="javascript:this.value=this.value.toUpperCase()"  required>
                </div>
              </div>

              

            </div>

          </div>
          <!-- **********************************
                    PIE DEL MODAL
          **************************************-->
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary ">Guardar Area</button>
          </div>
        </div>
        <?php 
          $crearArea = new ControladorArea();
          $crearArea->ctrAgregarArea();
        ?>
      </form>

    </div>
  </div>

  <!-- **********************************
          MODAL EDITAR AREA
 **************************************-->

 <div id="modalEditarArea" class="modal fade" role="dialog">

<div class="modal-dialog">

  <!-- -->
  <div class="modal-content">

  <form role="form" method="post">


      <!-- **********************************
                CABEZA DEL MODAL
      **************************************-->

      <div class="modal-header" style="background:#3c8dbc; color:white">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Editar Area de la Organización</h4>

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
              <input type="text" class="form-control input-lg" name="editarArea"  id="editarArea" required>
              <input type="hidden" name="idArea" id="idArea" >
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
        $editarArea = new ControladorArea();
        $editarArea->ctrEditarArea();
    ?>
  </form>

</div>
</div>

<?php 
        $borrarArea = new ControladorArea();
        $borrarArea->ctrEliminarArea();
    ?>

