<?php
require_once( __DIR__."/../../../app/modules/foro/classes/class.foro.php");
class WSblog extends API{
	public function getNoticias(){
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
				$filtro_subtemas = " AND canal='".$canal."' AND activo=1 AND ocio=1 ";
				$result = $foro->getTemas($filtro_subtemas." ORDER BY id_tema DESC  LIMIT ".$inicio.",".$regs);
				$this->response($this->json($result), 200);
			}
		}
		else{
			$error = array('status' => "Failed", "msg" => "Sesion incorrecta");
			$this->response($this->json($error), 400);		
		}
	}

}
?>