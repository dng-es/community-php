<?php
class batallasController{
	public static function getListAction($reg = 0, $filter = ""){
		$batallas = new batallas();
		$filtro = $filter." ORDER BY date_batalla DESC ";

		$find_reg = (isset($_GET['f']) and $_GET['f']>0) ? $_GET['f'] : "";
		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("batallas",$filtro);
		return array('items' => $batallas->getBatallas($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportListAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$batallas = new batallas();
			$elements = $batallas->getBatallas(" ORDER BY date_batalla DESC ");
			download_send_headers( strTranslate("Battles") . "_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}  		
	}

	public static function responderBatallaAction(){
		if (isset($_POST['batalla-create']) and $_POST['batalla-create']==1){
			//insertar respuestas del usuario
			self::responderBatalla();
		}		
	}

	public static function responderContrincarioBatallaAction(){
		if (isset($_POST['batalla-play']) and $_POST['batalla-play']==1){
			//insertar respuestas del usuario
			self::responderBatalla();
		}		
	}

	public static function responderBatalla(){
		$batallas = new batallas();
		$id_batalla = (isset($_POST['id_batalla']) ? $_POST['id_batalla'] : 0) ;
		//obtener datos de la lucha del usuario
		$lucha = $batallas->getBatallasLuchas(" AND id_batalla=".$id_batalla. " AND user_lucha='".$_SESSION['user_name']."' ");

		//insertar respuestas del usuario
		$batallas->updateBatallaRespuesta($id_batalla, $_SESSION['user_name'], $_POST['id_pregunta1'], $_POST['respuesta1']);
		$batallas->updateBatallaRespuesta($id_batalla, $_SESSION['user_name'], $_POST['id_pregunta2'], $_POST['respuesta2']);
		$batallas->updateBatallaRespuesta($id_batalla, $_SESSION['user_name'], $_POST['id_pregunta3'], $_POST['respuesta3']);
		//$batallas->updateBatallaRespuesta($id_batalla, $_SESSION['user_name'], $_POST['id_pregunta4'], $_POST['respuesta4']);
		//$batallas->updateBatallaRespuesta($id_batalla, $_SESSION['user_name'], $_POST['id_pregunta5'], $_POST['respuesta5']);

		//comprobar aciertos
		//$tiempo_lucha = ($_POST['minutos']*60) + $_POST['segundos'] + ($_POST['decimas']/100);
		$tiempo_lucha = strtotime('now') - strtotime($lucha[0]['date_lucha']);
		$aciertos = 0;
		$acierto1 = $batallas->getBatallasPreguntas(" AND id_pregunta=".$_POST['id_pregunta1']." ");
		if ($_POST['respuesta1']==$acierto1[0]['valida']){$aciertos++;}
		$acierto2 = $batallas->getBatallasPreguntas(" AND id_pregunta=".$_POST['id_pregunta2']." ");
		if ($_POST['respuesta2']==$acierto2[0]['valida']){$aciertos++;}
		$acierto3 = $batallas->getBatallasPreguntas(" AND id_pregunta=".$_POST['id_pregunta3']." ");
		if ($_POST['respuesta3']==$acierto3[0]['valida']){$aciertos++;}
		//$acierto4 = $batallas->getBatallasPreguntas(" AND id_pregunta=".$_POST['id_pregunta4']." ");
		//if ($_POST['respuesta4']==$acierto4[0]['valida']){$aciertos++;}
		//$acierto5 = $batallas->getBatallasPreguntas(" AND id_pregunta=".$_POST['id_pregunta5']." ");
		//if ($_POST['respuesta5']==$acierto5[0]['valida']){$aciertos++;}

		//crear datos de la lucha
		$batallas->updateBatallaLucha($id_batalla,$_SESSION['user_name'],$tiempo_lucha,$aciertos);

		//datos del ganador
		$ganador = $batallas->getBatallas(" AND id_batalla=".$id_batalla);
	
		//texto del emnsaje al usuario
		$mensaje = "";
		if (isset($ganador[0]['ganador']) and $ganador[0]['ganador'] != "") {
		  	if ($ganador[0]['ganador'] == $_SESSION['user_name']){$mensaje = "Has ganado esta batalla.\n";}
		  	else {$mensaje = "Has perdido esta batalla.\n";}
		}

		if ($aciertos<2){
			$mensaje .= ' Ummm, solo has acertado '.$aciertos.' preguntas en un tiempo de '.$tiempo_lucha.' segundos';
			session::setFlashMessage( 'actions_message', $mensaje, "alert alert-warning");
		}
		else{
			$mensaje .= ' Has acertado '.$aciertos.' preguntas en un tiempo de '.$tiempo_lucha.' segundos';
			session::setFlashMessage( 'actions_message', $mensaje, "alert alert-success");
		}

		redirectURL("batallas");
	}

	public static function deleteBatallasCaducadasAction(){
		batallas::deleteBatallasCaducadas();
	}	
}
?>