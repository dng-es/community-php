<?php
class incentivosObjetivosController{
	public static function getListAction($reg = 0, $filter = ""){
		$filter = " AND activo_objetivo=1".$filter;
		$incentivos = new incentivos();
		$find_reg = "";
		if (isset($_POST['find_reg'])){
			$filter .= " AND nombre_objetivo LIKE '%".sanitizeInput($_POST['find_reg'])."%' ";
			$find_reg = $_POST['find_reg'];
		}
		if (isset($_REQUEST['f'])){
			$filter .= " AND nombre_objetivo LIKE '%".sanitizeInput($_REQUEST['f'])."%' ";
			$find_reg = $_REQUEST['f'];
		} 
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incentives_objetivos", $filter); 
		return array('items' => $incentivos->getIncentivesObjetivos($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id = 0){
		if ($id != 0){
			$incentivos = new incentivos();
			$elements = $incentivos->getIncentivesObjetivos(" AND id_objetivo=".$id);
			return  $elements[0];
		}
	}

	public static function createAction(){
		if (isset($_POST['nombre_objetivo']) and trim($_POST['nombre_objetivo']) != ""){
			$nombre_objetivo = sanitizeInput($_POST['nombre_objetivo']);
			$tipo_objetivo = sanitizeInput( $_POST['tipo_objetivo'] );
			$ranking_objetivo = (isset($_POST['ranking_objetivo']) and $_POST['ranking_objetivo'] == "on") ? 1 : 0;
			$date_ini = sanitizeInput($_POST['date_ini']);
			$date_fin = sanitizeInput($_POST['date_fin']);
			$perfil_objetivo = sanitizeInput($_POST['perfil_objetivo']);
			$canal_objetivo = sanitizeInput($_POST['canal_objetivo']);
			if (is_array($canal_objetivo)) $canal_objetivo = implode(",", $canal_objetivo);
			
			$incentivos = new incentivos();
			if ($incentivos->insertIncentivesObjetivos($nombre_objetivo, $tipo_objetivo, $date_ini, $date_fin, $ranking_objetivo, $perfil_objetivo, $canal_objetivo))
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-targets");
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_objetivo = intval($_REQUEST['id']);
			$incentivos = new incentivos();
			if ($incentivos->disableIncentivesObjetivos($id_objetivo))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-targets");
		}
	}

	public static function getListDetalleAction($reg = 0, $filter = ""){
		$incentivos = new incentivos();
		$find_reg = "";
		$filter .= " ORDER BY d.destino_objetivo,d.id_producto";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incentives_objetivos_detalle d", $filter); 
		return array('items' => $incentivos->getIncentivesObjetivosDetalle($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createDetalleAction(){
		if (isset($_POST['id_objetivo']) and trim($_POST['id_objetivo']) > 0){
			$id_objetivo = intval($_POST['id_objetivo']);
			$destino_objetivo = sanitizeInput( $_POST['destino_objetivo']);
			$id_producto = intval($_POST['id_producto'] );
			$valor_objetivo = sanitizeInput($_POST['valor_objetivo']);

			$incentivos = new incentivos();

			//verificar que no exista un objetivo para el mismo destinatario y producto
			$verificacion = $incentivos->getIncentivesObjetivosDetalle(" AND d.id_producto=".$id_producto." AND d.destino_objetivo='".$destino_objetivo."' AND d.id_objetivo=".$id_objetivo." ");
			if (count($verificacion) == 0){
				if ($incentivos->insertIncentivesObjetivosDetalle($id_objetivo, $destino_objetivo, $id_producto, $valor_objetivo ))
					session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				else
					session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			else{
				session::setFlashMessage('actions_message', "Ya existe un objetivo para el mismo producto y destinatario", "alert alert-danger");
			}
			redirectURL("admin-incentives-targets-detail?id=".$id_objetivo);
		}
	}

	public static function deleteDetalleAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_objetivo = intval($_REQUEST['id']);
			$id_detalle = intval($_REQUEST['det']);
			$incentivos = new incentivos();
			if ($incentivos->deleteIncentivesObjetivosDetalle($id_detalle))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("admin-incentives-targets-detail?id=".$id_objetivo);
		}
	}

	public static function exportAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
			$incentivos = new incentivos();
			$elements = $incentivos->getIncentivesObjetivos("");
			download_send_headers(strTranslate("Incentives_targets")."_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function exportDetailAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
			$incentivos = new incentivos();
			$id_objetivo = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
			$elements = $incentivos->getIncentivesObjetivosDetalleExport(" AND d.id_objetivo=".$id_objetivo." ");
			download_send_headers(strTranslate("Incentives_targets")."_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function getFiltroTienda($user_perfil, $username, $empresa, $detalle = false){
		switch ($user_perfil){
			case 'admin':
				$filtro_tienda = "";
				break;
			case 'regional':
				$filtro_tienda = " AND u.empresa IN (SELECT cod_tienda FROM users_tiendas WHERE regional_tienda='".$username."' OR regional_post_tienda='".$username."')";
				break;
			case 'responsable':
				$filtro_tienda = " AND u.empresa IN (SELECT cod_tienda FROM users_tiendas WHERE responsable_tienda='".$username."')";
				break;
			default:
				$filtro_tienda = " AND u.empresa='".$empresa."' ";
				break;
		}

		if ($detalle == true) $filtro_tienda .= " AND u.username='".$username."' ";
		return $filtro_tienda;
	}

	public static function getFiltroPerfil($user_perfil){
		switch ($user_perfil){
			case 'admin':
				$filtro_perfil = "";
				break;
			case 'visualizador':
				$filtro_perfil = "";
				break;
			case 'regional':
				$filtro_perfil = "";
				break;
			case 'responsable':
				$filtro_perfil = " AND (perfil_objetivo<>'regional') ";
				break;
			default:
				$filtro_perfil = " AND (perfil_objetivo='' OR perfil_objetivo='".$_SESSION['user_perfil']."') ";
				break;
		}
		return $filtro_perfil;
	}
}
?>