<?php
class na_areasController{
	public static function getItemAction($id){
		$na_areas = new na_areas();
		return $na_areas->getAreas(" AND id_area=".$id." ");
	}

	public static function getListAction($reg = 0, $filtro = ""){
		$na_areas = new na_areas();
		$find_reg = "";
		if (isset($_POST['find_reg'])) {$filtro .= " AND area_nombre LIKE '%".$_POST['find_reg']."%' "; $find_reg = $_POST['find_reg'];}
		if (isset($_REQUEST['f'])) {$filtro .= " AND area_nombre LIKE '%".$_REQUEST['f']."%' "; $find_reg = $_REQUEST['f'];}
		$filtro .= " AND estado<>2  ORDER BY id_area DESC";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("na_areas", $filtro); 
		return array('items' => $na_areas->getAreas($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function updateAction(){
		$na_areas = new na_areas();
		$id_area = sanitizeInput($_POST['id_area']);
		$todos = (isset($_POST['area_todos']) and $_POST['area_todos'] == "on") ? 1 : 0;
		$nombre = sanitizeInput($_POST['area_nombre']);
		$descripcion = sanitizeInput($_POST['area_descripcion']);
		$registro = (isset($_POST['area_registro']) and $_POST['area_registro'] == "on") ? 1 : 0;
		$puntos = sanitizeInput($_POST['area_puntos']);
		$limite = sanitizeInput($_POST['area_limite']);
		$canal = $_POST['area_canal'];
		if (is_array($canal)) $canal = implode(",", $canal);

		if ($na_areas->updateArea($id_area, $nombre, $descripcion, $canal, $puntos, $limite, $registro, $todos)){
			$foro = new foro();
			//si existe el foro se actualiza, si no existe se crea
			if (connection::countReg("foro_temas"," AND id_area=".$id_area." AND id_tema_parent=0 ") > 0) 
				$foro->updateTemaArea($id_area, $nombre, $descripcion, $canal);
			else 
				$foro->InsertTema(0,'foro '.$nombre, $descripcion, "", $_SESSION['user_name'], $canal, 0, 1, '', $id_area);

			session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
		}
		else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
		
		redirectURL("admin-area?act=edit&id=".$_REQUEST['id_area']);
	}

	public static function insertAction(){
		$na_areas = new na_areas();
		$nombre = sanitizeInput($_POST['area_nombre']);
		$descripcion = sanitizeInput($_POST['area_descripcion']);
		$puntos = sanitizeInput($_POST['area_puntos']);
		$limite = sanitizeInput($_POST['area_limite']);
		$registro = (isset($_POST['area_registro']) and $_POST['area_registro'] == "on") ? 1 : 0;
		$todos = (isset($_POST['area_todos']) and $_POST['area_todos'] == "on") ? 1 : 0;
		$canal = $_POST['area_canal'];
		if (is_array($canal)) $canal = implode(",", $canal);

		if ($na_areas->insertArea($nombre, $descripcion, $canal, $puntos, $limite, 0, $registro, $todos)) {
			$id_area = connection::SelectMaxReg("id_area","na_areas","");

			//se crea su foro general si solo hay un canal. 
			if (count($canal) > 1){
				$foro = new foro();
				$foro->InsertTema(0,'foro '.$nombre, $descripcion, "", $_SESSION['user_name'], $canal, 0, 1, '', $id_area);
			}
			session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
		}
		else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

		redirectURL("admin-area?act=edit&id=".$id_area);
	}

	public static function getItemTareaAction($id){
		$na_areas = new na_areas();
		return $na_areas->getTareas(" AND id_tarea=".$id." ");
	}

	public static function RevisarFormAction(){
		$user_tarea = $_POST['user_rev'];
		$tarea_user = $_POST['id_tarea_rev'];
		$id_area = $_POST['id_area_rev'];
		$puntos = $_POST['puntos_rev'];
		$id_recompensa = $_POST['id_recompensa_rev'];
		self::revisarTarea($user_tarea, $tarea_user, $id_area, $puntos, $id_recompensa);
		redirectURL($_SERVER['REQUEST_URI']);
	}

	public static function revisarTarea($user_tarea, $tarea_user, $id_area, $puntos, $id_recompensa){
		$module_config = getModuleConfig("na_areas");
		$points_to_success = $module_config['options']['points_to_success'];
		$na_areas = new na_areas();
		if ($na_areas->RevisarTareaFormUser($user_tarea, $tarea_user, intval($puntos), 'admin')){
			//sumar puntos si la puntuacion es mayor o igual que $points_to_success
			if ($puntos >= $points_to_success){
				//obtener datos del area
				$area = $na_areas->getAreas(" AND id_area=".$id_area." ");
				$users = new users();
				$puntos = (count($area )> 0 ? $area[0]['puntos']: 0 );
				$users->sumarPuntos($user_tarea, $puntos, "Superación curso ID: ".$id_area);

				//enviar email al usuario. Primero hay que obtener sus datos
				$user_detail = usersController::getPerfilAction($user_tarea);
				self::emailTareaUser($user_detail, strTranslate("Task_ok_message"));

				//agregar recompensa
				if ($id_recompensa > 0){
					$recompensas = new recompensas();
					$recompensas->insertRecompensaUser($id_recompensa, $user_tarea, $_SESSION['user_name'], "Finalizacion tarea ID: ".$tarea_user);
				}
			}
			else{
				//enviar email al usuario. Primero hay que obtener sus datos
				$user_detail = usersController::getPerfilAction($user_tarea);
				self::emailTareaUser($user_detail, strTranslate("Task_ko_message"));
			}
		}
	}

	public static function uploadTareaAction(){
		if (isset($_POST['id_tarea']) and $_POST['id_tarea'] != ""){
			$na_areas = new na_areas();
			if($na_areas->insertTareaUser($_POST['id_area'],$_POST['id_tarea'],$_SESSION['user_name'],$_FILES['nombre-fichero'])) 
				session::setFlashMessage('actions_message', "Fichero envíado correctamente.", "alert alert-success");
			else 
				session::setFlashMessage('actions_message', "Se ha producido algún error en el envío del fichero.", "alert alert-danger");

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function activateAction(){
		//CAMBIAR ESTADO
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$na_areas = new na_areas();
			$estado = $_REQUEST['e'];
			if ($na_areas->estadoArea($_REQUEST['id'], $estado))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL('admin-areas');
		}
	}

	public static function exportAreasAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
			$na_areas = new na_areas();
			$elements = $na_areas->getAreas(" AND estado=1");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function exportUsersAreasAction(){
		if ((isset($_REQUEST['id']) and $_REQUEST['id'] != "") and !isset($_REQUEST['act'])){
			$na_areas = new na_areas();
			$elements = $na_areas->getAreasUsers(" AND id_area=".$_REQUEST['id']);
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
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
					session::setFlashMessage('actions_message', strTranslate("Enroll_successful"), "alert alert-success");
				else
					session::setFlashMessage('actions_message', strTranslate("Enroll_fail"), "alert alert-danger");
			else:
				session::setFlashMessage( 'actions_message', strTranslate("Enroll_limit_reached"), "alert alert-danger");
			endif;
			redirectURL("areas");
		}
	}

	public static function FinalizacionDeleteAction(){
		$na_areas = new na_areas();
		$elements = $na_areas->deleteFinalizacionForm($_REQUEST['id'],$_REQUEST['ut']);
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
			$nombre_grupo = '';
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
				if($pregunta['pregunta_tipo'] == 'texto') $respuesta_valor = $_POST["respuesta_".$pregunta['id_pregunta']];
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
					$respuesta_valor = substr($respuesta_valor, 0, (strlen($respuesta_valor) - 1));
				}
				$respuesta_valor = str_replace("'", "´", $respuesta_valor);
				$na_areas->insertRespuesta($pregunta['id_pregunta'], $_SESSION['user_name'], $respuesta_valor);
			endforeach; 
			
			if ($_POST['type-save'] == "1")
				self::finalizarFormAction($id_tarea);
			else
				session::setFlashMessage( 'actions_message', "Respuestas enviadas.", "alert alert-success");
			
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function finalizarFormAction($id_tarea){
		$na_areas = new na_areas();
		if($na_areas->insertFormulariosFinalizados($id_tarea, $_SESSION['user_name'])){
			
			//obtener datos de la tarea
			$tarea = $na_areas->getTareas(" AND id_tarea=".$id_tarea." ");
			$id_area = $tarea[0]['id_area'];
			$id_recompensa = $tarea[0]['id_recompensa'];
			
			//obtener datos de las preguntas
			$preguntas = $na_areas->getPreguntas(" AND id_tarea=".$id_tarea." AND pregunta_tipo<>'texto' ");
			$num_preguntas = count($preguntas);
			if ($num_preguntas > 0){
				//valorar respuestas
				$aciertos = 0;
				foreach($preguntas as $pregunta):
					if ($pregunta['pregunta_tipo']=='unica'){
						$respuestas = $na_areas->getRespuestas(" AND id_pregunta=".$pregunta['id_pregunta']." AND correcta=1 "); 
						$respuesta_user=$na_areas->getRespuestasUser(" AND id_pregunta=".$pregunta['id_pregunta']." AND respuesta_user='".$_SESSION['user_name']."' ");            
						foreach($respuestas as $respuesta):
							//echo $respuesta_user[0]['respuesta_valor'].' ***** '.$respuesta['respuesta_texto']."<br />";
							if ($respuesta_user[0]['respuesta_valor']==$respuesta['respuesta_texto']){
								$aciertos++;
								//echo "acierto: ".$pregunta['id_pregunta'];
							}
						endforeach;
					}
					elseif ($pregunta['pregunta_tipo']=='multiple'){
						$aciertos_multiples = 0;
						$respuestas = $na_areas->getRespuestas(" AND id_pregunta=".$pregunta['id_pregunta']." AND correcta=1 "); 
						$respuesta_user = $na_areas->getRespuestasUser(" AND id_pregunta=".$pregunta['id_pregunta']." AND respuesta_user='".$_SESSION['user_name']."' ");            
						$respuesta_multiple = explode("|",$respuesta_user[0]['respuesta_valor']);
						foreach($respuestas as $respuesta):
							if (in_array($respuesta['respuesta_texto'], $respuesta_multiple)) $aciertos_multiples++;
						endforeach;		

						//echo "aciertos mul: ".$aciertos_multiples." - respuestas: ".count($respuestas)." - resp.user: ".count($respuesta_multiple). "<br /> ";
						if ($aciertos_multiples == (count($respuestas)) and (count($respuestas) == count($respuesta_multiple)))	$aciertos++;		
					}
				endforeach;
				//calcular resultado final del cuestionario $puntos
				$puntos = ($aciertos / $num_preguntas) * 10;
				//echo "aciertos: ".$aciertos. " preg: ".$num_preguntas;

				//marcar cuestionario como revisado				
				self::revisarTarea($_SESSION['user_name'], $id_tarea, $id_area, $puntos, $id_recompensa);
			}

			session::setFlashMessage('actions_message', "Tarea finalizada correctamente. Próximamente podrás consultar la nota de tu evaluación.", "alert alert-success");
		}
		else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
	}

	public static function accesoAreaAction($id_area){
		$acceso = 1;
		if ($_SESSION['user_canal'] != 'admin')
			$acceso = connection::countReg("na_areas_users"," AND id_area=".$id_area." AND username_area='".$_SESSION['user_name']."' ");
		return $acceso;
	}
	
	public static function insertDocAction(){
		if (isset($_POST['id_tarea']) and $_POST['id_tarea'] != ""){
			$na_areas = new na_areas();
			$mensaje = $na_areas->insertTareaDoc($_POST['id_tarea'],$_POST['tipo'],$_POST['nombre-documento'],$_FILES['nombre-fichero'],$_POST['documento-link']);
			session::setFlashMessage('actions_message', $mensaje, "alert alert-warning");
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function deleteDocAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$na_areas = new na_areas();
			if($na_areas->deleteTareaDoc($_REQUEST['idd']))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-area-docs?a=".$_REQUEST['a']."&id=".$_REQUEST['id']);
		}
	}

	public static function inserGrupoAction(){
		if (isset($_POST['id_area_grupo']) and $_POST['id_area_grupo'] != ""){
			$na_areas = new na_areas();
			if($na_areas->insertGrupoArea($_POST['id_area_grupo'],$_POST['grupo_nombre']))
				session::setFlashMessage('actions_message', "Grupo creado correctamente.", "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL($_SERVER['REQUEST_URI']."&t=3");
		}
	}

	public static function inserTareaAction(){
		if (isset($_POST['id_area_tarea']) and $_POST['id_area_tarea'] != ""){
			$na_areas = new na_areas();
			if (isset($_POST['tarea_grupo']) and $_POST['tarea_grupo'] == 'on') $grupo = 1;
			else $grupo = 0;

			$descripcion = nl2br(str_replace("'", "´", $_POST['tarea_descripcion']));
			$titulo = sanitizeInput($_POST['tarea_titulo']);
			$tipo = sanitizeInput($_POST['tipo']);

			//SUBIR FICHERO
			if (isset($_FILES['fichero-tarea']) and $_FILES['fichero-tarea']['name'] != ""){
				$nombre_archivo = time().'_'.str_replace(" ", "_", $_FILES['fichero-tarea']['name']);
				$nombre_archivo = NormalizeText($nombre_archivo);		
				move_uploaded_file($_FILES['fichero-tarea']['tmp_name'], PATH_TAREAS.$nombre_archivo);
			}
			else $nombre_archivo = "";

			$id_recompensa = (isset($_POST['id_recompensa']) ? sanitizeInput($_POST['id_recompensa']) : 0);

			if($na_areas->insertTarea($_POST['id_area_tarea'], $titulo, $descripcion, $tipo, $grupo, $_SESSION['user_name'], $nombre_archivo, $id_recompensa))
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL($_SERVER['REQUEST_URI']."&t=2");
		}
	}

	public static function estadoTareaAction(){
		if (isset($_REQUEST['e']) and $_REQUEST['e'] != ""){
			$na_areas = new na_areas();
			if($na_areas->estadoTarea($_REQUEST['del_t'], $_REQUEST['e']))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger"); 

			redirectURL("admin-area?act=edit&t=2&id=".$_REQUEST['id']);
		}
	}

	public static function eliminarTareaAction(){
		if (isset($_REQUEST['del_t2']) and $_REQUEST['del_t2'] != ""){
			$na_areas = new na_areas();
			if($na_areas->estadoTarea($_REQUEST['del_t2'], 2))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-area?act=edit&t=2&id=".$_REQUEST['id']);
		}
	}

	public static function estadoLinksTareaAction(){
		if (isset($_REQUEST['el']) and $_REQUEST['el'] != ""){
			$na_areas = new na_areas();
			if($na_areas->estadoLinksTarea($_REQUEST['del_t'], $_REQUEST['el']))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-area?act=edit&t=2&id=".$_REQUEST['id']);
		}
	}

	public static function cambiarTipoTemaAction(){
		if (isset($_POST['find_tipo'])){
			$foro = new foro();
			if($foro->cambiarTipoTema($_POST['id_tema_tipo'],$_POST['find_tipo']))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-area?act=edit&t=4&id=".$_REQUEST['id']);
		}
	}

	public static function validarComentarioAction(){
		if (isset($_REQUEST['act2'])){
			$foro = new foro();
			$users = new users();
			if ($_REQUEST['act2'] == 'tema_ko')
				$foro->cambiarEstadoTema($_REQUEST['idt'], 0);
			elseif ($_REQUEST['act2'] == 'foro_ko'){
				$foro->cambiarEstado($_REQUEST['idc'],2);
				$users->restarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
			}
			session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-warning");
			redirectURL("admin-area?act=edit&t=4&id=".$_REQUEST['id']);
		}
	}

	public static function exportForoAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
			$foro = new foro();
			$elements = $foro->getComentariosExport(" AND c.id_tema=".$_REQUEST['idt']." ");
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function exportUsersAreaAction(){
		if (isset($_REQUEST['t']) and $_REQUEST['t'] == 1){
			$na_areas = new na_areas();
			$elements = $na_areas->getAreasUsers(" AND id_area=".$_REQUEST['id']);
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function insertPreguntaAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'new'){
			if (trim($_POST['pregunta_texto'])){
				$na_areas = new na_areas();
				$na_areas->insertPregunta($_REQUEST['id'],$_POST['pregunta_texto'],$_POST['pregunta_tipo']);
				$id_pregunta = connection::SelectMaxReg("id_pregunta","na_tareas_preguntas","");
				
				if ($_POST['pregunta_tipo'] != 'texto'){
					//INSERTAR PREGUNTA-RESPUESTA
					$num_repuestas=$_POST['contador-respuestas'];
					$resp_correcta = $_POST['radioRespuesta'];
					for ($i = 1; $i <= $num_repuestas; $i++){
						$campo_respuesta="respuesta".$i;
						$valor = trim($_POST[$campo_respuesta]);
						$valor = str_replace("'", "´", $valor);
						$valor = str_replace('"', '´', $valor);

						if ($_POST['pregunta_tipo']=='multiple'){
							$campo_correcta = "checkRespuesta".$i;
							$correcta = ((isset($_POST[$campo_correcta]) and $_POST[$campo_correcta]!='') ? 1 : 0);
						}
						if ($_POST['pregunta_tipo']=='unica'){
							$campo_correcta = "radioRespuesta1";
							$correcta = ((isset($_POST[$campo_correcta]) and $_POST[$campo_correcta]==$i) ? 1 : 0);
						}

						if ($valor != "") $na_areas->insertPreguntaRespuesta($id_pregunta, $valor, $correcta);
					}
				}
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}
			redirectURL("admin-area-form?a=".$_REQUEST['a']."&id=".$_REQUEST['id']);
		}
	}

	public static function deletePreguntaAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$na_areas = new na_areas();
			if ($na_areas->deletePregunta($_REQUEST['idp']))
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-area-form?a=".$_REQUEST['a']."&id=".$_REQUEST['id']);
		}
	}

	private static function emailTareaUser($user_detail, $msg_detail){
		global $ini_conf;
		$asunto = $ini_conf['SiteName'].': '.strTranslate("Task_title_message");
		$message_from = array($ini_conf['ContactEmail'] => $ini_conf['SiteName']);
		$message_to = array($user_detail['email']);

		$template = new tpl("tarea", "na_areas");
		$template->setVars(array(
					"title_email" => "Reto finalizado",
					"text_email" => $msg_detail
		));

		$cuerpo_mensaje = $template->getTpl();
		messageProcess($asunto, $message_from, $message_to , $cuerpo_mensaje, null, 'smtp');
	}
}
?>