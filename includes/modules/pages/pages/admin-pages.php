<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

session::getFlashMessage( 'actions_message' ); 
pagesController::deleteAction();
$elements = pagesController::getListAction(8);


?>

<div class="row row-top">
	<div class="col-md-9">
		<h1>Gestion de páginas</h1>
		<ul class="nav nav-pills navbar-default">      
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="?page=admin-page"><?php echo strTranslate("New_page");?></a></li>
		</ul>

		
		<table class="table">
		<tr>
		<th width="40px">&nbsp;</th>
		<th><?php echo strTranslate("Name");?></th>
		<th>URL</th>
		</tr>		
		<?php foreach($elements['items'] as $element): ?>
			<tr>
			<td nowrap="nowrap">
				<span class="fa fa-edit icon-table" title="Ver/editar"
					onClick="location.href='?page=admin-page&p=<?php echo $element['page_name'];?>'">
				</span>

				<span class="fa fa-ban icon-table" title="Eliminar"
					onClick="Confirma('¿Seguro que deseas eliminar la página?', '?page=admin-pages&pag=<?php echo $pag;?>&act=del&id=<?php echo $element['page_name'];?>')">
				</span>
			</td>						
			<td><?php echo $element['page_name'];?></td>
			<td><a href="<?php echo $ini_conf['SiteUrl'].'?page=pagename&id='.$element['page_name'];?>" target="_blank"><?php echo $ini_conf['SiteUrl'];?>?page=pagename&id=<?php echo $element['page_name'];?></a></td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>