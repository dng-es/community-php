<?php
//EXPORT USERS
emocionesController::exportListUserAction();

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Emociones"), "ItemUrl"=>"admin-emociones"),
			array("ItemLabel"=>"Emociones de los usuarios", "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		emocionesController::deleteAction();
		$elements = emocionesController::getListUserAction(35, " ");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-emocion">Nueva emoción</a></li>
					<li><a href="<?php echo $_REQUEST['page'];?>?export=true"><?php e_strTranslate("Export");?></a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-hover table-striped">
						<tr>
							<th width="40px"></th>
							<th>Emoción</th>
							<th><?php e_strTranslate("User");?></th>
							<th>Motivo</th>
							<th><?php e_strTranslate("Date");?></th>
						</tr>
						<?php foreach($elements['items'] as $element):?>
						<tr>
							<td nowrap="nowrap">
								<img style="height: 50px" src="images/emociones/<?php echo $element['image_emocion'];?>" />
							</td>
							<td><?php echo $element['name_emocion'];?></td>
							<td><?php echo $element['user_emocion'];?></td>
							<td><?php echo $element['desc_emocion_user'];?></td>
							<td><?php echo getDateFormat($element['date_emocion'], 'DATE_TIME');?></td>
						</tr>
						<?php endforeach; ?>
					</table>
					<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>