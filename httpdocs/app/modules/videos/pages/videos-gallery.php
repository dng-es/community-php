<?php
addJavascripts(array(getAsset("videos")."js/videos-gallery.js"));

$module_config = getModuleConfig("videos");
$module_channels = getModuleChannels($module_config['channels'], $_SESSION['user_canal']);
$filter_videos = ($_SESSION['user_canal'] == 'admin' ? "" : " AND (v.canal IN (".$module_channels.") OR v.canal='') ");
templateload("gallery","videos");
?>

<div class="row row-top">
	<br />
	<div class="col-md-12">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Video_gallery"), "ItemClass"=>"active"),
		));

		?>
		<h3 class="carousel-slide-title"><?php e_strTranslate("Important_videos");?></h3>
		<?php 
		$elements = videosController::getListAction(60, " AND estado=1 AND destacado=1 ".$filter_videos);
		showVideoCarousel($elements, "myCarouselA");
		?>

		<h3 class="carousel-slide-title"><?php e_strTranslate("Last_videos");?></h3>
		<?php 
		$elements = videosController::getListAction(60, " AND estado=1 ".$filter_videos);
		showVideoCarousel($elements, "myCarouselB");


		$videos = new videos();
		$tags = array_rand($videos->getTags($filter_videos), 2);
		foreach ($tags as $key=>$tag):
			$elements = videosController::getListAction(60, " AND estado=1 ".$filter_videos." AND tipo_video LIKE '%".$tag."%'");
			echo '<h3 class="carousel-slide-title">'.ucfirst($tag).'</h3>';
			showVideoCarousel($elements, "myCarousel".$key, $tag);
		endforeach;
		?>
	</div>
</div>