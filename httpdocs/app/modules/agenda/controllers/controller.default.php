<?php
class agendaController{
	public static function getListAction($reg = 0, $filter=""){
		$agendas = new agenda();
		$find_reg = "";
		if (isset($_POST['find_reg'])){
			$filter = " AND (titulo LIKE '%".$_POST['find_reg']."%' OR etiquetas LIKE '%".$_POST['find_reg']."%') ".$filter;
			$find_reg = $_POST['find_reg'];
		}
		if (isset($_REQUEST['f'])){
			$filter = " AND (titulo LIKE '%".$_REQUEST['f']."%' OR etiquetas LIKE '%".$_REQUEST['f']."%') ".$filter;
			$find_reg = $_REQUEST['f'];
		}

		$paginator_items = PaginatorPages($reg);

		$total_reg = connection::countReg("agenda", $filter);
		return array('items' => $agendas->getAgenda($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id){
		$agenda = new agenda();
		return $agenda->getAgenda(" AND id_agenda='".$id."' ");
	}

	public static function exportAction(){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$agenda = new agenda();
			$elements = $agenda->getAgenda(" ORDER BY id_agenda DESC ");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function deleteAgendaAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'):
			$id_agenda = intval($_REQUEST['id']);
			$agenda = new agenda();
			if ($agenda->deleteAgenda($id_agenda))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-agenda");
		endif;
	}

	public static function createAction(){
		if (isset($_POST['id']) && $_POST['id'] == 0){
			$agenda = new agenda();
			$id = 0;
			$activo = intval((isset($_POST['activo']) && $_POST['activo'] == '1') ? 1 : 0);
			$etiquetas = sanitizeInput($_POST["etiquetas"]);
			$tipo = sanitizeInput($_POST['tipo']);
			$date_ini = sanitizeInput($_POST['date_ini']);
			$date_fin = sanitizeInput($_POST['date_fin']);
			$canal = sanitizeInput($_POST['canal']);
			if (is_array($canal)) $canal = implode(",", $canal);

			if ((isset($_FILES['fichero'])) && ($_FILES['fichero']['name'] != '')){
				//SUBIR FICHERO
				$nombre_archivo = time().'_'.str_replace(" ", "_", $_FILES['fichero']['name']);
				$nombre_archivo = strtolower($nombre_archivo);
				$nombre_archivo = NormalizeText($nombre_archivo);

				if (!move_uploaded_file($_FILES['fichero']['tmp_name'], PATH_INFO.$nombre_archivo)){
					session::setFlashMessage('actions_message', "Ocurrió algún error al subir el contenido. No pudo guardarse el archivo.", "alert alert-danger");
					redirectURL("admin-agenda-new?act=new");
				}
			}
			else $nombre_archivo = "";


			if ($agenda->insertActividad(sanitizeInput($_POST['nombre']), sanitizeInput(stripslashes($_POST['descripcion'])), $_FILES['banner'], $date_ini, $date_fin, $nombre_archivo, $tipo,$canal, $activo, $etiquetas)) {

				$id = connection::SelectMaxReg("id_agenda", "agenda", " ");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-agenda-new?id=".$id);
		}
	}

	public static function updateAction(){
		if ((isset($_POST['id'])) && ($_POST['id'] > 0)){
			$agenda = new agenda();
			$id = sanitizeInput($_POST['id']);
			$activo = ((isset($_POST['activo']) && $_POST['activo'] == '1') ? 1 : 0);
			$etiquetas = sanitizeInput($_POST["etiquetas"]);
			$tipo = sanitizeInput($_POST['tipo']);
			$date_ini = sanitizeInput($_POST['date_ini']);
			$date_fin = sanitizeInput($_POST['date_fin']);
			$canal = $_POST['canal'];
			if (is_array($canal)) $canal = implode(",", $canal);

			if ((isset($_FILES['fichero'])) && ($_FILES['fichero']['name'] != '')){
				//SUBIR FICHERO
				$nombre_archivo = time().'_'.str_replace(" ","_",$_FILES['fichero']['name']);
				$nombre_archivo = strtolower($nombre_archivo);
				$nombre_archivo = NormalizeText($nombre_archivo);
				if (!move_uploaded_file($_FILES['fichero']['tmp_name'], PATH_INFO.$nombre_archivo)){
					session::setFlashMessage('actions_message', "Ocurrió algún error al subir el contenido. No pudo guardarse el archivo.", "alert alert-danger");
					redirectURL("admin-agenda-new?act=new");
				}
			}
			else $nombre_archivo = "";

			if ($agenda->updateActividad($_POST['id'],sanitizeInput($_POST['nombre']), sanitizeInput(stripslashes($_POST['descripcion'])),$_FILES['banner'], $date_ini, $date_fin, $nombre_archivo , $tipo, $canal, $activo, $etiquetas)){
				$id = connection::SelectMaxReg("id_agenda", "agenda", " ");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-agenda-new?id=".$_POST['id']);
		}
	}
}
?>