<aside class="main-sidebar">

    <section class="sidebar">

        <ul class="sidebar-menu" data-widget="tree">
            <?php
				
					echo '<li class="active">

							<a href="inicio">
			
								<i class="fa fa-home"></i>
								<span>Inicio</span>
			
							</a>
	
						</li>
						
						
						<li class="">

							<a href="reporte-productos-fecha">
			
								<i class="fa fa-plus-square"></i>
								<span>Detalle Salida Productos</span>
			
							</a>
	
						</li>
						<li class="">

							<a href="area">
			
								<i class="fa fa-home"></i>
								<span>Areas</span>
			
							</a>
	
						</li>
						
						';

				


				if($_SESSION["perfil"]==1 ){
					echo '<li>
			
							<a href="usuarios">
			
								<i class="fa fa-user"></i>
								<span>Usuarios</span>
			
							</a>
			
						</li>
						<li>

								<a href="perfil">

									<i class="fa fa-suitcase"></i>
									<span>Perfil</span>

								</a>

						</li>
						';

				}

				if($_SESSION["perfil"]=="1" || $_SESSION["perfil"]=="2" || $_SESSION["perfil"]=="3"){

					echo '	
							
							<li>

								<a href="categorias">
	
									<i class="fa fa-building-o"></i>
									<span>Categorías</span>
	
								</a>
	
							</li>';
				}

				if($_SESSION["perfil"]=="1" || $_SESSION["perfil"]=="2" || $_SESSION["perfil"]=="3"){
				echo '<li>

						<a href="solicitantes">

							<i class="fa fa-users"></i>
							<span>Solicitantes</span>

						</a>

					</li>';

				}

				if($_SESSION["perfil"]=="1" || $_SESSION["perfil"]=="2" || $_SESSION["perfil"]=="3"){
					




					echo ' <li class="treeview">

					<a href="#">
	
						<i class="fa fa-toggle-down"></i>
	
						<span>Gestión Ingresos</span>
	
						<span class="pull-right-container">
	
							<i class="fa fa-angle-left pull-right"></i>
	
						</span>
	
					</a>

					<ul class="treeview-menu">
	
						<li>
	
							<a href="proveedores">
	
								<i class="fa fa-truck"></i>
								<span>Proveedores</span>
	
							</a>
	
						</li>
	
						<li>
	
							<a href="entradas-almacen">
	
								<i class="fa fa-arrow-down"></i>
								<span>Ingreso Productos</span>
	
							</a>
	
						</li>
						';
						
						echo '</ul>

            		</li>';

					echo '<li>
	
					<a href="productos">

						<i class="fa fa-product-hunt"></i>
						<span>Productos</span>

					</a>

				</li>';





					echo
				' <li class="treeview">

					<a href="#">
	
						<i class="fa fa-toggle-up "></i>
	
						<span>Gestión Salidas</span>
	
						<span class="pull-right-container">
	
							<i class="fa fa-angle-left pull-right"></i>
	
						</span>
	
					</a>

					<ul class="treeview-menu">
	
						<li>
	
							<a href="salidas">
	
								<i class="fa fa-file"></i>
								<span>Administrar Salidas</span>
	
							</a>
	
						</li>';
						if($_SESSION["perfil"]=="1" || $_SESSION["perfil"]=="3"){
							echo
							'<li>
	
								<a href="crear-salida">
	
									<i class="fa fa-arrow-up"></i>
									<span>Crear Salida</span>
	
								</a>
	
							</li>';

						}

						echo '                </ul>

            		</li>';

					echo '<li>
		
							<a href="reportes">
		
								<i class="fa fa-pie-chart"></i>
								<span>Reportes Generales</span>
		
							</a>
		
						</li>';

				}

				

			
			?>






           
                   



        </ul>

    </section>

</aside>