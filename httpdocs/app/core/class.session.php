<?php
session_start();
session::setLanguage();
session::setChannel();
session::setDefaultTheme();

class session{

	public $user_permissions = array();
	private $user_page_permission = array();
	
	/**
	 * Valida la sesión de un usuario. Comprueba si esta correctamente logueado
	 */
	public function validateUserSession(){
		self::setUrlSession();
	
		if (isset($_POST['form-login-user'])) self::createSession(sanitizeInput($_POST['form-login-user']), sanitizeInput($_POST['form-login-password']));
		else self::ValidateSession();

		global $page, $paginas_free;
		visitasController::insertVisita($page);
		if (in_array($page, $paginas_free) == false){
			if (!isset($_SESSION['user_name']) || trim($_SESSION['user_name']) == "") self::destroySession();
			else {
				//obtener permisos el usuario
				$this->getUserPermissions($_SESSION['user_name']);
				//verificar acceso a la pagina
				$this->setPagePermission($page, $_SESSION['user_name']);
				$user_permissions = $this->checkPageTypePermission("view", $this->user_page_permission);

				if ($this->checkPageViewPermission($page, $_SESSION['user_perfil'], $user_permissions)) {

				}
				else{
					ErrorMsg(strTranslate("Access_denied"));
					die();
				}
			}
		}
	}

	/**
	 * Get user permissions
	 * @param  string 		$username 		User to get permissions
	 * @return array 						Array con los permisos
	 */
	public function getUserPermissions($username){
		$this->user_permissions = usersController::getUserPermissions($username, "");
	}

	/**
	 * Check page permissions for one especific user
	 * @param  strin 		$pagename 		Page name to check permissions
	 * @param  string 		$username 		User name to check page permissions
	 * @return array 						Array with permissions
	 */
	public function checkPagePermission($pagename, $username){
		return array_values(array_filter($this->user_permissions, function($arrayValue) use($pagename) { return $arrayValue['pagename'] == $pagename; }));
	}

	/**
	 * Set permissions for one specific page and user
	 * @param string 		$page     		Page name to set permissions
	 * @param string 		$username 		User name to set permissions
	 */
	public function setPagePermission($page, $username){
		$this->user_page_permission = $this->checkPagePermission($page, $username);
	}

	/**
	 * Check specific permission type for user page permissions
	 * @param  string 		$permission_type 		Permissión to check: view, edit, ...
	 * @param  array 		$user_page_permission 	Specific permisions for a given user and page
	 * @return int 									Permission, if found it
	 */
	public function checkPageTypePermission($permission_type, $user_page_permission){
		foreach($user_page_permission as $permission):
			if ($permission['permission_type'] == $permission_type) return $permission;
		endforeach;
	}

	/**
	 * Verifica el acceso a una pagina especifica según el usuaio y su perfil
	 * @param  string 		$page        	Página a verificar acceso
	 * @param  string 		$user_perfil 	Perfil del usuario a verificar
	 * @return boolean 						Resultado de la comprobacion
	 */
	public function checkPageViewPermission($page, $user_perfil, $user_permissions){
		if (count($user_permissions) > 0){
			if ($user_permissions['permission_type_value'] == 1) return true;
			else return false;
		}
		else{
			//verificar permiso por perfil. Si es admin se permite todo acceso
			if ($user_perfil == 'admin') return true;
			else{
				if (strpos($page, 'admin') === 0) return false;
				elseif (strpos($page, 'supervisor') === 0 && $user_perfil === 'supervisor') return true;
				elseif (strpos($page, 'supervisor') === 0 && $user_perfil !== 'supervisor') return false;
				else return true;
			}
		}
	}

	/**
	* Return current URL.
	* @return 	string 		Current URL
	*/
	public static function curPageURL(){
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") $pageURL .= "s";
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80")  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		else $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		return $pageURL;
	}

