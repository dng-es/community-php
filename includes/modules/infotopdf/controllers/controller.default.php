<?php
include_once(__DIR__ . "/../../mailing/templates/emailfooter.php");

class infotopdfController{
	public static function getItem(){
		if (isset($_GET['id'])){
			$info = new infotopdf();
			return $elements=self::getItemAction($_GET['id']);
		}
	}

	public static function getListAction($reg = 0, $filter = ""){
		$info = new infotopdf();
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
		$info = new infotopdf();
		return $info->getInfo(" AND id_info=".$id);
	}	

	public static function createAction(){
		
	}

	public static function updateAction(){

	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') {
			$info = new infotopdf();
			if ($info->deleteInfo($_REQUEST['id'],$_REQUEST['d'])) {
				session::setFlashMessage( 'actions_message', "Registro eliminado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al eliminar el registro.", "alert alert-danger");
			}
			redirectURL("?page=admin-info");
		}
	}

	public function getHTMLtoPDF(){
		if (isset($_REQUEST['idp']) and $_REQUEST['idp']>0){
			$info = new infotopdf();
			global $ini_conf;
			$html_content = $info->getInfo(" AND id_info=".$_REQUEST['idp']);
			$content = '<img src="'.$ini_conf['SiteUrl'].'/docs/info/'.$html_content[0]['file_info'].'" />';
			$content .= footerMail($_SESSION['user_name']);
			HTMLtoPDF($content, $html_content[0]['tipo']);
		}
	    
	}	
}
?>