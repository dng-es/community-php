<?php
require_once( __DIR__."/../../../app/modules/novedades/classes/class.novedades.php");
class WSnovedades extends API{
	public function getNovedades(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET"){ $this->response('', 406);}	

		//get data sent
		$ses_id = $_GET['ses_id'];
		$user = $_GET['user'];
		$canal = (isset($_GET['canal']) ? $_GET['canal'] : '');
		$perfil = (isset($_GET['canal']) ? $_GET['perfil'] : '');
		$tipo = (isset($_GET['tipo']) ? $_GET['tipo'] : '');

		$filtro_canal = (($canal == '') ? "" : " AND canal='".$canal."' ");
		$filtro_perfil = (($perfil == '') ? "" : " AND perfil='".$perfil."' ");
		$filtro_tipo = (($tipo == '') ? "" : " AND tipo='".$tipo."' ");

		// Session validation
		if ($this->checkSesId($ses_id,$user)){
			// Input validations
			if(trim($user) != ''){		
				$novedades = new novedades();
				$result = $novedades->getNovedades($filtro_canal.$filtro_perfil.$filtro_tipo." AND activo=1 ");

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