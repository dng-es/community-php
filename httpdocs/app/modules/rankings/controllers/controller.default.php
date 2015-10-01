<?php
class rankingsController{
	public static function getListAction($reg = 0, $filtro = ""){
		$rankings = new rankings();
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("users_tiendas_rankings r",$filtro); 
		return array('items' => $rankings->getRankings($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $paginator_items['find_reg'],
					'total_reg' => $total_reg);
	}

	public static function getListCategoryAction($reg = 0, $filtro = ""){
		$rankings = new rankings();
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("users_tiendas_ranking_category",$filtro); 
		return array('items' => $rankings->getRankingsCategories($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $paginator_items['find_reg'],
					'total_reg' => $total_reg);
	}	

	public static function getItemAction($id, $filter=" "){
		$rankings = new rankings();
		return $rankings->getRankings(" AND id_ranking=".$id.$filter);
	}

	public static function getItemCategoryAction($id, $filter = " "){
		$rankings = new rankings();
		return $rankings->getRankingsCategories(" AND id_ranking_category=".$id.$filter);
	}	

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del') {
			$rankings = new rankings();
			if ($rankings->updateEstadoRankings($_REQUEST['id'], $_REQUEST['e'])) {
				session::setFlashMessage( 'actions_message', "estado modificado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "error al modificar estado.", "alert alert-danger");
			}
			redirectURL("admin-rankings");
		}
	}			

	public static function createAction(){
		if (isset($_POST['id_ranking']) and $_POST['id_ranking'] == 0){
			$id_ranking = 0;
			$rankings = new rankings();
			$nombre = str_replace("'","´",$_POST['nombre']);
			$descripcion = stripslashes($_POST['descripcion']);
			$id_ranking_category = $_POST['id_ranking_category'];

			if ($rankings->insertRankings($nombre, $descripcion, $id_ranking_category)) {
				session::setFlashMessage( 'actions_message', "registro insertado correctamente", "alert alert-success");
				$id_ranking = connection::SelectMaxReg("id_ranking", "users_tiendas_rankings");
			}
			else{
				session::setFlashMessage( 'actions_message', "error al insertar el registro.", "alert alert-danger");
			}
			redirectURL("admin-ranking?id=".$id_ranking);
		}			
	}

	public static function updateAction(){
		if (isset($_POST['id_ranking']) and $_POST['id_ranking'] > 0){
			$rankings = new rankings();
			$id_ranking = $_POST['id_ranking'];
			$nombre = str_replace("'","´",$_POST['nombre']);
			$descripcion = stripslashes($_POST['descripcion']);
			$id_ranking_category = $_POST['id_ranking_category'];

			//cargar fichero
			self::uploadRankingData($_POST['id_ranking']);

			if ($rankings->updateRankings($id_ranking, $nombre, $descripcion, $id_ranking_category)) {
				session::setFlashMessage( 'actions_message', "registro modificado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "error al modificar el registro.", "alert alert-danger");
			}
			redirectURL("admin-ranking?id=".$id_ranking);
		}
	}

	public static function createCategoryAction(){
		if (isset($_POST['id_ranking']) and $_POST['id_ranking'] == 0){
			$id_ranking = 0;
			$rankings = new rankings();
			$nombre = str_replace("'","´",$_POST['nombre']);

			if ($rankings->insertRankingsCategory($nombre)) {
				session::setFlashMessage( 'actions_message', "registro insertado correctamente", "alert alert-success");
				$id_ranking = connection::SelectMaxReg("id_ranking", "users_tiendas_rankings");
			}
			else{
				session::setFlashMessage( 'actions_message', "error al insertar el registro.", "alert alert-danger");
			}
			redirectURL("admin-rankings-category?id=".$id_ranking);
		}			
	}

	public static function updateCategoryAction(){
		if (isset($_POST['id_ranking']) and $_POST['id_ranking'] > 0){
			$rankings = new rankings();
			$id_ranking = $_POST['id_ranking'];
			$nombre = str_replace("'","´",$_POST['nombre']);

			//cargar fichero
			self::uploadRankingData($_POST['id_ranking']);

			if ($rankings->updateRankingsCategory($id_ranking, $nombre)) {
				session::setFlashMessage( 'actions_message', "registro modificado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "error al modificar el registro.", "alert alert-danger");
			}
			redirectURL("admin-rankings-category?id=".$id_ranking);
		}
	}	

	public static function uploadRankingData($id_ranking){
		if (isset($_FILES['fichero']['name']) and $_FILES['fichero']['name'] != ""){
			//primero borramos los datos existentes
			$rankings = new rankings();
			$rankings->deleteRankingsData(" id_ranking=".$id_ranking);
			//SUBIR FICHERO		
			$tipo_archivo = strtoupper(substr($_FILES['fichero']['name'], strrpos($_FILES['fichero']['name'],".") + 1));
			$nombre_archivo = time().".".$tipo_archivo;
			//compruebo si las características del archivo son las que deseo
			if ($tipo_archivo!="XLS") {
				return false;
			}else{
				if (move_uploaded_file($_FILES['fichero']['tmp_name'], 'docs/cargas/'.$nombre_archivo)){				
					require_once 'docs/reader.php';
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('docs/cargas/'.$nombre_archivo);
					self::insertRankingData($data, $id_ranking);
					return true;			   
				}else{ return false;} 
			}
		}
	}

	public static function insertRankingData($data, $id_ranking){
		$rankings = new rankings();
		for($fila=2;$fila<=$data->sheets[0]['numRows'];$fila += 1){
			$cod_tienda = trim(strtoupper($data->sheets[0]['cells'][$fila][1]));
			$value_ranking = str_replace(",", ".", $data->sheets[0]['cells'][$fila][2]);

			if ($cod_tienda != ""){	
				$rankings->insertRankingsData( $id_ranking, $cod_tienda, $value_ranking );
			}
		}
	}	

	public static function ExportRankingDataAction(){
		if (isset($_REQUEST['exp']) and $_REQUEST['exp'] > 0){
			$rankings = new rankings();
			$elements = $rankings->getRankingsDataSimple(" AND id_ranking=".$_REQUEST['exp']." "); 
			exportCsv($elements);
		}
	}		
}
?>