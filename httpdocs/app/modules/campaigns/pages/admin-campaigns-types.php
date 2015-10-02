<?php
session::getFlashMessage('actions_message'); 
campaignsController::deleteTypeAction();
$elements = campaignsController::getListTypesAction(20);
?>
<div class="row row-top">
  	<div class="app-main">
  		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Campaigns"), "ItemUrl"=>"admin-campaigns"),
			array("ItemLabel"=>strTranslate("Campaign_types"), "ItemClass"=>"active"),
		));?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>  
					<li><a href="admin-campaigns-type?act=new">Nuevo tipo</a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th><?php echo strTranslate("Name");?></th>
							<th><?php echo strTranslate("Description");?></th>
						</tr>
						<?php foreach($elements['items'] as $element): ?>
							<tr>
							<td nowrap="nowrap">
								<a class="fa fa-edit icon-table" title="<?php echo strTranslate("Edit");?>"
									onClick="location.href='admin-campaigns-type?id=<?php echo $element['id_campaign_type'];?>'; return false;">
								</a>

								<a class="fa fa-ban icon-table" title="<?php echo strTranslate("Delete");?>"
									onClick="Confirma('<?php echo strTranslate("Are_you_sure_to_delete");?>', 'admin-campaigns-types?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_campaign_type'];?>'); return false;">
								</a>
							</td>			
							<td><?php echo $element['campaign_type_name'];?></td>
							<td><?php echo $element['campaign_type_desc'];?></td>
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