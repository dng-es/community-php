<?php
class visitasController{
	public static function exportAction(){
		if (isset($_POST['export-stats']) and isset($_POST['fecha_ini'])){
			$visitas = new visitas();
			$fecha_ini = $_POST['fecha_ini'];
			$fecha_fin = $_POST['fecha_fin'];
			$elements = $visitas->getVisitasInformes(" AND fecha BETWEEN '".$fecha_ini." 00:00:00' AND '".$fecha_fin." 23:59:59' ORDER BY fecha DESC ");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function insertVisita($page){
		$visitas = new visitas();

		//tiempo de la visita anterior
		$visitas->updateVisitaSeconds($_SESSION['user_name']);

		//insertar registro de la visita
		$webpage_id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : "");
		$visitas ->insertVisita($_SESSION['user_name'], $page, $webpage_id);  

		//puntuacion semanal
		if(connection::countReg("accesscontrol"," AND username='".$_SESSION['user_name']."' AND WEEK(fecha)=WEEK(NOW()) AND YEAR(fecha)=YEAR(NOW())") == 1) 
			users::sumarPuntos($username, PUNTOS_ACCESO_SEMANA, PUNTOS_ACCESO_SEMANA_MOTIVO);

		return true;
	}
}
?>