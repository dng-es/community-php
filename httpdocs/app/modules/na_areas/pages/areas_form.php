<?php
$module_config = getModuleConfig("na_areas");
$points_to_success = $module_config['options']['points_to_success'];

addJavascripts(array(getAsset("na_areas")."js/areas_form.js"));
$id_tarea = ((isset($_REQUEST['id']) and $_REQUEST['id'] != 0) ? $_REQUEST['id'] : 0);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		session::getFlashMessage( 'actions_message' );
		na_areasController::saveFormAction();
		na_areasController::finalizarFormAction($id_tarea);
		$tarea = na_areasController::getItemTareaAction($id_tarea);
		$id_area = ( isset($tarea[0]['id_area']) ? $tarea[0]['id_area'] : 0 );
		$acceso = na_areasController::accesoAreaAction($id_area);
		$area = na_areasController::getItemAction($id_area);

		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Na_areas"), "ItemUrl"=>"areas"),
			array("ItemLabel"=>$area[0]['area_nombre'], "ItemUrl"=>"areas_det?id=".$id_area),
			array("ItemLabel"=> $tarea[0]['tarea_titulo'], "ItemClass"=>"active"),
		));

		if($acceso==1){
			echo '<p>'.$area[0]['area_descripcion'].'</p>
				<hr />';

			$na_areas = new na_areas();
			$elements = $na_areas->getPreguntas(" AND id_tarea=".$id_tarea." ");
			$finalizados = connection::countReg("na_tareas_formularios_finalizados"," AND id_tarea=".$id_tarea." AND user_tarea='".$_SESSION['user_name']."' ");
			
			if ($finalizados>0){
				//obtener resultado de la valoracion
				$valoracion = $na_areas->getFormulariosFinalizados(" AND user_tarea='".$_SESSION['user_name']."' AND id_tarea=".$id_tarea);
				if (count($valoracion)>0){
					if ($valoracion[0]['revision'] == 1 and $valoracion[0]['puntos'] >= $points_to_success){ $msg = strTranslate("Na_areas_congratulations")." <b>".$valoracion[0]['puntos']."</b> ".strTranslate("Na_areas_congratulations2")."<b>".$area[0]['puntos']."</b> ".strTranslate("APP_points").".";}
					if ($valoracion[0]['revision'] == 1 and $valoracion[0]['puntos'] < $points_to_success){ $msg = "Tu nota es de <b>".$valoracion[0]['puntos']."</b>,  no has conseguido superar el mínimo en este curso para conseguir ".strTranslate("APP_points").".";}
					if ($valoracion[0]['revision'] == 0){ $msg = strTranslate("Revision_pending");}
				}
				echo '<div class="alert alert-info"><span class="fa fa-info-circle"></span> '.$msg.'</div>';
			}

			if (count($elements) > 0){
				if ($finalizados == 0){
					echo '<form action="" method="post" name="formTarea" id="formTarea" role="form" >
								<input type="hidden" id="id_tarea" name="id_tarea" value="'.$id_tarea.'" />';
				}
				foreach($elements as $element):
					$respuesta_user = $na_areas->getRespuestasUser(" AND id_pregunta=".$element['id_pregunta']." AND respuesta_user='".$_SESSION['user_name']."' ");
					if (count($respuesta_user) == 0) $respuesta_user[0]['respuesta_valor'] = "";
					echo '<div class="form-tarea-container">';
					echo '<h5><span class="fa fa-chevron-circle-right "></span> '.$element['pregunta_texto'].'</h5>
							<div>';
					if ($element['pregunta_tipo'] == 'texto'){
						echo '<textarea class="form-control" name="respuesta_'.$element['id_pregunta'].'">'.$respuesta_user[0]['respuesta_valor'].'</textarea>';
					}
					elseif ($element['pregunta_tipo'] == 'unica'){
						$respuestas=$na_areas->getRespuestas(" AND id_pregunta=".$element['id_pregunta']." ");             
						foreach($respuestas as $respuesta):
							if ($respuesta_user[0]['respuesta_valor'] == $respuesta['respuesta_texto']) $seleccionado = 'checked="checked"';
							else $seleccionado = "";
							echo '<input '.$seleccionado.' type="radio" id="respuesta_'.$element['id_pregunta'].'" name="respuesta_'.$respuesta['id_pregunta'].'" value="'.$respuesta['respuesta_texto'].'" /> '.$respuesta['respuesta_texto']."<br />";
						endforeach;
					}
					elseif ($element['pregunta_tipo'] == 'multiple'){
						$respuestas=$na_areas->getRespuestas(" AND id_pregunta=".$element['id_pregunta']." ");
						$respuesta_multiple = explode("|", $respuesta_user[0]['respuesta_valor']);
						foreach($respuestas as $respuesta):
							if (in_array($respuesta['respuesta_texto'],$respuesta_multiple)) $seleccionado = 'checked="checked"';
							else $seleccionado = "";
							echo '<input '.$seleccionado.' class="formTareaCheck" type="checkbox" id="respuesta_'.$element['id_pregunta'].'_'.$respuesta['id_respuesta'].'" name="respuesta_'.$element['id_pregunta'].'_'.$respuesta['id_respuesta'].'" value="'.$respuesta['respuesta_texto'].'" /> '.$respuesta['respuesta_texto']."<br />";
						endforeach;
					}
					echo '</div>';
					echo '</div>';
				endforeach;
				if ($finalizados == 0){
					echo '<br /><input id="SubmitForm" class="btn btn-primary" type="submit" value="'.strTranslate("Save").'" /">';
					if (count($respuesta_user) > 0){
						echo ' <button id="FinalizarForm" class="btn btn-primary" type="button">'.strTranslate("End_task").'</button>';
					}

					echo '</form>';
					echo '<br /><br /><div class="alert alert-warning">Asegúrate de haber contestado todas las preguntas correctamente antes de Finalizar la tarea.</div>';
				}
			}
		}
		else ErrorMsg(strTranslate("Access_denied"));
		?>
	</div>
	<div class="app-sidebar hidden-sm hidden-xs">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-bookmark fa-stack-1x fa-inverse"></i>
				</span>
				<?php echo strTranslate("Na_areas");?>
			</h4>
			<br />
			<p class="text-center"><i class="fa fa-mortar-board fa-big"></i></p>
		</div>
	</div>
</div>