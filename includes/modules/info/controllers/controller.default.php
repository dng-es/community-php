<?php
include_once(__DIR__ . "/../../mailing/templates/emailfooter.php");

class infoController{
	public static function getListAction($reg = 0, $filter=""){
		$info = new info();
		$filtro = $filter." ORDER BY titulo_info";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("info i",$filtro); 
		return array('items' => $info->getInfo($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $paginator_items['find_reg'],
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id){
		$info = new info();
		return $info->getInfo(" AND id_info=".$id);
	}	

	public static function createAction(){
		if (isset($_POST['id']) and $_POST['id']==0){
			$info = new info();
			$resultado=$info->insertInfo($_FILES['info_file'],$_POST['info_title'],$_POST['info_canal'],$_POST['info_tipo'],$_POST['info_campana']);
			if ($resultado==0){
				session::setFlashMessage( 'actions_message', "Registro insertado correctamente", "alert alert-success");
				$id = connection::SelectMaxReg("id_info","info","");
				redirectURL("?page=admin-info-doc&act=edit&id=".$id);
			}
			elseif ($resultado==1){
				session::setFlashMessage( 'actions_message', "Ocurrió algún error al subir el contenido. No pudo generarse el registro.", "alert alert-danger");
				redirectURL("?page=admin-info-doc&act=new");
			}
			elseif ($resultado==2){
				session::setFlashMessage( 'actions_message', "Ocurrió algún error al subir el contenido. No pudo guardarse el archivo.", "alert alert-danger");
				redirectURL("?page=admin-info-doc&act=new");
			}
		}
	}

	public static function updateAction($id){
		if (isset($_POST['id']) and $_POST['id']>0){
			$info = new info();
			if ($info->updateInfo($id,$_FILES['info_file'],$_POST['info_title'],$_POST['info_canal'],$_POST['info_tipo'],$_POST['info_campana'])) {
				session::setFlashMessage( 'actions_message', "Registro modificado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar el registro.", "alert alert-danger");
			}
			redirectURL("?page=admin-info-doc&act=edit&id=".$id);
		}
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

	public static function adminMenu(){
		return array( array("LabelHeader" => 'Modules',
							"LabelSection" => strTranslate("Info_Documents"),
							"LabelItem" => strTranslate("Info_Documents_new"),
							"LabelUrl" => 'admin-info-doc&act=new',
							"LabelPos" => 1),
					  array("LabelHeader"=>'Modules',
							"LabelSection"=> strTranslate("Info_Documents"),
							"LabelItem"=> strTranslate("Info_Documents_list"),
							"LabelUrl"=>'admin-info',
							"LabelPos" => 2));	
	}		
}
?>