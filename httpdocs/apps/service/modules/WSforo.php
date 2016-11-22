<?php
require_once( __DIR__."/../../../app/modules/users/classes/class.users.php");
require_once( __DIR__."/../../../app/modules/foro/classes/class.foro.php");
class WSforo extends API{
	public function getForos(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET") $this->response('', 406);

		//get data sent
		$ses_id = $_GET['ses_id'];
		$user = $_GET['user'];
		$canal = $_GET['canal'];
		$regs = $_GET['regs'];
		$page = $_GET['page'];
		$inicio = ($page - 1) * $regs;

		// Session validation
		if ($this->checkSesId($ses_id, $user)){
			// Input validations
			if(trim($user) != ''){		
				$foro = new foro();
				$filtro_subtemas = " AND id_tema_parent<>0 AND canal='".$canal."' AND activo=1 AND ocio=0 AND id_area=0 ";
				$result = $foro->getTemas($filtro_subtemas." ORDER BY id_tema DESC  LIMIT ".$inicio.",".$regs);
				$this->response($this->json($result), 200);
			}
		}
		else{
			$error = array('status' => "Failed", "msg" => "Sesion incorrecta");
			$this->response($this->json($error), 400);		
		}
	}

	public function getForosComentarios(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET") $this->response('', 406);

		//get data sent
		$ses_id = $_GET['ses_id'];
		$user = $_GET['user'];
		$id_tema = $_GET['id_tema'];
		$regs = $_GET['regs'];
		$page = $_GET['page'];
		$inicio = ($page - 1) * $regs;

		// Session validation
		if ($this->checkSesId($ses_id, $user)){
			// Input validations
			if(trim($user) != ''){		
				$foro = new foro();
				$filtro_comentarios = " AND c.id_tema=".$id_tema." AND estado=1 AND id_comentario_id=0";
				$result = $foro->getComentarios($filtro_comentarios.' ORDER BY date_comentario DESC LIMIT '.$inicio.','.$regs); 
				$this->response($this->json($result), 200);
			}
		}
		else{
			$error = array('status' => "Failed", "msg" => "Sesion incorrecta");
			$this->response($this->json($error), 400);		
		}
	}	

	public function insertForosComentarios(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "POST") $this->response('', 406);

		//get data sent
		$data = file_get_contents("php://input");
		$parametros = $this->jsonDecode($data);
		$user = $parametros->user;
		$ses_id = $parametros->ses_id;
		$id_tema = $parametros->id_tema;
		$comentario = $parametros->comentario;
		$id_comentario_respuesta = $parametros->id_comentario_respuesta;


		// Session validation
		if ($this->checkSesId($ses_id, $user)){
			$foro = new foro();
			if ($foro->InsertComentario($id_tema,
								$comentario,
								$user,
								ESTADO_COMENTARIOS_FORO,
								$id_comentario_respuesta)){
				$msg = array('status' => "ok", "msg" => "Mensaje insertado");
				$this->response($this->json($msg), 200);
			}
			else{
				$error = array('status' => "Failed", "msg" => "Error al insertar");
				$this->response($this->json($error), 400);		
			}
		}
		else{
			$error = array('status' => "Failed", "msg" => "Sesion incorrecta");
			$this->response($this->json($error), 400);		
		}
	}		

}
?>