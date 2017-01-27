<?php
class visitasController{
	public static function exportAction($filter){
		if (isset($_POST['export-stats']) and isset($_POST['fecha_ini'])){
			$visitas = new visitas();
			$elements = $visitas->getVisitasInformes($filter." ORDER BY fecha DESC ");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function insertVisita($page){
		$visitas = new visitas();

		$user_name = ((isset($_SESSION['user_name']) && $_SESSION['user_name'] != "") ? $_SESSION['user_name'] : "");
		$user_perfil = ((isset($_SESSION['user_perfil']) && $_SESSION['user_perfil'] != "") ? $_SESSION['user_perfil'] : "");
		$user_empresa = ((isset($_SESSION['user_empresa']) && $_SESSION['user_empresa'] != "") ? $_SESSION['user_empresa'] : "");
		$user_canal = ((isset($_SESSION['user_canal']) && $_SESSION['user_canal'] != "") ? $_SESSION['user_canal'] : "");
		$webpage_id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : "");
		
		//tiempo de la visita anterior
		if ($user_name != "") $visitas->updateVisitaSeconds($_SESSION['user_name']);

		//insertar registro de la visita
		$visitas ->insertVisita($user_name, $page, $webpage_id, $user_perfil, $user_empresa, $user_canal);  

		//puntuacion semanal
		if ($user_name != ""){
			if(connection::countReg("accesscontrol"," AND username='".$_SESSION['user_name']."' AND WEEK(fecha)=WEEK(NOW()) AND YEAR(fecha)=YEAR(NOW())") == 1) 
				users::sumarPuntos($_SESSION['user_name'], PUNTOS_ACCESO_SEMANA, PUNTOS_ACCESO_SEMANA_MOTIVO);
		}

		return true;
	}

	public static function exportNaAreasAction($filter){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == 'na_areas'){
			$visitas = new visitas();
			$elements = visitas::getAccessNaAreas($filter);
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function exportGroupAction($filter){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == 'group'){
			$visitas = new visitas();
			$elements = visitas::getAccessGroup($filter);
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}	
}
?>