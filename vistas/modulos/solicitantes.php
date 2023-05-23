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
       Gestión de Solicitantes
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
        <li class="active">Administrar Solicitantes</li>
      </ol>
    </section>



    

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">

        <div class="box-header with-border">

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarSolicitante">Agregar Solicitante</button>

         

        </div>


        <div class="box-body">
          <table class="table table-bordered table-striped tablas " >

            <thead>
              
              <tr>
                <th>#</th>
                <th>Nombres</th>
                <th>Apellidos </th>
                <th># Documento </th>
                <th>Cargo</th>
                <th>Solicitudes </th>
                <th>Ultima Solicitud </th>
                <th>Correo </th>
                <th>Acciones </th>
              </tr>

            </thead>
            <tbody>
            <?php 
              $item=null;
              $valor=null;
              $solicitantes =ControladorSolicitantes::ctrMostrarSolicitantes($item,$valor); 
             
              foreach($solicitantes as $key=>$value):?>

                <tr>
                  <td><?php echo ($key+1); ?></td>
                  <td><?php echo $value["nombres"]; ?></td>
                  <td><?php echo $value["apellidos"]; ?></td>
                  <td><?php echo $value["documento"]; ?></td>
                  <td><?php echo $value["id_perfil"]; ?></td>
                  <td><?php echo $value["solicitudes"]; ?></td>
                  <td><?php echo $value["ultima_solicitud"]; ?></td>
                  <td><?php echo $value["correo"]; ?></td>
                  <td>

                    <div class="btn-group">
                      <button class="btn btn-warning btnEditarSolicitante" idSolicitante="<?php echo $value["id_solicitante"];?>" data-toggle="modal" data-target="#modalEditarSolicitante"><i class="fa fa-pencil"></i></button>
                      <?php if($_SESSION["perfil"]=="1"):?>
                      <button class="btn btn-danger btnEliminarSolicitante" idSolicitante="<?php echo $value["id_solicitante"];?>"><i class="fa fa-times"></i></button>
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
          MODAL AGREGAR CATEGORIA
 **************************************-->

  <div id="modalAgregarSolicitante" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <!-- -->
      <div class="modal-content">

      <form role="form" method="post">


          <!-- **********************************
                    CABEZA DEL MODAL
          **************************************-->

          <div class="modal-header" style="background:#3c8dbc; color:white">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <h4 class="modal-title">Agregar Solicitante</h4>

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
                  <input type="text" class="form-control input-lg" name="nuevoNombreSolicitante" placeholder="Ingresar Nombre" required>
                </div>
              </div>
              <!--Entrada de apellido-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <input type="text" class="form-control input-lg" name="nuevoApellidoSolicitante" placeholder="Ingresar Apellido" required>
                </div>
              </div>
              <!--Entrada de dolcumento-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <input type="text" class="form-control input-lg" name="nuevaDocumentoSolicitante" placeholder="Ingrese # Documento" required>
                </div>
              </div>
              <!--Entrada de correo-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <input type="text" class="form-control input-lg" name="nuevoCorreoSolicitante" placeholder="Ingresar Correo del Solicitante" required>
                </div>
              </div>
              <!--Entrada de perfil-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <select class="form-control input-lg" name="nuevoPerfilSolicitante" id="">
                    <option value="">Seleccione el cargo</option>
                    <?php
                    $perfilSolicitante = ControladorPerfil::ctrMostrarPerfil(null, null);
                    
                    foreach ($perfilSolicitante as $key => $value): ?>

                    <option value="<?php echo $value["id_perfil"]; ?>"><?php echo $value["perfil"]; ?></option>

                    <?php endforeach; ?>
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
            <button type="submit" class="btn btn-primary ">Guardar Categoría</button>
          </div>
        </div>
        <?php 
          $crearSolicitante = new ControladorSolicitantes();
          $crearSolicitante->ctrAgregarSolicitante();
        ?>
      </form>

    </div>
  </div>

  <!-- **********************************
          MODAL EDITAR CATEGORIA
 **************************************-->

 <div id="modalEditarSolicitante" class="modal fade" role="dialog">

<div class="modal-dialog">

  <!-- -->
  <div class="modal-content">

  <form role="form" method="post">


      <!-- **********************************
                CABEZA DEL MODAL
      **************************************-->

      <div class="modal-header" style="background:#3c8dbc; color:white">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Editar datos del solicitante</h4>

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
                  <input type="text" class="form-control input-lg" name="editarNombreSolicitante" id="editarNombreSolicitante" placeholder="Ingresar Nombre" required>
                </div>
              </div>
              <!--Entrada de apellido-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <input type="text" class="form-control input-lg" name="editarApellidoSolicitante" id="editarApellidoSolicitante" placeholder="Ingresar Apellido" required>
                </div>
              </div>
              <!--Entrada de dolcumento-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <input type="text" class="form-control input-lg" name="editarDocumentoSolicitante" id="editarDocumentoSolicitante" placeholder="Ingrese # Documento" required>
                </div>
              </div>
              <!--Entrada de correo-->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <input type="text" class="form-control input-lg" name="editarCorreoSolicitante" id="editarCorreoSolicitante" placeholder="Ingresar Correo del Solicitante" required>
                  <input type="hidden" name="idSolicitante" id="idSolicitante">
                </div>
              </div>
               <!--Entrada de perfil-->
               <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <select class="form-control input-lg" name="editarPerfilSolicitante" >
                    <option value="" id="editarPerfilSolicitante">Seleccione el cargo</option>
                    <?php
                    $perfilSolicitante = ControladorPerfil::ctrMostrarPerfil(null, null);
                    
                    foreach ($perfilSolicitante as $key => $value): ?>

                    <option value="<?php echo $value["id_perfil"]; ?>"><?php echo $value["perfil"]; ?></option>

                    <?php endforeach; ?>
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
        <button type="submit" class="btn btn-primary ">Guardar Cambios</button>
      </div>
    </div>
    <?php 
       $editarSolicitante = new ControladorSolicitantes();
       $editarSolicitante->ctrEditarSolicitante();
    ?>
  </form>

</div>
</div>

<?php 
       $borrarSolicitante = new ControladorSolicitantes();
       $borrarSolicitante->ctrBorrarSolicitante();
    ?>

