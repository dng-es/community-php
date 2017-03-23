<?php
/**
 * Show tags from a post
 * @param  	string 		$tags 		Tags to show
 * @return 	string       			HTML tags
 */
function showTags($tags){
	$array_tags = explode(",", $tags);
	if (count($array_tags) > 0){
		echo '<span class="items-tags">';
		foreach($array_tags as $tag):
			if (trim($tag) != ""){
				echo '<span class="label label-default"><a href="videos?tag='.trim($tag).'"><i class="fa fa-tag"></i> '.trim($tag).'</a></span>';
			}
		endforeach;
		echo '</span>';
	}
}

/**
 * Show video gallery tags cloud
 * @return 	string 					HTML tags cloud
 */	
function tagsCloud(){ 
	$module_config = getModuleConfig("videos");
	$module_channels = getModuleChannels($module_config['channels'], $_SESSION['user_canal']);
	$filter_videos = ($_SESSION['user_canal'] == 'admin' ? "" : " AND (v.canal IN (".$module_channels.") OR v.canal='') ");
	?>
	<br />
	<div class="tags">
		<h4>
			<span class="fa-stack fa-sx">
				<span class="fa fa-circle fa-stack-2x"></span>
				<span class="fa fa-tags fa-stack-1x fa-inverse"></span>
			</span>
			<?php e_strTranslate("Tags");?>
		</h4>
		<?php
		$videos = new videos();
		$tags = $videos->getTags($filter_videos); //print_r($tags);
		$valor_max = max($tags);
		$valor_min = min($tags);
		$diferencia = $valor_max - $valor_min;
		$diferencia = ($diferencia == 0 ? 1 : $diferencia) ;

		//ordeno el array
		ksort($tags);

		//$separator = (strpos($_SERVER['REQUEST_URI'], "?") == 0  ? "?" : "&");
		//$enlace = (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? "&id": "?";

		foreach(array_keys($tags) as $key){
			$valor_relativo = round((($tags[$key] - $valor_min) / $diferencia) * 10);
			echo '<a href="videos?tag='.$key.'" class="tag'.$valor_relativo.'">'.$key.'</a> ';
		} ?>
	</div>
 <?php } ?>