<?php
class pagesController{
	public static function getListAction($reg = 0){
		$pages = new pages();
		$filtro = " ORDER BY page_name";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("pages",$filtro); 
		return array('items' => $pages->getPages($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $paginator_items['find_reg'],
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['page_name']) and $_POST['page_name'] == ""){
			$pages = new pages();
			$page_name = str_replace(" ", "_", NormalizeText($_POST['page_name_new']));
			$page_content = stripslashes($_POST['page_content']);
			if ($pages->insertPage($page_name,$page_content)) 
				session::setFlashMessage('actions_message', "Registro insertado correctamente", "alert alert-success");
			else 
				session::setFlashMessage('actions_message', "Error al insertar el registro.", "alert alert-danger");

			redirectURL("admin-page?p=".$page_name);
		}
	}

	public static function updateAction(){
		if (isset($_POST['page_name']) and $_POST['page_name'] != ""){
			$pages = new pages();
			$page_content = stripslashes($_POST['page_content']);
			if ($pages->updatePage($_POST['page_name'],$page_content))
				session::setFlashMessage('actions_message', "Registro modificado correctamente", "alert alert-success");

			else 
				session::setFlashMessage('actions_message', "Error al modificar el registro.", "alert alert-danger");

			redirectURL("admin-page?p=".$_POST['page_name']);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$pages = new pages();
			if ($pages->deletePage($_REQUEST['id'])) 
				session::setFlashMessage('actions_message', "Registro eliminado correctamente", "alert alert-success");
			else 
				session::setFlashMessage('actions_message', "Error al eliminar el registro.", "alert alert-danger");

			redirectURL("admin-pages");
		}
	}
}
?>