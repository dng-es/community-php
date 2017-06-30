<?php
class usersTiendasController{
	public static function getListAction($reg = 0, $filter = ""){
		$users = new users();
		$find_reg = getFindReg();
		if($find_reg != '')	$filter .= " AND nombre_tienda LIKE '%".$find_reg."%' OR cod_tienda LIKE '%".$find_reg."%' ";
		$filter .= " ORDER BY nombre_tienda";

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("users_tiendas",$filter);
		return array('items' => $users->getTiendas($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
			'pag' 		=> $paginator_items['pag'],
			'reg' 		=> $reg,
			'find_reg' 	=> $find_reg,
			'total_reg' => $total_reg);
	}

	public static function getItemAction($id = ""){
		$users = new users();
		$plantilla = $users->getTiendas(" AND cod_tienda='".$id."' ");
		return $plantilla[0];
	}

	public static function exportListAction($filter = ''){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$users = new users();
			$elements = $users->getTiendas($filter);
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}
}
?>