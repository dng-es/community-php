<?php
//EXPORT TIENDAS
usersTiendasController::exportListAction();  
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"?page=admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"?page=admin-users"),
			array("ItemLabel"=>strTranslate("Users_groups_list"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' ); 
		$elements = usersTiendasController::getListAction(15);
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="?page=<?php echo $_REQUEST['page'].'&export=true';?>"><?php echo strTranslate("Export");?></a></li>
			<li><a href="?page=admin-cargas-tiendas"><?php echo strTranslate("Groups_import");?></a></li>
			<div class="pull-right">
				<?php SearchForm($reg,"?page=admin-users-tiendas","searchForm","buscar tienda","Buscar","","navbar-form navbar-left");?>
			</div>
		</ul>
		<div class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th>Cód.</th>
					<th>Nombre</th>
					<th>Regional</th>   
					<th>Responsable</th>
					<th>Tipo.</th>
					<th width="40px"></th>
				</tr>
				<?php foreach($elements['items'] as $element):?>
				<tr>			
					<td><?php echo $element['cod_tienda'];?></td>
					<td><?php echo $element['nombre_tienda'];?></td>
					<td><?php echo $element['regional_tienda'];?></td>	
					<td><?php echo $element['responsable_tienda'];?></td>
					<td><?php echo $element['tipo_tienda'];?></td>
					<td><span class="label<?php echo ($element['activa']==0 ? " label-danger" : " label-success");?>"><?php echo ($element['activa']==1 ? "Activa" : "Inactiva");?></span></td>
				</tr>   
			<?php endforeach;?>
			</table>
		</div>
	<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>