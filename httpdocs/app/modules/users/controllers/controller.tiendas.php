<?php
class usersTiendasController{

	public static function getListAction($reg = 0, $filtro = ""){
		$users = new users();
		$find_reg = "";
		if (isset($_POST['find_reg']) or isset($_REQUEST['f'])) {
				$filtro = " AND nombre_tienda LIKE '%".$_POST['find_reg']."%' OR cod_tienda LIKE '%".$_POST['find_reg']."%' ";
				$find_reg = (isset($_POST['find_reg']) ? $_POST['find_reg'] : $_REQUEST['f']);
		}
		$filtro .= " ORDER BY nombre_tienda";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("users_tiendas",$filtro); 
		return array('items' => $users->getTiendas($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id = ""){
			$users = new users();
			$plantilla = $users->getTiendas(" AND cod_tienda='".$id."' ");	
			return  $plantilla[0];
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true) {
			$users = new users();
			$elements=$users->getTiendas("");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}		
}
?>