<?php
class usersController{
	public static function getItemAction(){
		if (isset($_GET['id']) and $_GET['id'] != ''){ 
			$users = new users();
			return $users->getUsers(" AND username='".$_GET['id']."'");
		}
	}

	public static function getUserPermissions($username, $filter = ""){
		$users = new users();
  		return $users->getUsersPermisions(" AND username='".$username."' ".$filter);
	}

	public static function getListAction($reg = 0, $filtro = ""){
		$users = new users();
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro .= " AND (surname LIKE '%".$_POST['find_reg']."%' OR username LIKE '%".$_POST['find_reg']."%') ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro .= " AND (surname LIKE '%".$_REQUEST['f']."%' OR username LIKE '%".$_REQUEST['f']."%') ";$find_reg=$_REQUEST['f'];} 
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
			$string_format.= (trim($element['perfil']) != "" ? '<span class="label label-warning">'.$element['perfil']."</span> " : '<span class="label label-danger" title="Hay usuarios sin perfil. Esto es potencialmente peligroso.">Hay usuarios sin perfil</span> ');
		endforeach;
		return $string_format;
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
			$users = new users();
			$elements = $users->getUsers("");
			download_send_headers("users_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function exportStatisticsAction(){
		if (isset($_REQUEST['export_s']) and $_REQUEST['export_s'] == true){
			$users = new users();
			$elements = $users->getUsers("");
			$usuarios = array();
			foreach($elements as $element):
				$usuario = array("usuario" => $element['username']);
				$usuario = array_merge($usuario, self::userStatistics($element['username']));
				array_push($usuarios, $usuario);
			endforeach;
			download_send_headers("statistics" . date("Y-m-d") . ".csv");
			echo array2csv($usuarios);
			die();
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$users = new users();
			if ($users->disableUser($_REQUEST['id'])) {
				session::setFlashMessage('actions_message', "Usuario deshabilitado correctamente.", "alert alert-success");
			}
			else{
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = (isset($_REQUEST['f']) ? $_REQUEST['f'] : "");
			redirectURL("admin-users?pag=".$pag."&f=".$find_reg);
		}
	}

	public static function getPerfilAction($username, $filter = ""){
		if ( $username != "" ){
			$users = new users();
			$plantilla = $users->getUsers(" AND username='".$username."' ".$filter);
			$plantilla[0]["user_foto"] = self::getUserFoto($plantilla[0]['foto']);
			return $plantilla[0];	
		}
	}

	public static function getPublicPerfilAction($nick, $filter=""){
		if ( $nick != "" ){
			$users = new users();
			$plantilla = $users->getUsers(" AND nick='".$nick."' ".$filter);
			if (count($plantilla)>0){
				$plantilla[0]["user_foto"] = self::getUserFoto($plantilla[0]['foto']);
				return $plantilla[0];
			}
		}
	}

	public static function updatePerfilAction(){
		$users = new users();
		if (isset($_POST['user-username']) and $_POST['user-username'] != ""){
			
			$comentarios = trim(sanitizeInput($_POST['user-comentarios']));

			if (strlen(trim($_POST['user-pass'])) < 6) session::setFlashMessage( 'actions_message', "La contraseña tiene que tener mínimo 6 caracteres", "alert alert-danger");
			else{
				$confirmar = $users->perfilUser($_POST['user-username'],
												trim(sanitizeInput($_POST['user-nick'])),
												trim(sanitizeInput($_POST['user-nombre'])),
												trim(sanitizeInput($_POST['user-apellidos'])),
												trim(sanitizeInput(trim($_POST['user-pass']))),
												trim(sanitizeInput($_POST['user-email'])),
												$_FILES['nombre-fichero'],
												$comentarios,
												trim(sanitizeInput($_POST['user-date'])),
												trim(sanitizeInput($_POST['user_lan'])), 
												trim(sanitizeInput($_POST['direccion_user'])), 
												trim(sanitizeInput($_POST['ciudad_user'])), 
												trim(sanitizeInput($_POST['provincia_user'])), 
												trim(sanitizeInput($_POST['cpostal_user'])),
												trim(sanitizeInput($_POST['telefono'])));
				if ($confirmar == 1) {
					$_SESSION['language'] = $_POST['user_lan'];
					session::setFlashMessage('actions_message', strTranslate("Update_profile_ok"), "alert alert-success");
				}
				elseif ($confirmar == 2) 
					session::setFlashMessage('actions_message', strTranslate("Update_profile_ko"), "alert alert-danger");
				elseif ($confirmar == 3) 
					session::setFlashMessage('actions_message', $_POST['user-nick']." ".strTranslate("Update_profile_nick_ko"), "alert alert-danger");
			}
			redirectURL("profile");
		}
	}

	public static function getUserStatistics(){
		if (isset($_GET['id']) and $_GET['id'] != '') return self::userStatistics($_GET['id']);
	}

	public static function recoverPasswordAction(){
		if (isset($_POST['form-lostpw-user'])){
			global $ini_conf;
			$users = new users();
			$username = sanitizeInput($_POST['form-lostpw-user']);
			$user = $users->getUsers(" AND username='".$username."'");


			if (($user[0]['user_password'] <> '') && ($user[0]['disabled'] <> 1)){
				$asunto = strtoupper($ini_conf['SiteName']).': '.strTranslate("Recover_credentials");
				$message_from = array($ini_conf['ContactEmail'] => $ini_conf['SiteName']);
				$message_to = array($user[0]['email']);

				$template = new tpl("remember", "users");
				$template->setVars(array(
							"title_email" => strTranslate("Recover_password"),
							"text_email" => strTranslate("Your_details_access").' '.$ini_conf['SiteName'],
							"label_username" => strTranslate("Username"),
							"field_username" => $username,
							"label_userpassword" => strTranslate("Password"),
							"field_userpassword" => $user[0]['user_password']
				));

				$cuerpo_mensaje = $template->getTpl();

				//if (SendEmail($ini_conf['ContactEmail'],$user[0]['email'],$asunto,$cuerpo_mensaje,0)) {
				if (messageProcess($asunto, $message_from, $message_to , $cuerpo_mensaje, null, 'smtp')) 
					session::setFlashMessage('actions_message', strTranslate("Recover_password_alert"), "alert alert-success");
				else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			else session::setFlashMessage('actions_message', strTranslate("User_not_valid"), "alert alert-danger");
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function loginRedirectAction(){
		if (isset($_SESSION['user_logged']) and $_SESSION['user_logged']) {		
			if (isset($_SESSION['url_request']) and $_SESSION['url_request'] != "") redirectURL($_SESSION['url_request']);
			else redirectURL("home");
		}
	}

	public static function insertUserAction(){
		if (isset($_POST['id_username']) and $_POST['id_username'] == ""){
			$users = new users();
			//VERIFICAR NOMBRE USUARIO YA EXISTE
			if (count($users->getUsers(" AND username='".$_POST['username']."' ")) == 0){
				$confirmed = (isset($_POST['confirmed_user']) and $_POST['confirmed_user'] == "on") ? 1 : 0;
				$registered = (isset($_POST['registered_user']) and $_POST['registered_user'] == "on") ? 1 : 0;
				$disabled = (isset($_POST['disabled_user']) and $_POST['disabled_user'] == "on") ? 1 : 0;
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
							$registered,
							trim(sanitizeInput($_POST['direccion_user'])),
							trim(sanitizeInput($_POST['ciudad_user'])),
							trim(sanitizeInput($_POST['provincia_user'])),
							trim(sanitizeInput($_POST['cpostal_user']))
							)) {
					session::setFlashMessage('actions_message', "Usuario insertado correctamente.", "alert alert-success");
					redirectURL("admin-user?id=".$_POST['username']);
				}
			}
			else { 
				session::setFlashMessage('actions_message', "El usuario ya existe.", "alert alert-warning");
				redirectURL("admin-user");
			}
		}
	}

	public static function updateUserAction(){
		if (isset($_POST['id_username']) and $_POST['id_username'] != ""){
			$users = new users();
			$confirmed = (isset($_POST['confirmed_user']) and $_POST['confirmed_user'] == "on") ? 1 : 0;
			$registered = (isset($_POST['registered_user']) and $_POST['registered_user'] == "on") ? 1 : 0;
			$disabled = (isset($_POST['disabled_user']) and $_POST['disabled_user'] == "on") ? 1 : 0;

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
						$registered, 
						trim(sanitizeInput($_POST['direccion_user'])),
						trim(sanitizeInput($_POST['ciudad_user'])),
						trim(sanitizeInput($_POST['provincia_user'])),
						trim(sanitizeInput($_POST['cpostal_user'])))) {
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");}
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-user?id=".$_POST['id_username']);
		}
	}

	public static function deleteFotoAction(){
		$users = new users();
		if (isset($_REQUEST['f']) and $_REQUEST['f'] != ""){
			if ($users->deleteFoto($_REQUEST['id'],$_REQUEST['f'])) 
				session::setFlashMessage('actions_message', "foto borrada correctamente.", "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-user?id=".$_REQUEST['id']);
		}
	}

	public static function updatePermissionsAction(){
		if (isset($_POST['user_permission']) and $_POST['user_permission'] != ""){
			foreach(array_keys($_POST) as $permission):
				if ($permission != "user_permission"){
					//detectar permisos de editar
					if (strrpos($permission, "edit_") === 0){
						$permission_name = substr($permission, 5);
						$permission_type = "edit";
						$permission_value = $_POST[$permission];
						self::updatePermissionAction($_POST['user_permission'], $permission_name, $permission_type, $permission_value);
					}

					//detectar permisos de ver/view
					if (strrpos($permission, "view_") === 0){
						$permission_name = substr($permission, 5);
						$permission_type = "view";
						$permission_value = $_POST[$permission];
						self::updatePermissionAction($_POST['user_permission'], $permission_name, $permission_type, $permission_value);
					}
				}
			endforeach;
			session::setFlashMessage('actions_message', "Permisos actualizados.", "alert alert-success");
			redirectURL("admin-user?t=2&id=".$_POST['user_permission']);
		}
	}

	public static function updatePermissionAction($username, $permission_name, $permission_type, $permission_value){
		$users = new users();
		$users->deleteUserPermission($username, $permission_name, $permission_type);
		$users->insertUserPermission($username, $permission_name, $permission_type, $permission_value);
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
			if (file_exists(__DIR__."/../../".$module['folder']."/".$module['folder'].".php")){
				include_once (__DIR__."/../../".$module['folder']."/".$module['folder'].".php");
				$moduleClass = $module['folder']."Core";
				$instance = new $moduleClass();
				if (method_exists($instance, "userModuleStatistis")) {
					$array_final = array_merge($array_final, $instance->userModuleStatistis($username));
				}
			}
		endforeach;
		return $array_final;
	}

	public static function exportEquipoListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$users = new users();

			$filtro_tienda = ($_SESSION['user_perfil'] == 'responsable' ? " AND responsable_tienda='".$_SESSION['user_name']."' " : "");
			$filtro = " AND disabled=0 AND perfil='usuario' ".$filtro_tienda." ORDER BY empresa, username ";

			$elements = $users->getUsersListado($filtro);
			download_send_headers("users_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function insertEquipoAction(){
		if (isset($_POST['id_username']) and $_POST['id_username'] != ""){
			$users = new users();
			//VERIFICAR NOMBRE USUARIO YA EXISTE
			$old_user = $users->getUsers(" AND username='".$_POST['id_username']."' ");
			if (count($old_user) == 0){
				if ($users->insertUserEquipo(sanitizeInput($_POST['id_username']),
						sanitizeInput($_POST['empresa_user']),
						sanitizeInput($_POST['user-nombre']),
						sanitizeInput($_POST['user-apellidos']),
						sanitizeInput($_POST['user-email']),
						sanitizeInput($_POST['telefono'])
						)) {
					session::setFlashMessage( 'actions_message', "Usuario insertado correctamente.", "alert alert-success");
				}
			}
			elseif($old_user[0]['disabled'] == 1){
				//reactivar usuario
				if ($users->reactivarUserEquipo(sanitizeInput($_POST['id_username']),
						sanitizeInput($_POST['empresa_user']),
						sanitizeInput($_POST['user-nombre']),
						sanitizeInput($_POST['user-apellidos']),
						sanitizeInput($_POST['user-email']),
						sanitizeInput($_POST['telefono'])
						))
					session::setFlashMessage( 'actions_message', "Usuario reactivado correctamente", "alert alert-success");
				else
					session::setFlashMessage( 'actions_message', "Error al reactivar usuario.", "alert alert-warning");

			}
			else { 
				//aviso de usuario activo. Obtner datos del responsable de la tienda donde esta activo
				$user_responsable = $users->getUsers(" AND username='".$old_user[0]['responsable_tienda']."' ");
				$responsable_alert = (isset($user_responsable[0]) ? "Ponte en contacto son su responsable ".$user_responsable[0]['name']." ".$user_responsable[0]['surname']."(".$user_responsable[0]['email'].") para que realice la baja.": "");
				session::setFlashMessage( 'actions_message', "El usuario ya existe en la tienda ".$old_user[0]['nombre_tienda'].". ". $responsable_alert, "alert alert-warning");
			}		
			redirectURL("mygroup");
		}
	}

	public static function updateEquipoAction(){
		if (isset($_POST['id_user_edit']) and $_POST['id_user_edit'] != ""){
			$users = new users();
			$id_user_edit = sanitizeInput($_POST['id_user_edit']);
			//VERIFICAR QUE EL USUARIO PERTENECE AL RESPONSABLE
			$contador = connection::countReg("users"," AND username='".$id_user_edit."' 
													AND empresa IN (SELECT DISTINCT cod_tienda FROM users_tiendas WHERE responsable_tienda='".$_SESSION['user_name']."') ");
			
			//echo "Contador: ".$contador."<br/>";
			if ($contador > 0 or $_SESSION['user_perfil'] == 'admin' or $_SESSION['user_perfil'] == 'responsable'){
				$empresa = sanitizeInput($_POST['user_edit_empresa']);
				if ($users->updateUserEquipo($id_user_edit, $empresa)) 
					session::setFlashMessage( 'actions_message', "Usuario modificado correctamente.", "alert alert-success");
				else 
					session::setFlashMessage( 'actions_message', "Error al modificar usuario.", "alert alert-warning");
			}
			else session::setFlashMessage( 'actions_message', "Usuario no encontrado.", "alert alert-warning");

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}


	public static function deleteEquipoAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del') {
			$username = sanitizeInput($_REQUEST['id']);
			$users = new users();
			$acceso = 1;
			if ($_SESSION['user_perfil'] == 'responsable'){
				//verificar que el usuario pertenezca al usuario conectado
				$acceso = count($users->getUsers(" AND username='".$username."' AND responsable_tienda='".$_SESSION['user_name']."' "));
			}

			if ($acceso > 0){
				if ($users->disableUser($username)) session::setFlashMessage( 'actions_message', "Usuario desactivado correctamente.", "alert alert-success");
				else session::setFlashMessage( 'actions_message', "Error al dar de baja usuario.", "alert alert-danger");
			}
			else session::setFlashMessage( 'actions_message', "Usuario no encontrado.", "alert alert-danger");	
			
			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = (isset($_REQUEST['f']) ? $_REQUEST['f'] : "");
			redirectURL("mygroup?pag=".$pag."&f=".$find_reg);
		}
	}

	public static function getListEquipoAction($reg = 0, $filtro = ""){
		$users = new users();
		$find_reg = "";
		if (isset($_REQUEST['find_reg'])) {$filtro .= " AND (username LIKE '%".$_REQUEST['find_reg']."%' OR name LIKE '%".$_REQUEST['find_reg']."%') ";$find_reg=$_REQUEST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro .= " AND (username LIKE '%".$_REQUEST['f']."%' OR name LIKE '%".$_REQUEST['f']."%') ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " ORDER BY empresa, username";
		$paginator_items = PaginatorPages($reg);
		
		$Sql = "SELECT count(*) AS table_counter FROM users u  
			  LEFT JOIN users_tiendas t ON t.cod_tienda=u.empresa 
			  WHERE 1=1 ".$filtro; //echo $Sql."<br />";
		$result = connection::execute_query($Sql);
		$row = connection::get_result($result);
		$total_reg = $row['table_counter'];

		return array('items' => $users->getUsers($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}	

	/**
	 * Devuelve la foto del usuario con la url completa incluido directorio según tema
	 * @param  string $foto dato guardado en la base de datos
	 * @return string       ruta completa de la foto
	 */
	public static function getUserFoto($foto){
		return ($foto == '' ? "themes/".$_SESSION['user_theme']."/images/".DEFAULT_IMG_PROFILE : PATH_USERS_FOTO.$foto);
	}	

	/**
	 * Devuelve el filtro de tienda sobre la tabla users dependiendo del perfil del usuario
	 * @param  string $campo_filtro campo de la tabla sobre el que se quiere filtrar
	 * @return string filtro tienda en la tabla users
	 */
	public static function getTiendaFilter($campo_filtro = 'empresa'){
		if ($_SESSION['user_perfil'] == 'admin' or $_SESSION['user_perfil'] == 'visualizador'){
			$filter = "";
		}
		elseif ($_SESSION['user_perfil'] == 'regional'){
			$filter = " AND (".$campo_filtro." IN (SELECT cod_tienda FROM users_tiendas WHERE regional_tienda='".$_SESSION['user_name']."')) ";
		}
		elseif ($_SESSION['user_perfil'] == 'responsable'){
			$filter = " AND (".$campo_filtro." IN (SELECT cod_tienda FROM users_tiendas WHERE responsable_tienda='".$_SESSION['user_name']."')) ";
		}
		else{
			$filter = " AND (".$campo_filtro."='".$_SESSION['user_empresa']."') ";
		}

		return $filter;
	}		
}
?>