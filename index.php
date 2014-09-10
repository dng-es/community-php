<?php
include_once ("includes/core/functions.core.php");
include_once ("includes/core/constants.php");

$page = (isset($_REQUEST['page']) and $_REQUEST['page']!="") ? $_REQUEST['page'] : 'login';

//LOGOUT SESSION
if ($page=='logout') {session::destroySession();}
else{
	//LOGIN-SESSION
	session::validateUserSession();

	//MOSTRAR PAGINA SOLICITADA. SI NO SE ENCUENTRA SE MUESTRA LA PAGINA 404
	ob_start();
	include_once(pageRouter($page.".php"));
	$output = ob_get_contents();
	ob_end_clean();

	//SELECCION METATAGS
	if (!isset($Key_Words)){ $Key_Words=$ini_conf['SiteKeywords'];}         
	if (!isset($Subject)){ $Subject=$ini_conf['SiteSubject'];}

	//PAGE HEADERS
	headers::PageHeader(SUBJECT_META_PAGE,KEYWORDS_META_PAGE);
	
	//PAGE BODY
	headers::PageBody($ini_conf,$page);		
	echo $output;
	
	//PAGE FOOTER
	footer::PageFooter();
}
?>