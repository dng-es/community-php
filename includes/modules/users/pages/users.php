<?php

//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

//EXPORT USERS
usersController::exportListAction();

//EXPORT STATISTICS
usersController::exportStatisticsAction();

$KEYWORDS_META_PAGE =  'usuarios, palabras clave';
$SUBJECT_META_PAGE = strTranslate("Users_list");
$TITLE_META_PAGE = strTranslate("Users_list");

session::getFlashMessage( 'actions_message' ); 
usersController::deleteAction();
$elements = usersController::getListAction(35);
?>

<div class="row row-top">
	<div class="col-md-9">
		<h1>Alta y modificación de usuarios</h1>
		<ul class="nav nav-pills navbar-default">       
			<li><a href="?page=user"><?php echo strTranslate("New_user");?></a></li>
			<li><a href="?page=<?php echo $_REQUEST['page'].'&export=true';?>"><?php echo strTranslate("Export");?> CSV</a></li>
			<li><a href="?page=<?php echo $_REQUEST['page'].'&export_s=true';?>">Exportar estadísticas CSV</a></li>
		</ul>
		<div class="pull-right">
			<?php echo SearchForm($elements['reg'],"?page=users","searchForm","buscar usuario","Buscar","","navbar-form navbar-left");?>	
		</div>
		<p class="legend-table"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strTranslate("Items");?></p>
		<div class="table-responsive">
			<table class="table">
				<tr>
				<th width="40px"></th>
				<th><?php echo strTranslate("Username");?></th>
				<th><?php echo strTranslate("Nick");?></th>
				<th><?php echo strTranslate("Group_user");?></th>  
				<th>Email</th>
				<th><?php echo strTranslate("Confirmed");?></th>
				<th><?php echo strTranslate("Disabled");?></th>
				</tr>	
				<?php foreach($elements['items'] as $element):?>
					<tr>
					<td nowrap="nowrap">
						<span class="fa fa-edit icon-table" title="<?php echo strTranslate("Edit");?>" onClick="location.href='?page=user&id=<?php echo $element['username'];?>'">
						</span>
						
						<span class="fa fa-ban icon-table" title="Eliminar"
							onClick="Confirma('¿Seguro que desea deshabilitar al usuario?', '?page=users&pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['username'];?>')">
						</span>
					</td>					
					<td><?php echo $element['username'];?></td>
					<td><?php echo $element['nick'];?></td>
					<td><?php echo $element['nombre_tienda'];?></td>
					<td><?php echo $element['email'];?></td>
					<td><span class="label<?php echo ($element['confirmed']==0 ? " label-danger" : " label-success");?>"><?php echo $element['confirmed'];?></span></td>
					<td><span class="label<?php echo ($element['disabled']==1 ? " label-danger" : " label-success");?>"><?php echo $element['disabled'];?></span></td>
					</tr>  
				<?php endforeach; ?>
			</table>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>