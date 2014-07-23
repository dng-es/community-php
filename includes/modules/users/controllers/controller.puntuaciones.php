<?php
class usersPuntuacionesController{

	public static function getListAction($reg = 0){
		$users = new users();
		$filtro = " AND puntuacion_puntos<>0 ORDER BY puntuacion_date DESC ";
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);	
		$total_reg = $users->countReg("users_puntuaciones",$filtro); 
		return array('items' => $users->getPuntuaciones($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$users = new users(); 
			$filtro =" AND puntuacion_puntos<>0 ";
			$elements = $users->getPuntuaciones($filtro." ORDER BY puntuacion_date DESC ");
			exportCsv($elements, "puntuaciones");
		}	
	}	
	
}
?>