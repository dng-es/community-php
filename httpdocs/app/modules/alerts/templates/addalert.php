<?php 
/**
 * Show create new panel alerts
 * @return 	string       		HTML panel
 */
function addAlert($id = 0){ 
	$filtro_categorias = $_SESSION['user_perfil'] == 'admin' ? "" : " AND (perfiles_type LIKE '%".$_SESSION['user_perfil']."%' OR perfiles_type LIKE '%usuario%') ";
	$categorias = alerts::getAlertsTypes($filtro_categorias);
	if (count($categorias) > 0):
		$filtro_tienda = usersController::getTiendaFilter("cod_tienda");
		$filtro_tienda_alerts = usersController::getTiendaFilter("empresa");
		$filter = " AND (SPLIT_STRING(destination_alert, ',', 1) IN (SELECT username FROM users WHERE 1=1 ".$filtro_tienda_alerts.") OR SPLIT_STRING(destination_alert, ',', 1) IN (SELECT cod_tienda FROM users_tiendas WHERE 1=1 ".$filtro_tienda.")) ";
		$element = alertsController::getItemAction($id, $filter);
	?>
	<form action="" name="formAddAction" id="formAddAction" method="post" role="form" enctype="multipart/form-data">
		<input type="hidden" name="id_alert" id="id_alert" value="<?php echo $element['id_alert'];?>" />
		

		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="form-group col-md-12">
						<label for="title_alert"><?php e_strTranslate("Title");?></label>
						<input value="<?php echo $element['title_alert'];?>" type="text" class="form-control" name="title_alert" id="title_alert" data-alert="<?php e_strTranslate("Required_field");?>" />
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12">
						<label for="text_alert"><?php e_strTranslate("Description");?></label>
						<textarea rows="7" class="form-control" name="text_alert" id="text_alert" data-alert="<?php e_strTranslate("Required_field");?>"><?php echo $element['text_alert'];?></textarea>
					</div>
				</div>

				<?php if ($_SESSION['user_perfil'] != 'usuario'):?>
				<div class="row">

					<div class="form-group col-md-6">
						<br />
						<div class="checkbox checkbox-primary">
							<input type="checkbox" class="styled" id="registro"  name="registro" <?php echo $element['registro'] == 1 ? "checked" : "";?>>
							<label for="registro"><?php e_strTranslate("MOD_Alert_allow_register");?></label>
						</div>
					</div>
					<div class="form-group col-md-6">
						<label for="registro_limite"><?php e_strTranslate("MOD_Alert_limit_register");?></label>
						<input type="text" class="form-control numeric text-right" id="registro_limite" name="registro_limite" value="<?php echo $element['registro_limite'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
					</div>
				</div>
				<?php endif;?>

			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="form-group col-md-12">
						<label for="priority"><?php e_strTranslate("MOD_Alert_Priority");?></label>
						<select class="form-control" name="priority" id="priority" data-alert="<?php e_strTranslate("Required_field");?>">
							<option value="hight" <?php echo ($element['priority'] == 'hight' ? 'selected="selected" ' : '');?>>Alta</option>
							<option value="medium" <?php echo ($element['priority'] == 'medium' ? 'selected="selected" ' : '');?>>Media</option>
							<option value="low" <?php echo ($element['priority'] == 'low' ? 'selected="selected" ' : '');?>>Baja</option>
						</select>
					</div>
				</div>


				<div class="row" style="overflow: visible">
					<div class="form-group col-md-6">
						<label for="id_alert_type"><?php e_strTranslate("Category");?></label>
						<select class="form-control selectpicker" data-container="body" name="id_alert_type" id="id_alert_type">
							<?php foreach($categorias as $categoria):?>
							<option data-content="<i style='width: 25px;display:inline-block;' class='text-center fa fa-<?php echo $categoria['icon_type'];?>'></i> <?php echo $categoria['name_type'];?>" value="<?php echo $categoria['id_alert_type'];?>" <?php echo ($element['id_alert_type'] == $categoria['id_alert_type'] ? 'selected="selected" ' : '');?>><?php echo $categoria['name_type'];?></option>
							<?php endforeach;?>
						</select>
					</div>

					<div class="form-group col-md-6">
						<label for="nombre_archivo">
							Documentación 
							<i class="fa fa-info-circle text-muted user-tip" title="<?php e_strTranslate("MOD_Alert_documents_info");?>"></i>
							<?php if($element['nombre_archivo'] != '') echo '<ul><li><small><a class="" href="docs/showfile.php?file='.$element['nombre_archivo'].'">'.$element['nombre_archivo'].'</a></small></li></ul>';?>
						</label>
						<input type="hidden" name="nombre_archivo_old" id="nombre_archivo_old" value="<?php echo $element['nombre_archivo'];?>" />
						<input name="nombre_archivo" id="nombre_archivo" type="file" class="btn btn-info btn-block" title="<?php e_strTranslate("Choose_file")?>" />
					</div>
				</div>


				<div class="row">
					<div class="form-group col-md-6">
						<label for="type_alert"><?php e_strTranslate("Type");?></label>
						<select class="form-control" name="type_alert" id="type_alert" data-sel="<?php echo $element['destination_alert'];?>" data-alert="<?php e_strTranslate("Required_field");?>">
							<option value="user" <?php echo ($element['type_alert'] == 'user' ? 'selected="selected" ' : '');?>>Usuario</option>
							<?php if ($_SESSION['user_perfil'] != 'usuario'):?>
							<option value="group" <?php echo ($element['type_alert'] == 'group' ? 'selected="selected" ' : '');?>><?php e_strTranslate("Group_user") ?></option>
							<?php endif;?>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="destination_alert">Destinatario</label>
						<select name="destination_alert[]" id="destination_alert" data-alert="<?php e_strTranslate("Required_field");?>" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" multiple data-actions-box="true" data-none-selected-text="<?php e_strTranslate("Seleccionar destinatario");?>" data-deselect-all-text="<?php e_strTranslate('deselect_all');?>"  data-select-all-text="<?php e_strTranslate('select_all');?>">

						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6">
						<label class=" control-label" for="date_ini">Inicio</label>
						<div id="datetimepicker1" class="input-group date">
							<input data-val="<?php echo date('D M d Y H:i:s O',strtotime($element['date_ini']));?>" data-format="yyyy/MM/dd" readonly type="text" id="date_ini" class="form-control" name="date_ini" data-alert="<?php e_strTranslate("Required_date");?>"></input>
							<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>

					<div class="form-group col-md-6">
						<label class=" control-label" for="date_fin">Fin</label>
						<div id="datetimepicker2" class="input-group date">
							<input data-val="<?php echo date('D M d Y H:i:s O',strtotime($element['date_fin']));?>" data-format="yyyy/MM/dd" readonly type="text" id="date_fin" class="form-control" name="date_fin" data-alert="<?php e_strTranslate("Required_date");?>"></input>
							<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
				</div>


				<div class="row">
					<div class="form-group col-md-6">
						<label class="control-label" for="time_ini">Hora inicio</label>
						<div class="input-group bootstrap-timepicker timepicker">
							<input data-val="<?php echo $element['time_ini'];?>" value="" id="time_ini" name="time_ini" type="text" readonly="readonly" class="form-control input-small" data-alert="">
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
						</div>
					</div>
					<div class="form-group col-md-6">
						<label class="control-label" for="time_fin">Hora fin</label>
						<div class="input-group bootstrap-timepicker timepicker">
							<input data-val="<?php echo $element['time_fin'];?>" value="" id="time_fin" name="time_fin" type="text" readonly="readonly" class="form-control input-small" data-alert="">
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
						</div>
					</div>
				</div>

			</div>
		</div>


		<div class="row">
			<div class="form-group col-md-3">
				<input type="submit" class="btn btn-primary btn-block" name="submitFormAddAction" id="submitFormAddAction" value="<?php e_strTranslate('Save')?> <?php echo strtolower(strTranslate('MOD_Alert'));?>">
			</div>
		</div>
	</form>
	<?php endif;
} ?>