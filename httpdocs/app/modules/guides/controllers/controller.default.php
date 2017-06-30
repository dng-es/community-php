<?php
class guidesController{
	public static function getListAction($reg = 0, $filter = ""){
		$guides = new guides();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND name_guide LIKE '%".$find_reg."%' ".$filter;

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("guides g",$filter);
		return array('items' => $guides->getGuides($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);

	}

	public static function getListCategoriesAction($reg = 0, $filter = ""){
		$guides = new guides();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND name_guide_category LIKE '%".$find_reg."%' ".$filter;
		
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("guides_categories c",$filter);
		return array('items' => $guides->getGuidesCategories($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);

	}

	public static function getListSubCategoriesAction($reg = 0, $filter = ""){
		$guides = new guides();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND desc_guide_subcategory LIKE '%".$find_reg."%' ".$filter;

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("guides_subcategories s",$filter);
		return array('items' => $guides->getGuidesSubCategories($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getListSubCategoriesTypesAction($reg = 0, $filter = ""){
		$guides = new guides();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND name_guide_subcategory_type LIKE '%".$find_reg."%' ".$filter;

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("guides_subcategories_types t",$filter);
		return array('items' => $guides->getGuidesSubCategoriesTypes($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);

	}

	public static function getListSubCategoriesUsersAction($reg = 0, $filter = ""){
		$guides = new guides();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND user_guide LIKE '%".$find_reg."%' ".$filter;

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("guides_subcategories_users gu",$filter);
		return array('items' => $guides->getGuidesSubCategoriesUsers($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);

	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$guides = new guides();
			if ($guides->deleteGuide($_REQUEST['id'], $_REQUEST['e'])) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guides");
		}
	}

	public static function deleteCategoryAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$guides = new guides();
			if ($guides->deleteGuideCategory($_REQUEST['id'], $_REQUEST['e'])) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guides-categories");
		}
	}

	public static function deleteSubCategoryAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$guides = new guides();
			if ($guides->deleteGuideSubCategory($_REQUEST['id'], $_REQUEST['e'])) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guides-subcategories");
		}
	}

	public static function deleteSubCategoryTypeAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$guides = new guides();
			if ($guides->deleteGuideSubCategoryType($_REQUEST['id'], $_REQUEST['e'])) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guides-subcategory-types");
		}
	}

