<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
function ini_page_header ($ini_conf){
?>
<script language="JavaScript" src="<?php echo getAsset("na_areas");?>js/areas_form.js"></script>
<?php }
function ini_page_body ($ini_conf){ 
	//CONTROL NIVEL DE ACCESO
	$na_areas = new na_areas();
	$id_tarea=0;
	$id_area=0;
	if (isset($_REQUEST['id']) and $_REQUEST['id']!=0){$id_tarea = $_REQUEST['id'];}

	//OBTENER DATOS DE LA TAREA
	$tarea_datos = $na_areas->getTareas(" AND id_tarea=".$id_tarea." ");
	$id_area=$tarea_datos[0]['id_area'];
	$id_tarea=$tarea_datos[0]['id_tarea'];

	//OBTENCION DE LOS DATOS DEL AREA
	$area = $na_areas->getAreas(" AND id_area=".$id_area);

	//GUARDAR FORMULARIO
	if (isset($_POST['id_tarea']) and $_POST['id_tarea']!="") na_areasController::SaveFormAction();

	//FINALIZAR FORMULARIO
	if (isset($_REQUEST['d']) and $_REQUEST['d']==1) na_areasController::FinalizarFormAction($id_tarea);

	//VERIFICAR ACCESO AL FORMULARIO
	$acceso=1;
	if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador'){
		$acceso=$na_areas->countReg("na_areas_users"," AND id_area=".$id_area." AND username_area='".$_SESSION['user_name']."' ");
	}
		
	echo '<div id="page-info">Cursos de formación</div>';
	echo '<div class="row inset row-top">';
	echo '<div class="col-md-12">';

	session::getFlashMessage( 'actions_message' );

	echo '  <h3>'.$area[0]['area_nombre'].'</h3>
			<p>'.$area[0]['area_descripcion'].'</p>
			<p><a href="?page=areas_det&id='.$id_area.'" class="btn btn-primary">volver al curso</a></p><hr />';

	if($acceso==1){
		$elements=$na_areas->getPreguntas(" AND id_tarea=".$id_tarea." ");
		$finalizados=$na_areas->countReg("na_tareas_formularios_finalizados"," AND id_tarea=".$id_tarea." AND user_tarea='".$_SESSION['user_name']."' ");
		
		if ($finalizados>0){
			//obtener resultado de la valoracion
			$valoracion = $na_areas->getFormulariosFinalizados(" AND user_tarea='".$_SESSION['user_name']."' AND id_tarea=".$id_tarea);
			if (count($valoracion)>0){
				if ($valoracion[0]['revision']==1 and $valoracion[0]['puntos']>=7){ $msg = "Enhorabuena, has conseguido un <b>".$valoracion[0]['puntos']."</b> en este curso y acumulado <b>".$area[0]['puntos']."</b> horas de vuelo.";}
				if ($valoracion[0]['revision']==1 and $valoracion[0]['puntos']<7){ $msg = "Tu nota es de <b>".$valoracion[0]['puntos']."</b>,  no has conseguido superar el mínimo en este curso para conseguir horas de vuelo.";}
				if ($valoracion[0]['revision']==0){ $msg = "Tus respuestas serán revisadas por un tutor. Muy pronto podrás consultar la puntuación obtenida accediendo al curso.";}
			}
			echo '<div class="alert alert-info"><span class="fa fa-info-circle"></span> '.$msg.'</div>';
		}

		if (count($elements)>0){
			echo '<form action="" method="post" name="formTarea" id="formTarea" role="form" >
							<input type="hidden" id="id_tarea" name="id_tarea" value="'.$id_tarea.'" />';
			foreach($elements as $element):
				$respuesta_user=$na_areas->getRespuestasUser(" AND id_pregunta=".$element['id_pregunta']." AND respuesta_user='".$_SESSION['user_name']."' ");
				if  (count($respuesta_user) == 0) { $respuesta_user[0]['respuesta_valor'] = "";}
				echo '<div class="form-tarea-container">';
				echo '<h5><span class="fa fa-chevron-circle-right "></span> '.$element['pregunta_texto'].'</h5>
						<div>';
				if ($element['pregunta_tipo']=='texto'){
					echo '<textarea class="form-control" name="respuesta_'.$element['id_pregunta'].'">'.$respuesta_user[0]['respuesta_valor'].'</textarea>';
				}
				elseif ($element['pregunta_tipo']=='unica'){
					$respuestas=$na_areas->getRespuestas(" AND id_pregunta=".$element['id_pregunta']." ");             
					foreach($respuestas as $respuesta):
						if ($respuesta_user[0]['respuesta_valor']==$respuesta['respuesta_texto']){$seleccionado='checked="checked"';}
						else {$seleccionado="";}
						echo '<input '.$seleccionado.' type="radio" id="respuesta_'.$element['id_pregunta'].'" name="respuesta_'.$respuesta['id_pregunta'].'" value="'.$respuesta['respuesta_texto'].'" /> '.$respuesta['respuesta_texto']."<br />";
					endforeach;           
				}
				elseif ($element['pregunta_tipo']=='multiple'){
					$respuestas=$na_areas->getRespuestas(" AND id_pregunta=".$element['id_pregunta']." ");
					$respuesta_multiple = explode("|",$respuesta_user[0]['respuesta_valor']);
					foreach($respuestas as $respuesta):
						if (in_array($respuesta['respuesta_texto'],$respuesta_multiple)){$seleccionado='checked="checked"';}
						else {$seleccionado="";}
						echo '<input '.$seleccionado.' class="formTareaCheck" type="checkbox" id="respuesta_'.$element['id_pregunta'].'_'.$respuesta['id_respuesta'].'" name="respuesta_'.$element['id_pregunta'].'_'.$respuesta['id_respuesta'].'" value="'.$respuesta['respuesta_texto'].'" /> '.$respuesta['respuesta_texto']."<br />";
					endforeach;                
				}
				echo '</div>';
				echo '</div>';
			endforeach;
			if ($finalizados==0){
				echo '<br /><button id="SubmitForm" class="btn btn-primary" type="button">Guardar respuestas</button>';
				if (count($respuesta_user)>0){
					echo ' <button id="FinalizarForm" class="btn btn-primary" type="button">Finalizar tarea</button>';
				}
			}
			echo '</form>';
			if ($finalizados==0){
				echo '<br /><br /><div class="alert alert-warning">Asegúrate de haber contestado todas las preguntas correctamente antes de Finaliza tarea.</div>';
			}
		}
	}
	else{
		ErrorMsg("No tienes acceso a la sección");
	}

	echo '</div>';
	echo '</div>';   
 }
?>