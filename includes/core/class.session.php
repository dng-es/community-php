<?php
session_start();
session::setLanguage();

class session {    
	
	public static function validateUserSession(){
		self::setUrlSession();
	
		if (isset($_POST['form-login-user'])) { self::createSession($_POST['form-login-user'],$_POST['form-login-password']);}
		else { self::ValidateSession();}

		global $page, $paginas_free;
		if (in_array($page, $paginas_free)==false){
			if (!isset($_SESSION['user_name']) or trim($_SESSION['user_name'])=="") {
				self::destroySession();
			}
			else {
				$visitas = new visitas();
				$visitas ->insertVisitas($_SESSION['user_name'],$page);  
			}
		}
	}

	/**
	* Devuelve la URL actual.
	*
	*/
	public static function curPageURL() {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) and $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} 
		else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}

	/**
	* Check if user is currently logged, if so redirects to the correct page, if not redirects to login. 
	* If no page is specified, redirects to home page.
	*
	*/
	public static function ValidateSession()
	{
		global $paginas_free;
		if ((isset($_SESSION['user_logged']) and $_SESSION['user_logged'] != true) && in_array($_REQUEST['page'], $paginas_free)==false){
			//Si alguno de los datos ingresados son incorrectos redirigimos a la pÃ¡gina de
			//error o de nuevo al formulario de ingreso.
			header ("Location: ?page=login");
		}
		elseif( (isset($_SESSION['user_logged']) and $_SESSION['user_logged'] == true) && (!isset($_REQUEST['page']) or (isset($_REQUEST['page']) and $_REQUEST['page']==""))){
			header ("Location: ?page=home");
		}
		else {
			//SI HAN PASADO 15 MINUTOS DE INACTIVIDAD SE CIERRA LA SESION (60*15=900)
			if ( (isset($_SESSION['user_logged']) and $_SESSION['user_logged'] == true) and (time()-$_SESSION["session_time"] > SESSION_MAXTIME)){ self::destroySession();}
			else {
				$_SESSION["session_time"] = time();
				if (isset($_SESSION['user_name']) && in_array($_REQUEST['page'], $paginas_free)==false){
					$users = new users();
					$users->deleteUserConn($_SESSION['user_name']);
					$users->insertUserConn($_SESSION['user_name'],$_SESSION['user_canal']);
				}
			}
		}
	}

	/**
	* Check if user is logged in Ajax pages. If not redirects to login page
	* @param 	string 	$url 		redirect url if user is not logged	
	*
	*/
	public static function ValidateSessionAjax($url="login"){
		if (!isset($_SESSION['user_logged']) or $_SESSION['user_logged'] != true){
			header ("Location: ?page=".$url);
		}
	}	

	/**
	* Verify user data sent from login form
	*
	* @param 	string 		$Login_user 	Username POST sent
	* @param 	string 		$Login_pass 	Password POST sent
	* @param 	string 		$url_confirm 	Destination page when login confirm
	*/
	public static function createSession($Login_user, $Login_pass, $url_confirm = "user-confirm"){
		$users = new users();
		$result_user=$users->getUsers(" AND username ='".$Login_user."'  
										AND user_password COLLATE utf8_bin ='".$Login_pass."' 
										AND disabled=0 ");			
																
		if (count($result_user) == 1){
			$_SESSION['user_name'] = $Login_user;
			$_SESSION['user_logged'] = false;
			if ($result_user[0]['confirmed']==1 and $result_user[0]['registered']==1){
				//Si ambos datos son correctos guardamos estos datos en la session.
				$_SESSION["session_time"] = time();
				$_SESSION['user_logged'] = true;
				$_SESSION['user_name'] = $result_user[0]['username'];
				$_SESSION['user_name'] = $result_user[0]['username'];
				$_SESSION['name'] = $result_user[0]['name'];
				$_SESSION['surname'] = $result_user[0]['surname'];
				$_SESSION['user_pass'] = $result_user[0]['user_password'];
				$_SESSION['user_nick'] = $result_user[0]['nick'];
				$_SESSION['user_email'] = $result_user[0]['email'];
				$_SESSION['user_canal'] = $result_user[0]['canal'];
				$_SESSION['user_empresa'] = $result_user[0]['empresa'];
				$_SESSION['user_canal_nombre'] = "";
				$_SESSION['user_perfil'] = $result_user[0]['perfil'];
				$_SESSION['user_mail'] = $result_user[0]['email'];
				$_SESSION['user_foto'] = ($result_user[0]['foto']!="" ? $result_user[0]['foto'] : DEFAULT_IMG_PROFILE);
				$_SESSION['user_canal_nombre'] = ($result_user[0]['canal']=='admin') ? "Administración" : ucfirst($result_user[0]['canal']);

				//crear estadistica de acceso
				$visitas = new visitas();
				$visitas ->insertVisitas($_SESSION['user_name'],"Inicio sesion");
				$users->updateLastAccess($_SESSION['user_name']);
			}
			elseif ($result_user[0]['confirmed']==0 and $result_user[0]['registered']==0) {
				//Redirijimos a la pagina de confirmacion de datos.
				header ("Location: ?page=".$url_confirm);			  
			}
		}	
	}


	public static function setUrlSession(){
		global $paginas_free;
		if(!session_id()) session_start();
		if (isset($_REQUEST['page'])){
			if (in_array($_REQUEST['page'], $paginas_free)==false){
				$_SESSION['url_request'] = self::curPageURL();
			}
		}
		//echo "SES: ".$_SESSION["url_request"];			
	}

	/**
	* Destroy users session and redirects to $url page.
	* @param 	string 	$url 		redirect url after session is destroyed
	*
	*/
	public static function destroySession( $url='login' ){
		$users = new users();
		if (isset($_SESSION['user_name'])) $users->deleteUserConn($_SESSION['user_name']);
		session_unset();
		session_destroy();		
		self::setUrlSession();
		header ("Location: ?page=".$url);
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
	public static function setFlashMessage( $name = '', $message = '', $class = 'alert alert-danger' ){
		//We can only do something if the name isn't empty
		if( !empty( $name ) ){
			//No message, create it
			if( !empty( $message ) && empty( $_SESSION[$name] ) ) {
				if( !empty( $_SESSION[$name] ) ) {
					unset( $_SESSION[$name] );
				}
				if( !empty( $_SESSION[$name.'_class'] ) ) {
					unset( $_SESSION[$name.'_class'] );
				}
				$_SESSION[$name] = $message;
				$_SESSION[$name.'_class'] = $class;
			}
		}
	}	
	/**
	* get flash message.
	*
	* @param 	string 	$name 		session message to be getted
	*/
	public static function getFlashMessage($name){
		if (isset($_SESSION[$name])){
			$class = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
			echo '<div class="msg-flash '.$class.'">'.$_SESSION[$name].'</div>';
			unset($_SESSION[$name]);
			unset($_SESSION[$name.'_class']);	
		}	
	}

	/**
	* Verify if user is allowed to visit current page by user level access
	*
	* @param 	array	$perfiles_autorizados 	Authorized users
	*/
	public static function AccessLevel($perfiles_autorizados){
		if (in_array($_SESSION['user_perfil'], $perfiles_autorizados)==false and $_SESSION['user_perfil']!='admin'){
			ErrorMsg(strTranslate("Access_denied"));
			die();
		}
	}

	/**
	* Set user language
	*
	*/
	public static function setLanguage(){
		global $ini_conf;
		if (isset($_REQUEST['lan']) and $_REQUEST['lan']!="") $_SESSION['language'] = $_REQUEST['lan'];
		include(dirname(__FILE__)."/../languages/".(isset($_SESSION['language']) ? $_SESSION['language'] : $ini_conf['language'])."/options.php");
		setlocale(LC_ALL, $LANGUAGE_LOCALE);
		date_default_timezone_set($LANGUAGE_TIMEZONE);
	}
}
?>