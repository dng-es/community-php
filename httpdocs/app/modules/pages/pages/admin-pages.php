<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Pages"), "ItemUrl"=>"admin-pages"),
			array("ItemLabel"=>strTranslate("Pages_list"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' );
		pagesController::deleteAction();
		$elements = pagesController::getListAction(15, " ORDER BY page_name ");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-page"><?php e_strTranslate("New_page");?></a></li>
					<div class="pull-right">
						<?php echo SearchChannelForm($elements['reg'],"admin-pages","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>	
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th><?php e_strTranslate("Name");?></th>
							<th><?php e_strTranslate("Channel");?></th>
							<th>URL</th>
						</tr>
						<?php foreach($elements['items'] as $element):?>
						<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="Eliminar" onClick="Confirma('¿Seguro que deseas eliminar la página?', 'admin-pages?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['page_name'];?>'); return false;"><i class="fa fa-trash icon-table"></i>
								</button>
								<button type="button" class="btn btn-default btn-xs" title="Ver/editar" onClick="location.href='admin-page?p=<?php echo $element['page_name'];?>'; return false;"><i class="fa fa-edit icon-table"></i>
								</button>
							</td>
							<td><?php echo $element['page_name'];?></td>
							<td><?php echo $element['page_canal'];?></td>
							<td><a href="<?php echo $ini_conf['SiteUrl'].'/pagename?id='.$element['page_name'];?>" target="_blank"><?php echo $ini_conf['SiteUrl'];?>/pagename?id=<?php echo $element['page_name'];?></a></td>
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