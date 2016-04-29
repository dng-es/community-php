<?php
class batallas extends API{
	public function getBatallas(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET"){ $this->response('', 406);}	

		//get data sent
		$ses_id = $_GET['ses_id'];
		$user = $_GET['user'];

		// Session validation
		if ($this->checkSesId($ses_id,$user)){
			// Input validations
			if(trim($user) != ''){		
				$Sql = "SELECT COUNT(*) AS total FROM batallas WHERE finalizada=0 AND user_retado='".$user."' AND id_batalla NOT IN ( SELECT id_batalla FROM batallas_luchas WHERE user_lucha='".$user."' ) ";
				$query = $this->getQuery($Sql);
				$filas = mysqli_num_rows($query);
				if(mysqli_num_rows($query) > 0){

					$result = mysqli_fetch_array($query,MYSQLI_ASSOC);
					$respuesta = array();
					$respuesta['pendientes'] = (int)($result['total']);
					
					// If success everythig is good send header as "OK" and user details
					$this->response($this->json($respuesta), 200);
				}
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