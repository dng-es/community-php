<?php
if (isset($_REQUEST['page']) and $_REQUEST['page']!="") {$page=$_REQUEST['page'];}
else {$page='login';}

include_once ("includes/core/functions.core.php");
include_once ("includes/core/constants.php");



//LOGOUT SESSION
if ($page=='logout') {session::destroySession();}

//LOGIN-SESSION
if (isset($_POST['form-login-user'])) { session::createSession($_POST['form-login-user'],$_POST['form-login-password']);}
else { session::ValidateSession();}

if (isset ($_REQUEST['page']) and (in_array($page, $paginas_free)==false)){
	if (!isset($_SESSION['user_name']) or trim($_SESSION['user_name'])=="") {
		session::destroySession();
		$page="login";
	}
	else {
		$visitas = new visitas();
		$visitas ->insertVisitas($_SESSION['user_name'],$page);  
	}
}

//MOSTRAR PAGINA SOLICITADA. SI NO SE ENCUENTRA SE MUESTRA LA PAGINA 404
if ($page != 'logout'){
	include_once(pageRouter($page.".php"));

	//SELECCION METATAGS
	if (!isset($Key_Words)){ $Key_Words=$ini_conf['SiteKeywords'];}         
	if (!isset($Subject)){ $Subject=$ini_conf['SiteSubject'];}

	//SELECCION DE MENUS
	if (!isset($menu_admin)){ $menu_admin=0;}
	if (!isset($menu_sel)){ $menu_sel=0;} 

	//PAGE HEADERS
	headers::PageHeader(SUBJECT_META_PAGE,KEYWORDS_META_PAGE);
	ini_page_header ($ini_conf);
	//PAGE BODY
	headers::PageBody($ini_conf,$page,$menu_admin);		
	ini_page_body ($ini_conf);
	//PAGE FOOTER
	footer::PageFooter($menu_admin);
}
?>