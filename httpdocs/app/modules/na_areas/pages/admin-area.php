<?php
//DESCARGAR USUARIOS DEL AREA
na_areasController::exportUsersAreaAction();

//DESCARGAR FORO
na_areasController::exportForoAction();

addJavascripts(array("js/jquery.numeric.js", 
					 "js/bootstrap.file-input.js", 
					 "js/libs/ckeditor/ckeditor.js", 
					 getAsset("na_areas")."js/admin-area.js"));

templateload("cmbCanales","users");
templateload("user_recompensa", "recompensas");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Na_areas"), "ItemUrl"=>"admin-areas"),
			array("ItemLabel"=> strTranslate("Edit")." ".strTranslate("Na_areas"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');

		$na_areas = new na_areas();
		$accion = sanitizeInput(isset($_GET['act']) ? $_GET['act'] : "");
		$accion1 = sanitizeInput(isset($_GET['act1']) ? $_GET['act1'] : "");
		$accion2 = sanitizeInput(isset($_GET['accion2']) ? $_GET['accion2'] : "");

		$id = ($accion == 'edit' ? $_GET['id'] : 0);
		if ($accion == 'edit' && $accion2 == 'ok' && $accion1 != "del") na_areasController::updateAction();
		elseif ($accion == 'new' && $accion2 == 'ok') na_areasController::insertAction();

		//validar contenidos del foro
		na_areasController::validarComentarioAction();

		//clasificar foro
		na_areasController::cambiarTipoTemaAction();

		//crear grupos
		na_areasController::inserGrupoAction();

		//crear tarea
		na_areasController::inserTareaAction();

		//activar/desactivar tarea
		na_areasController::estadoTareaAction();

		//eliminar tarea
		na_areasController::eliminarTareaAction();

		//activar/desactivar links tarea
		na_areasController::estadoLinksTareaAction();

		$elements = $na_areas->getAreas(" AND id_area=".$id." ");
		$area_nombre = sanitizeInput(isset($elements[0]['area_nombre']) ? $elements[0]['area_nombre'] : "");
		$area_descripcion = sanitizeInput(isset($elements[0]['area_descripcion']) ? $elements[0]['area_descripcion'] : "");
		$puntos = sanitizeInput(isset($elements[0]['puntos']) ? $elements[0]['puntos'] : "");
		$limite_users = sanitizeInput(isset($elements[0]['limite_users']) ? $elements[0]['limite_users'] : "");
		$area_canal = sanitizeInput(isset($elements[0]['area_canal']) ? $elements[0]['area_canal'] : "");
		$registro = intval(isset($elements[0]['registro']) ? $elements[0]['registro'] : 0);
		?>

		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-tabs">
					<li <?php echo (!(isset($_GET['t'])) ? ' class="active"' : '');?>><a href="#general" data-toggle="tab"><?php e_strTranslate("Main_data");?></a></li>
					<?php if ($accion == 'edit'): ?>
					<li<?php echo ((isset($_GET['t']) && $_GET['t'] == 2) ? ' class="active"' : '');?>><a href="#<?php e_strTranslate("Tasks");?>" data-toggle="tab"><?php e_strTranslate("Tasks");?></a></li>
					<li<?php echo ((isset($_GET['t']) && $_GET['t'] == 3) ? ' class="active"' : '');?>><a href="#<?php e_strTranslate("Users");?>" data-toggle="tab"><?php e_strTranslate("Users");?></a></li>
					<li<?php echo ((isset($_GET['t']) && $_GET['t'] == 4) ? ' class="active"' : '');?>><a href="#<?php e_strTranslate("Forums");?>" data-toggle="tab"><?php e_strTranslate("Forums");?></a></li>
					<?php endif;?>
				</ul>
			
				<div class="tab-content">
					<div class="tab-pane fade in <?php echo (!(isset($_GET['t'])) ? ' active' : '');?>" id="general">
						<div class="row">
							<div class="col-md-12">
								<form role="form" id="formData" name="formData" method="post" action="admin-area?act=<?php echo $accion;?>&amp;id=<?php echo $id;?>&amp;accion2=ok">
									<input type="hidden" id="id_area" name="id_area" value="<?php echo $id;?>" />
									<div class="row">
										<div class="form-group col-md-12">
											<label for="area_nombre"><small><?php e_strTranslate("Name");?>:</small></label>
											<input class="form-control form-big" type="text" id="area_nombre" name="area_nombre" value="<?php echo $area_nombre;?>"  data-alert="<?php e_strTranslate("Required_field");?>" />
										</div>
									</div>

									<div class="row">
										<div class="form-group col-md-12">
											<label for="area_descripcion"><small><?php e_strTranslate("Description");?>:</small></label>
											<textarea class="form-control" id="area_descripcion" name="area_descripcion" data-alert="<?php e_strTranslate("Required_field");?>"><?php echo $area_descripcion;?></textarea>
										</div>
									</div>
									
									<div class="row">
										<div class="form-group col-md-4">
											<label for="area_canal"><small><?php e_strTranslate("Channel");?>:</small></label>
											<select id="area_canal" name="area_canal[]" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" multiple data-actions-box="true" data-none-selected-text="<?php e_strTranslate("Choose_channel");?>" data-deselect-all-text="<?php e_strTranslate('deselect_all');?>"  data-select-all-text="<?php e_strTranslate('select_all');?>">
												<?php ComboCanales($area_canal);?>
											</select>
										</div>

										<div class="form-group col-md-2">
											<label for="area_puntos"><small><?php echo ucfirst(strTranslate("APP_points"));?>:</small></label>
											<input type="text" class="form-control" id="area_puntos" name="area_puntos" value="<?php echo $puntos;?>" data-alert="<?php e_strTranslate("Required_field");?>" />
										</div>

										<div class="form-group col-md-2">
											<label for="area_limite"><small>Límite de usuarios:</small></label>
											<input type="text" class="form-control" id="area_limite" name="area_limite" value="<?php echo $limite_users;?>" data-alert="<?php e_strTranslate("Required_field");?>" />
										</div>

										<div class="form-group col-md-4">
											<br />
											<div class="checkbox checkbox-primary">
												<input type="checkbox" class="styled" id="area_registro"  name="area_registro" <?php echo $registro == 1 ? "checked" : "";?>>
												<label for="area_registro">Permitir registro</label>
											</div>
										</div>
									</div>
									
									<div class="clearfix"></div>
									<div class="row">
										<div class="form-group col-md-12">
											<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary"><?php e_strTranslate("Save_data");?></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

					<?php
					if ($accion == 'edit'){
						$id_area = $elements[0]['id_area'];
						$area_canal = $elements[0]['area_canal']; ?>
						<div class="tab-pane fade <?php echo ((isset($_GET['t']) && $_GET['t'] == 2) ? ' in active' : '');?>" id="<?php e_strTranslate("Tasks");?>">
							<br />
							<div class="row">
								<div class="col-md-12">
									<?php showTareasArea($id_area); ?>
								</div>
							</div>
						</div>

						<div class="tab-pane fade <?php echo ((isset($_GET['t']) && $_GET['t'] == 3) ? ' in active' : '');?>" id="<?php e_strTranslate("Users");?>">
							<br />
							<div class="row">
								<div class="col-md-6">
									<?php showUsuariosArea($id_area,$area_canal); ?>
								</div>

								<div class="col-md-6">
									<?php showGruposArea($id_area); ?>
								</div>
							</div>
						</div>

						<div class="tab-pane fade <?php echo ((isset($_GET['t']) && $_GET['t'] == 4) ? ' in active' : '');?>" id="<?php e_strTranslate("Forums");?>">
							<br />
							<div class="row">
								<div class="col-md-12">
									<?php showForosArea($id_area); ?>
								</div>
							</div>
						</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>

<?php 
function showUsuariosArea($id_area,$area_canal){
	$na_areas = new na_areas;
	$elements = $na_areas->getAreasUsers(" AND id_area=".$id_area);?>

	<div class="panel panel-default">
		<div class="panel-heading">Importar usuarios al curso</div>
		<div class="panel-body">
			<p>Los usuarios actuales serán reemplazados por los incluídos en el fichero. El fichero <strong>Excel XLS</strong> deberá contener una única columna con el nombre de usuario. 
			La primera fila será considerada como encabezado y no será importada.</p>
			<form role="form" id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="admin-cargas-user-areas-process?id='<?php echo $id_area;?>">
				<input type="hidden" name="id_area" id="id_area" value="<?php echo $id_area;?>" />
				<input type="hidden" name="area_canal" id="area_canal" value="<?php echo $area_canal;?>" />
				<input id="nombre-fichero" name="nombre-fichero" type="file" class="btn btn-default" title="<?php e_strTranslate("Choose_file");?>" />
				<button type="submit" id="inputFile" name="inputFile" class="btn btn-primary"><?php e_strTranslate("Import_file");?></button>
				<div id="fichero-alert" class="alert-message alert alert-danger alert alert-danger"></div>
			</form>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Usuarios incluídos en el curso</div>
		<div class="panel-body">
			<?php if (count($elements) > 0):?>
			<p>Total usuarios inscritos: <b><?php echo count($elements);?></b>. Puedes descargar un fichero CSV con los usuarios inscritos en el curso: <br /><br />
			<a href="admin-area?act=edit&id='<?php echo $id_area;?>&t=1" class="btn btn-primary"><?php e_strTranslate("Download_file");?></a></span></p>
			<?php else:?> <p>No hay usuarios incluídos en el curso</p>
			<?php endif;?>
		</div>
	</div>
<?php }

function showGruposArea($id_area){
	$na_areas = new na_areas;
	$elements = $na_areas->getGruposUsers(" AND id_area=".$id_area);?>
	<div class="panel panel-default">
		<div class="panel-heading">Grupos de usuarios en el curso</div>
		<div class="panel-body">
			<p>Puedes crear nuevos grupos en el curso. Para ver los usuarios pertenecientes al grupo o editar sus miembros haz click sobre el nombre.
			</p>
			<form action="" method="post" name="formNewGrupo" id="formNewGrupo" role="form" class="form-inline">
				<div class="form-group">
					<input type="hidden" name="id_area_grupo" id="id_area_grupo" value="<?php echo $id_area;?>" />
					<label class="sr-only" for="grupo_nombre">Nuevo grupo:</label> 
					<input type="text" name="grupo_nombre" id="grupo_nombre" class="form-control" placeholder="nombre del nuevo grupo" />
					<span id="grupo-alert" class="alert-message alert alert-danger"><?php e_strTranslate("Required_field");?></span>
				</div>
				<button type="button" id="SubmitGrupo" name="SubmitGrupo" class="btn btn-primary">guardar grupo</button>
			</form>
			<br />
			<?php if (count($elements) > 0): ?>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<tr>
						<th>Nombre del grupo</th>
					</tr>
					<?php foreach($elements as $element):?>
					<tr>
						<td>
						<a href="admin-area-grupo?a=<?php echo $id_area;?>&g=<?php echo $element['id_grupo'];?>"><?php echo $element['grupo_nombre'];?></a></td>
					</tr>
					<?php endforeach;?>
				</table>
			</div>
			<?php endif;?>
		</div>
	</div>
<?php }

function showForosArea($id_area){
	$na_areas = new na_areas;
	$elements = $na_areas->getGruposUsers(" AND id_area=".$id_area);
	//TEMAS FOROS
	getForosActivos($id_area);
	//COMENTARIOS FORO PENDIENTE DE VALIDAR
	getForoPendientes($id_area);
}

function getForosActivos($id_area){
	$foro = new foro();
	$temas = $foro->getTemas(" AND id_tema_parent<>0 AND activo=1 AND id_area=".$id_area);?>
	<p>Hay los siguientes <span class="orange-color">TEMAS</span> creados en los foros</p><br />
	<table class="table table-striped">
		<tr>
			<th width="40px">&nbsp;</th>
			<th>ID</th>
			<th><?php e_strTranslate("Type");?></th>
			<th><?php e_strTranslate("Name");?></th>
			<th><?php e_strTranslate("Username");?></th>
			<th><span class="fa fa-comment"></span></th>
			<th><span class="fa fa-eye"></span></th>
		</tr>

	<?php foreach($temas as $element):
		$num_comentarios = connection::countReg("foro_comentarios"," AND estado=1 AND id_tema=".$element['id_tema']." ");
		$num_visitas = connection::countReg("foro_visitas"," AND id_tema=".$element['id_tema']." ");
		echo '<tr>';
		echo '<td nowrap="nowrap">
				<span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar el tema '.$element['id_tema'].'?\',
					\'admin-area?act=edit&act2=tema_ko&id='.$id_area.'&idt='.$element['id_tema'].'&u='.$element['user'].'\')" 
					title="Eliminar" />
				</span>

				<a class="fa fa-download icon-table" href="admin-area?act=edit&export=true&id='.$id_area.'&idt='.$element['id_tema'].'" title="Exportar"></a>     
			 </td>';
		echo '<td><a href="#" class="abrir-modal" title="TemaForo'.$element['id_tema'].'">'.$element['id_tema'].'</a>
				<!-- Modal -->
				<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Tema en el foro</h4>
							</div>
							<div class="modal-body">
							<p><b>'.$element['user'].'</b> creó el tema: '.$element['nombre'].'</p>
							<p><em>'.$element['descripcion'].'</em></p>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
		</td>';
		echo '<td nowrap="nowrap">
		<form action="" method="post" role="form" class="form-inline">
		<input type="hidden" name="id_tema_tipo" value="'.$element['id_tema'].'">
		<select name="find_tipo" id="find_tipo" class="form-control">
				<option>---Seleccionar tipo---</option>';         
					ComboTiposTemas($element['tipo_tema']);
		echo '</select>
		<button type="submit" class="btn btn-default">Modificar</button>
		</form>
		</td>';
		echo '<td>'.$element['nombre'].'</td>';
		echo '<td>'.$element['user'].'</td>';
		echo '<td title="'.$num_comentarios.' '.strtolower(strTranslate("Comments")).'">'.$num_comentarios.'</td>';
		echo '<td title="'.$num_visitas.' '.strtolower(strTranslate("Visits")).'">'.$num_visitas.'</td>';   
		echo '</tr>';
	endforeach;
	echo '</table><br />';
}

function getForoPendientes($id_area){
	$foro = new foro();
	$calculo = strtotime("-4 days");
	$fecha_ayer = date("Y-m-d", $calculo);
	$pendientes = $foro->getComentarios(" AND date_comentario>='".$fecha_ayer."' AND estado=1 AND t.id_area=".$id_area." ORDER BY id_comentario DESC");
	if (count($pendientes) == 0){
		echo '<p>No hay mensajes en el <span class="orange-color">FORO</span> insertados ultimamente (fecha: '.$fecha_ayer.').<br />
				'.ucfirst(strTranslate("APP_points")).' a otorgar por mensaje: <span class="orange-color">'.PUNTOS_FORO.'.</span></p><br />';
	}
	else{
		echo '<p>Hay los siguientes mensajes en el <span class="orange-color">FORO</span> insertados ultimamente (fecha: '.$fecha_ayer.').<br />
				'.ucfirst(strTranslate("APP_points")).' a otorgar por mensaje: <span class="orange-color">'.PUNTOS_FORO.'.</span></p><br />';?>
		<table class="table table-striped">
		<tr>
		<th width="30px">&nbsp;</th>
		<th>ID</th>
		<th><?php e_strTranslate("User");?></th>
		<th><?php e_strTranslate("Channel");?></th>
		<th><?php e_strTranslate("Date");?></th>
		<th><?php e_strTranslate("Forum");?></th>
		<th><?php e_strTranslate("Type");?></th>
		</tr>
	
		<?php foreach($pendientes as $element):
			echo '<tr>';
			echo '<td nowrap="nowrap">
					<span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar el comentario '.$element['id_comentario'].'?\',
						\'admin-area?act=edit&id='.$id_area.'&act2=foro_ko&idc='.$element['id_comentario'].'&u='.$element['user_comentario'].'\')" 
						title="Eliminar" />
					</span>
				 </td>';
			echo '<td><a href="#" class="abrir-modal" title="MensajeForo'.$element['id_comentario'].'">'.$element['id_comentario'].'</a>
					<!-- Modal -->
					<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title" id="myModalLabel">Tema en el foro</h4>
								</div>
								<div class="modal-body">
									<p><b>'.$element['user_comentario'].'</b> '.strTranslate("says").':</p>
									<p><em>'.$element['comentario'].'</em></p>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
			</td>';
			echo '<td>'.$element['user_comentario'].'</td>';
			echo '<td>'.$element['canal'].'</td>';
			echo '<td>'.getDateFormat($element['date_comentario'], "SHORT").'</td>'; 
			echo '<td>'.$element['nombre'].'</td>';
			echo '<td>'.$element['tipo_tema'].'</td>';
			echo '</tr>';
		endforeach;
		echo '</table><br />';
	}
}

function showTareasArea($id_area){
	$na_areas = new na_areas;
	$elements = $na_areas->getTareas(" AND id_area=".$id_area." AND activa<>2 ");
	?>
		<div class="row">
			<div class="col-md-5">
				<form action="admin-area?act=edit&id=<?php echo $id_area;?>" method="post" name="formNewTarea" id="formNewTarea" enctype="multipart/form-data" role="form" class="form-horizontal">
					<input type="hidden" name="id_area_tarea" id="id_area_tarea" value="<?php echo $id_area;?>" />

					<div class="row nopadding">
						<div class="col-md-6 nopadding">
							<div class="radio radio-primary">
								<input type="radio" class="tipo_file" name="tipo" value="formulario" checked="checked"> 
								<label><?php e_strTranslate("Form");?></label>
							</div>
						</div>
						<div class="col-md-6 nopadding">
							<div class="radio radio-primary">
								<input type="radio" class="tipo_file" name="tipo" value="fichero" />
								<label><?php e_strTranslate("File");?></label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="tarea_titulo" class="control-label"><?php e_strTranslate("Name");?>:</label>
						<input type="text" name="tarea_titulo" id="tarea_titulo" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>" />
					</div>

					<div class="form-group">
						<label for="tarea_descripcion" class="control-label"><?php e_strTranslate("Description");?>:</label>
						<textarea name="tarea_descripcion" id="tarea_descripcion" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>" /></textarea>
					</div>

					<div class="form-group">
						<label for="fichero-tarea" class="control-label">Fichero tarea:</label>
						<input id="fichero-tarea" name="fichero-tarea" type="file" class="btn btn-default btn-block" title="<?php e_strTranslate("Choose_file");?>" />
					</div>

					<?php if(getModuleExist("recompensas")): ?>
					<div class="form-group">
						<label for="id_recompensa" class="control-label"><?php e_strTranslate("Reward");?>: 
						<span class="text-muted"><small>Recompensa que recibirá el usuario el aprobar el curso</small></span></label>
						<?php comboRecompensas(0, "", "id_recompensa");?>
					</div>
					<?php endif; ?>

					<div class="form-group">
						<div class="checkbox checkbox-primary">
							<input class="styled" type="checkbox" name="tarea_grupo"  id="tarea_grupo">
							<label for="tarea_grupo"> Tarea de grupos</label>
						</div>
					</div>

					<div class="form-group">
						<button type="submit" id="SubmitTarea" name="SubmitTarea" class="btn btn-primary btn-block">Guardar tarea</button>
					</div>
				</form>
			</div>
			<div class="col-md-7">
				<?php if (count($elements) > 0):?>
				<div class="table-responsive">
					<table class="table table-hover table-striped">
						<tr>
							<th width="40px">&nbsp;</th>
							<th><?php e_strTranslate("Task");?></th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
						<?php foreach($elements as $element):
							if($element['activa'] == 1){
								$imagen_revision = '<i class="fa fa-check text-success"></i>';
								$valor_activar = 0;
								$texto_activar = "desactivar";
							}
							else{
								$imagen_revision = '<i class="fa fa-exclamation text-danger"></i>';
								$valor_activar = 1;
								$texto_activar = "activar";
							}

							if($element['activa_links'] == 1){
								$valor_activar_links = 0;
								$texto_activar_links = "desactivar";
								$texto_activar_links_v = strTranslate("App_Yes");
							}
							else{
								$valor_activar_links = 1;
								$texto_activar_links = "activar";
								$texto_activar_links_v = strTranslate("App_No");
							}

							echo '<tr>';
							echo '<td nowrap="nowrap">
										<span class="icon-table" onClick="Confirma(\'¿Seguro que quieres '.$texto_activar.' la tarea?\',
										\'admin-area?act=edit&e='.$valor_activar.'&del_t='.$element['id_tarea'].'&id='.$id_area.'\')" 
										title="'.$texto_activar.' tarea" />'.$imagen_revision.'</span>

										<span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que quieres eliminar la tarea?\',
										\'admin-area?act=edit&del_t2='.$element['id_tarea'].'&id='.$id_area.'\')" 
										title="Eliminar tarea" />
										</span>
									</td>
									<td>';
							
							if ($element['tipo'] == 'formulario'){
								echo '<a href="admin-area-form?a='.$id_area.'&id='.$element['id_tarea'].'">'.strTranslate("Form").'</a>';
							}
							else{
								echo '<a target="_blank" href="docs/showfile.php?t=1&file='.$element['tarea_archivo'].'">'.strTranslate("File").'</a>';
							}

							echo '<br /><em class="text-muted"><small>'.$element['tarea_titulo'].'</small></em>
									</td>
									<td>
										<span class="btn btn-default btn-xs" onClick="Confirma(\'¿Seguro que quieres '.$texto_activar_links.' los links de la tarea?\',
										\'admin-area?act=edit&el='.$valor_activar_links.'&del_t='.$element['id_tarea'].'&id='.$id_area.'\')" 
										title="'.$texto_activar_links.' tarea" />Link: '.$texto_activar_links_v.'</span>

										<a class="btn btn-default btn-xs" href="admin-area-docs?a='.$id_area.'&id='.$element['id_tarea'].'">docs</a>
										<a class="btn btn-default btn-xs" href="admin-area-revs?a='.$id_area.'&id='.$element['id_tarea'].'">revs</a>';
										if ($element['tarea_grupo'] == 1){
											echo '<a class="btn btn-default btn-xs" href="admin-area-tarea-grupo?a='.$id_area.'&id='.$element['id_tarea'].'">'.strTranslate("Groups").'</a>';
										}
							echo '</td>';
							echo '<td>';
							echo ((isset($element['id_recompensa']) && $element['id_recompensa'] > 0) ? '<img width="25px" title="'.$element['recompensa_name'].'" src="'.PATH_REWARDS.$element['recompensa_image'].'" />' : '');
							echo '</td>';
							echo '</tr>';
						endforeach; ?>
					</table>
				</div>
				<?php else:?>
				<p>No hay tareas incluidas en el curso</p>
			<?php endif;?>
			</div>
		</div>
	<?php
}
?>