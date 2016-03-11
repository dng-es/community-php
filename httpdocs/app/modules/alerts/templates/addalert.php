<?php 
function addAlert(){ ?>
	<form action="" name="formAddAction" id="formAddAction" method="post" role="form">
		<div class="form-group col-md-12">
			<label for="priority">Prioridad</label>
			<select class="form-control" name="priority" id="priority" data-alert="<?php e_strTranslate("Required_field");?>">
				<option value="hight">Alta</option>
				<option value="medium">Media</option>
				<option value="low">Baja</option>
			</select>
		</div>			
		<div class="form-group col-md-6">
			<label for="type_alert"><?php e_strTranslate("Type");?></label>
			<select class="form-control" name="type_alert" id="type_alert" data-alert="<?php e_strTranslate("Required_field");?>">
				<option value="user">Usuario</option>
				<option value="group"><?php e_strTranslate("Group_user") ?></option>
			</select>
		</div>
		<div class="form-group col-md-6">
			<label for="destination_alert">Destinatario</label>
			<select class="form-control" name="destination_alert" id="destination_alert" data-alert="<?php e_strTranslate("Required_field");?>">

			</select>
		</div>		
		<div class="form-group col-md-12">
			<label for="text_alert"><?php e_strTranslate("Description");?></label>
			<textarea class="form-control" name="text_alert" id="text_alert" data-alert="<?php e_strTranslate("Required_field");?>"></textarea>
		</div>
		<div class="form-group col-md-6">
			<label class=" control-label" for="date_ini">Inicio</label>
			<div id="datetimepicker1" class="input-group date">
				<input data-format="yyyy/MM/dd" readonly type="text" id="date_ini" class="form-control" name="date_ini" data-alert="<?php e_strTranslate("Required_date");?>"></input>
				<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
			</div>
		</div>

		<div class="form-group col-md-6">
			<label class=" control-label" for="date_fin">Fin</label>
			<div id="datetimepicker2" class="input-group date">
				<input data-format="yyyy/MM/dd" readonly type="text" id="date_fin" class="form-control" name="date_fin" data-alert="<?php e_strTranslate("Required_date");?>"></input>
				<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
			</div>
		</div>		
		<div class="form-group col-md-12">
			<input type="submit" class="btn btn-primary btn-block" name="submitFormAddAction" id="submitFormAddAction" value="<?php e_strTranslate('Save')?>">
		</div>
	</form>
<?php 
}
?>