<?php
class foro extends API{
	public function getForoTemas(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET") $this->response('', 406);

		//get data sent
		$ses_id = $_GET['ses_id'];
		$user = $_GET['user'];
		$canal = $_GET['canal'];

		// Session validation
		if ($this->checkSesId($ses_id, $user)){
			// Input validations
			if(trim($user) != ''){		
				$result = self::getTemas(" AND id_tema_parent<>0 AND ocio=0 AND id_area=0 AND canal='".$canal."' ");
				// If success everythig is good send header as "OK" and user details
				$this->response($this->json($result), 200);
			}
		}
		else{
			$error = array('status' => "Failed", "msg" => "Sesion incorrecta");
			$this->response($this->json($error), 400);		
		}
	}

	private function getTemas($filter){
		$Sql = "SELECT id_tema,nombre,descripcion FROM foro_temas WHERE activo=1 ".$filter;
		$query = $this->getQuery($Sql);
		$result = array();
		$i=0;
		while($rlt = mysqli_fetch_array($query, MYSQLI_ASSOC)){
			//$result[] = $rlt;
			$result[$i]['id_tema'] = $rlt['id_tema'];
			$result[$i]['nombre'] = $rlt['nombre'];
			$result[$i]['descripcion'] = $rlt['descripcion'];
			$i++;
		}
		return $result;
	}

}
?>