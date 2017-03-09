<?php
class usersCanalesController{
	public static function getListAction($reg = 0, $filtro = ""){
		$users = new users();
		$find_reg = "";
		if (isset($_POST['find_reg']) or isset($_REQUEST['f'])) {
				$filtro = " AND canal_name LIKE '%".$_POST['find_reg']."%' ";
				$find_reg = (isset($_POST['find_reg']) ? $_POST['find_reg'] : $_REQUEST['f']);
		}
		$filtro .= " ORDER BY canal";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("canales", $filtro); 
		return array('items' => $users->getCanales($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id = 0){
		$id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : $id);
		if ($id!=''){
			$users = new users();
			$canal = $users->getCanales(" AND canal='".$id."' ");
			return $canal[0];
		}
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$users = new users();
			$elements = $users->getCanales("");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function createAction(){
		if (isset($_POST['id_canal']) && $_POST['id_canal'] == ''){
			$canal = sanitizeInput($_POST['canal']);
			$canal = str_replace(" ", "_", $canal);
			$canal = NormalizeText($canal);
			$canal_name = sanitizeInput($_POST['canal_name']);
			$canal_lan = sanitizeInput($_POST['canal_lan']);
			$theme = sanitizeInput($_POST['theme']);
			$users = new users;
			if ($users->insertCanal($canal, $canal_name, $theme, $canal_lan)){
				//crear foro asociado
				$foro = new foro();
				$foro->InsertTema(0, "Foro ".$canal_name, '', '', 'admin', $canal, 0, 1, '', 0, 0, "");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-canal?id=".$canal);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id_canal']) && $_POST['id_canal'] != ''){
			$canal = sanitizeInput($_POST['id_canal']);
			$canal_name = sanitizeInput($_POST['canal_name']);
			$canal_lan = sanitizeInput($_POST['canal_lan']);
			$theme = sanitizeInput($_POST['theme']);
			$users = new users;
			if ($users->updateCanal($canal, $canal_name, $theme, $canal_lan))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-canal?id=".$canal);
		}
	}

	public static function getCanalesAction($filter = ""){
		$users = new users();
		$elements = $users->getCanales($filter." ORDER BY canal"); 
		$string_format = "";
		foreach ($elements as $element):
			$string_format .= (trim($element['canal']) == "" ? '<span class="label label-danger" title="Hay usuarios sin canal. Esto es potencialmente peligroso.">Hay usuarios sin canal</span> ' : ($element['canal'] != 'admin' ? '<span class="label label-warning">'.$element['canal']."</span> " : ""));
		endforeach;
		return $string_format;
	}
}
?>