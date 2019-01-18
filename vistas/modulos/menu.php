<aside class="main-sidebar">

	 <section class="sidebar">
	 	<div class="user-panel">
        <div class="pull-left image">
        	<?php
        	if($_SESSION["foto"] != "")
        	{
			echo '<img src="'.$_SESSION["foto"].'" class="img-circle" alt="User Image">';
			}
			else
			{
			echo '<img src="vistas/img/usuarios/default/anonymous.png" class="img-circle" alt="User Image">';
			}
			?>          
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION["nombre"] ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Conectado</a>
        </div>
      	</div>

		<ul class="sidebar-menu">

			<li class="active">

				<a href="inicio">

					<i class="fa fa-home"></i>
					<span>Inicio</span>

				</a>

			</li>

			<li class="treeview">

				<a href="#">

					<i class="fa fa-fw fa-building"></i>
					
					<span>Administrar</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					<?php
					if($_SESSION["perfil"] == "Administrador")
			        {
			        echo '<li>

						<a href="usuarios">
							
							<i class="fa fa-user"></i>
							<span>Usuarios</span>

						</a>

					</li>';
			        }
			        ?>					
					
					<li>

						<a href="clientes">
							
							<i class="fa fa-user"></i>
							<span>Clientes</span>

						</a>

					</li>

				</ul>

			</li>

			<li class="treeview">

				<a href="#">

					<i class="fa fa-fw fa-building"></i>
					
					<span>Empresa</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					
					<li>

						<a href="proyectos">
							
							<i class="fa fa-fw fa-map"></i>
							<span>Proyectos</span>

						</a>

					</li>

				</ul>

			</li>
			<li class="treeview">

				<a href="#">

					<i class="fa fa-fw fa-calculator"></i>
					
					<span>Reportes</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					
					<li>

						<a href="rep-prospeccion">
							
							<i class="fa fa-fw fa-calculator"></i>
							<span>Prospeccion</span>

						</a>

					</li>
					<li>

						<a href="rep-cotizador">
							
							<i class="fa fa-fw fa-calculator"></i>
							<span>Cotizador</span>

						</a>

					</li>
					<li>

						<a href="rep-reserva">
							
							<i class="fa fa-fw fa-calculator"></i>
							<span>Reserva</span>

						</a>

					</li>
					<li>

						<a href="rep-simulador">
							
							<i class="fa fa-fw fa-calculator"></i>
							<span>Simulador</span>

						</a>

					</li>
					<li>

						<a href="rep-proforma">
							
							<i class="fa fa-fw fa-calculator"></i>
							<span>Proforma</span>

						</a>

					</li>

				</ul>

			</li>
			<li class="treeview">

				<a href="#">

					<i class="fa fa-fw fa-building"></i>
					
					<span>Ventas</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					
					<li>

						<a href="ventas-p">
							
							<i class="fa fa-fw fa-map"></i>
							<span>Proforma</span>

						</a>

					</li>

				</ul>

			</li>
			<!--
			<li class="treeview">

				<a href="#">

					<i class="fa fa-list-ul"></i>
					
					<span>Ventas</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					
					<li>

						<a href="ventas">
							
							<i class="fa fa-circle-o"></i>
							<span>Administrar ventas</span>

						</a>

					</li>

					<li>

						<a href="crear-venta">
							
							<i class="fa fa-circle-o"></i>
							<span>Crear venta</span>

						</a>

					</li>

					<li>

						<a href="reportes">
							
							<i class="fa fa-circle-o"></i>
							<span>Reporte de ventas</span>

						</a>

					</li>

				</ul>

			</li>
			-->
		</ul>

	 </section>

</aside>