	public static function exportUsersListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true) {
			$guides = new guides();
			$elements = $guides->getGuidesSubCategoriesUsersExport("");
			download_send_headers("guides_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function getItemAction($id){
		$guides = new guides();
		$element = array();
		$elements = $guides->getGuides(" AND id_guide=".$id." ");
		if (isset($elements[0])) $element = $elements[0];
		else{
			$element['name_guide'] = "";
			$element['type_guide'] = "";
			$element['active_guide'] = 1;
			$element['order_guide'] = 1;
		}
		return $element;
	}

	public static function getItemCategoryAction($id){
		$guides = new guides();
		$element = array();
		$elements = $guides->getGuidesCategories(" AND id_guide_category=".$id." ");
		if (isset($elements[0])) $element = $elements[0];
		else{
			$element['id_guide'] = 0;
			$element['name_guide_category'] = "";
			$element['active_guide_category'] = 1;
			$element['order_guide_category'] = 1;
			$element['type_guide'] = "";
		}
		return $element;
	}

	public static function getItemSubCategoryAction($id){
		$guides = new guides();
		$element = array();
		$elements = $guides->getGuidesSubCategories(" AND id_guide_subcategory=".$id." ");

		if (isset($elements[0])) $element = $elements[0];
		else{
			$element['id_guide'] = 0;
			$element['id_guide_category'] = 0;
			$element['id_guide_subcategory_type'] = 0;
			$element['desc_guide_subcategory'] = "";
			$element['active_guide_subcategory'] = 1;
			$element['order_guide_subcategory'] = 1;
		}
		return $element;
	}	

	public static function getItemSubCategoryTypeAction($id){
		$guides = new guides();
		$element = array();
		$elements = $guides->getGuidesSubCategoriesTypes(" AND id_guide_subcategory_type=".$id." ");

		if (isset($elements[0])) $element = $elements[0];
		else{
			$element['name_guide_subcategory_type'] = "";
			$element['icon_guide_subcategory_type'] = "";
			$element['active_guide_subcategory_type'] = 1;
			$element['order_guide_subcategory_type'] = 1;
		}
		return $element;
	}

	public static function createAction(){
		if (isset($_POST['id']) and $_POST['id'] == 0){
			$guides = new guides();
			$name_guide = sanitizeInput($_POST['name_guide']);
			$type_guide = stripslashes($_POST['type_guide']);
			$order_guide = intval($_POST['order_guide']);
			$active_guide = ($_POST['active_guide'] == "on" ? 1 : 0);

			if ($guides->insertGuide($name_guide, $type_guide, $order_guide, $active_guide)){ 
				$id = connection::SelectMaxReg("id_guide", "guides", "");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guide?id=".$id);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id']) and $_POST['id'] > 0){
			$guides = new guides();
			$id = intval($_POST['id']);
			$name_guide = sanitizeInput($_POST['name_guide']);
			$type_guide = stripslashes($_POST['type_guide']);
			$order_guide = intval($_POST['order_guide']);
			$active_guide = ($_POST['active_guide'] == "on" ? 1 : 0);

			if ($guides->updateGuide($id, $name_guide, $type_guide, $order_guide, $active_guide)) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guide?id=".$id);
		}
	}

	public static function createCategoryAction(){
		if (isset($_POST['id']) and $_POST['id'] == 0){
			$guides = new guides();
			$id_guide = intval($_POST['id_guide']);
			$name_guide_category = stripslashes($_POST['name_guide_category']);
			$active_guide_category = ($_POST['active_guide_category'] == "on" ? 1 : 0);
			$order_guide_category = intval($_POST['order_guide_category']);

			if ($guides->insertCategory($id_guide, $name_guide_category, $active_guide_category, $order_guide_category)){ 
				$id = connection::SelectMaxReg("id_guide_category", "guides_categories", "");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guides-category?id=".$id);
		}
	}

	public static function updateCategoryAction(){
		if (isset($_POST['id']) and $_POST['id'] > 0){
			$guides = new guides();
			$id = intval($_POST['id']);
			$id_guide = intval($_POST['id_guide']);
			$name_guide_category = stripslashes($_POST['name_guide_category']);
			$active_guide_category = ($_POST['active_guide_category'] == "on" ? 1 : 0);
			$order_guide_category = intval($_POST['order_guide_category']);

			if ($guides->updateCategory($id, $id_guide, $name_guide_category, $active_guide_category, $order_guide_category)) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guides-category?id=".$id);
		}
	}

	public static function createSubCategoryAction(){
		if (isset($_POST['id']) and $_POST['id'] == 0){
			$guides = new guides();
			$id_guide_category = intval($_POST['id_guide_category']);
			$id_guide_subcategory_type = intval($_POST['id_guide_subcategory_type']);
			$desc_guide_subcategory = stripslashes($_POST['desc_guide_subcategory']);
			$active_guide_subcategory = ($_POST['active_guide_subcategory'] == "on" ? 1 : 0);
			$order_guide_subcategory = intval($_POST['order_guide_subcategory']);
			
			if ($guides->insertSubCategory($id_guide_category, $id_guide_subcategory_type, $desc_guide_subcategory, $active_guide_subcategory, $order_guide_subcategory)){ 
				$id = connection::SelectMaxReg("id_guide_subcategory", "guides_subcategories", "");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guides-subcategory?id=".$id);
		}
	}

	public static function updateSubCategoryAction(){
		if (isset($_POST['id']) and $_POST['id'] > 0){
			$guides = new guides();
			$id = intval($_POST['id']);
			$id_guide_category = intval($_POST['id_guide_category']);
			$id_guide_subcategory_type = intval($_POST['id_guide_subcategory_type']);
			$desc_guide_subcategory = stripslashes($_POST['desc_guide_subcategory']);
			$active_guide_subcategory = ($_POST['active_guide_subcategory'] == "on" ? 1 : 0);
			$order_guide_subcategory = intval($_POST['order_guide_subcategory']);

			if ($guides->updateSubCategory($id, $id_guide_category, $id_guide_subcategory_type, $desc_guide_subcategory, $active_guide_subcategory, $order_guide_subcategory)) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guides-subcategory?id=".$id);
		}
	}

	public static function createSubCategoryTypeAction(){
		if (isset($_POST['id']) and $_POST['id'] == 0){
			$guides = new guides();
			$name_guide_subcategory_type = sanitizeInput($_POST['name_guide_subcategory_type']);
			$icon_guide_subcategory_type = stripslashes($_POST['icon_guide_subcategory_type']);
			$active_guide_subcategory_type = ($_POST['active_guide_subcategory_type'] == "on" ? 1 : 0);
			$order_guide_subcategory_type = intval($_POST['order_guide_subcategory_type']);
			
			if ($guides->insertSubCategoryType($name_guide_subcategory_type, $icon_guide_subcategory_type, $active_guide_subcategory_type, $order_guide_subcategory_type)){ 
				$id = connection::SelectMaxReg("id_guide_subcategory_type", "guides_subcategories_types", "");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guides-subcategory-type?id=".$id);
		}
	}

	public static function updateSubCategoryTypeAction(){
		if (isset($_POST['id']) and $_POST['id'] > 0){
			$guides = new guides();
			$id = sanitizeInput($_POST['id']);
			$name_guide_subcategory_type = sanitizeInput($_POST['name_guide_subcategory_type']);
			$icon_guide_subcategory_type = stripslashes($_POST['icon_guide_subcategory_type']);
			$active_guide_subcategory_type = ($_POST['active_guide_subcategory_type'] == "on" ? 1 : 0);
			$order_guide_subcategory_type = intval($_POST['order_guide_subcategory_type']);

			if ($guides->updateSubCategoryType($id, $name_guide_subcategory_type, $icon_guide_subcategory_type, $active_guide_subcategory_type, $order_guide_subcategory_type)) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-guides-subcategory-type?id=".$id);
		}
	}

	public static function createSubCategoryUserAction(){
		if (isset($_POST['id_guide_users']) and $_POST['id_guide_users'] == 0){
			$guides = new guides();
			$id_guide_subcategory = sanitizeInput($_POST['id_guide_subcategory']);
			$user_guide_like= sanitizeInput($_POST['user_guide_like']);
			$user_guide_comment = sanitizeInput($_POST['user_guide_comment']);
			$result = array();

			if ($guides->insertSubCategoryUser($id_guide_subcategory, $_SESSION['user_name'], $user_guide_like, $user_guide_comment)){ 
				$id = connection::SelectMaxReg("id_guide_users", "guides_subcategories_users", "");
				$result['title'] = "";
				$result['message'] = "success";
				$result['description'] = strTranslate("Insert_procesing");
				$result['id'] = $id;
			}
			else{
				$result['title'] = "";
				$result['message'] = "error";
				$result['description'] = strTranslate("Error_procesing");
				$result['id'] = 0;
			}

			return json_encode($result);
		}
	}

	public static function updateSubCategoryUserAction(){
		if (isset($_POST['id_guide_users']) and $_POST['id_guide_users'] > 0){
			$guides = new guides();
			$id = sanitizeInput($_POST['id_guide_users']);
			$id_guide_subcategory = sanitizeInput($_POST['id_guide_subcategory']);
			$user_guide_like= sanitizeInput($_POST['user_guide_like']);
			$user_guide_comment = sanitizeInput($_POST['user_guide_comment']);
			$result = array();

			if ($guides->updateSubCategoryUser($id, $id_guide_subcategory, $_SESSION['user_name'], $user_guide_like, $user_guide_comment)){
				$result['title'] = "";
				$result['message'] = "success";
				$result['description'] = strTranslate("Update_procesing");
				$result['id'] = $id;
			} 
			else{
				$result['title'] = "";
				$result['message'] = "error";
				$result['description'] = strTranslate("Error_procesing");
				$result['id'] = $id;
			}

			return json_encode($result);
		}
	}			
}
?>