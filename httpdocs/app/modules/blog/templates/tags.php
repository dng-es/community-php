<?php
/**
 * Show tags from a post
 * @param  	string 		$tags 		Tags to show
 * @return 	string       			HTML tags
 */
function showTags($tags){
	$array_tags = explode(",", $tags);
	if (count($array_tags)>0){
		echo '<span class="items-tags">';
		foreach($array_tags as $tag):
			if (trim($tag)!=""){
				echo '<span class="label label-default"><a href="blog-list?c='.trim($tag).'"><i class="fa fa-tag"></i> '.trim($tag).'</a></span>';
			}
		endforeach;
	echo '</span>';
	}
}
?>