<?php
class cuestionariosController{
	public static function getListAction($reg = 0, $filtro=""){
		$cuestionarios = new cuestionarios();
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("cuestionarios",$filtro); 
		return array('items' => $cuestionarios->getCuestionarios($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $paginator_items['find_reg'],
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id, $filter=""){
		$cuestionarios = new cuestionarios();
		return $cuestionarios->getCuestionarios(" AND id_cuestionario=".$id.$filter);
	}	

	public static function createAction(){
		if (isset($_POST['id_cuestionario']) and $_POST['id_cuestionario']==0){
			$id_cuestionario = 0;
			$cuestionarios = new cuestionarios();
			$nombre = sanitizeInput($_POST['nombre']);
			$descripcion = sanitizeInput($_POST['descripcion']);
			if ($cuestionarios->insertCuestionarios($nombre, $descripcion)) {
				session::setFlashMessage( 'actions_message', "Registro insertado correctamente", "alert alert-success");
				$id_cuestionario = connection::SelectMaxReg("id_cuestionario", "cuestionarios");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al insertar el registro.", "alert alert-danger");
			}
			redirectURL("?page=admin-cuestionario&id=".$id_cuestionario);
		}			
	}

	public static function updateAction(){
		if (isset($_POST['id_cuestionario']) and $_POST['id_cuestionario']>0){
			$cuestionarios = new cuestionarios();
			$id_cuestionario = sanitizeInput($_POST['id_cuestionario']);
			$nombre = sanitizeInput($_POST['nombre']);
			$descripcion = sanitizeInput($_POST['descripcion']);
			if ($cuestionarios->updateCuestionarios($id_cuestionario, $nombre, $descripcion)) {
				session::setFlashMessage( 'actions_message', "Registro modificado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar el registro.", "alert alert-danger");
			}
			redirectURL("?page=admin-cuestionario&id=".$id_cuestionario);
		}
	}			

	public static function insertPreguntaAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='new') { 
			if (trim($_POST['pregunta_texto'])){
				$cuestionarios = new cuestionarios();
				$id_cuestionario = sanitizeInput($_REQUEST['id']);
				$cuestionarios->insertPregunta($id_cuestionario,$_POST['pregunta_texto'],$_POST['pregunta_tipo']);
				$id_pregunta = connection::SelectMaxReg("id_pregunta","cuestionarios_preguntas","");
				
				if ($_POST['pregunta_tipo']!='texto'){
					//INSERTAR PREGUNTA-RESPUESTA
					$num_repuestas=$_POST['contador-respuestas'];
					for ($i=1; $i <=$num_repuestas; $i++) { 
						$campo_respuesta = "respuesta".$i;
						$valor = trim($_POST[$campo_respuesta]);
						$valor = str_replace("'", "´", $valor);
						$valor = str_replace('"', '´', $valor);
						if ($valor!=""){$cuestionarios->insertPreguntaRespuesta($id_pregunta,$valor);}
					}
				}
				session::setFlashMessage( 'actions_message', "Pregunta insertada correctamente.", "alert alert-success");
				redirectURL($_SERVER['REQUEST_URI']);
			}
		}
	}	

