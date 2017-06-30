<?php
set_time_limit(0);
ini_set('memory_limit', '-1');

//EXPORT USERS
usersController::exportListAction();

//EXPORT STATISTICS
usersController::exportStatisticsAction();

$KEYWORDS_META_PAGE =  'usuarios, palabras clave';
$SUBJECT_META_PAGE = strTranslate("Users_list");
$TITLE_META_PAGE = strTranslate("Users_list");

addJavascripts(array(getAsset("users")."js/connect-as.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Users_list"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' );
		usersController::deleteAction();
		$elements = usersController::getListAction(35);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-user"><?php e_strTranslate("New_user");?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export_s=true';?>">Exportar estadísticas</a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-users","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
					</div>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th width="40px"></th>
						<th><?php e_strTranslate("Username");?></th>
						<th><?php e_strTranslate("Group_user");?></th>
						<th><?php e_strTranslate("Channel");?></th>
						<th><?php e_strTranslate("Profile");?></th>
						<th class="text-center"><?php e_strTranslate("Confirmed");?></th>
						<th class="text-center"><?php e_strTranslate("Disabled");?></th>
						<th width="40px"></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
									onClick="Confirma('¿Seguro que desea deshabilitar al usuario?', 'admin-users?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['username'];?>'); return false"><i class="fa fa-trash icon-table"></i>
								</button>
								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>" onClick="location.href='admin-user?id=<?php echo $element['username'];?>'; return false;"><i class="fa fa-edit icon-table"></i>
								</button>
							</td>
							<td>
								<?php echo $element['username'];?> - <?php echo $element['email'];?><br />
								<small class="text-muted"><?php echo $element['name'];?> <?php echo $element['surname'];?>  
								<a href="user-profile?n=<?php echo $element['nick'];?>" title="Ver perfil público"><?php echo $element['nick'];?></small></a>
							</td>
							<td><?php echo $element['nombre_tienda'];?></td>
							<td><?php echo $element['canal'];?></td>
							<td><?php echo $element['perfil'];?></td>
							<td class="text-center"><span class="label<?php echo ($element['confirmed'] == 0 ? " label-danger" : " label-success");?>"><?php echo ($element['confirmed'] == 1 ? strTranslate("App_Yes") : strTranslate("App_No"));?></span></td>
							<td class="text-center"><span class="label<?php echo ($element['disabled'] == 1 ? " label-danger" : " label-success");?>"><?php echo ($element['disabled'] == 0 ? strTranslate("App_No") : strTranslate("App_Yes"));?></span></td>
							<td><button type="button" class="btn btn-default btn-xs connect-as" title="<?php e_strTranslate("Connect_as");?>" data-u="<?php echo $element['username'];?>" data-p="<?php echo $element['user_password'];?>"><i class="fa fa-plug"></i></button></td>
							</tr>
						<?php endforeach;?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>