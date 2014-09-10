<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

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

<div id="page-info"><?php echo strTranslate("Video_gallery");?></div>
<div class="row row-top">
	<div class="col-md-9 inset">
		<?php 
		galleryVideos($elements['items'],true,0,4);
		Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<div class="col-md-3 lateral">
		<?php SearchForm($elements['reg'],"?page=videos","searchForm", strTranslate("Search_video_by_title"), strTranslate("Search"));?>
		<?php PanelSubirVideo(0);?>
	</div>
</div>