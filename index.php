<?php
include_once ("includes/core/functions.core.php");
include_once ("includes/core/constants.php");

$page = (isset($_REQUEST['page']) and $_REQUEST['page']!="") ? $_REQUEST['page'] : 'login';

//LOGOUT SESSION
if ($page=='logout') {session::destroySession();}

	//LOGIN-SESSION
	session::validateUserSession();

	//OBTENER PAGINA SOLICITADA. SI NO SE ENCUENTRA SE MUESTRA LA PAGINA 404
	ob_start();
	include_once(pageRouter($page.".php"));
	$output = ob_get_contents();
	ob_end_clean();

	//TEMPLATE PAGE HEADERS
	headers::PageHeader();
	
	//TEMPLATE PAGE BODY
	headers::PageBody($ini_conf,$page);

	//PAGE BODY
	echo $output;
	
	//TEMPLATE PAGE FOOTER
	footer::PageFooter();
?>