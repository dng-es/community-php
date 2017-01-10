<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Rewards"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Rewards_list"), "ItemClass"=>"active"),
		));
		
		session::getFlashMessage( 'actions_message' );
		$elements = recompensasController::getListAction(35);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-recompensa"><?php e_strTranslate("New_reward");?></a></li>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th width="40px"></th>
						<th><?php e_strTranslate("Name");?></th>
						<th width="40px"></th>
						</tr>
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>" onClick="location.href='admin-recompensa?id=<?php echo $element['id_recompensa'];?>'; return false"><i class="fa fa-edit icon-table"></i>
								</button>
							</td>
							<td><?php echo $element['recompensa_name'];?></td>
							<td><img src="<?php echo PATH_REWARDS.$element['recompensa_image'];?>" width="25px" /></td>
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