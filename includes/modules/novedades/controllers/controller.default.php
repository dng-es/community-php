<?php
class novedadesController{
	public static function getListAction($reg = 0, $filtro=""){
		$novedades = new novedades();
		$paginator_items = PaginatorPages($reg);
		$find_reg = "";
		
		$total_reg = connection::countReg("novedades",$filtro); 
		return array('items' => $novedades->getNovedades($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}	
}
?>