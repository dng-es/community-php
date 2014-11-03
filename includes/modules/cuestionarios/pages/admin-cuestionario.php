<?php

addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js",
					 getAsset("cuestionarios")."js/admin-cuestionario.js"));

//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

?>

<div class="row row-top">
	<div class="col-md-9">
		<h1><?php echo strTranslate("Form");?></h1>
		<?php
		session::getFlashMessage( 'actions_message' );
		cuestionariosController::createAction();
		cuestionariosController::updateAction();
		cuestionariosController::deletePreguntaAction();
		cuestionariosController::insertPreguntaAction();

		//OBTENER DATOS DEL Cuestionario
		$id_cuestionario = (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		if ($id_cuestionario>0){
			$cuestionario=cuestionariosController::getItemAction($id_cuestionario);
			$cuestionario_nombre = $cuestionario[0]['nombre'];
			$cuestionario_descripcion = $cuestionario[0]['descripcion'];
		}
		else{
			$cuestionario_nombre = "";
			$cuestionario_descripcion = "";
		}
		?>
		<form method="post" name="form-cuestionario" id="form-cuestionario" role="form">
			<input type="hidden" name="id_cuestionario" id="id_cuestionario" value="<?php echo $id_cuestionario;?>" />

			<label for="nombre"><?php echo strTranslate("Name");?></label>
			<input type="text" name="nombre" id ="nombre" class="form-control" value="<?php echo $cuestionario_nombre;?>" />
			<br />
			<?php
			if ($id_cuestionario!=""){
				echo '<p>'.strTranslate("Form").' URL: <a href="http://'.$ini_conf['SiteUrl'].'/?page=cuestionario&id='.$id_cuestionario.'" target="_blank">http://'.$ini_conf['SiteUrl'].'/?page=cuestionario&id='.$id_cuestionario.'</a></p>';
			}
			?>
			<label for="descripcion"><?php echo strTranslate("Description");?>:</label></td></tr>
			<textarea cols="40" rows="5" id="descripcion" name="descripcion"><?php echo $cuestionario_descripcion;?></textarea>
			<script type="text/javascript">
				var editor=CKEDITOR.replace('descripcion',{customConfig : 'config-page.js'});
				CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
			</script>
			<br /><button class="btn btn-primary" id="SubmitCuestionario" name="SubmitCuestionario" type="submit"><?php echo strTranslate("Save");?></button>
		</form>
		<br />
		<?php if ($id_cuestionario>0 ) FormularioTarea($id_cuestionario,$cuestionario); ?>
	</div>
	<?php menu::adminMenu();?>
</div>


<?php 


function FormularioTarea($id_cuestionario,$cuestionario){
		$cuestionarios = new cuestionarios();
		$preguntas = $cuestionarios->getPreguntas(" AND id_cuestionario=".$id_cuestionario." "); 

		if (count($preguntas)==0): ?>
			<div class="alert alert-warning">El cuestionario no tiene preguntas, puedes crearlas a continuación.</div>
		<?php else: ?>
			<h3><?php echo strTranslate("Form_questions");?></h3>
			<table class="table">
				<tr>
					<th width="20px">&nbsp;</th>
					<th><?php echo strTranslate("Form_question");?></th>
					<th><?php echo strTranslate("Form_question_type");?></th>
				</tr>

				<?php foreach($preguntas as $pregunta): ?>
				<tr>
				<td nowrap="nowrap">
						<span class="fa fa-ban icon-table" onClick="Confirma('¿Seguro que desea eliminar la pregunta?',
							'?page=admin-cuestionario&act=del&id=<?php echo $id_cuestionario;?>&idp=<?php echo $pregunta['id_pregunta'];?>')" 
							title="Eliminar pregunta" />
						</span>
					 </td>
							
				<td><?php echo $pregunta['pregunta_texto'];?></td>
				<td><?php echo $pregunta['pregunta_tipo'];?></td>
				</tr>  
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
		<h3><?php echo strTranslate("Form_new_question");?></h3>

		<div class="area-detalle">
		<form id="formData" name="formData" method="post" action="?page=admin-cuestionario&act=new&amp;id=<?php echo $id_cuestionario;?>&amp;">
			<label for="pregunta_texto"><?php echo strTranslate("Form_question");?>:</label>
			<input type="text" Size="40" id="pregunta_texto" name="pregunta_texto" value="" class="form-control" />
			<span id="pregunta-alert" class="alert-message alert alert-danger"><?php echo strTranslate("Required_field");?></span>

			<label for="pregunta_tipo"><?php echo strTranslate("Form_question_type");?>:</label>
			<select id="pregunta_tipo" name="pregunta_tipo" class="form-control">
				<option selected="selected" value="texto"><?php echo strTranslate("Form_question_type_text");?></option>
				<option value="unica"/><?php echo strTranslate("Form_question_type_radio");?></option>
				<option value="multiple"><?php echo strTranslate("Form_question_type_check");?></option>
			</select>
			<div id="container-respuestas">
				<a href="#" id="agregar-respuestas" class="btn btn-primary"><?php echo strTranslate("Form_new_answer");?></a><br /><br />
				<input type="hidden" name="contador-respuestas" id="contador-respuestas" value="1" />
				<label id="textoRespuesta1" style="width:70px;display:block;clear:both">Respuesta1:</label>
				<input class="form-control" id="respuesta1" name="respuesta1" value=""/>
			</div>
			<br />
			<div id="SubmitData" name="SubmitData" class="btn btn-primary"><?php echo strTranslate("Form_add_question");?></div></td></tr>
		</form>
		</div>
		<br />
<?php } ?>