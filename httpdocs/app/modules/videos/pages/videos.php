<?php
templateload("searchfile","videos");
templateload("tags","videos");

addJavascripts(array("js/bootstrap.file-input.js", 
					 "js/libs/jwplayer/jwplayer.js", 
					 getAsset("videos")."js/videos.js"));

$module_config = getModuleConfig("videos");
$module_channels = getModuleChannels($module_config['channels'], $_SESSION['user_canal']);

$tags = (isset($_REQUEST['tag']) ? sanitizeInput($_REQUEST['tag']) : '' );
$filtro_tags = ( $tags != ''  ? " AND tipo_video like '%".$tags."%' " : "" );
$filter_videos = $filtro_tags.($_SESSION['user_canal'] == 'admin' ? "" : " AND (v.canal IN (".$module_channels.") OR v.canal='') ");
$filter_id = ((isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? " AND id_file=".intval($_REQUEST['id'])." " : "");

$id_video = connection::SelectMaxReg("id_file", "galeria_videos v ", $filter_id.$filter_videos." AND estado=1 ");

$pagina_sig = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1 );
$pagina_com = (isset($_REQUEST['pag2']) ? $_REQUEST['pag2'] : 1 );
$num_videos = 6;
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Video_gallery"), "ItemUrl"=>"videos-gallery"),
			array("ItemLabel"=>strTranslate("Video"), "ItemClass"=>"active"),
		));

		$module_config = getModuleConfig("videos");

		templateload("gallery","videos");
		templateload("addfile","videos");
		templateload("tags","videos");
		templateload("addcomment","videos");
		templateload("comment","videos");
		templateload("notifications","notifications");

		session::getFlashMessage( 'actions_message' );
		videosController::voteAction();
		videosController::createAction();
		videosController::voteCommentAction("videos?id=".$id_video);
		videosController::createCommentAction();
		notificationsController::deleteNotification($id_video, 'videos');
		notificationsController::notificationInscription($id_video, 'videos', 'videos?id='.$id_video);

		if ($id_video > 0):
			$video = videosController::getItemAction($id_video, " AND estado=1 ");
			$comments = videosController::getCommentsListAction(2000, " AND estado=1 AND id_file=".$id_video." ORDER BY id_comentario DESC ");
			$elements = videosController::getListAction($num_videos, " AND estado=1 ".$filter_videos );
			?>
			<h2>
				<?php echo $video['titulo'];?>
				<?php if($_SESSION['user_perfil'] == 'admin') echo " <small>id ".$id_video."</small>";?>
			</h2>
			<p class="text-muted">
				<small>
					<?php echo ucfirst(getDateFormat($video['date_video'], "LONG"));?> <i class="fa fa-user text-primary"></i> <?php echo ucfirst(strTranslate("uploaded_by"));?> <?php echo $video['nick'];?>
					<i class="fa fa-youtube-play text-primary"></i> <?php echo $video['views'];?>  <?php e_strTranslate("Views");?> 
					<?php videoNotifications($id_video);?>
					<a href="videos?id=<?php echo $video['id_file'].'&idvv='.$video['id_file'];?>"><i class="fa fa-heart pointer"></i> <?php echo $video['videos_puntos'];?></a> 
				</small>
			</p>
			<p><?php showTags($video['tipo_video']);?></p>
			<?php playVideo("VideoGaleria".$id_video, PATH_VIDEOS.$video['name_file'], 100, 100, "bottom", false, $id_video);?>
			<?php if ($module_config['options']['allow_comments'] == true): ?>
			<?php addVideoComment($id_video);?>
			<br />
			<?php videoCommentGallery($comments['items'], "videos?id=".$id_video."&pag2=".$pagina_com);?>
			<?php Paginator($comments['pag'],$comments['reg'],$comments['total_reg'],$_REQUEST['page']."?id=".$id_video,'',$comments['find_reg'], 10, "", "pag2");?>
			<?php endif; ?>
		<?php else:?>
			<div class="alert alert-warning"><?php e_strTranslate("No_video_uploads");?></div>
		<?php endif;?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php SearchVideo(1000, "videos?id=".$id_video, "searchForm", strTranslate("Search_video_by_title"), strTranslate("Search"));?>
			<?php PanelSubirVideo(0);?>
			<div class="alert-message alert alert-danger" id="alertas-participa"></div>
			<?php tagsCloud();?>
			<div>
				<h4>
					<span class="fa-stack fa-sx">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-folder fa-stack-1x fa-inverse"></i>
					</span>
					<?php e_strTranslate("Last_videos");?>
				</h4>
				<br />
				<?php 
				if ($id_video > 0):
					foreach($elements['items'] as $element):
						echo '<div class="media-preview-container">
									<a href="videos?id='.$element['id_file'].'&pag='.$pagina_sig.'&tag='.$tags.'">
									<img src="'.PATH_VIDEOS.$element['name_file'].'.jpg" class="media-preview" alt="'.prepareString($element['titulo']).'" /></a>
									<div><a href="videos?id='.$element['id_file'].'&pag='.$pagina_sig.'&tag='.$tags.'">'.$element['titulo'].'</a><br />
										 '.$element['nick'].'<br />
										 <span><small>'.getDateFormat($element['date_video'], "LONG").'</small></span>
									</div>
								</div>';
					endforeach;
				
					if (($num_videos * $pagina_sig) < $elements['total_reg']):
					endif;?>
				<div class="ver-mas">
					<a href="videos?id=<?php echo $id_video;?>&v=1&pag=<?php echo $pagina_sig + 1;?>&tag=<?php echo $tags;?>">
					<span class="fa fa-search"></span> <?php e_strTranslate("See_more_videos");?></a>
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>