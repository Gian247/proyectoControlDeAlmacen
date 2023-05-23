<?php

 $item = null;
 $valor = null;
 $orden = "fecha_ingreso";
 $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

 ?>

 <!-- PRODUCT LIST -->
 <div class="box box-primary">
     <div class="box-header with-border">
         <h3 class="box-title">Productos agregados recientemente</h3>

         <div class="box-tools pull-right">
             
         </div>
     </div>
     <!-- /.box-header -->
     <div class="box-body">
         <ul class="products-list product-list-in-box">
            <?php

            for ($i = 0; $i < 10;$i++){
                echo '             <li class="item">
                    
                    <div class="product-info">
                        <a href="#" class="product-title">'.$productos[$i]["descripcion"].'
                            <span class="label label-warning pull-right"> S/. '.$productos[$i]["costo_unitario"].'</span></a>
                        
                    </div>
                </li>';
                }
            ?>
         </ul>
     </div>
     <!-- /.box-body -->
     <div class="box-footer text-center">
         <a href="productos" class="uppercase">Ver todos los productos</a>
     </div>
     <!-- /.box-footer -->
 </div>
 <!-- /.box -->