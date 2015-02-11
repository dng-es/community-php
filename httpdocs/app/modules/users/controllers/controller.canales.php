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
		
		$total_reg = connection::countReg("canales",$filtro); 
		return array('items' => $users->getCanales($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id = 0){
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';		
		if ($id!=''){
			$users = new users();
			$canal = $users->getCanales(" AND canal='".$id."' ");	
			return $canal[0];
		}		
	}	

	public static function exportListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$users = new users();
			$elements=$users->getCanales("");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}	

	public static function createAction(){
		if (isset($_POST['id_canal']) and $_POST['id_canal']==''){
			$canal = sanitizeInput($_POST['canal']);
			$canal = str_replace(" ","_",$canal);
			$canal = NormalizeText($canal);
			$canal_name = sanitizeInput($_POST['canal_name']);
			$users = new users;
			if ($users->insertCanal($canal,$canal_name)){
				//crear foro asociado
				$foro = new foro();
				$foro->InsertTema(0, "Foro ".$canal_name, '', '', 'admin', $canal, 0, 1, '', 0, 0, "");
				session::setFlashMessage( 'actions_message', "Canal creado correctamente.", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al crear canal.", "alert alert-danger");
			}
			redirectURL("?page=admin-canal&id=".$canal);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id_canal']) and $_POST['id_canal']!=''){
			$canal = sanitizeInput($_POST['id_canal']);
			$canal_name = sanitizeInput($_POST['canal_name']);
			$users = new users;
			if ($users->updateCanal($canal,$canal_name)){
				session::setFlashMessage( 'actions_message', "Canal modificado correctamente.", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar canal.", "alert alert-danger");
			}
			redirectURL("?page=admin-canal&id=".$canal);
		}	
	}		
}
?>