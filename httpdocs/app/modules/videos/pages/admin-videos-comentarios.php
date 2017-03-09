<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Videos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Video_comments"), "ItemClass"=>"active"),
		));
		
		session::getFlashMessage('actions_message');
		videosController::validateCommentAction();

		$videos = new videos();
		$id_file = intval($_REQUEST['id']);
		$pendientes = $videos->getComentariosVideo(" AND c.estado=1 AND c.id_file=".$id_file." ORDER BY id_comentario DESC");
		if (count($pendientes) == 0): ?>
			<div class="alert alert-danger"><?php e_strTranslate("No_video_comments");?></div>
		<?php else: ?>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<tr>
								<th width="40px">&nbsp;</th>
								<th>ID</th>
								<th><?php e_strTranslate("Comment");?></th>
								<th><?php e_strTranslate("Author");?></th>
								<th><?php e_strTranslate("Date");?></th>
							</tr>
							<?php foreach($pendientes as $element):
								echo '<tr>';
								echo '<td nowrap="nowrap">
										<span class="fa fa-ban icon-table" title="'.strTranslate("Delete").'" 
											onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'\',
											\'admin-videos-comentarios?act=elem_ko&idc='.$element['id_comentario'].'&id='.$id_file.'&u='.$element['user_comentario'].'\')">
										</span>
									</td>';
								echo '<td>'.$element['id_comentario'].'</td>';
								echo '<td><em class="legend">'.$element['comentario'].'</em></td>';
								echo '<td>'.$element['user_comentario'].'</td>';
								echo '<td>'.getDateFormat($element['date_comentario'], "SHORT").'</td>';
								echo '</tr>';
							endforeach; ?>
						</table>
					</div>
				</div>
			</div>
		<?php endif;?>
	</div>
	<?php menu::adminMenu();?>
</div>