	public static function deletePreguntaAction(){
		$cuestionarios = new cuestionarios();
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del') { 
			if ($cuestionarios->deletePregunta($_REQUEST['idp'])){
				session::setFlashMessage( 'actions_message', "Registro eliminado correctamente.", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al eliminar el registro.", "alert alert-danger");
			}
			redirectURL("?page=admin-cuestionario&id=".$_REQUEST['id']);
		}	
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del') {
			$cuestionarios = new cuestionarios();
			if ($cuestionarios->deleteCuestionarios($_REQUEST['id'], $_REQUEST['e'])) {
				session::setFlashMessage( 'actions_message', "Estado modificado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar estado.", "alert alert-danger");
			}
			redirectURL("?page=admin-cuestionarios");
		}
	}	

	public static function cloneAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'clone') {
			$cuestionarios = new cuestionarios();
			//datos del cuestionario original
			$cuestionario = self::getItemAction($_REQUEST['id']);
			if ($cuestionarios->insertCuestionarios($cuestionario[0]['nombre']." - Clon", $cuestionario[0]['descripcion'], $cuestionario[0]['checklist'])) {
				$id_cuestionario = connection::SelectMaxReg("id_cuestionario","cuestionarios","");
				//
				$preguntas = $cuestionarios->getPreguntas(" AND id_cuestionario=".$_REQUEST['id']." ");
				foreach($preguntas as $pregunta):
					//insertar nueva pregunta
					$cuestionarios->insertPregunta($id_cuestionario,$pregunta['pregunta_texto'],$pregunta['pregunta_tipo']);
					$id_pregunta = connection::SelectMaxReg("id_pregunta","cuestionarios_preguntas","");
					$respuestas = $cuestionarios->getRespuestas(" AND id_pregunta=".$pregunta['id_pregunta']." ");
					//insertar respuestas de la pregunta
					foreach($respuestas as $respuesta):
						$cuestionarios->insertPreguntaRespuesta($id_pregunta,$respuesta['respuesta_texto']);
					endforeach;
				endforeach;
				session::setFlashMessage( 'actions_message', "Registro clonado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al clonar el registro.", "alert alert-danger");
			}
			redirectURL("?page=admin-cuestionarios");
		}
	}	

	public static function saveFormAction(){
	    if (isset($_POST['id_cuestionario']) and $_POST['id_cuestionario']!=""){
			$cuestionarios = new cuestionarios();
			$id_cuestionario = sanitizeInput($_POST['id_cuestionario']);
			$preguntas=$cuestionarios->getPreguntas(" AND id_cuestionario=".$id_cuestionario." ");
			foreach($preguntas as $pregunta):

			  if($pregunta['pregunta_tipo'] == 'texto'){
			    $respuesta_valor=$_POST["respuesta_".$pregunta['id_pregunta']];
			  }
			  elseif($pregunta['pregunta_tipo'] == 'unica'){
			    $respuesta_valor="";
			    $respuesta_valor=$_POST["respuesta_".$pregunta['id_pregunta']];
			  }
			  elseif($pregunta['pregunta_tipo'] == 'multiple'){
			    $respuesta_valor = "";
			    $respuestas_usuario=$cuestionarios->getRespuestas(" AND id_pregunta=".$pregunta['id_pregunta']." ");
			    foreach($respuestas_usuario as $respuesta_usuario):
			      $campo="respuesta_".$pregunta['id_pregunta']."_".$respuesta_usuario['id_respuesta'];  
			      if (isset($_POST[$campo]) and $_POST[$campo]!=''){$respuesta_valor.=$_POST[$campo]."|";}
			    endforeach;
			    $respuesta_valor=substr($respuesta_valor, 0,(strlen($respuesta_valor)-1));
			  }
			  
			  $respuesta_valor = str_replace("'", "´", $respuesta_valor);
			  $cuestionarios->insertRespuesta($pregunta['id_pregunta'],$_SESSION['user_name'],$respuesta_valor);
			endforeach; 
			session::setFlashMessage( 'actions_message', "Respuestas enviadas.", "alert alert-success");
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}	

	public static function finalizarFormAction($id_cuestionario){
		if (isset($_REQUEST['d']) and $_REQUEST['d'] == 1){
			$cuestionarios = new cuestionarios();
			if($cuestionarios->insertFormulariosFinalizados($id_cuestionario,$_SESSION['user_name'])){
				session::setFlashMessage( 'actions_message', "Cuestionario finalizado correctamente. Próximamente podrás consultar la nota de tu evaluación.", "alert alert-success");
			}
			else{ session::setFlashMessage( 'actions_message', "Se ha producido algún error al finalizar el cuestionario.", "alert alert-danger");}    
			redirectURL("?page=cuestionario&id=".$id_cuestionario);
		}
	}	

	public static function RevisarFormAction(){
		if ( isset($_POST['id_tarea_rev']) and $_POST['id_tarea_rev'] != '' ){
			$cuestionarios = new cuestionarios();
			$user_tarea = sanitizeInput($_POST['user_rev']);
			$tarea_user = sanitizeInput($_POST['id_tarea_rev']);
			$puntos = sanitizeInput($_POST['puntos_rev']);
			if ($cuestionarios->RevisarTareaFormUser($user_tarea,$tarea_user,$puntos,$_SESSION['user_name'])){
				session::setFlashMessage( 'actions_message', "Cuestionario revisado correctamente.", "alert alert-success");
			}
			else{ session::setFlashMessage( 'actions_message', "Se ha producido algún error al revisar el cuestionario.", "alert alert-danger");}    
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}	

	public static function FinalizacionDeleteAction(){
		if (isset($_REQUEST['act_f']) and $_REQUEST['act_f'] == "del"){
			$cuestionarios = new cuestionarios();
			$cuestionarios->deleteFinalizacionForm($_REQUEST['id']," AND user_tarea='".$_REQUEST['ut']."'");
			redirectURL("?page=admin-cuestionario-revs&id=".$_REQUEST['id']);	
		}
	}

	public static function ExportFormUserAction(){
		if (isset($_REQUEST['t']) and $_REQUEST['t'] != ""){
			$cuestionarios = new cuestionarios();
			$elements = $cuestionarios->getRespuestasUserAdmin(" AND p.id_cuestionario=".$_REQUEST['id']." and r.respuesta_user='".$_REQUEST['t']."' ");
			download_send_headers("data_export_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function ExportFormAllAction(){
		if (isset($_REQUEST['t3']) and $_REQUEST['t3'] == "1"){
			$cuestionarios = new cuestionarios();
			$elements=$cuestionarios->getFormulariosFinalizados(" AND id_cuestionario=".$_REQUEST['id']." ORDER BY user_tarea"); 
			$file_name='exported_file'.date("YmdGis");

			$final = array();
			foreach($elements as $element):
				//respuestas del usuario
				$respuestas = $cuestionarios -> getFormulariosFinalizadosRespuestas($element['id_cuestionario'],$element['user_tarea']);
				$i=1;
				foreach($respuestas as $respuesta):
					$pregunta_texto = "pregunta".$i;
					$element[$pregunta_texto]=$respuesta['respuesta_valor'];
					$i++;
				endforeach;    
				array_push($final, $element);
			endforeach;
			download_send_headers("data_export_" . date("Y-m-d") . ".csv");
			echo array2csv($final);
			die();
		}
	}

	public static function deleteCuestionarioAction($id_cuestionario){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == "del"){
			$cuestionarios = new cuestionarios();
			//eliminar finalizaciones
			$cuestionarios->deleteFinalizacionForm($_REQUEST['id'],"");
			//eliminar respuestas

			if ($cuestionarios->deleteRespuestasForm($_REQUEST['id'],"")){
				session::setFlashMessage( 'actions_message', "Cuestionario vaciado correctamente.", "alert alert-success");
			}
			else{ session::setFlashMessage( 'actions_message', "Se ha producido algún error al vaciar el cuestionario.", "alert alert-danger");}    
			redirectURL("?page=admin-cuestionario-revs&id=".$id_cuestionario);
		}
	}
}
?>