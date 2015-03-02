<?php
class incentivosFabricantesController{
	public static function getListAction($reg = 0){
		$incentivos = new incentivos();
		$filtro = "";
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro = " AND nombre_fabricante LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro = " AND nombre_fabricante LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
		$filtro .= " AND activo_fabricante=1 ORDER BY nombre_fabricante";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incentives_fabricantes",$filtro); 
		return array('items' => $incentivos->getIncentivesFabricantes($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		if (isset($_POST['fabricante-nombre']) and trim($_POST['fabricante-nombre']) != ""){
			$nombre_fabricante = sanitizeInput( $_POST['fabricante-nombre'] );
			$incentivos = new incentivos();
			if ($incentivos->insertIncentivesFabricantes($nombre_fabricante))
				session::setFlashMessage( 'actions_message', "Fabricante creado correctamente.", "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', "Error al crear fabricante.", "alert alert-danger");
			redirectURL("admin-incentives-fabricantes");
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$id_fabricante = sanitizeInput( $_REQUEST['id'] );
			$incentivos = new incentivos();
			if ($incentivos->disableIncentivesFabricantes($id_fabricante))
				session::setFlashMessage( 'actions_message', "Fabricante deshabilitado correctamente.", "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', "Error al deshabilitar fabricante.", "alert alert-danger");
			redirectURL("admin-incentives-fabricantes");
		}	
	}
}
?>