	/**
	* Check if user is currently logged, if so redirects to the correct page, if not redirects to login. 
	* If no page is specified, redirects to home page.
	*/
	public static function ValidateSession(){
		global $paginas_free;
		if ((isset($_SESSION['user_logged']) && $_SESSION['user_logged'] != true) && in_array($_REQUEST['page'], $paginas_free) == false){
			//Si alguno de los datos ingresados son incorrectos redirigimos a la pÃ¡gina de
			//error o de nuevo al formulario de ingreso.
			header ("Location: " . APP_DEF_PAGE);
			exit();
		}
		elseif( (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == true) && (!isset($_REQUEST['page']) || (isset($_REQUEST['page']) && $_REQUEST['page'] == ""))){
			header ("Location: home");
			exit();
		}
		else {
			//SI HAN PASADO 15 MINUTOS DE INACTIVIDAD SE CIERRA LA SESION (60*15=900)
			if ( (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == true) && (time()-$_SESSION["session_time"] > SESSION_MAXTIME)) self::destroySession();
			else {
				$_SESSION["session_time"] = time();
				if (isset($_SESSION['user_name']) && in_array($_REQUEST['page'], $paginas_free) == false){
					$users = new users();
					$users->deleteUserConn($_SESSION['user_name']);
					$users->insertUserConn($_SESSION['user_name'],$_SESSION['user_canal']);
				}
			}
		}
	}

	/**
	* Check if user is logged in Ajax pages. If not redirects to login page
	* @param 	string 		$url 			redirect url if user is not logged	
	*/
	public static function ValidateSessionAjax($url = "login"){
		if (!isset($_SESSION['user_logged']) || $_SESSION['user_logged'] != true){
			header ("Location: ".$url);
			exit();
		}
	}

