<?php
$num_users = number_format(connection::countReg("users", " AND disabled=0 AND registered=1 AND confirmed=1 "), 0, ',', '.');
$num_empresas = number_format(connection::countReg("users_tiendas", " AND activa=1 "), 0, ',', '.');
$num_access = number_format(connection::countReg("accesscontrol", " AND webpage<>'Inicio de sesion' "), 0, ',', '.');
$num_perfiles = usersController::getPerfilesAction();
$num_canales = usersCanalesController::getCanalesAction();
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"#")
		));
		?>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading" role="tab">
						<h3 class="panel-title">
							<?php e_strTranslate("Overview");?> 
							<small><i class="fa fa-pie-chart pull-right text-muted"></i></small>
						</h3>
					</div>
					<div class="panel-body">
						<dl class="dl-horizontal">
							<dt>Usuarios activos</dt>
							<dd><?php echo $num_users;?></dd>
							<dt><?php e_strTranslate("Groups_user");?> activas</dt>
							<dd><?php echo $num_empresas;?></dd>
							<dt>Perfiles activos</dt>
							<dd><?php echo $num_perfiles;?></dd>
							<dt>Canales activos</dt>
							<dd><?php echo $num_canales;?></dd>
						</dl>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title"><?php e_strTranslate("Reports");?> <small><i class="fa fa-area-chart pull-right text-muted"></i></small></h3></div>
					<div class="panel-body">
						<dl class="dl-horizontal">
							<dt><?php e_strTranslate("Visits_title");?></dt>
							<dd><a href="admin-informe-accesos"><?php e_strTranslate("Go_to");?></a> <span class="text-muted"><small>- <?php e_strTranslate("Page_views");?> <?php echo $num_access;?></small></span></dd>
							<dt><?php echo ucfirst(strTranslate("APP_points"));?></dt>
							<dd><a href="admin-informe-puntuaciones"><?php e_strTranslate("Go_to");?></a></dd>
							<dt><?php echo ucfirst(strTranslate("APP_shares"));?></dt>
							<dd><a href="admin-informe-participaciones"><?php e_strTranslate("Go_to");?></a></dd>
							<dt><?php e_strTranslate("Users_list");?></dt>
							<dd><a href="admin-users?export=true"><?php e_strTranslate("Export");?> CSV</a></dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<?php
			//mostrar información sobre otros módulos activos
			menu::adminPanels();
			?>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>