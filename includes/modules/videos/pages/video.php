<?php
include_once ("includes/videos/templates/gallery.php");
include_once ("includes/videos/templates/addfile.php");
include_once ("includes/videos/templates/addcomment.php");
include_once ("includes/videos/templates/comment.php");

addJavascripts(array("js/bootstrap.file-input.js", 
					 "js/libs/jwplayer/jwplayer.js", 
					 "js/jquery.bettertip.pack.js", 
					 getAsset("videos")."js/video.js"));

$id_video = (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
$pagina_sig = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1 );
//$pagina_sig++;
$pagina_com = (isset($_REQUEST['pag2']) ? $_REQUEST['pag2'] : 1 );
$num_videos = 6;

if ($id_video > 0){
	templateload("gallery","videos");
	templateload("addfile","videos");
	templateload("addcomment","videos");
	templateload("comment","videos");
	?>		

	<div class="row row-top">
		<div class="col-md-8 col-lg-9 inset">
			
			<?php
			session::getFlashMessage( 'actions_message' );
			videosController::voteAction();
			videosController::createAction();
			videosController::voteCommentAction("video&id=".$id_video);
			videosController::createCommentAction();
			
			$video = videosController::getItemAction($id_video, " AND estado=1 ");
			$comments = videosController::getCommentsListAction(2000, " AND estado=1 AND id_file=".$id_video." ORDER BY id_comentario DESC ");
			$elements = videosController::getListAction($num_videos, " AND estado=1 ");
			?>
			<h1><?php echo strTranslate("Video_gallery");?></h1>
			<?php playVideo("VideoGaleria".$id_video,PATH_VIDEOS.$video['name_file'],100,100, "bottom", false, $id_video);?>
			<h4><?php echo $video['titulo'];?>
			<span class="legend"><?php echo strTranslate("uploaded_by");?> <b><?php echo $video['nick'];?></b> - <span><?php echo dateLong($video['date_video']);?></span>
			 - <b>Reproducciones</b> : <?php echo $video['views'];?> 
			 - <a href="?page=video&id=<?php echo $video['id_file'].'&idvv='.$video['id_file'];?>"><i class="fa fa-heart"></i> <?php echo $video['videos_puntos'];?></a>
			</span></h4>
			<?php addVideoComment($id_video);?>
			<?php videoCommentGallery($comments['items'], "video&id=".$id_video."&pag2=".$pagina_com);?>
			<?php Paginator($comments['pag'],$comments['reg'],$comments['total_reg'],$_REQUEST['page']."&id=".$id_video,'',$comments['find_reg'], 10, "", "pag2");?>
		</div>
		<div class="col-md-4 col-lg-3 nopadding lateral-container">
			<div class="panel-interior">
				<?php SearchForm(1000,"?page=video&id=".$id_video,"searchForm", strTranslate("Search_video_by_title"), strTranslate("Search"));?>
				<?php PanelSubirVideo(0);?>
				<div class="alert-message alert alert-danger" id="alertas-participa"></div>
			</div>
			<div class="video-preview-lateral">
				<?php	
				foreach($elements['items'] as $element):
					echo '<div class="video-preview-container"><a href="?page=video&id='.$element['id_file'].'&pag='.$pagina_sig.'"><img src="'.PATH_VIDEOS.$element['name_file'].'.jpg" class="video-preview" /></a>
								<div><a href="?page=video&id='.$element['id_file'].'&pag='.$pagina_sig.'">'.$element['titulo'].'</a><br />
									 <span>'.dateLong($element['date_video']).'</span><br />
									 '.$element['nick'].'</div></div>';
				endforeach;			
				?>
				<?php if (($num_videos*$pagina_sig) < $elements['total_reg']): ?>
				<div class="ver-mas">
					<a href="?page=video&id=<?php echo $id_video;?>&v=1&pag=<?php echo $pagina_sig+1;?>">
					<span class="fa fa-search"></span> <?php echo strTranslate("See_more_videos");?></a>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
	<?php
}
else{ErrorMsg("Error al cargar video.");}
?>