	/**
	* Verify user data sent from login form
	* @param 	string 		$Login_user 	Username POST sent
	* @param 	string 		$Login_pass 	Password POST sent
	* @param 	string 		$url_confirm 	Destination page when login confirm
	*/
	public static function createSession($Login_user, $Login_pass, $url_confirm = "user-confirm"){
		$users = new users();
		$result_user = $users->getUsers(" AND username ='".$Login_user."'  
										AND user_password COLLATE utf8_bin ='".$Login_pass."' 
										AND disabled=0 ");

		if (count($result_user) == 1){
			$_SESSION['user_name'] = $Login_user;
			$_SESSION['user_logged'] = false;
			$_SESSION['id_externo'] = $result_user[0]['id_externo'];
			if ($result_user[0]['confirmed'] == 1 && $result_user[0]['registered'] == 1){
				//Si ambos datos son correctos guardamos estos datos en la session.
				self::setTheme($result_user[0]['canal']);
				$_SESSION["session_time"] = time();
				$_SESSION['user_logged'] = true;
				$_SESSION['user_name'] = $result_user[0]['username'];
				$_SESSION['name'] = $result_user[0]['name'];
				$_SESSION['surname'] = $result_user[0]['surname'];
				$_SESSION['user_pass'] = $result_user[0]['user_password'];
				$_SESSION['user_nick'] = $result_user[0]['nick'];
				$_SESSION['user_email'] = $result_user[0]['email'];
				$_SESSION['user_canal'] = $result_user[0]['canal'];
				$_SESSION['user_empresa'] = $result_user[0]['empresa'];
				$_SESSION['user_puntos'] = $result_user[0]['puntos'];
				$_SESSION['user_canal_nombre'] = "";
				$_SESSION['user_perfil'] = $result_user[0]['perfil'];
				$_SESSION['user_mail'] = $result_user[0]['email'];
				$user_foto = ($result_user[0]['foto'] == '' ? "themes/".$_SESSION['user_theme']."/images/".DEFAULT_IMG_PROFILE : PATH_USERS_FOTO.$result_user[0]['foto']);
				$_SESSION['user_foto'] = $user_foto;
				$_SESSION['user_canal_nombre'] = ($result_user[0]['canal'] == 'admin') ? "Administración" : ucfirst($result_user[0]['canal']);
				$_SESSION['language'] = $result_user[0]['user_lan'];
				//por defecto se mostraran los puntos. En loader.php se tomará el valor de configuración
				$_SESSION['show_user_points'] = true;


				//crear estadistica de acceso
				visitasController::insertVisita("Inicio sesion");
				$users->updateLastAccess($_SESSION['user_name']);
			}
			elseif ($result_user[0]['confirmed'] == 0 && $result_user[0]['registered'] == 0){
				//Redirijimos a la pagina de confirmacion de datos.
				header ("Location: ".$url_confirm);
				exit();
			}
		}
		else session::setFlashMessage( 'actions_message', "Usuario o contraseña incorrecta", "alert alert-warning");
	}

	/**
	 * Set session variable url_request
	 */
	public static function setUrlSession(){
		global $paginas_free;
		if(!session_id()) session_start();
		if (isset($_REQUEST['page'])){
			if (in_array($_REQUEST['page'], $paginas_free) == false) $_SESSION['url_request'] = self::curPageURL();
		}
	}

	/**
	* Destroy users session and redirects to $url page.
	* @param 	string 	$url 		redirect url after session is destroyed
	*
	*/
	public static function destroySession($url = APP_DEF_PAGE){
		$users = new users();
		if (isset($_SESSION['user_name'])){
			$users->deleteUserConn($_SESSION['user_name']);
			visitas::updateVisitaSeconds($_SESSION['user_name']);
		}

		session_unset();
		session_destroy();
		self::setUrlSession();
		header ("Location: ".$url);
		die();
	}
	
	/**
	* Function to create flash messages
	* @access public
	* @param 	string 	$name 		session message name
	* @param 	string 	$message 	message
	* @param 	string 	$class 		display class
	* @return 	string 	message
	*/
	public static function setFlashMessage($name = '', $message = '', $class = 'alert alert-danger', $title = "" ){
		//We can only do something if the name isn't empty
		if(!empty( $name)){
			//No message, create it
			if(!empty($message) && empty( $_SESSION[$name])){
				if(!empty($_SESSION[$name])) unset($_SESSION[$name]);
				if(!empty($_SESSION[$name.'_class'])) unset($_SESSION[$name.'_class']);
				if(!empty($_SESSION[$name.'_title'])) unset($_SESSION[$name.'_title']);

				$_SESSION[$name] = $message;
				$_SESSION[$name.'_class'] = $class;
				$_SESSION[$name.'_title'] = $title;
			}
		}
	}

	/**
	* get flash message.
	* @param 	string 	$name 		session message to be getted
	*/
	public static function getFlashMessage($name){
		if (isset($_SESSION[$name])){
			$class = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
			if ($class == 'success') $title_default = "Muy bien!";
			elseif ($class == 'warning') $title_default = "Cuidado...";
			elseif ($class == 'info') $title_default = "Info";
			elseif ($class == 'danger') $title_default = "Error";
			$title = !empty( $_SESSION[$name.'_title'] ) ? $_SESSION[$name.'_title'] : $title_default;
			echo '<div class="msg-flash '.$class.'" data-title="'.$title.'">'.$_SESSION[$name].'</div>';
			unset($_SESSION[$name]);
			unset($_SESSION[$name.'_class']);
			unset($_SESSION[$name.'_title']);
		}
	}

	/**
	* Verify if user is allowed to visit current page by user level access
	* @param 	array	$perfiles_autorizados 	Authorized users
	*/
	public static function AccessLevel($perfiles_autorizados){
		if (in_array($_SESSION['user_perfil'], $perfiles_autorizados) == false && $_SESSION['user_perfil'] != 'admin'){
			ErrorMsg(strTranslate("Access_denied"));
			die();
		}
	}

	/**
	* Set user language
	*/
	public static function setLanguage(){
		global $ini_conf;
		if (isset($_REQUEST['lan']) && $_REQUEST['lan'] != "") $_SESSION['language'] = $_REQUEST['lan'];
		if (!isset($_SESSION['language'])) $_SESSION['language'] = $ini_conf['language'];
		include(dirname(__FILE__)."/../languages/".(isset($_SESSION['language']) ? $_SESSION['language'] : $ini_conf['language'])."/options.php");
		setlocale(LC_ALL, $LANGUAGE_LOCALE);
		date_default_timezone_set($LANGUAGE_TIMEZONE);
	}

	/**
	* Set user channel
	*/
	public static function setChannel(){
		if (isset($_POST['chooseFormValue']) && $_POST['chooseFormValue'] != "") {
			$_SESSION['user_canal'] = sanitizeInput($_POST['chooseFormValue']);
			self::setTheme(sanitizeInput($_POST['chooseFormValue']));
		}
	}

	/**
	* Set user default channel
	*/
	public static function setDefaultTheme(){
		if (!isset($_SESSION['user_theme']) || $_SESSION['user_theme'] == "") $_SESSION['user_theme'] = DEFAULT_THEME;
	}

	/**
	* Set user theme
	*/
	public static function setTheme($channel){
		$channels = usersCanalesController::getListAction(1, " AND canal='".$channel."' ");
		$_SESSION['user_theme'] = ((isset($channels['items'][0]['theme']) && is_file("themes/".$channels['items'][0]['theme']."/css/styles.css")) ? $channels['items'][0]['theme'] : "default");
	}
}
?>