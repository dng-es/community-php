<?php
//EXPORT USERS
emocionesController::exportListUserAction();

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
?>
<div class="row row-top">
	<div class="col-md-6 col-md-offset-3">
		<div class="col-md-12">
			<h1>emociones de los usuarios</h1>
			<?php
			session::getFlashMessage('actions_message');
			emocionesController::deleteAction();
			$elements = emocionesController::getListUserAction(35, " ");
			?>
			<a href="?page=user&act=new" class="btn btn-primary">nueva emoción</a>
			<a href="?page=<?php echo $_REQUEST['page'].'&export=true';?>" class="btn btn-primary">exportar CSV</a>
			<div class="clearfix"></div>
			<br />
			<p><?php echo strtolower(strTranslate("Total"));?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></p>
			<table class="table" >
				<tr>
				<th width="40px"></th>
				<th>emoción</th>
				<th>usuario</th>
				<th>motivo</th>
				<th>fecha</th>
				</tr>
				<?php foreach($elements['items'] as $element):?>
					<tr>
					<td nowrap="nowrap">
						<img style="height: 50px" src="images/banners/<?php echo $element['image_emocion'];?>" />
					</td>
					<td><?php echo $element['name_emocion'];?></td>
					<td><?php echo $element['user_emocion'];?></td>
					<td><?php echo $element['desc_emocion_user'];?></td>
					<td><?php echo dateLong($element['date_emocion']);?><br />
					<?php echo strftime(TIME_FORMAT,strtotime($element['date_emocion']));?>
					</td>
					</tr>
				<?php endforeach; ?>
			</table>
			<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>