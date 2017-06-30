<?php 

function userAddress($usuario){ ?>
	<form id="address-form" name="address-form" action="" method="post" role="form" class="form-horizontal">
		<div class="row hidden">
			<div class="col-md-6">
				<label class=" control-label" for="user-nombre"><small><?php e_strTranslate("Name");?></small></label>
				<input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="<?php echo $usuario['name'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
			</div>
			<div class="col-md-6">
				<label class="control-label" for="user-apellidos"><small><?php e_strTranslate("Surname");?></small></label>
				<input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="<?php echo $usuario['surname'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label class=" control-label" for="direccion_user"><small><?php e_strTranslate("Address");?></small></label>
				<input maxlength="250" name="direccion_user" id="direccion_user" type="text" class="form-control" value="<?php echo $usuario['direccion_user'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
			</div>
			<div class="col-md-6">
				<label class="control-label" for="ciudad_user"><small><?php e_strTranslate("City");?></small></label>
				<input maxlength="100" name="ciudad_user" id="ciudad_user" type="text" class="form-control" value="<?php echo $usuario['ciudad_user'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label class=" control-label" for="provincia_user"><small><?php e_strTranslate("State");?></small></label>
				<input maxlength="100" name="provincia_user" id="provincia_user" type="text" class="form-control" value="<?php echo $usuario['provincia_user'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
			</div>
			<div class="col-md-6">
				<label class="control-label" for="cpostal_user"><small><?php e_strTranslate("Postal_code");?></small></label>
				<input maxlength="10" name="cpostal_user" id="cpostal_user" type="text" class="form-control" value="<?php echo $usuario['cpostal_user'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label class="control-label" for="telefono"><small><?php e_strTranslate("Telephone");?></small></label>
				<input maxlength="10" name="telefono" id="telefono" type="text" class="form-control" value="<?php echo $usuario['telefono'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 inset">
				<input type="submit" class="btn btn-primary" id="address-submit" name="address-submit" value="<?php e_strTranslate("Update");?>" />
			</div>
		</div>
	</form>
<?php } ?>