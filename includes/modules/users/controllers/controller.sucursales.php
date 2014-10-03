<?php
class usersSucursalesController{

	public static function getListAction($reg = 0, $username){
		$users = new users();
		$filtro = " ORDER BY name_sucursal DESC ";
		$filtro = (($username!="") ? " AND user_sucursal='".$username."' " : "") . $filtro;
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);	
		//$filtro = $filtro.' LIMIT '.$paginator_items['inicio'].','.$reg;
		$total_reg = connection::countReg("users_sucursales",$filtro); 
		return array('items' => $users->getUsersSucursales($filtro),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id = 0){
		$id_template = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;		
		$sucursal_name = isset($_POST['template_name']) ? $_POST['template_name'] : "";
		$template_body = isset($_POST['template_body']) ? $_POST['template_body'] : "";
		if ($id_template!=0){
			$mailing = new mailing();
			$plantilla= $mailing->getTemplates(" AND id_template=".$id_template);	
			$template_name = $plantilla[0]['template_name'];
			$template_body = $plantilla[0]['template_body'];
			$template_mini = $plantilla[0]['template_mini'];
			$id_type = $plantilla[0]['id_type'];
			$id_campaign = $plantilla[0]['id_campaign'];
			$campana = $plantilla[0]['campana'];
			$tipo = $plantilla[0]['tipo'];
		}
		return array('id_template' => $id_template,
					 'template_name' => $template_name,
					 'template_body' => $template_body,
					 'template_mini' => $template_mini,
					 'id_type' => $id_type,
					 'id_campaign' => $id_campaign,
					 'campana' => $campana,
					 'tipo' => $tipo);		
	}

	public static function createAction(){
		if (isset($_POST['sucursal_name']) and $_POST['sucursal_name']!="" and $_POST['sucursal_name']==0){
			$users = new users();
			$id = 0;
			$sucursal_name = str_replace("'", "´", $_POST['sucursal_name']);
			$sucursal_direccion = str_replace("'", "´", $_POST['sucursal_direccion']);


			if ($users->insertUsersSucursales($sucursal_name,$sucursal_direccion)) {
				session::setFlashMessage( 'actions_message', "Registro insertado correctamente.", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al insertar el registro.", "alert alert-danger");
			}
			redirectURL("?page=user-perfil&t=2");
		}		
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') {
			$users = new users();
			if ($users->deteleUsersSucursales($_REQUEST['id'], " AND user_sucursal='".$_SESSION['user_name']."' ")) {
				session::setFlashMessage( 'actions_message', "Registro eliminado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al eliminar el registro.", "alert alert-danger");
			}
			redirectURL("?page=user-perfil&t=2");
		}
	}		
}
?>