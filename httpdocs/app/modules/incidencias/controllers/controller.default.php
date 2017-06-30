<?php
class incidenciasController{
	public static function getItemAction($id, $filter){
		$incidencias = new incidencias();
		$element = array();
		$elements = $incidencias->getIncidencias(" AND  id_incidencia=".$id." ".$filter);

		if (isset($elements[0])) {
			$element = $elements[0];
			$estados = incidenciasController::getListEstadosAction(9999, " AND id_incidencia=".$id." ");
			$element['estados'] = $estados['items'];
		}
		else{
			$element['date_incidencia'] = '';
			$element['texto_incidencia'] = '';
			$element['estado_incidencia'] = '';
			$element['solucion_incidencia'] = '';
			$element['estados'] = array();
		}
		return $element;
	}

	public static function getListAction($reg = 0, $filter = ""){
		$incidencias = new incidencias();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND (texto_incidencia LIKE '%".$find_reg."%' OR id_incidencia='".$find_reg."') ";
		
		$find_reg2 = "";
		if (isset($_REQUEST['f2']) && $_REQUEST['f2'] != '') {
			$filter .= " AND estado_incidencia=".$_REQUEST['f2']." ";
			$find_reg2 = $_REQUEST['f2'];
		} 
		$filter .= " ORDER BY date_incidencia DESC";
		$paginator_items = PaginatorPages($reg);

		$totales = connection::countReg("incidencias ","");
		$pendientes = connection::countReg("incidencias "," AND estado_incidencia=0 ");
		$canceladas = connection::countReg("incidencias "," AND estado_incidencia=2 ");
		$finalizadas = connection::countReg("incidencias "," AND estado_incidencia=1 ");
		
		$total_reg = connection::countReg("incidencias",$filter);
		return array('items' => $incidencias->getIncidencias($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'find_reg2' 	=> $find_reg2,
					'totales' 	=> $totales,
					'pendientes' 	=> $pendientes,
					'canceladas' 	=> $canceladas,
					'finalizadas' 	=> $finalizadas,
					'total_reg' => $total_reg);
	}

	public static function getListEstadosAction($reg = 0, $filter = ""){
		$incidencias = new incidencias();
		$find_reg = getFindReg();
		$filter .= " ORDER BY date_estado_cambio DESC";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = connection::countReg("incidencias_estados",$filter);
		return array('items' => $incidencias->getIncidenciasEstados($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportListAction($filter){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$incidencias = new incidencias();
			$elements = $incidencias->getIncidenciasExport($filter);
			download_send_headers("incidencias" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}	

	public static function createAction(){
		if (isset($_POST['id']) && $_POST['id'] == 0):
			$incidencias = new incidencias();
			$texto_incidencia = sanitizeInput(trim($_POST['texto_incidencia']));
			$id = 0;
			if ($texto_incidencia == ''){
				session::setFlashMessage('actions_message', "Datos incompletos", "alert alert-warning");
			}
			else{
				if ($incidencias->insertIncidencias($_SESSION['user_name'], $texto_incidencia)) {
					session::setFlashMessage('actions_message',  strTranslate("Insert_procesing"), "alert alert-success");
					$id = connection::SelectMaxReg("id_incidencia","incidencias"," AND username_incidencia='".$_SESSION['user_name']."' ");
					$incidencias->insertIncidenciaEstado($id, $_SESSION['user_name'], 0);
					
					//envio de emails
					global $ini_conf;
					$usuario = usersController::getPerfilAction($_SESSION['user_name']);
					$mensaje_user = "<p>La incidencia ".sprintf("%04d", $id)." se ha creado correctamente. En breve nos pondremos en contacto contigo.</p>
						<p>Incidencia:</p>".nl2br($texto_incidencia);
					self::emailAction($usuario['email'], "Nueva incidencia", $mensaje_user);
					
					$mensaje_support = "<p>Nueva incidencia ".sprintf("%04d", $id)." creada. Datos de la incidencia:</p>
						Usuario: ".$usuario['username']."<br />
						Nombre: ".$usuario['name']."<br />
						Apellidos: ".$usuario['surname']."<br />
						Email: ".$usuario['email']."<br />
						Incidencia :".nl2br($texto_incidencia);
					self::emailAction($ini_conf['MailingEmail'], "Nueva incidencia", $mensaje_support);
				}
				else
					session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}

			redirectURL("incidence?id=".$id);
		endif;
	}

	public static function updateAction(){
		if (isset($_POST['id']) && $_POST['id'] > 0):
			$incidencias = new incidencias();
			$texto_incidencia = sanitizeInput(trim($_POST['texto_incidencia']));
			$id = intval($_POST['id']);
			if ($texto_incidencia == ''){
				session::setFlashMessage('actions_message', "Datos incompletos", "alert alert-warning");
			}
			else{
				if ($incidencias->updateIncidencias($id, $_SESSION['user_name'], $texto_incidencia)){
					if (isset($_REQUEST['a']) && $_REQUEST['a'] >= 0){
						self::changeEstadoAction($id, intval($_REQUEST['a']), true, " AND username_incidencia='".$_SESSION['user_name']."' ");
					}
					session::setFlashMessage('actions_message',  strTranslate("Update_procesing"), "alert alert-success");
				} 
				else
					session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}

			redirectURL("incidence?id=".$id);
		endif;	
	}

	// public static function cancelAction(){
	// 	if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
	// 		$incidencias = new incidencias();
	// 		$id_incidencia = intval($_REQUEST['id']);
	// 		self::changeEstadoAction($id_incidencia, 2, true, '');
	// 		$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
	// 		$find_reg = (isset($_REQUEST['f']) ? $_REQUEST['f'] : "");
	// 		redirectURL("admin-incidences?pag=".$pag."&f=".$find_reg);
	// 	}
	// }

	// public static function estadosAction($filter = "", $destination = "admin-incidence"){
	// 	if (isset($_REQUEST['e']) && $_REQUEST['e'] >= 0){
	// 		$incidencias = new incidencias();
	// 		$estado_incidencia = intval($_REQUEST['e']);
	// 		$id_incidencia = intval($_REQUEST['id']);
	// 		if ($incidencias->estadoIncidencia($id_incidencia, $estado_incidencia, $filter)) {
	// 			$incidencias->insertIncidenciaEstado($id_incidencia, $_SESSION['user_name'], $estado_incidencia);
	// 			session::setFlashMessage('actions_message',  strTranslate("Update_procesing"), "alert alert-success");
	// 			self::changeEstadoAction($id_incidencia, $estado_incidencia, true, $filter);
	// 		}
	// 		else{
	// 			session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
	// 		}
	// 		$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
	// 		$find_reg = (isset($_REQUEST['f']) ? $_REQUEST['f'] : "");
	// 		redirectURL($destination."?id=".$id_incidencia);
	// 	}
	// }

	public static function updateAdminAction($filter = "", $destination = "admin-incidence"){
		if (isset($_POST['solucion_incidencia']) && $_POST['solucion_incidencia'] >= 0){
			$incidencias = new incidencias();
			$solucion_incidencia = sanitizeInput($_POST['solucion_incidencia']);
			$categoria_incidencia = sanitizeInput($_POST['categoria_incidencia']);
			$id_incidencia = intval($_POST['id']);
			$enviar_email = (isset($_POST['enviar_email']) && $_POST['enviar_email'] == "on") ? 1 : 0;
			if ($incidencias->updateAdminIncidencias($id_incidencia, $solucion_incidencia, $categoria_incidencia, $filter)) {
				session::setFlashMessage('actions_message',  strTranslate("Update_procesing"), "alert alert-success");
				if (isset($_REQUEST['a']) && $_REQUEST['a'] >= 0)self::changeEstadoAction($id_incidencia, intval($_REQUEST['a']), true, "");
				elseif($enviar_email) self::emailEstadoAction($id_incidencia, $estado_incidencia);
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = $find_reg = getFindReg();
			redirectURL($destination."?id=".$id_incidencia);
		}
	}

	public static function changeEstadoAction($id_incidencia, $estado_incidencia, $envio_emails = true, $filter = ""){
		$incidencias = new incidencias();
		if ($incidencias->estadoIncidencia($id_incidencia, $estado_incidencia, $filter)) {
			$incidencias->insertIncidenciaEstado($id_incidencia, $_SESSION['user_name'], $estado_incidencia);
			session::setFlashMessage('actions_message',  strTranslate("Update_procesing"), "alert alert-success");
			if ($envio_emails) self::emailEstadoAction($id_incidencia, $estado_incidencia);
		}
		else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
	}

	public static function emailEstadoAction($id_incidencia, $estado_incidencia){
		//envio de email usuario. Obtener datos de la incidencia y del destinatario
		$incidencia_data = self::getItemAction($id_incidencia);
		$estado_incidencia = ($incidencia_data['estado_incidencia'] == 0 ? "pasada a pendiente" : ($incidencia_data['estado_incidencia'] == 1 ? "finalizada" : "cancelada"));
		$usuario = usersController::getPerfilAction($incidencia_data['username_incidencia']);
		$mensaje_user = "<p>La incidencia ".sprintf("%04d", $id_incidencia)." ha sido ".$estado_incidencia.".</p>
			<p><b>Incidencia</b>:</p>".nl2br($incidencia_data['texto_incidencia'])."
			<p><b>Solución</b>:</p>".nl2br($incidencia_data['solucion_incidencia']);
		self::emailAction($usuario['email'], "Incidencia ".$estado_incidencia, $mensaje_user);

		//envio de email soporte.
		global $ini_conf;
		return self::emailAction($ini_conf['MailingEmail'], "Incidencia ".$estado_incidencia, $mensaje_user);
	}		
	
	public static function emailAction($destinatario, $titulo, $mensaje){
		global $ini_conf;
		$asunto = strtoupper($ini_conf['SiteName']).': '.$titulo;
		$message_from = array($ini_conf['MailingEmail'] => $ini_conf['SiteName']);
		$message_to = array($destinatario);

		$template = new tpl("incidencia", "incidencias");
		$template->setVars(array(
					"title_email" => $titulo,
					"text_email" => $mensaje
		));
		$cuerpo_mensaje = $template->getTpl();

		if (messageProcess($asunto, $message_from, $message_to , $cuerpo_mensaje, null, 'smtp')) return true;
		else return false;
	}
}
?>