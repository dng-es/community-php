<?php
class incentivosController{
	public static function getListAction($reg = 0, $filtro = ""){
		$incentivos = new incentivos();
		$find_reg = "";
		$filtro .= " ORDER BY id_venta DESC ";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incentives_ventas",$filtro); 
		return array('items' => $incentivos->getVentas($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportAction($filter=""){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$incentivos = new incentivos();
			$elements = $incentivos->getVentasExport($filter);
			download_send_headers(strTranslate("Incentives_sales")."_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}  		
	}	

	public static function getListPuntosAction($reg = 0, $filtro = ""){
		$incentivos = new incentivos();
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro = " AND username_puntuacion LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro = " AND username_puntuacion LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " ORDER BY id_puntos_venta DESC ";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incentives_ventas_puntos",$filtro); 
		$total_sum = connection::sumReg("incentives_ventas_puntos", 'puntuacion_venta',$filtro); 
		return array('items' => $incentivos->getVentasPuntuaciones($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_sum' => $total_sum,
					'total_reg' => $total_reg);
	}	

	public static function exportPuntuacionesAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$incentivos = new incentivos();
			$elements = $incentivos->getVentasPuntuaciones("");
			download_send_headers(strTranslate("Incentives_points")."_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}  		
	}

	public static function getRankingAction($objetivo){
		if($objetivo['tipo_objetivo'] == 'Usuario') return self::getRankingUsuarioAction($objetivo);
		else return self::getRankingTiendaAction($objetivo);
	}

	public static function getRankingUsuarioAction($objetivo){
		echo "usuario";
		$incentivos = new incentivos();
		$objetivos = $incentivos->getObjetivosRanking(" AND id_objetivo=".$objetivo['id_objetivo']." ");
		$elements = array();
		foreach($objetivos as $objetivo_detalle):		
			//obtener ventas del objetivo
			$ventas = $incentivos->getVentasRanking(" AND id_producto IN (".$objetivo_detalle['productos'].") AND fecha_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' AND username_venta='".$objetivo_detalle['destino_objetivo']."' GROUP BY username_venta ");

			if (count($ventas)>0){
				$venta_detalle = array('objetivo' => $objetivo_detalle['suma'], 
										'usuario'=> $ventas[0]['username_venta'], 
										'nick'=> $objetivo_detalle['nick'], 
										'usuario_nombre'=> $objetivo_detalle['surname'].", ".$objetivo_detalle['name'], 
										'porcentaje'=> ($ventas[0]['suma']>0 ? (($ventas[0]['suma']/$objetivo_detalle['suma'])*100) : 0), 
										'cantidad' => $ventas[0]['suma']);

				array_push($elements, $venta_detalle);
			}

		endforeach;

		return arraySort($elements, 'porcentaje', SORT_DESC);
	}

	public static function getRankingTiendaAction($objetivo){
		echo "tienda";
		$incentivos = new incentivos();
		$objetivos = $incentivos->getObjetivosRankingTienda(" AND id_objetivo=".$objetivo['id_objetivo']." ");
		$elements = array();
		foreach($objetivos as $objetivo_detalle):		
			//obtener ventas del objetivo
			$ventas = $incentivos->getVentasRanking(" AND id_producto IN (".$objetivo_detalle['productos'].") AND fecha_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' AND username_venta IN (SELECT username FROM users WHERE empresa='".$objetivo_detalle['destino_objetivo']."') ");

			if (count($ventas)>0){

				$venta_detalle = array('objetivo' => $objetivo_detalle['suma'], 
										'usuario'=> $objetivo_detalle['destino_objetivo'], 
										'usuario_nombre'=> $objetivo_detalle['nombre_tienda'], 
										'porcentaje'=> ($ventas[0]['suma']>0 ? (($ventas[0]['suma']/$objetivo_detalle['suma'])*100) : 0), 
										'cantidad' =>  $ventas[0]['suma']);

				array_push($elements, $venta_detalle);
			}

		endforeach;

		return arraySort($elements, 'porcentaje', SORT_DESC);
	}
}
?>