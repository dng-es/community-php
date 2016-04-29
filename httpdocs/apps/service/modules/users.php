<?php
class users extends API{
	public function login(){
		//Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "POST") $this->response('', 406);

		//get data sent
		$data = file_get_contents("php://input");
		$parametros = $this->jsonDecode($data);
		$user = $parametros->user;
		$pwd = $parametros->pwd;

		if(!empty($user) and !empty($pwd)){
			$sql = "SELECT username,nick,email,name,surname,confirmed,disabled,empresa,
					IFNULL(t.nombre_tienda, '') AS nombre_tienda 
					FROM users u LEFT JOIN users_tiendas t ON u.empresa=t.cod_tienda
					WHERE username = '".$user."' AND user_password = '".$pwd."' ";
			$query = $this->getQuery($sql);
			$filas = mysqli_num_rows($query);
			if(mysqli_num_rows($query) > 0){
				$result = mysqli_fetch_array($query, MYSQLI_ASSOC);				
				//verificar usuario deshabiliitado
				if ($result['disabled']==1){
					$error = array('status' => "Failed", "msg" => "Usuario deshabilitado");
					$this->response($this->json($error), 400);
				}
				//verificar usuario confirmado
				elseif ($result['confirmed']==0){
					$error = array('status' => "Failed", "msg" => "Usuario no confirmado");
					$this->response($this->json($error), 400);
				}				
				//generar sesion aleatoria
				$rand = $this->genRandomString();
				$result['ses_id'] = $rand;
				$sql = "INSERT INTO users_login (ses_id,username) VALUES ('".$rand."','".$user."')";
				if(mysqli_query($this->db, $sql)){					
					// If success everythig is good send header as "OK" and user details
					$this->response($this->json($result), 200);
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

	public function getUserData($user){
		//OBTENER DATOS DEL USUARIO
		$Sql = "SELECT * FROM users u LEFT JOIN users_tiendas t ON u.empresa=t.cod_tienda
					WHERE username='".$user."' ";
		$query = $this->getQuery($Sql);
		$user_data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $user_data;
	}

	public function getUserProfile(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET") $this->response('', 406);
		
		//get data sent
		$ses_id = $_GET['ses_id'];
		$user = $_GET['user'];
		$user_profile = $_GET['user_profile'];

		// Session validation
		if ($this->checkSesId($ses_id,$user)){
			// Input validations
			if(!empty($user) and !empty($user_profile)){
				$Sql = "SELECT nick,name,surname, foto, puntos, participaciones, user_comentarios, empresa, email
						FROM users 
						WHERE username='".$user_profile."' ";
	
				$query = $this->getQuery($Sql);
				$result = array();
				$i=0;
				while($rlt = mysqli_fetch_array($query, MYSQLI_ASSOC)){
					//$result[] = $rlt;
					$result[$i]['nick'] = $rlt['nick'];
					$result[$i]['name'] = $rlt['name'];
					$result[$i]['surname'] = $rlt['surname'];
					$result[$i]['email'] = $rlt['email'];
					$result[$i]['foto'] = $rlt['foto'];
					$result[$i]['puntos'] = (int)$rlt['puntos'];
					$result[$i]['participaciones'] = (int)$rlt['participaciones'];
					$result[$i]['comentarios'] = $rlt['user_comentarios'];
					$result[$i]['empresa'] = $rlt['empresa'];
					$i++;
				}
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