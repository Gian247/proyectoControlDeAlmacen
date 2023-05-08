<?php
//   if ($_SESSION["perfil"]=="Vendedor" || $_SESSION["perfil"]=="Especial") {
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
            Administrar usuarios

        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

            <li class="active">Administrar usuarios</li>
        </ol>
    </section>





    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">

            <div class="box-header with-border">

                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">Agregar
                    Usuario</button>



            </div>


            <div class="box-body">
                <table class="table table-bordered table-striped tablas dt-responsive" width="100%">

                    <thead>
                        <tr>
                            <th style="width:3px">#</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Foto</th>
                            <th>Perfil</th>
                            <th>Estado</th>
                            <th>Ultimo Login</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php 
                $item=null;
                $valor=null;

                $usuarios=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
                foreach($usuarios as $key=>$value):?>
                        <tr>
                            <td><?php echo ($key+1); ?></td>
                            <td><?php echo $value["nombres"]; ?></td>
                            <td><?php echo $value["apellidos"]; ?></td>
                            <td><?php echo $value["user"]; ?></td>
                            <td><?php echo $value["correo"]; ?></td>
                            <!-- Validando si viene una foto de la base de datos -->
                            <?php if($value["foto"]!=""):?>
                            <td><img src="<?php echo $value["foto"]; ?>" class="img-thumbnail" width="40px"></td>
                            <?php else:?>
                            <td><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px">
                            </td>
                            <?php endif;?>

                            <td><?php echo $value["id_perfil"];?></td>
                            <?php if($value["estado"]!=0):?>
                            <td><button class="btn btn-success btn-xs btnActivar"
                                    idUsuario=<?php echo $value["id_usuario"]; ?> estadoUsuario=0>Activado</button>
                            </td>
                            <?php else: ?>
                            <td><button class="btn btn-danger btn-xs btnActivar"
                                    idUsuario=<?php echo $value["id_usuario"]; ?> estadoUsuario=1>Desactivado</button>
                            </td>
                            <?php endif;?>

                            <td><?php echo $value["ultimo_login"]; ?></td>
                            <td>

                                <div class="btn-group">
                                    <button class="btn btn-warning btnEditarUsuario" data-toggle="modal"
                                        idUsuario="<?php echo $value["id_usuario"] ;?>"
                                        data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger"><i class="fa fa-times btnEliminarUsuario" idUsuario="<?php echo $value["id_usuario"];?>" fotoUsuario="<?php echo $value['foto'] ?>" usuario="<?php echo $value["user"];?>"></i></button>
                                </div>
                            </td>

                        </tr>


                        <?php endforeach; ?>


                    </tbody>
                </table>
            </div>


        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>


<!-- **********************************
          MODAL AGREGAR USUARIO
 **************************************-->

