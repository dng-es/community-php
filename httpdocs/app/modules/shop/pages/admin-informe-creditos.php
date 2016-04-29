<?php
//EXPORT EXCEL - SHOW AND GENERATE
shopCreditosController::exportListAction();
$elements = shopCreditosController::getListAction(100);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Reports"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Report")." <b>".strTranslate("APP_Credits")."</b>", "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php e_strTranslate("Items");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="admin-informe-participaciones"><?php e_strTranslate("Report");?> <?php e_strTranslate("APP_shares");?></a></li>
			<li><a href="admin-informe-accesos"><?php e_strTranslate("Report");?> <?php echo strtolower(strTranslate("Visits"));?></a></li>
			<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
		</ul>
		<div class="table-responsive">
			<table class="table">
				<tr>
				<th><?php e_strTranslate("User");?></th>
				<th><?php e_strTranslate("Nick");?></th>
				<th><?php echo ucfirst(strTranslate("APP_Credits"));?></th>
				<th><?php echo ucfirst(strTranslate("APP_Credits"));?> motivo</th>
				<th><?php echo ucfirst(strTranslate("APP_Credits"));?> detalle</th>
				<th><?php e_strTranslate("Date");?></th>
				</tr>
				<?php foreach($elements['items'] as $element): ?>
					<tr>
					<td>&nbsp;<?php echo $element['credito_username'];?></td>
					<td><?php echo $element['nick'];?></td>
					<td><?php echo $element['credito_puntos'];?></td>
					<td><?php echo $element['credito_motivo'];?></td>
					<td><?php echo $element['credito_detalle'];?></td>
					<td><?php echo getDateFormat($element['credito_date'], "DATE_TIME");?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>