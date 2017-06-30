<?php
require_once( __DIR__."/../../../app/modules/users/classes/class.users.php");
require_once( __DIR__."/../../../app/modules/users/controllers/controller.default.php");
class WSusers extends API{
	public function login(){
		//Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "POST") $this->response('', 406);

		//get data sent
		$data = file_get_contents("php://input");
		$parametros = $this->jsonDecode($data);
		$user = $parametros->user;
		$pwd = $parametros->pwd;

		if(!empty($user) and !empty($pwd)){
			$users = new users();
			if ($result = $users->getUsers(" AND username ='".$user."' AND user_password COLLATE utf8_bin ='".$pwd."' ")){		
				//verificar usuario deshabiliitado
				if ($result[0]['disabled'] == 1){
					$error = array('status' => "Failed", "msg" => "Usuario deshabilitado");
					$this->response($this->json($error), 400);
				}
				//verificar usuario confirmado
				elseif ($result[0]['confirmed'] == 0){
					$error = array('status' => "Failed", "msg" => "Usuario no confirmado");
					$this->response($this->json($error), 400);
				}				
				//generar sesion aleatoria
				$rand = self::genRandomString();
				$result[0]['ses_id'] = $rand;
				$sql = "INSERT INTO users_login (ses_id,username) VALUES ('".$rand."','".$user."')";
				if(connection_sql::execute_query($sql)){					
					// If success everythig is good send header as "OK" and user details
					$this->response($this->json($result[0]), 200);
				}
				else{
					$error = array('status' => "Failed", "msg" => "Error al obtener datos: " . mysqli_error($this->db));
					$this->response($this->json($error), 400);
				}
			}
			$error = array('status' => "Failed", "msg" => "Usuario o contraseña incorrecta");
			$this->response($this->json($error), 400);
		}
		// If invalid inputs "Bad Request" status message and reason
		$error = array('status' => "Failed", "msg" => "Usuario o contraseña incorrecta");
		$this->response($this->json($error), 400);
	}

	public function getProfile(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET") $this->response('', 406);
		
		//get data sent
		$ses_id = $_GET['ses_id'];
		$user = $_GET['user'];
		$user_profile = $_GET['user_profile'];

		// Session validation
		if ($this->checkSesId($ses_id, $user)){
			// Input validations
			if(!empty($user) and !empty($user_profile)){
				$result = usersController::getPerfilAction($user_profile);
				// If success everythig is good send header as "OK" and user details
				$this->response($this->json($result), 200);
			}
			// If invalid inputs "Bad Request" status message and reason
			$error = array('status' => "Failed", "msg" => "Error al obtener datos");
			$this->response($this->json($error), 400);
		}
		else{
			$error = array('status' => "Failed", "msg" => "Sesion incorrecta");
			$this->response($this->json($error), 400);		
		}
	}	
}
?>