<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

$pages = new pages();
if (isset($_REQUEST['id']) and $_REQUEST['id']!=""){
	$id = $_REQUEST['id'];
	$page = $pages->getPages(" AND page_name='".$id."' ");

	echo '<div class="row row-top">';
	echo '	<div class="col-md-11 inset">
				'.$page[0]['page_content'];
	echo '</div>';
	echo '</div>';
}
?>
