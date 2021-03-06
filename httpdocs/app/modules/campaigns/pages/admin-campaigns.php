<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Campaigns"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Campaigns_list"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		campaignsController::deleteAction();
		$elements = campaignsController::getListAction(20);?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-campaign?act=new"><?php e_strTranslate("New_campaign");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-campaigns","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th><?php e_strTranslate("Name");?></th>
							<th><?php e_strTranslate("Channel");?></th>
							<th><?php e_strTranslate("Type");?></th>
							<th><?php e_strTranslate("Description");?></th>
							<th><?php e_strTranslate("News");?></th>
						</tr>
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="Eliminar"
									onClick="Confirma('¿Seguro que deseas eliminar la campaña?', 'admin-campaigns?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_campaign'];?>'); return false;"><i class="fa fa-trash icon-table"></i>
								</button>
								<button type="button" class="btn btn-default btn-xs" title="Ver/editar"
									onClick="location.href='admin-campaign?id=<?php echo $element['id_campaign'];?>'; return false;">
									<i class="fa fa-edit icon-table"></i>
								</button>
							</td>
							<td><?php echo $element['name_campaign'];?></td>
							<td><?php echo $element['canal_campaign'];?></td>
							<td><?php echo $element['tipo'];?></td>
							<td><?php echo $element['desc_campaign'];?></td>
							<td align="center"><span class="label<?php echo ($element['novedad']==0 ? " label-warning" : " label-success");?>"><?php echo ($element['novedad'] == 0 ? strTranslate("App_No") : strTranslate("App_Yes"));?></span></td>
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