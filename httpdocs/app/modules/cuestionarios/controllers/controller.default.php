<?php
class cuestionariosController{
	public static function getListAction($reg = 0, $filter = ""){
		$cuestionarios = new cuestionarios();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND nombre LIKE '%".$find_reg."%' ";
		$filter .= " ORDER BY id_cuestionario DESC";
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("cuestionarios", $filter);
		return array('items' => $cuestionarios->getCuestionarios($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemAction($id, $filter = ""){
		$cuestionarios = new cuestionarios();
		return $cuestionarios->getCuestionarios(" AND id_cuestionario=".$id.$filter);
	}

	public static function createAction(){
		if (isset($_POST['id_cuestionario']) && $_POST['id_cuestionario'] == 0){
			$id_cuestionario = 0;
			$cuestionarios = new cuestionarios();
			$nombre = sanitizeInput($_POST['nombre']);
			$descripcion = sanitizeInput($_POST['descripcion']);
			if ($cuestionarios->insertCuestionarios($nombre, $descripcion)){
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				$id_cuestionario = connection::SelectMaxReg("id_cuestionario", "cuestionarios");
			}
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-cuestionario?id=".$id_cuestionario);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id_cuestionario']) && $_POST['id_cuestionario'] > 0){
			$cuestionarios = new cuestionarios();
			$id_cuestionario = intval($_POST['id_cuestionario']);
			$nombre = sanitizeInput($_POST['nombre']);
			$descripcion = sanitizeInput($_POST['descripcion']);
			if ($cuestionarios->updateCuestionarios($id_cuestionario, $nombre, $descripcion)) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-cuestionario?id=".$id_cuestionario);
		}
	}

	public static function insertPreguntaAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'new'){
			if (trim($_POST['pregunta_texto'])){
				$cuestionarios = new cuestionarios();
				$id_cuestionario = intval($_REQUEST['id']);
				$cuestionarios->insertPregunta($id_cuestionario, $_POST['pregunta_texto'], $_POST['pregunta_tipo']);
				$id_pregunta = connection::SelectMaxReg("id_pregunta", "cuestionarios_preguntas", "");
				
				if ($_POST['pregunta_tipo'] != 'texto'){
					//INSERTAR PREGUNTA-RESPUESTA
					$num_repuestas=$_POST['contador-respuestas'];
					for ($i = 1; $i <= $num_repuestas; $i++){ 
						$campo_respuesta = "respuesta".$i;
						$valor = trim($_POST[$campo_respuesta]);
						$valor = str_replace("'", "´", $valor);
						$valor = str_replace('"', '´', $valor);

						if ($_POST['pregunta_tipo'] == 'multiple'){
							$campo_correcta = "checkRespuesta".$i;
							$correcta = ((isset($_POST[$campo_correcta]) && $_POST[$campo_correcta] != '') ? 1 : 0);
						}
						if ($_POST['pregunta_tipo'] == 'unica'){
							$campo_correcta = "radioRespuesta1";
							$correcta = ((isset($_POST[$campo_correcta]) && $_POST[$campo_correcta] == $i) ? 1 : 0);
						}

						if ($valor != "") $cuestionarios->insertPreguntaRespuesta($id_pregunta, $valor, $correcta);
					}
				}
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
				redirectURL($_SERVER['REQUEST_URI']);
			}
		}
	}

	public static function deletePreguntaAction(){
		$cuestionarios = new cuestionarios();
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$idp = intval($_REQUEST['idp']);
			$id = intval($_REQUEST['id']);
			if ($cuestionarios->deletePregunta($idp))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-cuestionario?id=".$id);
		}
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$cuestionarios = new cuestionarios();
			if ($cuestionarios->deleteCuestionarios(intval($_REQUEST['id']), intval($_REQUEST['e'])))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-cuestionarios");
		}
	}

	public static function cloneAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'clone'){
			$cuestionarios = new cuestionarios();
			//datos del cuestionario original
			$id = intval($_REQUEST['id']);
			$cuestionario = self::getItemAction($id);
			if ($cuestionarios->insertCuestionarios($cuestionario[0]['nombre']." - Clon", $cuestionario[0]['descripcion'], $cuestionario[0]['checklist'])){
				$id_cuestionario = connection::SelectMaxReg("id_cuestionario", "cuestionarios","");
				$preguntas = $cuestionarios->getPreguntas(" AND id_cuestionario=".$id." ");
				foreach($preguntas as $pregunta):
					//insertar nueva pregunta
					$cuestionarios->insertPregunta($id_cuestionario, $pregunta['pregunta_texto'], $pregunta['pregunta_tipo']);
					$id_pregunta = connection::SelectMaxReg("id_pregunta","cuestionarios_preguntas","");
					$respuestas = $cuestionarios->getRespuestas(" AND id_pregunta=".$pregunta['id_pregunta']." ");
					//insertar respuestas de la pregunta
					foreach($respuestas as $respuesta):
						$cuestionarios->insertPreguntaRespuesta($id_pregunta, $respuesta['respuesta_texto']);
					endforeach;
				endforeach;
				session::setFlashMessage('actions_message', "Registro clonado correctamente", "alert alert-success");
			}
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-cuestionarios");
		}
	}

	public static function saveFormAction(){
		if (isset($_POST['id_cuestionario']) && $_POST['id_cuestionario'] != ""){
			$cuestionarios = new cuestionarios();
			$id_cuestionario = intval($_POST['id_cuestionario']);
			$preguntas=$cuestionarios->getPreguntas(" AND id_cuestionario=".$id_cuestionario." ");
			foreach($preguntas as $pregunta):

				if($pregunta['pregunta_tipo'] == 'texto')
					$respuesta_valor = $_POST["respuesta_".$pregunta['id_pregunta']];
				elseif($pregunta['pregunta_tipo'] == 'unica'){
					$respuesta_valor = "";
					$respuesta_valor = $_POST["respuesta_".$pregunta['id_pregunta']];
				}
				elseif($pregunta['pregunta_tipo'] == 'multiple'){
					$respuesta_valor = "";
					$respuestas_usuario = $cuestionarios->getRespuestas(" AND id_pregunta=".$pregunta['id_pregunta']." ");
					foreach($respuestas_usuario as $respuesta_usuario):
						$campo = "respuesta_".$pregunta['id_pregunta']."_".$respuesta_usuario['id_respuesta'];  
						if (isset($_POST[$campo]) && $_POST[$campo] != '') $respuesta_valor .= $_POST[$campo]."|";
					endforeach;
					$respuesta_valor=substr($respuesta_valor, 0, (strlen($respuesta_valor) - 1));
				}

				$respuesta_valor = str_replace("'", "´", $respuesta_valor);
				$cuestionarios->insertRespuesta($pregunta['id_pregunta'], $_SESSION['user_name'], $respuesta_valor);
			endforeach; 
			if ($_POST['type-save'] == "1") self::finalizarFormAction($id_cuestionario);
			else session::setFlashMessage( 'actions_message', "Respuestas enviadas.", "alert alert-success");

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function finalizarFormAction($id_cuestionario){
		$cuestionarios = new cuestionarios();
		if($cuestionarios->insertFormulariosFinalizados($id_cuestionario, $_SESSION['user_name'])){
			//obtener datos de las preguntas
			$preguntas = $cuestionarios->getPreguntas(" AND id_cuestionario=".$id_cuestionario." AND pregunta_tipo<>'texto' ");
			$num_preguntas = count($preguntas);
			if ($num_preguntas > 0){
				//valorar respuestas
				$aciertos = 0;
				foreach($preguntas as $pregunta):
					if ($pregunta['pregunta_tipo'] == 'unica'){
						$respuestas = $cuestionarios->getRespuestas(" AND id_pregunta=".$pregunta['id_pregunta']." AND correcta=1 "); 
						$respuesta_user = $cuestionarios->getRespuestasUser(" AND id_pregunta=".$pregunta['id_pregunta']." AND respuesta_user='".$_SESSION['user_name']."' ");
						foreach($respuestas as $respuesta):
							if ($respuesta_user[0]['respuesta_valor'] == $respuesta['respuesta_texto']) $aciertos++;
						endforeach;
					}
					elseif ($pregunta['pregunta_tipo'] == 'multiple'){
						$aciertos_multiples = 0;
						$respuestas = $cuestionarios->getRespuestas(" AND id_pregunta=".$pregunta['id_pregunta']." AND correcta=1 "); 
						$respuesta_user = $cuestionarios->getRespuestasUser(" AND id_pregunta=".$pregunta['id_pregunta']." AND respuesta_user='".$_SESSION['user_name']."' ");            
						$respuesta_multiple = explode("|",$respuesta_user[0]['respuesta_valor']);
						foreach($respuestas as $respuesta):
							if (in_array($respuesta['respuesta_texto'], $respuesta_multiple)) $aciertos_multiples++;
						endforeach;

						//echo "aciertos mul: ".$aciertos_multiples." - respuestas: ".count($respuestas)." - resp.user: ".count($respuesta_multiple). "<br /> ";
						if ($aciertos_multiples == (count($respuestas)) && (count($respuestas) == count($respuesta_multiple)))	$aciertos++;
					}
				endforeach;
				//calcular resultado final del cuestionario $puntos
				$puntos = ($aciertos / $num_preguntas) * 10;
				//echo "aciertos: ".$aciertos. " preg: ".$num_preguntas;

				//marcar cuestionario como revisado				
				$cuestionarios->RevisarTareaFormUser($_SESSION['user_name'], $id_cuestionario, intval($puntos), 'admin');
			}

			session::setFlashMessage( 'actions_message', "Cuestionario finalizado correctamente. Próximamente podrás consultar la nota de tu evaluación.", "alert alert-success");
		}
		else session::setFlashMessage( 'actions_message', "Se ha producido algún error al finalizar el cuestionario.", "alert alert-danger");
	}

	public static function RevisarFormAction(){
		if ( isset($_POST['id_tarea_rev']) && $_POST['id_tarea_rev'] != '' ){
			$cuestionarios = new cuestionarios();
			$user_tarea = sanitizeInput($_POST['user_rev']);
			$tarea_user = sanitizeInput($_POST['id_tarea_rev']);
			$puntos = sanitizeInput($_POST['puntos_rev']);
			if ($cuestionarios->RevisarTareaFormUser($user_tarea, $tarea_user, $puntos, $_SESSION['user_name']))
				session::setFlashMessage('actions_message', "Cuestionario revisado correctamente.", "alert alert-success");
			else
				session::setFlashMessage('actions_message', "Se ha producido algún error al revisar el cuestionario.", "alert alert-danger");

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function FinalizacionDeleteAction(){
		if (isset($_REQUEST['act_f']) && $_REQUEST['act_f'] == "del"){
			$cuestionarios = new cuestionarios();
			$id = intval($_REQUEST['id']);
			$ut = sanitizeInput($_REQUEST['ut']);
			$cuestionarios->deleteFinalizacionForm($id, " AND user_tarea='".$ut."'");
			redirectURL("admin-cuestionario-revs?id=".$id);
		}
	}

	public static function ExportFormUserAction(){
		if (isset($_REQUEST['t']) && $_REQUEST['t'] != ""){
			$cuestionarios = new cuestionarios();
			$id = intval($_REQUEST['id']);
			$t = sanitizeInput($_REQUEST['t']);
			$elements = $cuestionarios->getRespuestasUserAdmin(" AND p.id_cuestionario=".$id." AND r.respuesta_user='".$t."' ");
			download_send_headers("data_export_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function ExportFormAllAction(){
		if (isset($_REQUEST['t3']) && $_REQUEST['t3'] == "1"){
			$cuestionarios = new cuestionarios();
			$id = intval($_REQUEST['id']);
			$elements=$cuestionarios->getFormulariosFinalizados(" AND id_cuestionario=".$id." ORDER BY user_tarea"); 
			$file_name='exported_file'.date("YmdGis");
			$num_preguntas = connection::countReg("cuestionarios_preguntas", " AND id_cuestionario=".$id." ");

			$final = array();
			foreach($elements as $element):
				//respuestas del usuario
				$respuestas = $cuestionarios -> getFormulariosFinalizadosRespuestas($element['id_cuestionario'], $element['user_tarea']);
				for($i=0; $i < $num_preguntas; $i++){
					$pregunta_texto = "pregunta".($i + 1);
					$element[$pregunta_texto] = (isset($respuestas[$i]['respuesta_valor']) ? $respuestas[$i]['respuesta_valor'] : "");
				}
				array_push($final, $element);
			endforeach;
			download_send_headers("data_export_" . date("Y-m-d") . ".csv");
			echo array2csv($final);
			die();
		}
	}

	public static function deleteCuestionarioAction($id_cuestionario){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == "del"){
			$cuestionarios = new cuestionarios();
			$id = intval($_REQUEST['id']);
			//eliminar finalizaciones
			$cuestionarios->deleteFinalizacionForm($id, "");
			//eliminar respuestas

			if ($cuestionarios->deleteRespuestasForm($id, ""))
				session::setFlashMessage('actions_message', "Cuestionario vaciado correctamente.", "alert alert-success");
			else
				session::setFlashMessage('actions_message', "Se ha producido algún error al vaciar el cuestionario.", "alert alert-danger");

			redirectURL("admin-cuestionario-revs?id=".$id_cuestionario);
		}
	}
}
?>