<aside class="main-sidebar">

    <section class="sidebar">

        <ul class="sidebar-menu" data-widget="tree">
            <?php
				if($_SESSION["perfil"]==1){
					echo '<li class="active">

							<a href="inicio">
			
								<i class="fa fa-home"></i>
								<span>Inicio</span>
			
							</a>
	
						</li>
	
						<li>
			
							<a href="usuarios">
			
								<i class="fa fa-user"></i>
								<span>Usuarios</span>
			
							</a>
			
						</li>';

				}

				if($_SESSION["perfil"]==1 || $_SESSION["perfil"]=="Especial"){

					echo '	
							<li>

								<a href="perfil">

									<i class="fa fa-th"></i>
									<span>Perfil</span>

								</a>

							</li>
							<li>

								<a href="categorias">
	
									<i class="fa fa-th"></i>
									<span>Categorías</span>
	
								</a>
	
							</li>';
				}

				if($_SESSION["perfil"]==1 || $_SESSION["perfil"]=="Vendedor"){
				echo '<li>

						<a href="solicitantes">

							<i class="fa fa-users"></i>
							<span>Solicitantes</span>

						</a>

					</li>';

				}

				if($_SESSION["perfil"]==1 || $_SESSION["perfil"]=="Vendedor"){
					




					echo ' <li class="treeview">

					<a href="#">
	
						<i class="fa fa-list-ul"></i>
	
						<span>Gestión Ingresos</span>
	
						<span class="pull-right-container">
	
							<i class="fa fa-angle-left pull-right"></i>
	
						</span>
	
					</a>

					<ul class="treeview-menu">
	
						<li>
	
							<a href="proveedores">
	
								<i class="fa fa-circle-o"></i>
								<span>Proveedores</span>
	
							</a>
	
						</li>
	
						<li>
	
							<a href="entradas-almacen">
	
								<i class="fa fa-circle-o"></i>
								<span>Ingreso Productos</span>
	
							</a>
	
						</li>
						<li>
	
								<a href="productos">
	
									<i class="fa fa-product-hunt"></i>
									<span>Productos</span>
	
								</a>
	
							</li>';
						
						echo '</ul>

            		</li>';





					echo
				' <li class="treeview">

					<a href="#">
	
						<i class="fa fa-list-ul"></i>
	
						<span>Gestión Salidas</span>
	
						<span class="pull-right-container">
	
							<i class="fa fa-angle-left pull-right"></i>
	
						</span>
	
					</a>

					<ul class="treeview-menu">
	
						<li>
	
							<a href="salidas">
	
								<i class="fa fa-circle-o"></i>
								<span>Administrar Salidas</span>
	
							</a>
	
						</li>
	
						<li>
	
							<a href="crear-salida">
	
								<i class="fa fa-circle-o"></i>
								<span>Crear Salida</span>
	
							</a>
	
						</li>
						<li>
		
							<a href="reportes">
		
								<i class="fa fa-circle-o"></i>
								<span>Reporte de Salidas</span>
		
							</a>
		
						</li>';
						
						echo '                </ul>

            		</li>';

				}

				

			
			?>






           
                   



        </ul>

    </section>

</aside>