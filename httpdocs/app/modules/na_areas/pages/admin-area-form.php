<?php
addJavascripts(array(getAsset("na_areas")."js/admin-area-form.js"));

$na_areas = new na_areas();
$id_area = intval($_REQUEST['a']);
$id_tarea = intval($_REQUEST['id']);

//OBTENER DATOS DE LA TAREA
$tarea=$na_areas->getTareas(" AND id_tarea=".$id_tarea." ");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Na_areas"), "ItemUrl"=>"admin-areas"),
			array("ItemLabel"=>strTranslate("Form"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');

		//INSERTAR PREGUNTA
		na_areasController::insertPreguntaAction();
		
		//ELIMINAR PREGUNTA
		na_areasController::deletePreguntaAction();
		?>
		<p>
			Tarea: <?php echo $tarea[0]['tarea_titulo'];?> | 
			<a href="admin-area?act=edit&t=2&id=<?php echo $id_area;?>" class="text-primary">Volver a la gestión del curso</a> | 
			<a href="areas_form?id=<?php echo $id_tarea;?>" target="_blank" id="ver-formulario" class="">Ver formulario</a>
		</p>
		<?php
		if (count($tarea) == 1 && $tarea[0]['tipo'] == 'formulario') FormularioTarea($id_tarea, $id_area, $tarea);
		else ErrorMsg("Error al cargar el formulario la tarea"); ?>
	</div>
	<?php menu::adminMenu();?>
</div>

<?php 
function FormularioTarea($id_tarea,$id_area,$tarea){
		$na_areas = new na_areas();
		$preguntas = $na_areas->getPreguntas(" AND id_tarea=".$id_tarea." "); 

		if (count($preguntas) == 0){
			echo '<div class="tareas-row">El formulario no tiene preguntas, puede crear las preguntas a continuación.</div>';
		}
		else{
				//SHOW DATA
				echo '<table class="table">';
				echo '<tr>';
				echo '<th width="20px">&nbsp;</th>';
				echo '<th>&nbsp;Pregunta</th>';
				echo '<th>&nbsp;Tipo</th>';
				echo '<th>&nbsp;Correcta</th>';
				echo '</tr>';

				foreach($preguntas as $pregunta):
					$correctas = $na_areas->getRespuestas(" AND id_pregunta=".$pregunta['id_pregunta']." AND correcta=1 ");
				echo '<tr>';
				echo '<td nowrap="nowrap">
						<span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar la pregunta?\',
							\'admin-area-form?act=del&id='.$id_tarea.'&a='.$id_area.'&idp='.$pregunta['id_pregunta'].'\')" 
							title="Eliminar pregunta" />
						</span>
					 </td>';
				echo '<td>'.$pregunta['pregunta_texto'].'</td>';
				echo '<td>'.$pregunta['pregunta_tipo'].'</td>';
				echo '<td>';
				foreach($correctas as $correcta):
					echo $correcta['id_respuesta']." ";
				endforeach;
				echo '</td>';
				echo '</tr>';
				endforeach;
				echo '</table>';
		}
		//INSERTAR NUEVA PREGUNTA
		?>
		<div class="col-md-5">
			<div class="panel panel-default">
				<div class="panel-heading"><?php e_strTranslate("Form_new_question");?></div>
				<div class="panel-body">
					<form id="formData" name="formData" method="post" action="admin-area-form?act=new&amp;id=<?php echo $id_tarea;?>&amp;a=<?php echo $id_area;?>">
						<div class="row">
							<div class="form-group col-md-8">
								<label for="pregunta_texto"><?php e_strTranslate("Form_question");?>:</label>
								<input type="text" Size="40" id="pregunta_texto" name="pregunta_texto" value="" class="form-control" />
								<span id="pregunta-alert" class="alert-message alert alert-danger"><?php e_strTranslate("Required_field");?></span>
							</div>
							
							<div class="form-group col-md-4">
								<label for="pregunta_tipo"><?php e_strTranslate("Form_question_type");?>:</label>
								<select id="pregunta_tipo" name="pregunta_tipo" class="form-control">
									<option selected="selected" value="texto">texto libre</option>
									<option value="unica"/>respuesta única</option>
									<option value="multiple">respuesta multiple</option>
								</select>
							</div>

							<div class="form-group col-md-12" id="container-respuestas">
								<a href="#" id="agregar-respuestas" class="btn btn-primary">nueva respuesta</a><br /><br />
								<input type="hidden" name="contador-respuestas" id="contador-respuestas" value="1" />
								<span id="textoRespuesta1" style="width:70px;display:block;clear:both">Respuesta1:</span>
								<input class="form-control" id="respuesta1" name="respuesta1" value=""/>
								
								<div class="checkboxContainer">
									<input type="checkbox" id="checkRespuesta1" name="checkRespuesta1" class="checkForm"> Respuesta correcta
								</div>

								<div class="radioContainer">
									<input type="radio" id="radioRespuesta1" name="radioRespuesta1" value="1" class="radioForm"> Respuesta correcta
								</div>
								<hr />
							</div>
						</div>
						<br />
						<div class="form-group col-md-12">
							<div id="SubmitData" name="SubmitData" class="btn btn-primary btn-block"><?php e_strTranslate("Form_add_question");?></div>
						</div>
					</form>
				</div>
			</div>
		</div>
<?php } ?>