
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



                <?php
                    $item = "id_salida";
                    //Obtengo el id de la venta que mande por get en el boton edtar venta
                    $valor = $_GET["idSalida"];
                    //Hago la consulta al controlador y almacenamos la respuesta en la variable
                    $salida = ControladorSalidas::ctrMostrarSalidas($item, $valor);
                    //Ponemos el campo que vamos a buscar
                    $itemUsuario = "id_usuario";
                    //El valor que buscaremos en el campo, en este caso sera el que venta en el campo de id_vendedor
                    $valorUsuario = $salida["id_usuario"];
                    //Con esos datos hacemos la consulta al controlador de usuario para obtener el nombre
                    $usuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
                    //Para el cliente se repiten los pasos del vendedor
                    $itemSolicitante = "id_solicitante";
                    $valorSolicitante = $salida["id_solicitante"];
                    //Se hace la consulta al controlador de clientes
                    $solicitante = ControladorSolicitantes::ctrMostrarSolicitantes($itemSolicitante, $valorSolicitante);
                    
                    


                ?>

              <!--=====================================
              ENTRADA DEL USUARIO
              ======================================-->

              <div class="form-group">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-user"></i></span>

                  <input type="text" class="form-control" id="nuevoUsuarioSalida" value="<?php echo $usuario["nombres"]; ?>" readonly>

                  <input type="hidden" name="idUsuario" value="<?php echo $usuario["id_usuario"]; ?>">

                </div>

              </div>

              <!--=====================================
              ENTRADA DEL CÓDIGO
              ======================================-->

              <div class="form-group">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-key"></i></span>

                  <input type="text" class="form-control" id="nuevaSalida" name="editarSalida" value="<?php echo $salida["codigo_salida"] ?>" readonly>
                  
                </div>

              </div>

              <!--=====================================
              ENTRADA DEL SOLICITANTE
              ======================================-->

              <div class="form-group">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-users"></i></span>

                  <select class="form-control" id="seleccionarSolicitante" name="seleccionarSolicitante" required>

                  <option value="<?php echo $solicitante["id_solicitante"]; ?>"><?php echo $solicitante["nombres"]; ?></option>
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

              <div class="form-group row nuevoProducto">




              <?php
                //En este paso almacenamos en un array las productos almacenados en la venta,
                //La funcoion json_decode convierte un string codificado en json a una variable de PHP
                $listaProducto = json_decode($salida["productos"], true);
                //Recorremos el array.
                foreach ($listaProducto as $key => $value) {
                  //Preparamos los campos para la consulta
                  $item = "id_producto";
                  //Obtiene el id del producto en el for
                  $valor = $value["id"];
                  $orden = "id_producto";
                  //Con los datos anteriores hacemos la consulta en el controlador productos, y la alamacenamos en 
                  //una variable
                  $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
                  //En esta variable se almacena el stock actual del producto + el estock solicitado en la orden
                  $stockAntiguo = $respuesta["stockDisponible"] + $value["cantidad"];
                  //Empezamos a imprimir los campos de las ordenes
                  echo '<div class="row activarBoton" style="padding:5px 15px">
            
                        <div class="col-xs-6" style="padding-right:0px">
            
                          <div class="input-group">
                
                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'"><i class="fa fa-times"></i></button></span>

                            <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value["id"].'" name="agregarProducto" value="'.$value["descripcion"].'" readonly required>

                          </div>

                        </div>

                        <div class="col-xs-3">
              
                          <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stockDisponible"].'" required>

                        </div>

                        <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">

                          <div class="input-group">

                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                   
                            <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$respuesta["costo_unitario"].'" name="nuevoPrecioProducto" value="'.$value["total"].'" readonly required>
   
                          </div>
               
                        </div>

                      </div>';
                }


                ?>


              </div>
              <!-- Este campo almacena las productos seleccionados -->
              <input type="hidden" id="listaProductos" name="listaProductos" >

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

                            <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" value="<?php echo $salida["total_valor_salida"] ?>" total=""  readonly required>

                            <input type="hidden" name="totalVenta" id="totalVenta" value="<?php echo $salida["total_valor_salida"] ?>">


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
       
          <button type="submit" class="btn btn-primary pull-right botonGuardarSalida" disabled>Guardar Salida de Producto</button>

        </div>

      </form>

      <?php

      $guardar = new ControladorSalidas();
      $guardar->ctrEditarSalida();

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