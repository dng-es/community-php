<?php
include_once(__DIR__ . "/../../mailing/templates/emailfooter.php");

class infoController{
	public static function getListAction($reg = 0, $filter=""){
		$info = new info();
		$filtro = $filter." ORDER BY titulo_info";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = $info->countReg("info i",$filtro); 
		return array('items' => $info->getInfo($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $paginator_items['find_reg'],
					'total_reg' => $total_reg);
	}

	public function getItemAction($id){
		$info = new info();
		return $info->getInfo(" AND id_info=".$id);
	}	

	public static function createAction(){
		
	}

	public static function updateAction(){

	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') {
			$info = new info();
			if ($info->deleteInfo($_REQUEST['id'],$_REQUEST['d'])) {
				session::setFlashMessage( 'actions_message', "Registro eliminado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al eliminar el registro.", "alert alert-danger");
			}
			redirectURL("?page=admin-info");
		}
	}

	public static function getZipAction(){
		if (isset($_REQUEST['exp']) and $_REQUEST['exp']!=""){
			fileToZip($_REQUEST['exp'], PATH_INFO);
		}
	}	
}
?>