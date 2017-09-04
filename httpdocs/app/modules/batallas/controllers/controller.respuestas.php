<?php
class batallasRespuestasController{
	public static function getListAction($reg = 0, $filter = ""){
		$batallas = new batallas();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= "AND pregunta LIKE '%".$find_reg."%' ";
		$filter .= " ORDER BY pregunta ASC ";
		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("batallas_preguntas", $filter);
		return array('items' => $batallas->getBatallasPreguntas($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$batallas = new batallas();
			$elements = $batallas->getBatallasPreguntas(" ORDER BY pregunta ASC ");
			download_send_headers( strTranslate("Battles") . "_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function activeAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$batallas = new batallas();
			$id_pregunta = sanitizeInput($_REQUEST['id']);
			$estado = (sanitizeInput($_REQUEST['a']) == 1 ? 0 : 1);
			if ($batallas->estadoPregunta($id_pregunta, $estado)) {
				session::setFlashMessage('actions_message', "Estado cambiado correctamente.", "alert alert-success");
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = (isset($_REQUEST['f']) ? $_REQUEST['f'] : "");
			redirectURL("admin-batallas-preguntas?pag=".$pag."&f=".$find_reg);
		}
	}

	public static function activeAllAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$batallas = new batallas();
			$pregunta_tipo = sanitizeInput($_REQUEST['id']);
			$estado = sanitizeInput($_REQUEST['a']);
			if ($batallas->estadoPreguntastipo($pregunta_tipo, $estado)) {
				session::setFlashMessage('actions_message', "Estado cambiado correctamente.", "alert alert-success");
			}
			else session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = (isset($_REQUEST['f']) ? $_REQUEST['f'] : "");
			redirectURL("admin-batallas-preguntas-tipos?pag=".$pag."&f=".$find_reg);
		}
	}	

	public static function volcarMySQLPreguntas($data){
		try {
			$batallas = new batallas();
			$contador_insert = 0;
			$contador_ko = 0;

			for($fila = 2;$fila <= $data->sheets[0]['numRows']; $fila += 1){
				$pregunta_tipo = utf8_encode(sanitizeInput(trim(str_replace('"', '\"', $data->sheets[0]['cells'][$fila][1]))));
				$pregunta = utf8_encode(sanitizeInput(trim(str_replace('"', '\"', $data->sheets[0]['cells'][$fila][2]))));
				$respuesta1 = utf8_encode(sanitizeInput(trim(str_replace('"', '\"', $data->sheets[0]['cells'][$fila][3]))));
				$respuesta2 = utf8_encode(sanitizeInput(trim(str_replace('"', '\"', $data->sheets[0]['cells'][$fila][4]))));
				$respuesta3 = ucfirst(utf8_encode(sanitizeInput(trim(str_replace('"', '\"', $data->sheets[0]['cells'][$fila][5])))));
				$valida = (int)$data->sheets[0]['cells'][$fila][6];
				$canal_pregunta = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][7])));

				if ($pregunta != ""){
					//insertar pregunta
					if ($batallas->insertBatallaPregunta($pregunta_tipo, $pregunta, $respuesta1, $respuesta2, $respuesta3, $valida, $canal_pregunta)) $contador_insert++;
					else $contador_ko++;
				}
			}

			echo date("Y-m-d H:i:s")." El proceso de importación ha finalizado con éxito\n";
			echo date("Y-m-d H:i:s")." Se ha insertado ".$contador_insert." registros\n";			
			echo date("Y-m-d H:i:s")." Errores ".$contador_ko." registros\n";						
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function getListTypesAction($reg = 0, $filter = ""){
		$batallas = new batallas();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= "AND pregunta_tipo LIKE '%".$find_reg."%' ";
		$filter .= " ORDER BY pregunta_tipo ASC ";
		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("batallas_preguntas", $filter, 'DISTINCT pregunta_tipo');
		return array('items' => $batallas->getBatallaCategorias($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}	
}
?>