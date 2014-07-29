<?php
class visitasController{
	public static function createAction(){
		
	}

	public static function updateAction(){

	}

	public static function exportAction(){
		if (isset($_POST['export-stats']) and isset($_POST['fecha_ini'])){
			$visitas = new visitas();
			$fecha_ini = $_POST['fecha_ini'];
			$fecha_fin = $_POST['fecha_fin'];
			$elements = $visitas->getVisitasInformes(" AND fecha BETWEEN '".$fecha_ini." 00:00:00' AND '".$fecha_fin." 23:59:59' ORDER BY fecha DESC ");
			exportCsv($elements, "accesos");
		}
	}
}
?>