<?php
class incentivosObjetivosController{
	public static function getListAction($reg = 0, $filtro = ""){
		$incentivos = new incentivos();
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro .= " AND nombre_objetivo LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro .= " AND nombre_objetivo LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " AND activo_objetivo=1 ORDER BY nombre_objetivo";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incentives_objetivos",$filtro); 
		return array('items' => $incentivos->getIncentivesObjetivos($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id = 0){
		if ($id!=0){
			$incentivos = new incentivos();
			$elements = $incentivos->getIncentivesObjetivos(" AND id_objetivo=".$id);	
			return  $elements[0];
		}
	}

	public static function createAction(){
		if (isset($_POST['nombre_objetivo']) and trim($_POST['nombre_objetivo']) != ""){
			$nombre_objetivo = sanitizeInput( $_POST['nombre_objetivo'] );
			$tipo_objetivo = sanitizeInput( $_POST['tipo_objetivo'] );
			$date_ini = sanitizeInput( $_POST['date_ini'] );
			$date_fin = sanitizeInput( $_POST['date_fin'] );
			$incentivos = new incentivos();
			if ($incentivos->insertIncentivesObjetivos( $nombre_objetivo, $tipo_objetivo, $date_ini, $date_fin ))
				session::setFlashMessage( 'actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-targets");
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_objetivo = sanitizeInput( $_REQUEST['id'] );
			$incentivos = new incentivos();
			if ($incentivos->disableIncentivesObjetivos($id_objetivo))
				session::setFlashMessage( 'actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-targets");
		}	
	}

	public static function getListDetalleAction($reg = 0, $filtro = ""){
		$incentivos = new incentivos();
		$find_reg = "";
		$filtro .= " ORDER BY d.destino_objetivo,d.id_producto";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incentives_objetivos_detalle d",$filtro); 
		return array('items' => $incentivos->getIncentivesObjetivosDetalle($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createDetalleAction(){
		if (isset($_POST['id_objetivo']) and trim($_POST['id_objetivo']) >0){
			$id_objetivo = sanitizeInput( $_POST['id_objetivo'] );
			$destino_objetivo = sanitizeInput( $_POST['destino_objetivo'] );
			$id_producto = sanitizeInput( $_POST['id_producto'] );
			$valor_objetivo = sanitizeInput( $_POST['valor_objetivo'] );

			$incentivos = new incentivos();

			//verificar que no exista un objetivo para el mismo destinatario y producto
			$verificacion = $incentivos->getIncentivesObjetivosDetalle(" AND d.id_producto=".$id_producto." AND d.destino_objetivo='".$destino_objetivo."' AND d.id_objetivo=".$id_objetivo." ");
			if (count($verificacion) == 0){
				if ($incentivos->insertIncentivesObjetivosDetalle( $id_objetivo, $destino_objetivo, $id_producto, $valor_objetivo ))
					session::setFlashMessage( 'actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				else
					session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			else{
				session::setFlashMessage( 'actions_message', "Ya existe un objetivo para el mismo producto y destinatario", "alert alert-danger");
			}
			redirectURL("admin-incentives-targets-detail?id=".$id_objetivo);
		}
	}

	public static function deleteDetalleAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_objetivo = sanitizeInput( $_REQUEST['id'] );
			$id_detalle = sanitizeInput( $_REQUEST['det'] );
			$incentivos = new incentivos();
			if ($incentivos->deleteIncentivesObjetivosDetalle($id_detalle))
				session::setFlashMessage( 'actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-targets-detail?id=".$id_objetivo);
		}	
	}	

	public static function exportAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$incentivos = new incentivos();
			$elements = $incentivos->getIncentivesObjetivos("");
			download_send_headers(strTranslate("Incentives_targets")."_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}  		
	}

	public static function exportDetailAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$incentivos = new incentivos();
			$id_objetivo = (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
			$elements = $incentivos->getIncentivesObjetivosDetalleExport(" AND d.id_objetivo=".$id_objetivo." ");
			download_send_headers(strTranslate("Incentives_targets")."_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}  		
	}		
}
?>