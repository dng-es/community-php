<?php
//EXPORT USERS
usersCanalesController::exportListAction();

session::getFlashMessage('actions_message'); 
$elements = usersCanalesController::getListAction(35);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Channels"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Channel_list"), "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-canal"><?php e_strTranslate("Channel_new");?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th width="40px"></th>
						<th><?php e_strTranslate("Channel");?></th>
						<th><?php e_strTranslate("Description");?></th>
						<th><?php e_strTranslate("Theme");?></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<span class="fa fa-edit icon-table" title="<?php e_strTranslate("Edit");?>" onClick="location.href='admin-canal?id=<?php echo $element['canal'];?>'">
								</span>
							</td>
							<td><?php echo $element['canal'];?></td>
							<td><?php echo $element['canal_name'];?></td>
							<td><?php echo $element['theme'];?></td>
							</tr>  
						<?php endforeach; ?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>