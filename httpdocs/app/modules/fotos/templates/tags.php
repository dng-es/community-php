<?php
/**
 * Show tags from a post
 * @param  	String 		$tags 		Tags to show
 * @return 	String       			HTML tags
 */
function showTags($tags){
	$array_tags = explode(",", $tags);
	if (count($array_tags) > 0){
		echo '<span class="items-tags">';
		foreach($array_tags as $tag):
			if (trim($tag) != ""){
				echo '<span class="label label-default"><a href="fotos?tag='.trim($tag).'"><i class="fa fa-tag"></i> '.trim($tag).'</a></span>';
			}
		endforeach;
		echo '</span>';
	}
}
?>