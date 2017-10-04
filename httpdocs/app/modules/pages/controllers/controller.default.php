<?php
class pagesController{
	public static function getListAction($reg = 0, $filter = ""){
		$pages = new pages();
		$find_reg = getFindReg();
		if ($find_reg !=  '') $filter .= " AND page_canal='".$find_reg."' ".$filter;

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("pages", $filter); 
		return array('items' => $pages->getPages($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $paginator_items['find_reg'],
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['page_name']) && $_POST['page_name'] == ""){
			$pages = new pages();
			$page_name = str_replace(" ", "_", NormalizeText($_POST['page_name_new']));
			$page_content = stripslashes($_POST['page_content']);
			$page_title = sanitizeInput($_POST['page_title']);
			$page_menu = (isset($_POST['page_menu']) && $_POST['page_menu'] == "on") ? 1 : 0;
			$page_order = (isset($_POST['page_order']) && $_POST['page_order'] != "") ? $_POST['page_order'] : 0;
			$page_canal = sanitizeInput($_POST['page_canal']);
			$page_user_menu = (isset($_POST['page_user_menu']) && $_POST['page_user_menu'] == "on") ? 1 : 0;
			$page_user_menu_order = (isset($_POST['page_user_menu_order']) && $_POST['page_user_menu_order'] != "") ? $_POST['page_user_menu_order'] : 0;

			if ($pages->insertPage($page_name, $page_content, $page_menu, $page_title, $page_order, $page_canal, $page_user_menu, $page_user_menu_order)) 
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-page?p=".$page_name);
		}
	}

	public static function updateAction(){
		if (isset($_POST['page_name']) && $_POST['page_name'] != ""){
			$pages = new pages();
			$page_name = sanitizeInput($_POST['page_name']);
			$page_title = sanitizeInput($_POST['page_title']);
			$page_content = stripslashes($_POST['page_content']);
			$page_menu = (isset($_POST['page_menu']) && $_POST['page_menu'] == "on") ? 1 : 0;
			$page_order= (isset($_POST['page_order']) && $_POST['page_order'] != "") ? $_POST['page_order'] : 0;
			$page_canal = sanitizeInput($_POST['page_canal']);
			$page_user_menu = (isset($_POST['page_user_menu']) && $_POST['page_user_menu'] == "on") ? 1 : 0;
			$page_user_menu_order = (isset($_POST['page_user_menu_order']) && $_POST['page_user_menu_order'] != "") ? $_POST['page_user_menu_order'] : 0;

			if ($pages->updatePage($page_name, $page_content, $page_menu, $page_title, $page_order, $page_canal, $page_user_menu, $page_user_menu_order))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-page?p=".$_POST['page_name']);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$pages = new pages();
			if ($pages->deletePage($_REQUEST['id'])) 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-pages");
		}
	}
}
?>