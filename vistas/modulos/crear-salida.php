
<?php
// if ($_SESSION["perfil"]=="ESpecial") {
// echo '<script>
//     window.location="inicio";
//   </script>';
// return;
// }
?>
<div class="content-wrapper">

<section class="content-header">

  <h1>

  Crear Salida de Producto


  </h1>

  <ol class="breadcrumb">

    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

    <li class="active">Crear Salida </li>


  </ol>

</section>

<section class="content">

  <div class="row">

    <!--=====================================
    EL FORMULARIO
    ======================================-->

    <div class="col-lg-5 ">

      <div class="box box-success">

        <div class="box-header with-border"></div>

        <form role="form" method="post" class="formularioSalida">

          <div class="box-body">

            <div class="box">

              <!--=====================================
              ENTRADA DEL VENDEDOR
              ======================================-->

              <div class="form-group">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-user"></i></span>

                  <input type="text" class="form-control" id="nuevoUsuarioSalida" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                  <input type="hidden" name="idUsuario" value="<?php echo $_SESSION["id"]; ?>">

                </div>

              </div>

              <!--=====================================
              ENTRADA DEL CÓDIGO
              ======================================-->

              <div class="form-group">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-key"></i></span>

                  <?php
                  /*------------------------------------------------
                          BLOQUE RELLENADOR DE CAMPO ID SALIDA
                   -----------------------------------------------*/
                  $item = null;
                  $valor = null;

                  $salidas = ControladorSalidas::ctrMostrarSalidas($item, $valor);

                  if(!$salidas){

                    echo '<input type="text" class="form-control" id="nuevaSalida" name="nuevaSalida" value="10001" readonly>';


                  }else{

                    foreach ($salidas as $key => $value) {

                      //Recorre el arreglo si es que vienen datos

                    }
                    //Obtiene el ultimovalor del codigo y  le suma 1
                    $codigo = $value["codigo_salida"] + 1;


                    //Manda a la vista del usuario el valordel codigo calculado
                    echo '<input type="text" class="form-control" id="nuevaSalidas" name="nuevaSalida" value="'.$codigo.'" readonly>';


                  }

                  ?>


                </div>

              </div>

              <!--=====================================
              ENTRADA DEL CLIENTE
              ======================================-->

              <div class="form-group">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-users"></i></span>

                  <select class="form-control" id="seleccionarCliente" name="seleccionarCliente" required>

                  <option value="">Seleccionar Persona Solicitante</option>

                  <?php

                    $item = null;
                    $valor = null;

                    $solicitantes = ControladorSolicitantes::ctrMostrarSolicitantes($item, $valor);

                     foreach ($solicitantes as $key => $value) {

                       echo '<option value="'.$value["id_solicitante"].'">'.$value["nombres"].' '.$value["apellidos"].'</option>';

                     }

                  ?>

                  </select>

                  <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs tr" data-toggle="modal" data-target="#modalAgregarSolicitante" data-dismiss="modal">Agregar Solicitante</button></span>


                </div>

              </div>

              <!--=====================================
              ENTRADA PARA AGREGAR PRODUCTO
              ======================================-->

              <div class="form-group row nuevoProducto" id="nuevoProducto">



              </div>
              <!-- Este campo almacena las productos seleccionados -->
              <input type="hidden" id="listaProductos" name="listaProductos">

              <!--=====================================================0
              BOTÓN PARA AGREGAR PRODUCTO solo en pantallas pequeñas
              ==========================================================-->

              <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

              <hr>

              <div class="row">

                
              
              <!--=====================================
                ENTRADA TOTAL
                ======================================-->

                <div class="col-xs-8 pull-right">

                  <table class="table">

                    <thead>

                      <tr>
                        <th></th>
                        <th>Total</th>
                      </tr>

                    </thead>

                    <tbody>

                      <tr>

                        <td style="width: 50%">



                        </td>

                         <td style="width: 50%">

                          <div class="input-group">

                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

                            <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" placeholder="00000" readonly required>

                            <input type="hidden" name="totalVenta" id="totalVenta">


                          </div>

                        </td>

                      </tr>

                    </tbody>

                  </table>

                </div>

              </div>

              <hr>



            </div>

        </div>

        <div class="box-footer">

          <button type="submit" class="btn btn-primary pull-right botonGuardarSalida" disabled>Guardar de Producto</button>

        </div>

      </form>

      <?php

      $guardar = new ControladorSalidas();
      $guardar->ctrCrearSalida();

      ?>

      </div>

    </div>

    <!--=====================================
    LA TABLA DE PRODUCTOS
    ======================================-->

    <div class="col-lg-7 hidden-md hidden-sm hidden-xs">

      <div class="box box-warning">

        <div class="box-header with-border"></div>

        <div class="box-body">

          <table class="table table-bordered table-striped  tablaSalidas">

             <thead>

               <tr>
                <th style="width: 10px">#</th>
                <th>Código</th>
                <th>Descripcion</th>
                <th>Stock</th>
                <th>Acciones</th>
              </tr>

            </thead>

          </table>

        </div>

      </div>


    </div>

  </div>

</section>

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