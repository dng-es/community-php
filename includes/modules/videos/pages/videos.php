<?php
addJavascripts(array("js/bootstrap.file-input.js", 
					 "js/libs/jwplayer/jwplayer.js", 
					 "js/jquery.bettertip.pack.js"));

templateload("gallery","videos");
templateload("addfile","videos");

session::getFlashMessage( 'actions_message' );
videosController::voteAction();
videosController::createAction();
$elements = videosController::getListAction(4, " AND estado=1 ");	
?>
<div class="row row-top">
	<div class="col-md-9 inset">
		<h1><?php echo strTranslate("Video_gallery");?></h1>
		<?php 
		galleryVideos($elements['items'],true,0,4);
		Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<div class="col-md-3 lateral">
		<?php SearchForm($elements['reg'],"?page=videos","searchForm", strTranslate("Search_video_by_title"), strTranslate("Search"));?>
		<?php PanelSubirVideo(0);?>
	</div>
</div>