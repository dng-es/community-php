<?php
session_start();

class session {          
	
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
		elseif( (isset($_SESSION['user_logged']) and $_SESSION['user_logged'] == true) && (!isset($_REQUEST['page']) or $_REQUEST['page']=="")){
			header ("Location: ?page=home");
		}
		else {
			//SI HAN PASADO 15 MINUTOS DE INACTIVIDAD SE CIERRA LA SESION (60*15=900)
			if ( (isset($_SESSION['user_logged']) and $_SESSION['user_logged'] == true) and (time()-$_SESSION["session_time"] > 1800)){ self::DestroySession();}
			else {$_SESSION["session_time"] = time();}
		}
	}

	/**
	* Check if user is logged in Ajax pages. If not redirects to login page
	*
	*/
	public static function ValidateSessionAjax(){
		if (!isset($_SESSION['user_logged']) or $_SESSION['user_logged'] != true){
			header ("Location: ?page=login");
		}
	}	

	/**
	* Verify user data sent from login form
	*
	* @param 	string 		$Login_user 	Username POST sent
	* @param 	string 		$Login_pass 	Password POST sent
	* @param 	string 		$destination 	Destination page when login OK
	*/
	public static function CreateSession($Login_user, $Login_pass, $destination = "home")
	{
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
				$_SESSION['user_foto'] = $result_user[0]['foto'];			  
				$_SESSION['territorial'] = $result_user[0]['territorial'];
				$_SESSION['user_canal_nombre'] = ($result_user[0]['canal']=='admin') ? "Administración" : ucfirst($result_user[0]['canal']);

				//crear estadistica de acceso
				$visitas = new visitas();
				$visitas ->insertVisitas($_SESSION['user_name'],"Inicio sesion");
				$users->updateLastAccess($_SESSION['user_name']);
							  
				//Redirijimos a la pagina correcta.
				header ("Location: ?page=".$destination);
			}
			elseif ($result_user[0]['confirmed']==0 and $result_user[0]['registered']==0) {
				//Redirijimos a la pagina de confirmacion de datos.
				header ("Location: ?page=user-confirm");			  
			}
		}	
	}

	/**
	* Destroy users session and redirects to login page.
	*
	*/
	public static function DestroySession(){
		session_unset();
		session_destroy();
		header ("Location: ?page=login");
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
	public static function AccessLevel($perfiles_autorizados)
	{
		if (in_array($_SESSION['user_perfil'], $perfiles_autorizados)==false and $_SESSION['user_perfil']!='admin'){
			ErrorMsg("Acceso denegado.");
			die();
		}
	}
}
?>