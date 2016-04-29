<?php
class visitas extends API{
	public function insertAccess(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "POST") $this->response('', 406);
		//get data sent
		$data = file_get_contents("php://input");
		$parametros = $this->jsonDecode($data);
		$ses_id = $parametros->ses_id;
		$user = $parametros->user;
		$page = $parametros->page;
		$perfil = $parametros->perfil;
		$empresa = $parametros->empresa;
		$canal = $parametros->canal;
		$pageid = $parametros->pageid;

		// Session validation
		if ($this->checkSesId($ses_id,$user)){
			// Input validations
			if(!empty($user) and !empty($page)){
				$sql = "INSERT INTO accesscontrol (username,webpage,movil) VALUES ('".$user."','".$page."',2);";
				$this->getQuery($sql);

				//puntuacion semanal
			    $users = new users();
			    if($users->countReg("accesscontrol"," AND username='".$user."' AND WEEK(fecha)=WEEK(NOW()) AND YEAR(fecha)=YEAR(NOW())")==1){
				  $users->sumarPuntos($user,PUNTOS_ACCESO_SEMANA,PUNTOS_ACCESO_SEMANA_MOTIVO);}

				//usuarios conectados
				$users = new users();
				$users->deleteUserConn($user);
				$users->insertUserConn($user,$result['canal']);				  

				// If success everythig is good send header as "OK" and user details
				$resultado = array('status' => "Ok", "msg" => "Visita insertada");
				$this->response($this->json($resultado), 200);

			}
			// If invalid inputs "Bad Request" status message and reason
			$error = array('status' => "Failed", "msg" => "Error al insertar visita");
			$this->response($this->json($error), 400);
		}
		else{
			$error = array('status' => "Failed", "msg" => "Sesion incorrecta");
			$this->response($this->json($error), 400);		
		}
	}
}
?>