<div id="modalAgregarUsuario" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <!-- -->
        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">


                <!-- **********************************
                    CABEZA DEL MODAL
          **************************************-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Agregar Usuario</h4>

                </div>
                <!-- **********************************
                  CUERPO DEL MODAL
          **************************************-->

                <div class="modal-body">

                    <div class="box-body">
                        <!--Entrada de nombre-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoNombre"
                                    placeholder="NOMBRES COMPLETOS" required>
                            </div>
                        </div>

                        <!--Entrada de apellido-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoApellido"
                                    placeholder="APELLIDOS" required>
                            </div>
                        </div>

                        <!--Entrada de correo-->

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoCorreo"
                                    placeholder="CORREO ELECTRONICO" required>
                            </div>
                        </div>


                        <!--Entrada de usuario-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoUsuario" id="nuevoUsuario"
                                    placeholder="NOMBRE DE USUARIO" required>
                            </div>
                        </div>
                        <!--Entrada de contraseña-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoPassword"
                                    placeholder="CONTRASEÑA" required>
                            </div>
                        </div>

                        <!--Entrada de seleccion de perfil-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select class="form-control input-lg" name="nuevoPerfil">
                                    <option value="">Seleccione perfil</option>
                                    <option value=1>ADMINISTRADOR</option>
                                    <option value=2>ADMINISTRATIVO</option>
                                    <option value=3>LOGISTICA</option>
                                    <option value=4>ADMINISTRACION LOGISTICA</option>
                                    <option value=5>MANTENIMIENTO</option>

                                </select>
                            </div>
                        </div>

                        <!--Entrada para subir foto-->
                        <div class="form-group">
                            <div class="panel">SUBIR FOTO</div>
                            <input type="file" name="nuevaFoto" class="nuevaFoto">
                            <p class="help-block">Peso maximo de la foto 2 MB</p>
                            <img class="img-thumbnail previsualizar" width="100px"
                                src="vistas/img/usuarios/default/anonymous.png" alt="">
                        </div>

                    </div>

                </div>
                <!-- **********************************
                    PIE DEL MODAL
          **************************************-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary ">Guardar usuario</button>
                </div>
        </div>


        <?php
            $crearUsuario = new ControladorUsuarios();
            $crearUsuario -> ctrCrearUsuario();

        ?>

        </form>

    </div>
</div>

<!-- **********************************
          MODAL EDITAR USUARIO
 **************************************-->

<div id="modalEditarUsuario" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <!-- -->
        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">


                <!-- **********************************
                CABEZA DEL MODAL
      **************************************-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Agregar Usuario</h4>

                </div>
                <!-- **********************************
              CUERPO DEL MODAL
      **************************************-->

                <div class="modal-body">

                    <div class="box-body">
                        <!--Entrada de nombre-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre"
                                    value="" required>
                            </div>
                        </div>
                        <!--Entrada de apellido-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" id="editarApellido" name="editarApellido" placeholder="" required>
                            </div>
                        </div>

                        <!--Entrada de correo-->

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" id="editarCorreo" name="editarCorreo"
                                    placeholder="" required>
                            </div>
                        </div>
                        <!--Entrada de usuario-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="text" class="form-control input-lg" id="editarUsuario" name="editarUsuario"
                                    value="" readonly required>
                            </div>
                        </div>
                        <!--Entrada de contraseña-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control input-lg" name="editarPassword"
                                    placeholder="Escriba la nueva contraseña">
                                <input type="hidden" id="passwordActual" name="passwordActual">
                            </div>
                        </div>

                        <!--Entrada de seleccion de perfil-->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select class="form-control input-lg" name="editarPerfil">
                                    <option value="" id="editarPerfil">Seleccione perfil</option>
                                    <option value=1>ADMINISTRADOR</option>
                                    <option value=2>ADMINISTRATIVO</option>
                                    <option value=3>LOGISTICA</option>
                                    <option value=4>ADMINISTRACION LOGISTICA</option>
                                    <option value=5>MANTENIMIENTO</option>
                                </select>
                            </div>
                        </div>

                        <!--Entrada para subir foto-->
                        <div class="form-group">
                            <div class="panel">SUBIR FOTO</div>
                            <input type="file" name="editarFoto" class="nuevaFoto">
                            <p class="help-block">Peso maximo de la foto 2 MB</p>
                            <img class="img-thumbnail previsualizar" width="100px"
                                src="vistas/img/usuarios/default/anonymous.png" alt="">
                            <input type="hidden" name="fotoActual" id="fotoActual">
                        </div>

                    </div>

                </div>
                <!-- **********************************
                PIE DEL MODAL
      **************************************-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary ">Modificar usuario</button>
                </div>
        </div>


        <?php
         $editarUsuario = new ControladorUsuarios();
         $editarUsuario -> ctrEditarUsuario();

    ?>

        </form>

    </div>
</div>

<?php

 $borrarUsuarios = new ControladorUsuarios();
 $borrarUsuarios->ctrBorrarUsuario();
?>