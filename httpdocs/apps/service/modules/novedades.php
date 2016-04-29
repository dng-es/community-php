<?php
class novedades extends API{
	public function getNovedades(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET"){ $this->response('', 406);}	

		//get data sent
		$ses_id = $_GET['ses_id'];
		$user = $_GET['user'];
		$canal = $_GET['canal'];

		// Session validation
		if ($this->checkSesId($ses_id,$user)){
			// Input validations
			if(trim($user) != ''){		
				$Sql = "SELECT cuerpo,date_novedad FROM novedades WHERE canal='".$canal."' ";
				$query = $this->getQuery($Sql);
				$result = array();
				$rlt = mysqli_fetch_array($query, MYSQLI_ASSOC);
				$result[] = $rlt;
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