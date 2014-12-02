<?php
class mailingTemplatesController{

	public static function getListAction($reg = 0, $activo="todos", $filter=""){
		$mailing = new mailing();
		$filtro = $filter." ORDER BY template_name DESC ";
		if (isset($_GET['f']) and $_GET['f']!="") { $filtro = " AND t.id_campaign=".$_GET['f']." ".$filtro;}
		if ($activo == "activos"){ $filtro = " AND activo=1 ".$filtro;}
		if ($activo == "todos"){ $filtro = " AND activo<>2 ".$filtro;}

		$find_reg = (isset($_GET['f']) and $_GET['f']>0) ? $_GET['f'] : "";
		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("mailing_templates t ",$filtro);
		return array('items' => $mailing->getTemplates($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}	

	public static function getItemAction($id = 0){
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;		
		if ($id!=0){
			$mailing = new mailing();
			$plantilla = $mailing->getTemplates(" AND active=1 AND id_template=".$id);	
			return $plantilla[0];
		}		
	}	

	public static function exportListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$mailing = new mailing();
			$elements = $mailing->getTemplates(" AND activo=1 ORDER BY template_name DESC ");
			download_send_headers("templates_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}	
	}	

	public static function createAction(){
		if (isset($_POST['template_name']) and $_POST['template_name']!="" and $_POST['id_template']==0){
			$mailing = new mailing();
			$id_template = 0;
			$template_name = str_replace("'", "´", $_POST['template_name']);
			$template_body = str_replace("'", "´", $_POST['template_body']);
			$template_img = uploadFileToFolder($_FILES['nombre-fichero'], "images/mailing/");
			$id_type = $_POST['template_tipo'];
			$id_campaign = $_POST['template_campana'];

			if ($mailing->insertTemplate($template_name,$template_body, $template_img, $id_type, $id_campaign)) {
				session::setFlashMessage( 'actions_message', "Registro insertado correctamente.", "alert alert-success");
				$id_template = connection::SelectMaxReg("id_template","mailing_templates","");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al insertar el registro.", "alert alert-danger");
			}

			redirectURL("?page=admin-template&id=".$id_template);
		}		
	}

	public static function updateAction(){
		if (isset($_POST['template_name']) and $_POST['template_name']!="" and $_POST['id_template']>0){
			$mailing = new mailing();
			$id_template = $_POST['id_template'];
			$template_name = str_replace("'", "´", $_POST['template_name']);
			$template_body = str_replace("'", "´", $_POST['template_body']);
			$template_img = uploadFileToFolder($_FILES['nombre-fichero'], "images/mailing/");
			$id_type = $_POST['template_tipo'];
			$id_campaign = $_POST['template_campana'];

			if ($mailing->updateTemplate($id_template, $template_name, $template_body, $template_img, $id_type, $id_campaign)) {
				session::setFlashMessage( 'actions_message', "Registro modificado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar el registro.", "alert alert-danger");
			}
			
			redirectURL("?page=admin-template&id=".$id_template);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') {
			$mailing = new mailing();
			if ($mailing->deleteTemplate($_REQUEST['id'])) {
				session::setFlashMessage( 'actions_message', "Registro eliminado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al eliminar el registro.", "alert alert-danger");
			}
			redirectURL("?page=admin-templates");
		}
	}	


	public static function updateEstadoAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='dela') {
			$mailing = new mailing();
			if ($mailing->updateEstadoTemplate($_REQUEST['id'], $_REQUEST['a'])) {
				session::setFlashMessage( 'actions_message', "Registro modificado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar el registro.", "alert alert-danger");
			}
			redirectURL("?page=admin-templates");
		}
	}
}
?>