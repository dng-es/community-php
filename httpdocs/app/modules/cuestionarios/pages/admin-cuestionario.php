<?php
addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js",
					 getAsset("cuestionarios")."js/admin-cuestionario.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Forms"), "ItemUrl"=>"admin-cuestionarios"),
			array("ItemLabel"=>strTranslate("Form"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		cuestionariosController::createAction();
		cuestionariosController::updateAction();
		cuestionariosController::deletePreguntaAction();
		cuestionariosController::insertPreguntaAction();

		//OBTENER DATOS DEL Cuestionario
		$id_cuestionario = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		if ($id_cuestionario>0){
			$cuestionario = cuestionariosController::getItemAction($id_cuestionario);
			$cuestionario_nombre = $cuestionario[0]['nombre'];
			$cuestionario_descripcion = $cuestionario[0]['descripcion'];
		}
		else{
			$cuestionario_nombre = "";
			$cuestionario_descripcion = "";
		}
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#general" data-toggle="tab"><?php e_strTranslate("Main_data");?></a></li>
					<?php if ($id_cuestionario > 0 ):?>
					<li><a href="#formquestions" data-toggle="tab"><?php e_strTranslate("Form_questions");?></a></li>
					<?php endif;?>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade in active" id="general">
						<div class="row">
							<div class="col-md-12">
								<form method="post" name="form-cuestionario" id="form-cuestionario" role="form">
									<input type="hidden" name="id_cuestionario" id="id_cuestionario" value="<?php echo $id_cuestionario;?>" />
									<label for="nombre"><?php e_strTranslate("Name");?></label>
									<input type="text" name="nombre" id ="nombre" class="form-control form-big" value="<?php echo $cuestionario_nombre;?>" />
									<br />
									<?php
									if ($id_cuestionario > 0){
										echo '<p>'.strTranslate("Form").' URL: <a href="'.$ini_conf['SiteUrl'].'/cuestionario?id='.$id_cuestionario.'" target="_blank">'.$ini_conf['SiteUrl'].'/cuestionario?id='.$id_cuestionario.'</a></p>';
									}
									?>
									<label for="descripcion"><?php e_strTranslate("Description");?>:</label></td></tr>
									<textarea cols="40" rows="5" id="descripcion" name="descripcion"><?php echo $cuestionario_descripcion;?></textarea>
									<script type="text/javascript">
										var editor=CKEDITOR.replace('descripcion',{customConfig : 'config-page.js'});
										CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
									</script>
									<br /><button class="btn btn-primary" id="SubmitCuestionario" name="SubmitCuestionario" type="submit"><?php e_strTranslate("Save");?></button>
								</form>
							</div>
						</div>
					</div>
					<?php if($id_cuestionario > 0 ):?>
					<div class="tab-pane fade in" id="formquestions">
						<div class="row">
							<div class="col-md-12">
								<br />
								<?php FormularioTarea($id_cuestionario,$cuestionario); ?>
							</div>
						</div>
					</div>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>

<?php 
function FormularioTarea($id_cuestionario, $cuestionario){
		$cuestionarios = new cuestionarios();
		$preguntas = $cuestionarios->getPreguntas(" AND id_cuestionario=".$id_cuestionario." ");

		if (count($preguntas) == 0): ?>
			<div class="alert alert-warning">El cuestionario no tiene preguntas, puedes crearlas a continuación.</div>
		<?php else: ?>
			<table class="table">
				<tr>
					<th width="20px">&nbsp;</th>
					<th><?php e_strTranslate("Form_question");?></th>
					<th><?php e_strTranslate("Form_question_type");?></th>
				</tr>
				<?php foreach($preguntas as $pregunta): ?>
				<tr>
					<td nowrap="nowrap">
						<button type="button" class="btn btn-default btn-xs" onClick="Confirma('¿Seguro que desea eliminar la pregunta?', 'admin-cuestionario?act=del&id=<?php echo $id_cuestionario;?>&idp=<?php echo $pregunta['id_pregunta'];?>'); return false;" title="Eliminar pregunta" /><i class="fa fa-trash icon-table"></i>
						</button>
					</td>
					<td><?php echo $pregunta['pregunta_texto'];?></td>
					<td><?php echo $pregunta['pregunta_tipo'];?></td>
				</tr>  
				<?php endforeach;?>
			</table>
		<?php endif; ?>
		<div class="col-md-5">
			<div class="panel panel-default">
				<div class="panel-heading"><?php e_strTranslate("Form_new_question");?></div>
				<div class="panel-body">
					<form id="formData" name="formData" method="post" action="admin-cuestionario?act=new&amp;id=<?php echo $id_cuestionario;?>&amp;">
					<div class="row">
						<div class="form-group col-md-8">
							<label for="pregunta_texto"><?php e_strTranslate("Form_question");?>:</label>
							<input type="text" Size="40" id="pregunta_texto" name="pregunta_texto" value="" class="form-control" />
							<span id="pregunta-alert" class="alert-message alert alert-danger"><?php e_strTranslate("Required_field");?></span>
						</div>
						
						<div class="form-group col-md-4">
							<label for="pregunta_tipo"><?php e_strTranslate("Form_question_type");?>:</label>
							<select id="pregunta_tipo" name="pregunta_tipo" class="form-control">
								<option selected="selected" value="texto"><?php e_strTranslate("Form_question_type_text");?></option>
								<option value="unica"/><?php e_strTranslate("Form_question_type_radio");?></option>
								<option value="multiple"><?php e_strTranslate("Form_question_type_check");?></option>
							</select>
						</div>

						<div class="form-group col-md-12" id="container-respuestas">
							<a href="#" id="agregar-respuestas" class="btn btn-primary"><?php e_strTranslate("Form_new_answer");?></a><br /><br />
							<input type="hidden" name="contador-respuestas" id="contador-respuestas" value="1" />
							<label id="textoRespuesta1" style="width:70px;display:block;clear:both">Respuesta1:</label>
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
		<br />
<?php }?>