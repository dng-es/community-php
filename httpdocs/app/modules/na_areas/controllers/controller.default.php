<?php
class na_areasController{

	public static function getListAction($reg = 0, $filter = ""){
		$na_areas = new na_areas();
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("na_areas",$filter); 
		return array('items' => $na_areas->getAreas($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id){
		$na_areas = new na_areas();
		return $na_areas->getAreas(" AND id_area=".$id." ");
	}

	public static function getItemTareaAction($id){
		$na_areas = new na_areas();
		return $na_areas->getTareas(" AND id_tarea=".$id." ");
	}

	public static function RevisarFormAction(){
		$module_config = getModuleConfig("na_areas");
		$points_to_success = $module_config['options']['points_to_success'];

		$na_areas = new na_areas();
		$user_tarea = $_POST['user_rev'];
		$tarea_user = $_POST['id_tarea_rev'];
		$id_area = $_POST['id_area_rev'];
		$puntos = $_POST['puntos_rev'];
		if ($na_areas->RevisarTareaFormUser($user_tarea,$tarea_user,$puntos,$_SESSION['user_name'])){
			//sumar horas de vuelo si la puntuacion es mayor o igual que $points_to_success
			if ($puntos >= $points_to_success){
				//obtener datos del area
				$area = $na_areas->getAreas(" AND id_area=".$id_area." ");
				$users = new users();
				$puntos = (count($area)>0 ? $area[0]['puntos']: 0 );
				$users->sumarPuntos($user_tarea,$puntos,"Superación curso ID: ".$id_area);
			}
		}
		redirectURL($_SERVER['REQUEST_URI']);		
	}

	public static function uploadTareaAction(){
		if (isset($_POST['id_tarea']) and $_POST['id_tarea'] != ""){
			$na_areas = new na_areas();
			if($na_areas->insertTareaUser($_POST['id_area'],$_POST['id_tarea'],$_SESSION['user_name'],$_FILES['nombre-fichero'])){
				session::setFlashMessage( 'actions_message', "Fichero envíado correctamente.", "alert alert-success");
			} 
			else{ 
				session::setFlashMessage( 'actions_message', "Se ha producido algún error en el envío del fichero.", "alert alert-danger");
			}		
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function apuntarseAction(){
		if (isset($_REQUEST['id']) and $_REQUEST['id'] != ""){
			$id_area = $_REQUEST['id'];
			$na_areas = new na_areas();
			//verificar si ya se ha alcanzado el limite de usuarios
			$datos_area = $na_areas->getAreas(" AND id_area=".$id_area." ");
			$limite_users = $datos_area[0]['limite_users'];
			$total_users = connection::countReg("na_areas_users"," AND id_area=".$id_area." ");
			if ($total_users<$limite_users):	
				if ($na_areas->insertUserArea($id_area,$_SESSION['user_name']))
					session::setFlashMessage( 'actions_message', strTranslate("Enroll_successful"), "alert alert-success");  
				else
					session::setFlashMessage( 'actions_message', strTranslate("Enroll_fail"), "alert alert-danger");
			else:
				session::setFlashMessage( 'actions_message', strTranslate("Enroll_limit_reached"), "alert alert-danger");
			endif;
			redirectURL("areas");   
		}
	}

	public static function FinalizacionDeleteAction(){
		$na_areas = new na_areas();
		$elements=$na_areas->deleteFinalizacionForm($_REQUEST['id'],$_REQUEST['ut']);
		redirectURL("admin-area-revs?a=".$_REQUEST['a']."&id=".$_REQUEST['id']);	
	}

	public static function ExportFormUserAction(){
		$na_areas = new na_areas();
		$elements = $na_areas->getRespuestasUserAdmin(" AND p.id_tarea=".$_REQUEST['id']." and r.respuesta_user='".$_REQUEST['t']."' ");
		download_send_headers("data_" . date("Y-m-d") . ".csv");
		echo array2csv($elements);
		die();
	}

	public static function ExportFileUserAction(){
		$na_areas = new na_areas();
		$elements = $na_areas->getTareasUserExport($_REQUEST['id'],$_REQUEST['a']);
		download_send_headers("data_" . date("Y-m-d") . ".csv");
		echo array2csv($elements);
		die();
	}

	public static function validateRevAction(){
		$na_areas = new na_areas();
		$id_tarea_user = $_REQUEST['idr'];
		$na_areas->RevisarTareaUser($id_tarea_user,$_SESSION['user_name']);
	}	

	public static function ExportFormAllAction(){
		$na_areas = new na_areas();
		$elements = $na_areas->getFormulariosFinalizados(" AND id_tarea=".$_REQUEST['id']." ORDER BY user_tarea"); 
		$file_name = 'exported_file'.date("YmdGis");

		$final = array();
		foreach($elements as $element):
			//nombre del grupo
			$nombre_grupo='';
			if (count($grupos = $na_areas->getUsuarioGrupoTarea($_REQUEST['id'],$_REQUEST['a']," AND grupo_username='".$element['user_tarea']."' ")) > 0){
				 $nombre_grupo = $grupos[0]['grupo_nombre'];
			}	
			$element['nombre_grupo'] = $nombre_grupo;

			//respuestas del usuario
			$respuestas = $na_areas -> getFormulariosFinalizadosRespuestas($element['id_tarea'],$element['user_tarea']);
			$i=1;
			foreach($respuestas as $respuesta):
				$pregunta_texto = "pregunta".$i;
				$element[$pregunta_texto]=$respuesta['respuesta_valor'];
				$i++;
			endforeach;    
			array_push($final, $element);
		endforeach;
		download_send_headers("data_" . date("Y-m-d") . ".csv");
		echo array2csv($final);
		die();
	}	

	public static function saveFormAction(){
	    if (isset($_POST['id_tarea']) and $_POST['id_tarea'] != ""){
			$na_areas = new na_areas();
			$id_tarea = $_POST['id_tarea'];
			$preguntas = $na_areas->getPreguntas(" AND id_tarea=".$id_tarea." ");
			foreach($preguntas as $pregunta):

			  if($pregunta['pregunta_tipo'] == 'texto'){
			    $respuesta_valor = $_POST["respuesta_".$pregunta['id_pregunta']];
			  }
			  elseif($pregunta['pregunta_tipo'] == 'unica'){
			    $respuesta_valor = "";
			    $respuesta_valor = $_POST["respuesta_".$pregunta['id_pregunta']];
			  }
			  elseif($pregunta['pregunta_tipo'] == 'multiple'){
			    $respuesta_valor = "";
			    $respuestas_usuario = $na_areas->getRespuestas(" AND id_pregunta=".$pregunta['id_pregunta']." ");
			    foreach($respuestas_usuario as $respuesta_usuario):
			      $campo = "respuesta_".$pregunta['id_pregunta']."_".$respuesta_usuario['id_respuesta'];  
			      if (isset($_POST[$campo]) and $_POST[$campo] != ''){$respuesta_valor .= $_POST[$campo]."|";}
			    endforeach;
			    $respuesta_valor = substr($respuesta_valor, 0,(strlen($respuesta_valor)-1));
			  }
			  
			  $respuesta_valor = str_replace("'", "´", $respuesta_valor);
			  $na_areas->insertRespuesta($pregunta['id_pregunta'],$_SESSION['user_name'],$respuesta_valor);
			endforeach; 
			session::setFlashMessage( 'actions_message', "Respuestas enviadas.", "alert alert-success");
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}	

	public static function finalizarFormAction($id_tarea){
		if (isset($_REQUEST['d']) and $_REQUEST['d'] == 1){
			$na_areas = new na_areas();
			if($na_areas->insertFormulariosFinalizados($id_tarea,$_SESSION['user_name'])){
				session::setFlashMessage( 'actions_message', "Tarea finalizada correctamente. Próximamente podrás consultar la nota de tu evaluación.", "alert alert-success");
			}
			else{ session::setFlashMessage( 'actions_message', "Se ha producido algún error al finalizar la tarea.", "alert alert-danger");}    
			redirectURL("areas_form?id=".$id_tarea);
		}
	}

	public static function accesoAreaAction($id_area){
		$acceso=1;
		if ($_SESSION['user_perfil'] != 'admin' and $_SESSION['user_perfil'] != 'formador'){
			$acceso = connection::countReg("na_areas_users"," AND id_area=".$id_area." AND username_area='".$_SESSION['user_name']."' ");
		}
		return $acceso;
	}
	
	public static function insertDocAction(){
		if (isset($_POST['id_tarea']) and $_POST['id_tarea'] != ""){ 
			$na_areas = new na_areas();
			$mensaje = $na_areas->insertTareaDoc($_POST['id_tarea'],$_POST['tipo'],$_POST['nombre-documento'],$_FILES['nombre-fichero'],$_POST['documento-link']);
			session::setFlashMessage( 'actions_message', $mensaje, "alert alert-warning"); 
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function deleteDocAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del') { 
			$na_areas = new na_areas();
			if($na_areas->deleteTareaDoc($_REQUEST['idd'])){
				session::setFlashMessage( 'actions_message', "Documento eliminado correctamente.", "alert alert-success"); 
			}
			else {
				session::setFlashMessage( 'actions_message', "Error al eliminar el documento.", "alert alert-danger"); 
			}
			redirectURL("admin-area-docs?a=".$_REQUEST['a']."&id=".$_REQUEST['id']);
		}
	}
}
?>