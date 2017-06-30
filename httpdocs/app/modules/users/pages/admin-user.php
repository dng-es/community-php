<?php
addJavascripts(array("js/jquery.geturlparam.js",
					getAsset("users")."js/connect-as.js",
					getAsset("users")."js/admin-user.js"));

templateload("cmbCanales", "users");

$id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : "");
$user_permissions = usersController::getUserPermissions($id);
$special_pages = array("login", "registration", "registration_process", "registration-confirm", "remember", "user-confirm", "users-conn-ajax", "users-conn-data", "admin-puntos-ajax", "admin-cargas-user-process", "admin-cargas-puntos-process",  
	"muro_responder_ajax", "muro_process", "muro_todos_ajax", "muro-respuestas", "mensajes-leer", "mensajes-verify", 
	"ut", "lt", "unsuscribe", "cron-birthday", "cron-scheduled", "admin-message-test", "admin-message-proccess", 
	"admin-message-proccess-step1", "user-message-test", "admin-area-edit-t", "admin-cargas-user-areas-process",
	"fotos-comments-ajax", "fotos-load-ajax", "gallery_process", "admin-cuestionario-revs-ajax",
	"videos-process", "admin-modules-ajax-process", "admin-modules-ajax");

$base_dir = str_replace('modules/users/pages', '', realpath(dirname(__FILE__))) ;
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"admin-users"),
			array("ItemLabel"=>strTranslate("User_info"), "ItemClass"=>"active"),
		));
		
		session::getFlashMessage('actions_message');
		usersController::insertUserAction();
		usersController::updateUserAction();
		usersController::deleteFotoAction();
		usersController::updatePermissionsAction();
		if(getModuleExist("recompensas")):
			templateload("user_recompensa", "recompensas");
			recompensasController::deleteUserRewardAction();
			recompensasController::insertUserRewardAction();
		endif;
		$elements = usersController::getItemAction();
		$foto_user = usersController::getUserFoto($elements[0]['foto']);
		$estadisticas = usersController::getUserStatistics();
		?>
		<div class="panel panel-default">
			<div class="panel-body">
		<!-- Nav tabs -->
		<button type="button" class="btn btn-default btn-xs connect-as pull-right" data-u="<?php echo $elements[0]['username'];?>" data-p="<?php echo $elements[0]['user_password'];?>"><i class="fa fa-plug"></i> <?php e_strTranslate("Connect_as");?></button>
		<ul class="nav nav-tabs" id="myTab">
			<li><a href="#general" data-toggle="tab"><?php e_strTranslate("Main_data");?></a></li>
			<li><a href="#statistics" data-toggle="tab"><?php e_strTranslate("Statistics");?></a></li>
			<?php if(getModuleExist("recompensas")): ?>
			<li><a href="#rewards" data-toggle="tab"><?php e_strTranslate("Rewards");?></a></li>
			<?php endif; ?>
			<li><a href="#permissions" data-toggle="tab"><?php e_strTranslate("Permissions");?></a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane fade in" id="general">
				<div class="row">
					<div class="col-md-9 inset">
						<form id="formData" role="form" name="formData" method="post" action="">
							<input type="hidden" name="level_user" value="3"/>
							<input type="hidden" id="id_username" name="id_username" value="<?php echo $elements[0]['username'];?>" />
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="username"><small><?php e_strTranslate("Username");?>:</small></label>
									<input type="text" class="form-big form-control<?php if ($id != "") echo ' TextDisabled" readonly="readonly';?>" id="username" name="username" value="<?php echo $elements[0]['username'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
								</div>
								<div class="col-md-6 form-group">
									<label for="nick_user"><small><?php e_strTranslate("Nick");?>:</small></label>
									<input type="text" class="form-control TextDisabled" readonly="readonly" id="nick_user" name="nick_user" value="<?php echo $elements[0]['nick'];?>" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="user_password"><small><?php e_strTranslate("Password");?>:</small></label>
									<input type="text" class="form-control" id="user_password" name="user_password" value="<?php echo $elements[0]['user_password'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
								</div>
								<div class="col-md-6 form-group">
									<label for="perfil_user"><small><?php e_strTranslate("Profile");?>:</small></label>
									<select id="perfil_user" name="perfil_user" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>">
										<option value="">--<?php e_strTranslate("Choose_profile");?>--</option>
										<?php ComboPerfiles($elements[0]['perfil']);?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="name_user"><small><?php e_strTranslate("Name");?>:</small></label>
									<input type="text" class="form-control" id="name_user" name="name_user" value="<?php echo $elements[0]['name'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
								</div>
								<div class="col-md-6 form-group">
									<label for="surname"><small><?php e_strTranslate("Surname");?>:</small></label>
									<input type="text" class="form-control" name="surname" value="<?php echo $elements[0]['surname'];?>" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="canal_user"><small><?php e_strTranslate("Channel");?>:</small></label>
									<select id="canal_user" name="canal_user" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>">
										<option value="">--<?php e_strTranslate("Choose_channel");?>--</option>
										<?php ComboCanales($elements[0]['canal'], "");?>
									</select>
								</div>
								<div class="col-md-6 form-group">
									<label for="empresa_user"><small><?php e_strTranslate("Group_user");?>:</small></label>
									<select id="empresa_user" name="empresa_user" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>">
										<option value="">--<?php e_strTranslate("Choose_group");?>--</option>
										<?php 
										$users = new users();
										$centros = $users->getTiendas("");
										foreach($centros as $centro): ?>
										<option value="<?php echo $centro['cod_tienda'];?>" <?php if ($elements[0]['empresa'] == $centro['cod_tienda']) echo ' selected="selected" ';?>><?php echo $centro['nombre_tienda'];?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="telefono_user"><small><?php e_strTranslate("Telephone");?>:</small></label>
									<input type="text" class="form-control" name="telefono_user" value="<?php echo $elements[0]['telefono'];?>" />
								</div>
								<div class="col-md-6 form-group">
									<label for="email_user"><small>Email:</small></label>
									<input type="text" class="form-control" id="email_user" name="email_user" value="<?php echo $elements[0]['email'];?>" data-alert="<?php e_strTranslate("Required_email");?>" />
								</div>
							</div>
							<hr />
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="direccion_user"><small><?php e_strTranslate("Address");?>:</small></label>
									<input type="text" class="form-control" id="direccion_user" name="direccion_user" value="<?php echo $elements[0]['direccion_user'];?>" />
								</div>
								<div class="col-md-6 form-group">
									<label for="ciudad_user"><small><?php e_strTranslate("City");?>:</small></label>
									<input type="text" class="form-control" id="ciudad_user" name="ciudad_user" value="<?php echo $elements[0]['ciudad_user'];?>" data-alert="<?php e_strTranslate("Required_email");?>" />
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 form-group">
									<label for="provincia_user"><small><?php e_strTranslate("State");?>:</small></label>
									<input type="text" class="form-control" id="provincia_user" name="provincia_user" value="<?php echo $elements[0]['provincia_user'];?>" />
								</div>
								<div class="col-md-6 form-group">
									<label for="cpostal_user"><small><?php e_strTranslate("Postal_code");?>:</small></label>
									<input type="text" class="form-control" id="cpostal_user" name="cpostal_user" value="<?php echo $elements[0]['cpostal_user'];?>" data-alert="<?php e_strTranslate("Required_email");?>" />
								</div>
							</div>

							<hr />
							<div class="row inset">
								<div class="col-md-4 form-group">
									<div class="checkbox checkbox-primary">
										<input type="checkbox" onclick="return false;" onkeydown="e = e || window.event; if(e.keyCode !== 9) return false;" class="styled disabled" id="confirmed_user" name="confirmed_user" <?php echo $elements[0]['confirmed'] == 1 ? "checked" : "";?>>
										<label class="disabled" for="confirmed_user" onclick="return false;" onkeydown="e = e || window.event; if(e.keyCode !== 9) return false;"><?php e_strTranslate("Confirmed");?></label>
									</div>
								</div>

								<div class="col-md-4 form-group">
									<div class="checkbox checkbox-primary">
										<input type="checkbox" class="styled" id="registered_user"  name="registered_user" <?php echo $elements[0]['registered'] == 1 ? "checked" : "";?>>
										<label for="registered_user"><?php e_strTranslate("Registered");?></label>
									</div>
								</div>

								<div class="col-md-4 form-group">
									<div class="checkbox checkbox-primary">
										<input type="checkbox" class="styled" id="disabled_user"  name="disabled_user" <?php echo $elements[0]['disabled'] == 1 ? "checked" : "";?>>
										<label for="disabled_user"><?php e_strTranslate("Disabled");?></label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 form-group">
									<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary"><?php e_strTranslate("Save_data");?></button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-3 inset">
						<br />
						<div class="panel panel-default">
							<div class="panel-heading"><?php e_strTranslate("Picture");?></div>
							<div class="panel-body nopadding">
								<img src="<?php echo $foto_user;?>" style="width:100%" class="responsive" /><br /><br />
								<?php
								echo '<div class="btn btn-primary btn-block" id="DeleteFoto" onClick="Confirma(\'¿Seguro que desea borrar la foto del usuario?\',
									\'admin-user?id='.$elements[0]['username'].'&f='.$elements[0]['foto'].'\')" 
									title="'.strTranslate("Delete_photo").'" />'.strTranslate("Delete_photo").'</div>';
								?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="statistics">
				<div class="row">
					<div class="col-md-12 inset">
						<p class="text-muted">Estadísticas de uso de la comunidad por el usuario <b><?php echo $elements[0]['username'];?></b></p>
						<table class="table table-striped">
							<tr><td><label><?php e_strTranslate("Date_add");?></label></td><td><?php echo getDateFormat($elements[0]['date_add'], "DATE_TIME");?></td></tr>
							<tr><td><label><?php echo ucfirst(strTranslate("APP_points"));?></label></td><td><?php echo $elements[0]['puntos'];?></td></tr>
							<tr><td><label><?php echo ucfirst(strTranslate("APP_shares"));?></label></td><td><?php echo $elements[0]['participaciones'];?></td></tr>
							<?php if (count($estadisticas)>0):?>
								<?php foreach(array_keys($estadisticas) as $final):?>
									<tr><td><label><?php echo $final;?></label></td><td><?php echo $estadisticas[$final];?></td></tr>
								<?php endforeach;?>
							<?php endif;?>
						</table>
					</div>
				</div>
			</div>

			<?php if(getModuleExist("recompensas")): ?>
			<div class="tab-pane fade" id="rewards">
				<div class="row">
					<div class="col-md-12 inset">
						<?php userRecompensaAdmin($elements[0]['username']);?>
					</div>
				</div>
			</div>
			<?php endif;?>

			<div class="tab-pane fade" id="permissions">
				<div class="row">
					<div class="col-md-12 inset">
						<p class="text-muted">Permisos del usuario <b><?php echo $elements[0]['username'];?></b></p>
						<?php foreach($modules as $module): 
							$pages = FileSystem::showFilesFolder($base_dir . "modules/" . $module['folder']."/pages");
							?>
							<form method="post" action="">
								<input type="hidden" name="user_permission" id="user_permission" value="<?php echo $elements[0]['username'];?>" />
								<input type="hidden" name="user_permission_module" id="user_permission_module" value="<?php echo $module['folder'];?>" />
								<table class="table table-striped">
									<tr>
										<th><?php e_strTranslate(ucfirst($module['folder']));?></th>
										<th width="80px"><?php e_strTranslate("View");?></th>
										<th width="80px"><?php e_strTranslate("Edit");?></th>
									</tr>
									<?php foreach($pages as $page):  
									$page_name = str_replace(".php", "", $page);
									$permission_check_view = "";
									$permission_input_view = 0;
									$permission_view_found = false;
									$permission_check_edit = "";
									$permission_input_edit = 0;
									$permission_edit_found = false;
									if(!in_array($page_name, $special_pages)):  
										foreach($user_permissions as $permission):  
											if ($permission['pagename'] == $page_name && $permission['permission_type'] == "view"){
												if ($permission['permission_type_value'] == 1){
													$permission_check_view = ' checked="checked" ';
													$permission_input_view = 1;
												}
												$permission_view_found = true;
											}

											if ($permission['pagename'] == $page_name && $permission['permission_type'] == "edit"){
												if ($permission['permission_type_value'] == 1){
													$permission_check_edit = ' checked="checked" ';
													$permission_input_edit = 1;
												}
												$permission_edit_found = true;
											}

										endforeach;
										
										if ($elements[0]['perfil'] == 'admin'){
											//permisos genericos administradores
											if (!$permission_view_found){
												$permission_check_view = ' checked="checked" ';
												$permission_input_view = 1;
											}

											if (!$permission_edit_found){
												$permission_check_edit = ' checked="checked" ';
												$permission_input_edit = 1;
											}
										}
										else{
											//permisos genericos usuarios
											if (!$permission_view_found && (strpos($page_name, 'admin') !== 0)){
												$permission_check_view = ' checked="checked" ';
												$permission_input_view = 1;
											}

											if (!$permission_edit_found && (strpos($page_name, 'admin') !== 0)){
												$permission_check_edit = ' checked="checked" ';
												$permission_input_edit = 1;
											}
										}
										?>
										<tr>
											<td><label><?php echo $page_name;?></label></td>
											<td>
												<input class="permission-check" <?php echo $permission_check_view;?> type="checkbox">
												<input type="hidden" name="view_<?php echo $page_name;?>" id="view_<?php echo $page_name;?>" value="<?php echo $permission_input_view;?>">
											</td>
											<td>
												<input class="permission-check" <?php echo $permission_check_edit;?> type="checkbox">
												<input  type="hidden" name="edit_<?php echo $page_name;?>" id="edit_<?php echo $page_name;?>" value="<?php echo $permission_input_edit;?>">
											</td>
										</tr>
									<?php endif;?>
									<?php endforeach;?>
								</table>
								<button type="submit" class="btn btn-default btn-xs pull-right"><?php e_strTranslate("Save");?> <?php e_strTranslate("Permissions");?></button>
								<div class="clearfix"></div>
							</form>
							<br />
						<?php endforeach;?>
						<br />
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	<?php menu::adminMenu();?>
</div>