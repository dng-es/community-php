<?php
function panelVideos(){
	$module_config = getModuleConfig("videos");
	$module_channels = getModuleChannels($module_config['channels'], $_SESSION['user_canal']);
	$filtro_canal = ($_SESSION['user_canal'] == 'admin' ? "" : " AND (v.canal IN (".$module_channels.") OR v.canal='') ");
	$last_video = videosController::getListAction(1, $filtro_canal." AND estado=1 ");
	?>
	<div class="col-md-12 section panel">
		<h3><?php e_strTranslate("Last_videos");?></h3>
		<?php if (isset($last_video['items'][0])): ?>
		<div class="media-preview-container">
			<a href="videos">
			<img class="media-preview" src="<?php echo PATH_VIDEOS.$last_video['items'][0]['name_file'].'.jpg';?>" alt="<?php echo prepareString($last_video['items'][0]['titulo']);?>" /></a>
			<div>
				<a href="videos"><?php echo $last_video['items'][0]['titulo'];?></a><br />
				<?php echo $last_video['items'][0]['nick'];?><br />
				<small><span><?php echo ucfirst(getDateFormat($last_video['items'][0]['date_video'], "LONG"));?></small></span>
			</div>
		</div>
		<?php else: ?>
			<div class="text-muted"><?php e_strTranslate("No_video_uploads");?></div>
		<?php endif; ?>
		</small>
	</div>
<?php } ?>