<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

function ini_page_header ($ini_conf) {}
function ini_page_body ($ini_conf){

	$info = new infotopdf();
	echo '<h1>Tu documentación</h1>';

	//TODOS LOS DOCUMENTOS
	$elements=$info->getInfoTipos("");
	foreach($elements as $element):
		echo '<div class="col-md-6">
					<center><a href="?page=infotopdf-det&id='.$element['id_tipo'].'"><img src="images/banners/'.$element['foto_info'].'" /></a></center>
				</div>';	  	  	
	endforeach;
}
///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////
?>