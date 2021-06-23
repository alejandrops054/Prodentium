<aside class="main-sidebar">

	 <section class="sidebar">
		<ul class="sidebar-menu">

		<?php
		if($_SESSION["perfil"] == "Administrador"){
			echo '<li class="active"><a href="inicio"><i class="fa fa-home"></i><span>Inicio</span></a></li>
				  <li><a href="usuarios"><i class="fa fa-users"></i><span> Usuarios</span></a></li>';
		}
		
		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Asistente"){
			echo '<li><a href="corte-caja"><i class="fas fa-cash-register"></i><span>&nbsp;Caja</span></a></li>
				<li class="treeview"><a href="#"><i class="fa fa-sticky-note"></i><span>Orden de trabajo (ODT)</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
					<ul class="treeview-menu">
						<li><a href="crear-venta"><i class="fa fa-circle-o"></i><span>Crear ODT</span></a></li>
						<li><a href="ventas"><i class="fa fa-circle-o"></i><span>Administrar ODT</span></a></li>
					</ul>
				</li>';
		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Asistente"){
			echo '<li><a href="compras"><i class="fa fa-pencil-square"></i><span>Gastos</span></a></li>
				  <li><a href="proveedor"><i class="fa fa-address-book"></i><span>Proveedores</span></a></li>
			      <li><a href="productos"><i class="fa fa-folder-open"></i><span>Servicios</span></a></li>';
		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Asistente"){

			echo '<li><a href="clientes"><i class="fa fa-user-md"></i><span>Doctores</span></a></li>';
		}

		if($_SESSION["perfil"] == "Administrador"){
			echo '<li><a href="reportes"><i class="fas fa-file-contract"></i><span>&nbsp;&nbsp;Reporte</span></a></li>
				  <li class="treeview"><a href="#"><i class="fa fa-cog"></i><span>Configuración</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
						<ul class="treeview-menu">
						<li><a href="ajustes"><i class="fa fa-circle-o"></i><span>Ajustes</span></a></li>';
						//echo'<li><a href="tickets"><i class="fa fa-circle-o"></i><span>Soporte técnico tickets</span></a></li>';
					echo '</ul>
				</li>';
		}
		?>
		</ul>
	 </section>
	 
</aside>