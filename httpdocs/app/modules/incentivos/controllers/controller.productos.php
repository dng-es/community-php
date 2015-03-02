<?php
class incentivosProductosController{
	public static function getListAction($reg = 0){
		$incentivos = new incentivos();
		$filtro = "";
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro = " AND nombre_producto LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro = " AND nombre_producto LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " AND activo_producto=1 ORDER BY nombre_producto";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incentives_productos",$filtro); 
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
				session::setFlashMessage( 'actions_message', "Producto creado correctamente.", "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', "Error al crear producto.", "alert alert-danger");
			redirectURL("admin-incentives-products");
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_producto = sanitizeInput( $_REQUEST['id'] );
			$incentivos = new incentivos();
			if ($incentivos->disableIncentivesProductos($id_producto))
				session::setFlashMessage( 'actions_message', "Producto deshabilitado correctamente.", "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', "Error al deshabilitar producto.", "alert alert-danger");
			redirectURL("admin-incentives-products");
		}	
	}

	public static function getListAceleratorsAction($reg = 0, $filtro = ""){
		$incentivos = new incentivos();
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro .= " AND refrencia_acelerador LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro .= " AND refrencia_acelerador LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " ORDER BY referencia_acelerador,date_ini";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incentives_productos_aceleradores",$filtro); 
		return array('items' => $incentivos->getIncentivesProductAcelerators($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAceleratorsAction(){
		if (isset($_POST['referencia_acelerador']) and trim($_POST['referencia_acelerador']) != ""){
			$referencia_acelerador = sanitizeInput( $_POST['referencia_acelerador'] );
			$valor_acelerador = sanitizeInput( $_POST['valor_acelerador'] );
			$date_ini = sanitizeInput( $_POST['date_ini'] );
			$date_fin = sanitizeInput( $_POST['date_fin'] );
			$incentivos = new incentivos();
			if ($incentivos->insertIncentivesProductAcelerator( $referencia_acelerador, $valor_acelerador, $date_ini, $date_fin ))
				session::setFlashMessage( 'actions_message', "Acelerador creado correctamente.", "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', "Error al crear acelerador.", "alert alert-danger");
			redirectURL("admin-incentives-products-acelerators?ref=".$referencia_acelerador);
		}
	}

	public static function deleteAceleratorsAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_acelerador = sanitizeInput( $_REQUEST['id'] );
			$referencia_acelerador = sanitizeInput( $_REQUEST['ref'] );
			$incentivos = new incentivos();
			if ($incentivos->deleteIncentivesProductAcelerator($id_acelerador))
				session::setFlashMessage( 'actions_message', "Acelerador eliminado correctamente.", "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', "Error al eliminar acelerador.", "alert alert-danger");
			redirectURL("admin-incentives-products-acelerators?ref=".$referencia_acelerador);
		}	
	}	
}
?>