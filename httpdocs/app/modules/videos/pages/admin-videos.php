<?php
videosController::downloadZipFile(PATH_VIDEOS);
//videosController::downloadVideoFile();

$filter = " AND v.estado=1";
videosController::exportListAction($filter." ORDER BY v.id_file DESC ");
addJavascripts(array(getAsset("videos")."js/admin-videos.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Videos"), "ItemUrl"=>"admin-videos"),
			array("ItemLabel"=>strTranslate("Video_list"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		videosController::changeEstado();
		videosController::changeTags();
		$elements = videosController::getListAction(25, $filter);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default"> 
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?>.</a></li>
					<li><a href="<?php echo $_REQUEST['page'];?>?export=true"><?php e_strTranslate("Export");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-videos","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px"></th>
							<th><?php e_strTranslate("Video");?></th>
							<th><?php e_strTranslate("Tags");?></th>
							<th><?php e_strTranslate("Author");?></th>
							<th><i class="fa fa-comment"></i></th>
						</tr>		
						<?php foreach($elements['items'] as $element):
							$num_comentarios = connection::countReg("galeria_videos_comentarios", " AND estado=1 AND id_file=".$element['id_file']." ");?>
						<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
									onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-videos?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_file'];?>'); return false"><i class="fa fa-trash icon-table"></i>
								</button>

								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Download");?>" onClick="location.href='admin-videos?exp=<?php echo $element['name_file'];?>'; return false"><i class="fa fa-download icon-table"></i>
								</button>
							</td>
							<td>
								<?php echo $element['titulo'];?><br />
								<em class="text-muted"><small><?php echo getDateFormat($element['date_video'], "LONG");?></small></em>
							</td>
							<td>
								<label>
								<input type="checkbox" name="destacado_video" id="destacado_video_<?php echo $element['id_file'];?>" value="<?php echo $element['destacado'];?>" <?php echo $element['destacado'] == 1 ? 'checked="checked" ' : '';?> /> 
								<?php e_strTranslate("Important_videos");?>
								</label>&nbsp;
								<input type="text" name="tipo_video" id="tipo_video_<?php echo $element['id_file'];?>" value="<?php echo $element['tipo_video'];?>" /> 
								<button data-pag="<?php echo $elements['pag'];?>" data-id="<?php echo $element['id_file'];?>" class="btn btn-default trigger-tags btn-xs"><?php e_strTranslate("Update");?></button>
							</td>
							<td><?php echo $element['user_add'];?></td>
							<td title="<?php echo $num_comentarios.' '.strtolower(strTranslate('Comments'));?>">
								<?php if ($num_comentarios == 0) echo $num_comentarios;
								else echo '<a href="admin-videos-comentarios?id='.$element['id_file'].'">'.$num_comentarios.'</a>';?>
							</td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], 'admin-videos', '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>