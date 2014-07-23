<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);


function ini_page_header ($ini_conf) {?>

<?php }
function ini_page_body ($ini_conf){
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
}
?>
