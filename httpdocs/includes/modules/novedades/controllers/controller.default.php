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

	public static function updateAction(){
		if (isset($_POST['texto'])){
			$novedades = new novedades();		
			$cuerpo = stripslashes($_POST['texto']);
			$activo = ($_POST['activo']=="on" ? 1 : 0);
			$canal = $_POST['canal'];

			if ($novedades->updateNovedades($cuerpo,$activo, $canal)) {
				session::setFlashMessage( 'actions_message', "Modificación realizada correctamente.", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar registro.", "alert alert-danger");
			}
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}
}
?>