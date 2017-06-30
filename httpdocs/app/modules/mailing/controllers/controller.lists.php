<?php
class mailingListsController{

	public static function getListAction($reg = 0, $usuario = ""){
		$mailing = new mailing();
		$find_reg = getFindReg();
		$filter = " AND activo=1 ORDER BY name_list ASC ";
		if ($usuario != "") $filter = " AND user_list='".$usuario."' ".$filter;

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("mailing_lists",$filter);
		return array('items' => $mailing->getLists($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id = 0){
		$id_list = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		$name_list = sanitizeInput(isset($_POST['name_list']) ? $_POST['name_list'] : "");
		$date_list = sanitizeInput(isset($_POST['date_list']) ? $_POST['date_list'] : "");
		if ($id_list!=0){
			$mailing = new mailing();
			$lista= $mailing->getLists(" AND id_list=".$id_list);	
			$name_list = $lista[0]['name_list'];
			$date_list = $lista[0]['date_list'];
		}
		return array('id_list' => $id_list,
					 'name_list' => $name_list,
					 'date_list' => $date_list);
	}

	public static function exportListAction($filter = ""){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$mailing = new mailing();
			$elements = $mailing->getLists($filter." AND activo=1 ORDER BY name_list DESC ");
			download_send_headers("listas_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function exportUserListAction($filter = ""){
		if (isset($_REQUEST['exportm']) && $_REQUEST['exportm'] == true){
			$mailing = new mailing();
			$elements = $mailing->getListsUsers($filter." AND id_list=".intval($_REQUEST['id']));
			download_send_headers("emails_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function createAction(){
		if (isset($_POST['name_list']) && $_POST['name_list'] != "" && $_POST['id_list'] == 0){
			$mailing = new mailing();
			$id_list = 0;
			$name = sanitizeInput($_POST['name_list']);
			$usuario = $_SESSION['user_name'];
			if ($mailing->insertList($name, $usuario)) {
				session::setFlashMessage( 'actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				$id_list = connection::SelectMaxReg("id_list", "mailing_lists", "");

				//agregar usuarios
				self::importAction($id_list);
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("user-list?act=editid=".$id_list);
		}
	}

	public static function updateAction(){
		if (isset($_POST['name_list']) && $_POST['name_list'] != "" && $_POST['id_list'] > 0){
			$mailing = new mailing();
			$id_list = intval($_POST['id_list']);
			$name_list = sanitizeInput($_POST['name_list']);

			if ($mailing->updateList($id_list, $name_list)) {
				//agregar usuarios
				self::importAction($id_list);
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("user-list?id=".$id_list);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$mailing = new mailing();
			if ($mailing->deleteList(intval($_REQUEST['id'])))
				session::setFlashMessage( 'actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else 
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("user-lists");
		}
	}

	private static function importAction($id_list){
		if (isset($_FILES['nombre-fichero']['name']) && $_FILES['nombre-fichero']['name'] != ""){
			$nombre_archivo = uploadFileToFolder($_FILES['nombre-fichero'], "docs/cargas/");

			require_once 'docs/reader.php';
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read('docs/cargas/'.$nombre_archivo);
			self::volcarListaMySQL($data, $id_list);
		}
	}

	private function volcarListaMySQL($data, $id_list){
		$mailing = new mailing();
		$mailing->deleteListsUsers($id_list, "");

		require_once 'docs/reader.php';
		$excelll = new Spreadsheet_Excel_Reader();

		for($fila = 2; $fila <= $data->sheets[0]['numRows']; $fila += 1){
			$username = trim(strtolower($data->sheets[0]['cells'][$fila][1]));
			$userdate = trim($data->sheets[0]['cells'][$fila][2]);
			//if ($excelll->isDate($userdate)==false){$userdate="";}
			//else{$userdate = $excelll->createDate($userdate);}

			//$userdate = $excelll->createDate($userdate);

			//var_dump($userdate);

			//$userdate = date('Y-m-d', trim($data->sheets[0]['cells'][$fila][2]));
			//$userdate = date("M-d-Y", $userdate);	
			if (validateEmail($username)){
				$mailing->insertListsUsers($id_list,$username);
				if ($userdate != ""){
					$userdate = date("Y-m-d", strtotime($userdate));
					$mailing->insertListsUsersData($username, $userdate);
				}
			}
		}
	}
}
?>