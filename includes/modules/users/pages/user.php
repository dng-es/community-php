<?php
addJavascripts(array(getAsset("users")."js/user.js"));

//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

session::getFlashMessage( 'actions_message' );
usersController::insertUserAction();
usersController::updateUserAction();
usersController::deleteFotoAction();
$elements = usersController::getItemAction();
$estadisticas = usersController::getUserStatistics();

?>
	
<div class="row row-top">
	<div class="col-md-6">
		<h1><?php echo strTranslate("User_info");?></h1>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#general" data-toggle="tab"><?php echo strTranslate("Main_data");?></a></li>
		  <li><a href="#statistics" data-toggle="tab"><?php echo strTranslate("Statistics");?></a></li>
		</ul>		
		
		<div class="tab-content">
			<div class="tab-pane fade in active" id="general">
			<br />	
			<form id="formData" role="form" name="formData" method="post" action="">
			<input type="hidden" name="level_user" value="3"/>
			<input type="hidden" id="id_username" name="id_username" value="<?php echo $elements[0]['username'];?>" />
			<table style="width:100%; border-spacing:5px; border-collapse: separate">
			  <tr><td width="30%" valign="top"><label><?php echo strTranslate("Username");?>:</label></td><td width="70%">
			  <input type="text" class="form-control<?php if (isset($_REQUEST['id']) and $_REQUEST['id']!="") {echo ' TextDisabled" readonly="readonly';}?>" Size="40" id="username" name="username" value="<?php echo $elements[0]['username'];?>"/>
			  <span id="user-alert" class="alert-message alert alert-danger"></span>
			  </td></tr>
			  <tr><td width="30%" valign="top"><label><?php echo strTranslate("Nick");?>:</label></td><td width="70%">
			  <input type="text" class="form-control TextDisabled" readonly="readonly" Size="40" id="nick_user" name="nick_user" value="<?php echo $elements[0]['nick'];?>"/>
			  </td></tr>
			  <tr><td valign="top" width="30%"><label><?php echo strTranslate("Password");?>:</label></td><td width="70%">
			  <input type="text" class="form-control" id="user_password" name="user_password" value="<?php echo $elements[0]['user_password'];?>"/>
			  <span id="pass-alert" class="alert-message alert alert-danger"></span>
			  </td></tr>  
			  <tr><td valign="top"><label><?php echo strTranslate("Name");?>:</label></td><td>
			  <input type="text" class="form-control" id="name_user" name="name_user" value="<?php echo $elements[0]['name'];?>"/>
			  <span id="nombre-alert" class="alert-message alert alert-danger"></span>
			  </td></tr>
			  <tr><td><label><?php echo strTranslate("Surname");?>:</label></td><td>
				<input type="text" class="form-control" name="surname" value="<?php echo $elements[0]['surname'];?>"/></td></tr>    
			  <tr><td valign="top"><label><?php echo strTranslate("Profile");?>:</label></td><td>
			  <select id="perfil_user" name="perfil_user" class="form-control">
			  <option value="">--<?php echo strTranslate("Choose_profile");?>--</option>
			  	<?php ComboPerfiles($elements[0]['perfil']);?>
			  </select>
			  <span id="perfil-alert" class="alert-message alert alert-danger"></span>
			  </td>
			  </tr>
			  <tr><td valign="top"><label><?php echo strTranslate("Channel");?>:</label></td><td>
			  <select id="canal_user" name="canal_user" class="form-control">
			  <option value="">--<?php echo strTranslate("Choose_channel");?>--</option>
			  	<?php ComboCanales($elements[0]['canal']);?>
			  </select>
			  <span id="canal-alert" class="alert-message alert alert-danger"></span>
			  </td>
			  </tr>
			  <tr><td valign="top"><label><?php echo strTranslate("Group_user");?>:</label></td><td>
			  <select id="empresa_user" name="empresa_user" class="form-control">
			  <option value="">--<?php echo strTranslate("Choose_group");?>--</option>
			  	<?php 
			  		  $users = new users();
			  		  $centros = $users->getTiendas("");
			  		  foreach($centros as $centro): ?>
			  			<option value="<?php echo $centro['cod_tienda'];?>" <?php if ($elements[0]['empresa']==$centro['cod_tienda']){ echo ' selected="selected" ';}?>><?php echo $centro['nombre_tienda'];?></option>	
			  	<?php endforeach;
			  	?>
			  </select>
			  <span id="empresa-alert" class="alert-message alert alert-danger"></span>
			  </td></tr>
			  <tr><td><label>Teléfono:</label></td><td>
			  <input type="text" class="form-control" name="telefono_user" value="<?php echo $elements[0]['telefono'];?>"/>
			  <span id="telefono-alert" class="alert-message alert alert-danger"></span>
			  </td></tr>
			  <tr><td valign="top"><label>Email:</label></td><td>
			  <input type="text" class="form-control" id="email_user" name="email_user" value="<?php echo $elements[0]['email'];?>"/>
			  <span id="email-alert" class="alert-message alert alert-danger"></span>
			  </td></tr>
			  <tr><td></td><td>
			  	<br />
				<label checkbox-inline>
					<input type="checkbox" id="confirmed_user"  name="confirmed_user" <?php echo $elements[0]['confirmed']==1 ? "checked" : "";?>> <?php echo strTranslate("Confirmed");?>
				</label>

				<label checkbox-inline>
					<input type="checkbox" id="registered_user"  name="registered_user" <?php echo $elements[0]['registered']==1 ? "checked" : "";?>> <?php echo strTranslate("Registered");?>
				</label>

				<label checkbox-inline>
					<input type="checkbox" id="disabled_user"  name="disabled_user" <?php echo $elements[0]['disabled']==1 ? "checked" : "";?>> <?php echo strTranslate("Disabled");?>
				</label>
			  <tr><td>&nbsp;</td><td>
			  <br />
			  <button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary"><?php echo strTranslate("Save_data");?></button>
			  <br /><br />
			  </td></tr>
			</table>
		</form>	
	</div>

	<div class="tab-pane fade" id="statistics">
		<br />
		<p>Estadísticas de uso de la comunidad por el usuario <b><?php echo $elements[0]['username'];?></b></p>
		<table class="table">
		<tr><td><label>Fecha de alta</label></td><td><?php echo $elements[0]['date_add'];?></td></tr>
		<tr><td><label><?php echo ucfirst(strTranslate("APP_points"));?></label></td><td><?php echo $elements[0]['puntos'];?></td></tr>
		<tr><td><label>Participaciones</label></td><td><?php echo $elements[0]['participaciones'];?></td></tr>
		<?php if (count($estadisticas)>0): ?>
			<?php foreach(array_keys($estadisticas) as $final): ?>
				<tr><td><label><?php echo $final;?></label></td><td><?php echo $estadisticas[$final];?></td></tr>
			<?php endforeach;?>
		<?php endif;?>
		</table>
	</div>	
	</div>			
	</div>

	<div class="col-md-3">
		<br /><br />
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo strTranslate("Picture");?></div>
			<div class="panel-body">
				  <img src="<?php echo PATH_USERS_FOTO.(($elements[0]['foto']=="") ? "user.jpg" : $elements[0]['foto']);?>" style="width:100%" class="responsive" /><br /><br />
				<?php
				echo '<div class="btn btn-primary btn-block" id="DeleteFoto" onClick="Confirma(\'¿Seguro que desea borrar la foto del usuario?\',
					\'?page=user&id='.$elements[0]['username'].'&f='.$elements[0]['foto'].'\')" 
					title="'.strTranslate("Delete_photo").'" />'.strTranslate("Delete_photo").'</div>';
				?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>