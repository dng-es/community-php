<?php
addJavascripts(array(getAsset("cuestionarios")."js/cuestionario.js"));
$id_cuestionario = ((isset($_REQUEST['id']) and $_REQUEST['id']!=0) ? $_REQUEST['id'] : 0);

$cuestionario = cuestionariosController::getItemAction($id_cuestionario);
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<h1><?php echo $cuestionario[0]['nombre'];?></h1>
		<p><?php echo $cuestionario[0]['descripcion'];?></p>
		<hr />
		<?php
		session::getFlashMessage( 'actions_message' );
		cuestionariosController::saveFormAction();
		cuestionariosController::finalizarFormAction($id_cuestionario);
		
		$cuestionarios = new cuestionarios();
		$elements = $cuestionarios->getPreguntas(" AND id_cuestionario=".$id_cuestionario." ");
		$finalizados = connection::countReg("cuestionarios_finalizados"," AND id_cuestionario=".$id_cuestionario." AND user_tarea='".$_SESSION['user_name']."' ");
		
		if ($finalizados>0){
			//obtener resultado de la valoracion
			$valoracion = $cuestionarios->getFormulariosFinalizados(" AND user_tarea='".$_SESSION['user_name']."' AND id_cuestionario=".$id_cuestionario);
			if (count($valoracion)>0){
				if ($valoracion[0]['revision']==1){ $msg = "Enhorabuena, has conseguido un <b>".$valoracion[0]['puntos']."</b> en este cuestionario";}
				if ($valoracion[0]['revision']==0){ $msg = "Tus respuestas serán revisadas. Muy pronto podrás consultar la puntuación obtenida accediendo al cuestionario.";}
			}
			echo '<div class="alert alert-info"><span class="fa fa-info-circle"></span> '.$msg.'</div>';
		}

		if (count($elements)>0){
			echo '<form action="" method="post" name="formTarea" id="formTarea" role="form" >
							<input type="hidden" id="id_cuestionario" name="id_cuestionario" value="'.$id_cuestionario.'" />';
			foreach($elements as $element):
				$respuesta_user=$cuestionarios->getRespuestasUser(" AND id_pregunta=".$element['id_pregunta']." AND respuesta_user='".$_SESSION['user_name']."' ");
				if  (count($respuesta_user) == 0) { $respuesta_user[0]['respuesta_valor'] = "";}
				echo '<div class="form-tarea-container">';
				echo '<h5><span class="fa fa-chevron-circle-right "></span> '.$element['pregunta_texto'].'</h5>
						<div>';
				if ($element['pregunta_tipo']=='texto'){
					echo '<textarea class="form-control" name="respuesta_'.$element['id_pregunta'].'">'.$respuesta_user[0]['respuesta_valor'].'</textarea>';
				}
				elseif ($element['pregunta_tipo']=='unica'){
					$respuestas=$cuestionarios->getRespuestas(" AND id_pregunta=".$element['id_pregunta']." ");             
					foreach($respuestas as $respuesta):
						if ($respuesta_user[0]['respuesta_valor']==$respuesta['respuesta_texto']){$seleccionado='checked="checked"';}
						else {$seleccionado="";}
						echo '<input '.$seleccionado.' type="radio" id="respuesta_'.$element['id_pregunta'].'" name="respuesta_'.$respuesta['id_pregunta'].'" value="'.$respuesta['respuesta_texto'].'" /> '.$respuesta['respuesta_texto']."<br />";
					endforeach;           
				}
				elseif ($element['pregunta_tipo']=='multiple'){
					$respuestas=$cuestionarios->getRespuestas(" AND id_pregunta=".$element['id_pregunta']." ");
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
					echo ' <button id="FinalizarForm" onClick="Confirma(\'¿Seguro que desea finalizar el cuestionario?.\nRecuerda  que previamente tienes que guardar tus respuestas.\',\'?page=cuestionario&id='.$id_cuestionario.'&d=1\')" class="btn btn-primary" type="button">Finalizar cuestionario</button>';
				}
			}
			echo '</form>';
			if ($finalizados==0){
				echo '<br /><br /><div class="alert alert-warning">Asegúrate de haber contestado todas las preguntas correctamente antes de finalizar el cuestionario.</div>';
			}
		}
		?>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			
		</div>
	</div>
</div>