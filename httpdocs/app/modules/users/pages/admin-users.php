<?php
//EXPORT USERS
usersController::exportListAction();

//EXPORT STATISTICS
usersController::exportStatisticsAction();

$KEYWORDS_META_PAGE =  'usuarios, palabras clave';
$SUBJECT_META_PAGE = strTranslate("Users_list");
$TITLE_META_PAGE = strTranslate("Users_list");

addJavascripts(array(getAsset("users")."js/connect-as.js"));

session::getFlashMessage( 'actions_message' ); 
usersController::deleteAction();
$elements = usersController::getListAction(35);
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"?page=admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Users_list"), "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">       
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="?page=admin-user"><?php echo strTranslate("New_user");?></a></li>
			<li><a href="?page=<?php echo $_REQUEST['page'].'&export=true';?>"><?php echo strTranslate("Export");?></a></li>
			<li><a href="?page=<?php echo $_REQUEST['page'].'&export_s=true';?>">Exportar estadísticas</a></li>
			<div class="pull-right">
				<?php echo SearchForm($elements['reg'],"?page=admin-users","searchForm","buscar usuario","Buscar","","navbar-form navbar-left");?>	
			</div>
		</ul>

		<div class="table-responsive">
			<table class="table table-striped">
				<tr>
				<th width="40px"></th>
				<th><?php echo strTranslate("Username");?></th>
				<th><?php echo strTranslate("Nick");?></th>
				<th><?php echo strTranslate("Group_user");?></th>  
				<th>Email</th>
				<th><?php echo strTranslate("Confirmed");?></th>
				<th><?php echo strTranslate("Disabled");?></th>
				<th width="40px"></th>
				</tr>	
				<?php foreach($elements['items'] as $element):?>
					<tr>
					<td nowrap="nowrap">
						<span class="fa fa-edit icon-table" title="<?php echo strTranslate("Edit");?>" onClick="location.href='?page=admin-user&id=<?php echo $element['username'];?>'">
						</span>
						
						<span class="fa fa-ban icon-table" title="Eliminar"
							onClick="Confirma('¿Seguro que desea deshabilitar al usuario?', '?page=admin-users&pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['username'];?>')">
						</span>
					</td>					
					<td><?php echo $element['username'];?></td>
					<td><?php echo $element['nick'];?></td>
					<td><?php echo $element['nombre_tienda'];?></td>
					<td><?php echo $element['email'];?></td>
					<td><span class="label<?php echo ($element['confirmed']==0 ? " label-danger" : " label-success");?>"><?php echo ($element['confirmed']==1 ? "Sí" : "No");?></span></td>
					<td><span class="label<?php echo ($element['disabled']==1 ? " label-danger" : " label-success");?>"><?php echo ($element['disabled']==0 ? "No" : "Sí");?></span></td>
					<td><button type="button" class="btn btn-default btn-xs connect-as" title="<?php echo strTranslate("Connect_as");?>" data-u="<?php echo $element['username'];?>" data-p="<?php echo $element['user_password'];?>"><i class="fa fa-plug"></i></button></td>
					</tr>  
				<?php endforeach; ?>
			</table>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>