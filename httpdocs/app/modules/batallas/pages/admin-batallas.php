<?php
//EXPORT DATA
batallasController::exportListAction();
?>
<div class="row row-top">
	<div class="app-main section-admin">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Battles"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Battles_list"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		$elements = batallasController::getListAction(20);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">    
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th><?php e_strTranslate("User");?>1</th>
							<th><?php e_strTranslate("User");?>2</th>
							<th><?php e_strTranslate("Date");?></th>
							<th><?php e_strTranslate("Type");?></th>
							<th>Ganador</th>
						</tr>
						<?php foreach($elements['items'] as $element): ?>
						<tr>
							<td><?php echo $element['user_create'];?></td>
							<td><?php echo $element['user_retado'];?></td>
							<td><?php echo getDateFormat( $element['date_batalla'], "DATE_TIME");?></td>
							<td><?php echo $element['tipo_batalla'];?></td>
							<td><?php echo $element['ganador'];?></td>
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