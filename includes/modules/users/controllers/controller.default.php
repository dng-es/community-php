<?php
class usersController{

	public static function getItemAction(){
		if (isset($_GET['act']) and $_GET['act']=='edit'){ 
			$users = new users();
	  		return $users->getUsers(" AND username='".$_GET['id']."'");
  		}
	}

	public static function getListAction($reg = 0){
		$users = new users();
		$filtro = "";
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro = " AND username LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro = " AND username LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " ORDER BY username";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = $users->countReg("users",$filtro); 
		return array('items' => $users->getUsers($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$users = new users();
			$elements = $users->getUsers("");
			exportCsv($elements, "usuarios");
		}  		
	}	

	public static function exportStatisticsAction(){
		if (isset($_REQUEST['export_s']) and $_REQUEST['export_s']==true) {
			$users = new users();
			$elements = $users->getUsers("");
			$usuarios = array();
			foreach($elements as $element):
				$usuario = array("usuario" => $element['username']);
				$usuario = array_merge($usuario, self::userStatistics($element['username']));
				array_push($usuarios, $usuario);
			endforeach;
			exportCsv($usuarios, "estadisticas");
		}  		
	}

	public static function createAction(){
		
	}

	public static function updateAction(){

	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') {
			$users = new users();
			if ($users->disableUser($_REQUEST['id'])) {
				session::setFlashMessage( 'actions_message', "Usuario deshabilitado correctamente.", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al deshabilitar usuario.", "alert alert-danger");
			}
			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = (isset($_REQUEST['f']) ? $_REQUEST['f'] : "");
			redirectURL("?page=users&pag=".$pag."&f=".$find_reg);
		}
	}

	public static function getPerfilAction(){
		if ($_SESSION['user_name']!=""){
			$users = new users();
			$plantilla = $users->getUsers(" AND username='".$_SESSION['user_name']."' ");
			$user_foto = PATH_USERS_FOTO.($plantilla[0]['foto']=="" ? "user.jpg" : $plantilla[0]['foto']);
			$plantilla[0]["user_foto"] = $user_foto;
			return $plantilla[0];	
		}	
	}	

	public static function updatePerfilAction(){
		$users = new users();
		if (isset($_POST['user-username']) and $_POST['user-username']!=""){
			$confirmar=$users->perfilUser($_POST['user-username'],
										   $_POST['user-nick'],
										   $_POST['user-nombre'],
										   $_POST['user-apellidos'],
										   $_POST['user-pass'],
										   $_POST['user-email'],
										   $_FILES['nombre-fichero'],
										   $_POST['user-comentarios'],
										   $_POST['user-date']);
			if ($confirmar == 1){
				session::setFlashMessage( 'actions_message', "Tus datos se han modificado correctamente.", "alert alert-success");
			}
			elseif ($confirmar == 2) {
				session::setFlashMessage( 'actions_message', "Se ha producido algun error al modificar tus datos.", "alert alert-danger");
			}
			elseif ($confirmar == 3) {
				session::setFlashMessage( 'actions_message', "El Alias <b>".$_POST['user-nick']."</b> ya existe.", "alert alert-danger");
			}
			redirectURL("?page=user-perfil");	
		}
	}	

	public static function getUserStatistics(){
		if (isset($_GET['act']) and $_GET['act']=='edit'){ 
			return self::userStatistics($_GET['id']);
		}
	}		

	/**
	 * Estadisticas de uso de la comunidad de un usuario. Utilizada en ficha de usuario y exportar (exportStatisticsAction())
	 * @param  	string 		$username 		Usuario del que se desean obtener estadísticas
	 * @return 	array           			Array con datos
	 */	
	public static function userStatistics($username){
		$array_final = array();
		$usuario = users::getUsers(" AND username='".$username."' ");
		$last_access = ($usuario[0]['last_access']!= null ? strftime(DATE_TIME_FORMAT,strtotime($usuario[0]['last_access'])) : "sin accesos");
		$array_final = array_merge($array_final, array("Último acceso" => $last_access));
		$modules = getListModules();		
		foreach($modules as $module):
			$moduleClass = $module['folder']."Controller";
			$instance = new $moduleClass();
			if (method_exists($instance, "userModuleStatistis")) {
		        $array_final = array_merge($array_final, $instance->userModuleStatistis($username));
		    }
		endforeach;
		return $array_final;
	}

}
?>