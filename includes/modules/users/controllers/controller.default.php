<?php
class usersController{

	public static function getItemAction(){
		if (isset($_GET['id']) and $_GET['id']!=''){ 
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
		
		$total_reg = connection::countReg("users",$filtro); 
		return array('items' => $users->getUsers($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getPerfilesAction($filter = ""){
		$users = new users();	
		$elements = $users->getPerfiles($filter." ORDER BY perfil"); 
		$string_format = "";
		foreach ($elements as $element):
			$string_format.= (trim($element['perfil'])!="" ? $element['perfil']." " : '<span class="label label-danger" title="Hay usuarios sin perfil. Esto es potencialmente peligroso.">Hay usuarios sin perfil</span> ');
		endforeach;
		return $string_format;
	}

	public static function getCanalesAction($filter = ""){
		$users = new users();	
		$elements = $users->getCanales($filter." ORDER BY canal"); 
		$string_format = "";
		foreach ($elements as $element):
			$string_format.= (trim($element['canal'])=="" ? '<span class="label label-danger" title="Hay usuarios sin canal. Esto es potencialmente peligroso.">Hay usuarios sin canal</span> ' : ($element['canal']!='admin' ? $element['canal']." " : ""));
		endforeach;
		return $string_format;
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

	public static function getPerfilAction($username, $filter=""){
		if ( $username != "" ){
			$users = new users();
			$plantilla = $users->getUsers(" AND username='".$username."' ".$filter);
			$user_foto = PATH_USERS_FOTO.($plantilla[0]['foto']=="" ? "user.jpg" : $plantilla[0]['foto']);
			$plantilla[0]["user_foto"] = $user_foto;
			return $plantilla[0];	
		}	
	}

	public static function getPublicPerfilAction($nick, $filter=""){
		if ( $nick != "" ){
			$users = new users();
			$plantilla = $users->getUsers(" AND nick='".$nick."' ".$filter);
			if (count($plantilla)>0){
				$user_foto = PATH_USERS_FOTO.($plantilla[0]['foto']=="" ? "user.jpg" : $plantilla[0]['foto']);
				$plantilla[0]["user_foto"] = $user_foto;
				return $plantilla[0];
			}		
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
		if (isset($_GET['id']) and $_GET['id']!=''){ 
			return self::userStatistics($_GET['id']);
		}
	}		

	/**
	 * Estadisticas de uso de la comunidad de un usuario. Utilizada en ficha de usuario y exportar (exportStatisticsAction())
	 * @param  	string 		$username 		Usuario del que se desean obtener estadísticas
	 * @return 	array           			Array con datos
	 */	
	public static function userStatistics($username){
		$users = new users();
		$array_final = array();
		$usuario = $users->getUsers(" AND username='".$username."' ");
		$last_access = ($usuario[0]['last_access']!= null ? getDateFormat($usuario[0]['last_access'], "DATE_TIME") : "sin accesos");
		$array_final = array_merge($array_final, array(strTranslate("Last_access") => $last_access));
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

	public static function recoverPasswordAction(){
		if (isset($_POST['form-lostpw-user'])){
			$users = new users();
			$user = $users->getUsers(" AND username='".$_POST['form-lostpw-user']."'");

			if ($user[0]['user_password'] <> ''){
				$asunto = strtoupper($ini_conf['SiteName']).': '.strTranslate("Recover_credentials");
				$cuerpo_mensaje = strTranslate("Your_details_access").' '.$ini_conf['SiteName'].':
				'.strTranslate("Username").': '.$_POST['form-lostpw-user'].'
				'.strTranslate("Password").': '.$user[0]['user_password'];	

				if (SendEmail($ini_conf['ContactEmail'],$user[0]['email'],$asunto,$cuerpo_mensaje,0)) {
					session::setFlashMessage( 'actions_message', strTranslate("Recover_password_alert"), "alert alert-success");
				}
				else { session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");}
			}
			else { session::setFlashMessage( 'actions_message', strTranslate("User_not_valid"), "alert alert-danger");}
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function loginRedirectAction(){
		if (isset($_SESSION['user_logged']) and $_SESSION['user_logged']) {		
			if (isset($_SESSION['url_request']) and $_SESSION['url_request']!=""){
				redirectURL($_SESSION['url_request']);
			}
			else{
				redirectURL("?page=home");
			}		
		}
	}

	public static function insertUserAction(){
		if (isset($_POST['id_username']) and $_POST['id_username']==""){
			$users = new users();
			//VERIFICAR NOMBRE USUARIO YA EXISTE
			if (count($users->getUsers(" AND username='".$_POST['username']."' "))==0){
				$confirmed = ($_POST['confirmed_user']=="on" ? 1 : 0);
				$registered = ($_POST['registered_user']=="on" ? 1 : 0);
				$disabled = ($_POST['disabled_user']=="on" ? 1 : 0);
				if ($users->insertUser($_POST['username'],
							$_POST['user_password'],
							$_POST['email_user'],
							$_POST['name_user'],
							$confirmed,
							$disabled,
							$_POST['empresa_user'],
							$_POST['canal_user'],
							$_POST['perfil_user'],
							$_POST['telefono_user'],
							$_POST['surname'],
							$registered
							)) {
					session::setFlashMessage( 'actions_message', "Usuario insertado correctamente.", "alert alert-success");
					redirectURL("?page=user&id=".$_POST['username']);
				}
			}
			else { 
				session::setFlashMessage( 'actions_message', "El usuario ya existe.", "alert alert-warning");
				redirectURL("?page=user");
			}		
		}
	}

	public static function updateUserAction(){
		if (isset($_POST['id_username']) and $_POST['id_username']!=""){
			$users = new users();
			$confirmed = (isset($_POST['confirmed_user']) and $_POST['confirmed_user']=="on") ? 1 : 0;
			$registered = (isset($_POST['registered_user']) and $_POST['registered_user']=="on") ? 1 : 0;
			$disabled = (isset($_POST['disabled_user']) and $_POST['disabled_user']=="on") ? 1 : 0;

			if ($users->updateUser($_POST['id_username'],
								$_POST['user_password'],
								$_POST['email_user'],
								$_POST['name_user'],
								$confirmed,
								$disabled,
								$_POST['empresa_user'],
								$_POST['canal_user'],
								$_POST['perfil_user'],
								$_POST['telefono_user'],
								$_POST['surname'],
								$registered)) {
						session::setFlashMessage( 'actions_message', "Usuario modificado correctamente.", "alert alert-success");}
			else { 
				session::setFlashMessage( 'actions_message', "Se ha producido algun error durante la modificacion de los datos.", "alert alert-danger");}

			redirectURL("?page=user&id=".$_POST['id_username']);
		}
	}	

	public static function deleteFotoAction(){
		$users = new users();
		if (isset($_REQUEST['f']) and $_REQUEST['f']!=""){
			if ($users->deleteFoto($_REQUEST['id'],$_REQUEST['f'])) { 
				session::setFlashMessage( 'actions_message', "foto borrada correctamente.", "alert alert-success");}
			else { 
				session::setFlashMessage( 'actions_message', "No se ha podido eliminar la foto.", "alert alert-danger");}
			redirectURL("?page=user&id=".$_REQUEST['id']);
		}
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		return array( array("LabelHeader" => 'Tools',
							"LabelSection" => strTranslate("Users"),
							"LabelItem" => strTranslate("Users_list"),
							"LabelUrl" => 'users',
							"LabelPos" => 1),
					  array("LabelHeader" => 'Tools',
							"LabelSection" => strTranslate("Users"),
							"LabelItem" => strTranslate("Users_import"),
							"LabelUrl" => 'cargas-users',
							"LabelPos" => 2),
					  array("LabelHeader" => 'Tools',
							"LabelSection"=> strTranslate("Users"),
							"LabelItem"=> 'Asignación de puntos',
							"LabelUrl"=> 'admin-puntos',
							"LabelPos" => 3),
					  array("LabelHeader"=> 'Tools',
							"LabelSection"=> strTranslate("Users"),
							"LabelItem"=> strTranslate("Users_groups_list"),
							"LabelUrl"=> 'users-tiendas',
							"LabelPos" => 4),
					  array("LabelHeader"=> 'Tools',
							"LabelSection"=> strTranslate("Reports"),
							"LabelItem" => ucfirst(strTranslate("APP_points")),
							"LabelUrl" => 'informe-puntuaciones',
							"LabelPos" => 2),
					  array("LabelHeader" => 'Tools',
							"LabelSection" => strTranslate("Reports"),
							"LabelItem" => ucfirst(strTranslate("APP_shares")),
							"LabelUrl" => 'informe-participaciones',
							"LabelPos" => 3));	
	}	

}
?>