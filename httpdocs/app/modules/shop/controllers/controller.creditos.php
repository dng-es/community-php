<?php
class shopCreditosController{
	public static function getListAction($reg = 0){
		$shop = new shop();
		$filtro = " AND credito_puntos<>0 ORDER BY credito_date DESC ";
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("users_creditos",$filtro); 
		return array('items' => $shop->getCreditos($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
			$shop = new shop(); 
			$filtro =" AND credito_puntos<>0 ";
			$elements = $shop->getCreditos($filtro." ORDER BY credito_date DESC ");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function getCreditosAction($username, $filter = ""){
		if ($username != ""){
			$shop = new shop();
			$elements = $shop->getUsersCreditos(" AND credito_username='".$username."' ".$filter);
			return $elements;	
		}
	}

	public static function updateCreditosAction($username, $creditos, $id_product){
		if ($username != ""){
			shop::updateCredito($username, $creditos);
			shop::insertCredito($username, $creditos, "Compras premios", "Producto ID.".$id_product);
		}
	}
}
?>