<?php
//EXPORT EXCEL - SHOW AND GENERATE
recompensasController::exportListAction();
$elements = recompensasController::getListUserListAction(100, " ORDER BY recompensa_date DESC");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Rewards"), "ItemUrl"=>"admin-recompensas"),
			array("ItemLabel"=>strTranslate("Rewards_assigned"), "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Items");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-hover table-striped">
						<tr>
							<th><?php e_strTranslate("User");?></th>
							<th><?php e_strTranslate("Reward");?></th>
							<th>Detalle</th>
							<th><?php e_strTranslate("Date");?></th>
						</tr>
						<?php foreach($elements['items'] as $element): ?>
						<tr>
							<td><?php echo $element['recompensa_user'];?></td>
							<td><img src="<?php echo PATH_REWARDS.$element['recompensa_image'];?>" width="25px" /> <?php echo $element['recompensa_name'];?></td>
							<td><?php echo $element['recompensa_comment'];?></td>
							<td><?php echo getDateFormat($element['recompensa_date'], "DATE_TIME");?></td>
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