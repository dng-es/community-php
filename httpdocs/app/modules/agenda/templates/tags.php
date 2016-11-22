<?php
/**
 * Show tags from a post
 * @param  	string 		$tags 		Tags to show
 * @return 	string       			HTML tags
 */
function showTags($tags, $destination = "ofertas"){
	$array_tags = explode(",", $tags);
	if (count($array_tags) > 0){
		echo '<p><span class="items-tags">';
		foreach($array_tags as $tag):
			if (trim($tag) != ""){
				echo '<span class="label label-default"><a href="'.$destination.'?f='.trim($tag).'"><i class="fa fa-tag"></i> '.trim($tag).'</a></span>';
			}
		endforeach;
		echo '</span></p>';
	}
}
?>