<?php
templateload("searchfile","videos");

addJavascripts(array("js/bootstrap.file-input.js", 
					 "js/libs/jwplayer/jwplayer.js", 
					 "js/jquery.bettertip.pack.js", 
					 getAsset("videos")."js/videos.js"));

if (isset($_REQUEST['id']) and $_REQUEST['id']>0){
	$id_video = $_REQUEST['id'];
}
else{
	//SELECCION ULTIMO VIDEO
	$filter_videos = ($_SESSION['user_canal']!='admin' ? " AND canal='".$_SESSION['user_canal']."' " : "");			
	$id_video = connection::SelectMaxReg("id_file", "galeria_videos", $filter_videos." AND estado=1 ");
}

$pagina_sig = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1 );
$pagina_com = (isset($_REQUEST['pag2']) ? $_REQUEST['pag2'] : 1 );
$num_videos = 6;

?>		

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Video_gallery"), "ItemClass"=>"active"),
		));

		$module_config = getModuleConfig("videos");

		templateload("gallery","videos");
		templateload("addfile","videos");
		templateload("addcomment","videos");
		templateload("comment","videos");

		session::getFlashMessage( 'actions_message' );
		videosController::voteAction();
		videosController::createAction();
		videosController::voteCommentAction("videos?id=".$id_video);
		videosController::createCommentAction();

		if ($id_video > 0):

			$video = videosController::getItemAction($id_video, " AND estado=1 ");
			$comments = videosController::getCommentsListAction(2000, " AND estado=1 AND id_file=".$id_video." ORDER BY id_comentario DESC ");
			$elements = videosController::getListAction($num_videos, " AND estado=1 ");
			?>
			<?php playVideo("VideoGaleria".$id_video,PATH_VIDEOS.$video['name_file'],100,100, "bottom", false, $id_video);?>
			<h3><?php echo $video['titulo'];?>
			<small>
			<span class="legend"><?php echo strTranslate("uploaded_by");?> <b><?php echo $video['nick'];?></b> - <span><?php echo getDateFormat($video['date_video'], "LONG");?></span>
			 - <b><?php echo strTranslate("Views");?></b> : <?php echo $video['views'];?> 
			 - <a href="videos?id=<?php echo $video['id_file'].'&idvv='.$video['id_file'];?>"><i class="fa fa-heart"></i> <?php echo $video['videos_puntos'];?></a> 
			 <?php if($_SESSION['user_perfil'] == 'admin') echo " ID - ".$id_video;?>
			</span>
			</small>
			</h3>
			<?php if ($module_config['options']['allow_comments']==true): ?>
			<?php addVideoComment($id_video);?>
			<br />
			<?php videoCommentGallery($comments['items'], "videos?id=".$id_video."&pag2=".$pagina_com);?>
			<?php Paginator($comments['pag'],$comments['reg'],$comments['total_reg'],$_REQUEST['page']."?id=".$id_video,'',$comments['find_reg'], 10, "", "pag2");?>
			<?php endif; ?>
		<?php endif;?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php SearchVideo(1000,"videos?id=".$id_video,"searchForm", strTranslate("Search_video_by_title"), strTranslate("Search"));?>
			<?php PanelSubirVideo(0);?>
			<div class="alert-message alert alert-danger" id="alertas-participa"></div>
			<br />
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-folder fa-stack-1x fa-inverse"></i>
				</span>
				<?php echo strTranslate("Last_videos");?>
			</h4>
			<br />
			<?php	
			foreach($elements['items'] as $element):
				echo '<div class="media-preview-container">
							<a href="videos?id='.$element['id_file'].'&pag='.$pagina_sig.'">
							<img src="'.PATH_VIDEOS.$element['name_file'].'.jpg" class="media-preview" alt="'.$element['titulo'].'" /></a>
							<div><a href="videos?id='.$element['id_file'].'&pag='.$pagina_sig.'">'.$element['titulo'].'</a><br />
								 <span>'.getDateFormat($element['date_video'], "LONG").'</span><br />
								 '.$element['nick'].'
							</div>
						</div>';
			endforeach;			
			?>
			<?php if (($num_videos*$pagina_sig) < $elements['total_reg']): ?>
			<div class="ver-mas">
				<a href="videos?id=<?php echo $id_video;?>&v=1&pag=<?php echo $pagina_sig+1;?>">
				<span class="fa fa-search"></span> <?php echo strTranslate("See_more_videos");?></a>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>