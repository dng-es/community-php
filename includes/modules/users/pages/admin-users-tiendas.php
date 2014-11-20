<?php
//EXPORT TIENDAS
usersTiendasController::exportListAction();  
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<ol class="breadcrumb">
			<li><a href="?page=home"><?php echo strTranslate("Home");?></a></li>
			<li><a href="?page=admin"><?php echo strTranslate("Administration");?></a></li>
			<li><a href="#"><?php echo strTranslate("Users");?></a></li>
			<li class="active"><?php echo strTranslate("Users_groups_list");?></li>
		</ol>
		<?php
		session::getFlashMessage( 'actions_message' ); 
		$elements = usersTiendasController::getListAction(15);
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>       
			<div class="pull-right">
				<?php SearchForm($reg,"?page=admin-users-tiendas","searchForm","buscar tienda","Buscar","","navbar-form navbar-left");?>
			</div>
		</ul>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th>Cód.</th>
					<th>Nombre</th>
					<th>Regional</th>   
					<th>Responsable</th>
					<th>Tipo.</th>
				</tr>
				<?php foreach($elements['items'] as $element):?>
				<tr>			
					<td><?php echo $element['cod_tienda'];?></td>
					<td><?php echo $element['nombre_tienda'];?></td>
					<td><?php echo $element['regional_tienda'];?></td>	
					<td><?php echo $element['responsable_tienda'];?></td>
					<td><?php echo $element['tipo_tienda'];?></td>
				</tr>   
			<?php endforeach;?>
			</table>
		</div>
	<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>