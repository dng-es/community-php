<?php
class incentivosProductosController{
	public static function getListAction($reg = 0, $filtro=""){
		$incentivos = new incentivos();
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro = " AND nombre_producto LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro = " AND nombre_producto LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " AND activo_producto=1 ORDER BY nombre_producto";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incentives_productos p ",$filtro); 
		return array('items' => $incentivos->getIncentivesProductos($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['producto-referencia']) and trim($_POST['producto-referencia']) != ""){
			$referencia_producto = sanitizeInput( $_POST['producto-referencia'] );
			$nombre_producto = sanitizeInput( $_POST['producto-nombre'] );
			$id_fabricante = sanitizeInput( $_POST['id_fabricante'] );
			$incentivos = new incentivos();
			if ($incentivos->insertIncentivesProductos( $referencia_producto, $nombre_producto, $id_fabricante ))
				session::setFlashMessage( 'actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-products");
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_producto = sanitizeInput( $_REQUEST['id'] );
			$incentivos = new incentivos();
			if ($incentivos->disableIncentivesProductos($id_producto))
				session::setFlashMessage( 'actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-products");
		}	
	}

	public static function getListAceleratorsAction($reg = 0, $filtro = ""){
		$incentivos = new incentivos();
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro .= " AND p.refrencia_acelerador LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro .= " AND p.refrencia_acelerador LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " ORDER BY referencia_producto,date_ini";
		$paginator_items = PaginatorPages($reg);

		$total_reg = connection::countReg("incentives_productos_aceleradores a, incentives_productos p "," AND p.id_producto=a.id_producto ".$filtro); 
		return array('items' => $incentivos->getIncentivesProductAcelerators($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAceleratorsAction(){
		if (isset($_POST['id_producto']) and trim($_POST['id_producto']) != 0){
			$id_producto = sanitizeInput( $_POST['id_producto'] );
			$valor_acelerador = sanitizeInput( $_POST['valor_acelerador'] );
			$date_ini = sanitizeInput( $_POST['date_ini'] );
			$date_fin = sanitizeInput( $_POST['date_fin'] );
			$incentivos = new incentivos();
			//verificar date_fin no sea menor a date_ini
			if ($date_fin < $date_ini){
				session::setFlashMessage( 'actions_message', "La fecha fin no puede ser inferior a la fecha de inicio", "alert alert-danger");
			}
			else{
				//verificar no se solapen fechas
				$filter_overlap = " AND id_producto=".$id_producto." AND (
                ( date_ini >= '".$date_ini."' AND date_ini <= '".$date_fin."' )
                OR
                ( date_ini <= '".$date_ini."' AND date_fin >= '".$date_fin."' )
                OR
                ( date_fin >= '".$date_ini."' AND date_fin <= '".$date_fin."' )
                )";
				$contador = connection::countReg("incentives_productos_aceleradores", $filter_overlap);
				getDateFormat( $date, $format );
				if ($contador>0){
					session::setFlashMessage( 'actions_message', "No se pueden solapar fechas.\n F. inicio: ".getDateFormat($date_ini, "SHORT")."\n F. fin:".getDateFormat($date_fin, "SHORT"), "alert alert-danger");
				}
				else{
					if ($incentivos->insertIncentivesProductAcelerator( $id_producto, $valor_acelerador, $date_ini, $date_fin ))
						session::setFlashMessage( 'actions_message', strTranslate("Insert_procesing"), "alert alert-success");
					else
						session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");
				}
			}
			redirectURL("admin-incentives-products-acelerators?ref=".$id_producto);
		}
	}

	public static function deleteAceleratorsAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_acelerador = sanitizeInput( $_REQUEST['id'] );
			$id_producto = sanitizeInput( $_REQUEST['ref'] );
			$incentivos = new incentivos();
			if ($incentivos->deleteIncentivesProductAcelerator($id_acelerador))
				session::setFlashMessage( 'actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-products-acelerators?ref=".$id_producto);
		}	
	}

	public static function exportAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$incentivos = new incentivos();
			$elements = $incentivos->getIncentivesProductos("");
			download_send_headers(strTranslate("Incentives_products")."_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}  		
	}	

	public static function getListPuntosAction($reg = 0, $filtro = ""){
		$incentivos = new incentivos();
		$find_reg = "";
		$filtro .= " ORDER BY date_ini";
		$paginator_items = PaginatorPages($reg);

		$total_reg = connection::countReg("incentives_productos_puntos", $filtro); 
		return array('items' => $incentivos->getIncentivesProductosPuntos($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createPuntosAction(){
		if (isset($_POST['id_producto']) and trim($_POST['id_producto']) != 0){
			$id_producto = sanitizeInput( $_POST['id_producto'] );
			$puntos = sanitizeInput( $_POST['puntos'] );
			$date_ini = sanitizeInput( $_POST['date_ini'] );
			$date_fin = sanitizeInput( $_POST['date_fin'] );
			$incentivos = new incentivos();
			//verificar date_fin no sea menor a date_ini
			if ($date_fin < $date_ini){
				session::setFlashMessage( 'actions_message', "La fecha fin no puede ser inferior a la fecha de inicio", "alert alert-danger");
			}
			else{
				//verificar no se solapen fechas
				$filter_overlap = " AND id_producto=".$id_producto." AND (
                ( date_ini >= '".$date_ini."' AND date_ini <= '".$date_fin."' )
                OR
                ( date_ini <= '".$date_ini."' AND date_fin >= '".$date_fin."' )
                OR
                ( date_fin >= '".$date_ini."' AND date_fin <= '".$date_fin."' )
                )";
				$contador = connection::countReg("incentives_productos_puntos", $filter_overlap);
				getDateFormat( $date, $format );
				if ($contador>0){
					session::setFlashMessage( 'actions_message', "No se pueden solapar fechas.\n F. inicio: ".getDateFormat($date_ini, "SHORT")."\n F. fin:".getDateFormat($date_fin, "SHORT"), "alert alert-danger");
				}
				else{
					if ($incentivos->insertIncentivesProductosPuntos( $id_producto, $puntos, $date_ini, $date_fin ))
						session::setFlashMessage( 'actions_message', strTranslate("Insert_procesing"), "alert alert-success");
					else
						session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");
				}
			}
			redirectURL("admin-incentives-products-points?ref=".$id_producto);
		}
	}

	public static function deletePuntosAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_puntos = sanitizeInput( $_REQUEST['id'] );
			$id_producto = sanitizeInput( $_REQUEST['ref'] );
			$incentivos = new incentivos();
			if ($incentivos->deleteIncentivesProductosPuntos($id_puntos))
				session::setFlashMessage( 'actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-products-points?ref=".$id_producto);
		}	
	}	
}
?>