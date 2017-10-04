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
			if (isset($_REQUEST['date_ini'])and $_REQUEST['date_ini']<>""){
				$date1 = str_replace('/', '-', trim(sanitizeInput($_REQUEST['date_ini'])));
				$date_ini = date("Y-m-d H:i:s",strtotime($date1));

				$fecha_ini=" AND l.date_lucha>='".$date_ini."'";
			}
			if (isset($_REQUEST['date_fin'])and $_REQUEST['date_fin']<>""){
				$date2 = str_replace('/', '-', trim(sanitizeInput($_REQUEST['date_fin'])));
				$date_fin = date("Y-m-d H:i:s",strtotime($date2));
				$fecha_fin = " AND l.date_lucha<='".$date_fin."'";
			}
			//Export Resumen
			if (isset($_REQUEST['r']) && $_REQUEST['r'] == true){
				//Se extrae el total de preguntas.
				$elements=$batallas->getBatallasPreguntas("ORDER BY id_pregunta ASC ");
				//Se extrae las veces que se han utilizado las preguntas.
				$usos = $batallas->getBatallasCount(" AND p.id_pregunta = r.batalla_pregunta ".$fecha_ini.$fecha_fin." GROUP BY r.batalla_pregunta ORDER BY p.id_pregunta ASC ","usos");
				//Se extrae las veces que se han acertado las preguntas.
				$aciertos=$batallas->getBatallasCount(" AND p.id_pregunta = r.batalla_pregunta AND p.valida=r.batalla_respuesta ".$fecha_ini.$fecha_fin." GROUP BY r.batalla_pregunta ORDER BY pregunta ASC","aciertos");
				//Se extrae las veces que se han fallado las preguntas.
				$fallos=$batallas->getBatallasCount(" AND p.id_pregunta = r.batalla_pregunta AND p.valida<>r.batalla_respuesta ".$fecha_ini.$fecha_fin." GROUP BY r.batalla_pregunta ORDER BY pregunta ASC","fallos");

				$elements= self::getListPreguntas($elements,$usos,$aciertos,$fallos);

			}
			//Export Detallado
			elseif (isset($_REQUEST['d']) && $_REQUEST['d'] == true){

				//Se extrae las veces que se han utilizado las preguntas.
				$usos = $batallas->getBatallasCount(" AND p.id_pregunta = r.batalla_pregunta ".$fecha_ini.$fecha_fin." GROUP BY r.batalla_pregunta,r.`username_batalla` ORDER BY p.id_pregunta ASC ","usos");
				//Se extrae las veces que se han acertado las preguntas.
				$aciertos=$batallas->getBatallasCount(" AND p.id_pregunta = r.batalla_pregunta AND p.valida=r.batalla_respuesta ".$fecha_ini.$fecha_fin." GROUP BY r.batalla_pregunta,r.`username_batalla` ORDER BY pregunta ASC","aciertos");

				//Se extrae las veces que se han fallado las preguntas.
				$fallos=$batallas->getBatallasCount(" AND p.id_pregunta = r.batalla_pregunta AND p.valida<>r.batalla_respuesta ".$fecha_ini.$fecha_fin." GROUP BY r.batalla_pregunta,r.`username_batalla` ORDER BY pregunta ASC","fallos");

				$elements= self::getListPreguntasUsers($usos,$aciertos,$fallos);

			}
			elseif (isset($_REQUEST['id']) && $_REQUEST['id'] <>''){
				$id=$_REQUEST['id'];
				//Se extrae las veces que se han utilizado las preguntas.
				$usos = $batallas->getBatallasCount(" AND p.id_pregunta = r.batalla_pregunta ".$fecha_ini.$fecha_fin." AND p.id_pregunta=".$_REQUEST['id']." GROUP BY r.batalla_pregunta,r.`username_batalla` ORDER BY p.id_pregunta ASC ","usos");
				//Se extrae las veces que se han acertado las preguntas.
				$aciertos=$batallas->getBatallasCount(" AND p.id_pregunta = r.batalla_pregunta AND p.valida=r.batalla_respuesta ".$fecha_ini.$fecha_fin." AND p.id_pregunta=".$_REQUEST['id']." GROUP BY r.batalla_pregunta,r.`username_batalla` ORDER BY pregunta ASC","aciertos");

				//Se extrae las veces que se han fallado las preguntas.
				$fallos=$batallas->getBatallasCount(" AND p.id_pregunta = r.batalla_pregunta AND p.valida<>r.batalla_respuesta ".$fecha_ini.$fecha_fin." AND p.id_pregunta=".$_REQUEST['id']." GROUP BY r.batalla_pregunta,r.`username_batalla` ORDER BY pregunta ASC","fallos");

				$elements= self::getListPreguntasUsers($usos,$aciertos,$fallos);

			}
			download_send_headers( strTranslate("Battles")."_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function activeAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$batallas = new batallas();
			$id_pregunta = sanitizeInput($_REQUEST['id']);
			$estado = (sanitizeInput($_REQUEST['a']) == 1 ? 0 : 1);
			if ($batallas->estadoPregunta($id_pregunta, $estado))
				session::setFlashMessage('actions_message', "Estado cambiado correctamente.", "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = getFindReg();
			redirectURL("admin-batallas-preguntas?pag=".$pag."&f=".$find_reg);
		}
	}

	public static function activeAllAction(){
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del'){
			$batallas = new batallas();
			$pregunta_tipo = sanitizeInput($_REQUEST['id']);
			$estado = sanitizeInput($_REQUEST['a']);
			if ($batallas->estadoPreguntastipo($pregunta_tipo, $estado))
				session::setFlashMessage('actions_message', "Estado cambiado correctamente.", "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			$pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : "");
			$find_reg = getFindReg();
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

	public static function getListPreguntas($elements,$usos,$aciertos,$fallos){
	//Externalizar para dinamizar esto cuando esté todo hecho
		for ($j=0; $j < count($elements) ; $j++) {
			//Se añaden los usos
			$t=0;
			while (($elements[$j]['id_pregunta']<>$usos[$t]['id_pregunta'])and ($t<=count($usos))){
				$t++;
			}
			$elements[$j]['usos'] = (isset($usos[$t]['usos'])AND $usos[$t]['usos']<>'') ? $usos[$t]['usos'] : 0;

			//Se añaden los aciertos
			$i=0;
			while (($elements[$j]['id_pregunta']<>$aciertos[$i]['id_pregunta'])and ($i<=count($aciertos))){
				$i++;
			}

			$elements[$j]['aciertos'] = (isset($aciertos[$i]['aciertos'])AND $aciertos[$i]['aciertos']<>'') ? $aciertos[$i]['aciertos'] : 0;

			//Se añaden los fallos
			$k=0;
			while (($elements[$j]['id_pregunta']<>$fallos[$k]['id_pregunta'])and ($k<=count($fallos))){
				$k++;
			}

			$elements[$j]['fallos'] = (isset($fallos[$k]['fallos'])AND $fallos[$k]['fallos']<>'') ? $fallos[$k]['fallos'] : 0;
			// if (($aciertos[$i]['id_pregunta']==63)AND ($usos[$t]['username']=='odelgado')){
			// 	echo "hola".$usos[$t]['username'].$aciertos[$i]['username'].$fallos[$k]['username'];
			// die;
			// }

		}

		$elements[0]["fechas: ". $_REQUEST['date_ini']." - ".$_REQUEST['date_fin'].""]='';

		return $elements;
	}

	public static function getListPreguntasUsers($usos,$aciertos,$fallos){
	//Externalizar para dinamizar esto cuando esté todo hecho
		for ($j=0; $j < count($usos) ; $j++) {
			//Se añaden los usos

			//Se añaden los aciertos
			$i=0;
			while ((($usos[$j]['id_pregunta']<>$aciertos[$i]['id_pregunta'])or ($usos[$j]['username']<>$aciertos[$i]['username'])) and ($i<=count($aciertos))){
				$i++;
			}

			$usos[$j]['aciertos'] = ((isset($aciertos[$i]['aciertos'])AND $aciertos[$i]['aciertos']<>'')and ($i<=count($aciertos))) ? $aciertos[$i]['aciertos'] : 0;

			//Se añaden los fallos
			$k=0;
			while ((($usos[$j]['id_pregunta']<>$fallos[$k]['id_pregunta'])or ($usos[$j]['username']<>$fallos[$k]['username'])) and  ($k<=count($fallos))){
				$k++;
			}
			// if (($usos[$j]['username']=='admin')and ($usos[$j]['id_pregunta']==2)){
			// 	echo $usos[$j]['id_pregunta'] . $usos[$j]['username'] . $fallos[$k]['id_pregunta'] . $fallos[$k]['username'];
			// 	die;
			//}

			$usos[$j]['fallos'] = ((isset($fallos[$k]['fallos'])AND $fallos[$k]['fallos']<>'')AND ($k<=count($fallos))) ? $fallos[$k]['fallos'] : 0;


			// if (($aciertos[$i]['id_pregunta']==63)AND ($usos[$t]['username']=='odelgado')){
			// 	echo "hola".$usos[$t]['username'].$aciertos[$i]['username'].$fallos[$k]['username'];
			// die;
			// }

		}

		$usos[0]["fechas: ". $_REQUEST['date_ini']." - ".$_REQUEST['date_fin'].""]='';

		return $usos;
	}


}
?>