<?php
class incentivosController{
	public static function getListAction($reg = 0, $filtro = ""){
		$incentivos = new incentivos();
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro .= " AND referencia_incentivo LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro .= " AND referencia_incentivo LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " ORDER BY referencia_incentivo,date_ini";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incentives",$filtro); 
		return array('items' => $incentivos->getIncentives($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['referencia_incentivo']) and trim($_POST['referencia_incentivo']) != ""){
			$referencia_incentivo = sanitizeInput( $_POST['referencia_incentivo'] );
			$puntos_incentivo = sanitizeInput( $_POST['puntos_incentivo'] );
			$date_ini = sanitizeInput( $_POST['date_ini'] );
			$date_fin = sanitizeInput( $_POST['date_fin'] );
			$incentivos = new incentivos();
			if ($incentivos->insertIncentives( $referencia_incentivo, $puntos_incentivo, $date_ini, $date_fin ))
				session::setFlashMessage( 'actions_message', "Incentivo creado correctamente.", "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', "Error al crear incentivo.", "alert alert-danger");
			redirectURL("admin-incentives");
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_incentivo = sanitizeInput( $_REQUEST['id'] );
			$incentivos = new incentivos();
			if ($incentivos->deleteIncentives($id_incentivo))
				session::setFlashMessage( 'actions_message', "Incentivo eliminado correctamente.", "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', "Error al eliminar incentivo.", "alert alert-danger");
			redirectURL("admin-incentives");
		}	
	}
}
?>