<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

function ini_page_header ($ini_conf) {?>
	<!-- Bootstrap input file -->
	<script type="text/javascript" src="js/bootstrap.file-input.js"></script>
	<script type="text/javascript" src="js/jwplayer/jwplayer.js"></script>
	<!-- tooltip -->   
	<script type="text/javascript" src="js/jquery.bettertip.pack.js"></script>      
	<script type="text/javascript">
		$(function(){
				BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
		})
	</script>
	<!-- fin tooltip -->          
<?php }
function ini_page_body ($ini_conf){
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
	<?php
}
?>