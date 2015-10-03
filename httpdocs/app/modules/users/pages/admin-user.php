<?php
addJavascripts(array("js/jquery.geturlparam.js",
					getAsset("users")."js/connect-as.js",
					getAsset("users")."js/admin-user.js"));

templateload("cmbCanales", "users");

$modules = getListModules(); 
$user_permissions = usersController::getUserPermissions($_REQUEST['id']);
$special_pages = array("login", "registration", "registration_process", "registration-confirm", "remember", "user-confirm", "users-conn-ajax", "users-conn-data", "admin-puntos-ajax", 
						"admin-cargas-user-process", "admin-cargas-puntos-process",  
						"muro_responder_ajax", "muro_process", "muro_todos_ajax", "muro-respuestas", 
						"mensajes-leer", "mensajes-verify", 
						"ut", "lt", "unsuscribe", "cron-birthday", "cron-scheduled", "admin-message-test", "admin-message-proccess", "admin-message-proccess-step1", "user-message-test", 
						"admin-area-edit-t", "admin-cargas-user-areas-process",
						"fotos-comments-ajax", "fotos-load-ajax", "gallery_process",
						"admin-cuestionario-revs-ajax",
						"videos-process",
						"admin-modules-ajax-process", "admin-modules-ajax");

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
		
		session::getFlashMessage( 'actions_message' );
		usersController::insertUserAction();
		usersController::updateUserAction();
		usersController::deleteFotoAction();
		usersController::updatePermissionsAction();
		$elements = usersController::getItemAction();
		$estadisticas = usersController::getUserStatistics();
		?>
		<div class="panel panel-default">
			<div class="panel-body">
		<!-- Nav tabs -->
		<button type="button" class="btn btn-default btn-xs connect-as pull-right" data-u="<?php echo $elements[0]['username'];?>" data-p="<?php echo $elements[0]['user_password'];?>"><i class="fa fa-plug"></i> <?php echo strTranslate("Connect_as");?></button>
		<ul class="nav nav-tabs" id="myTab">
			<li class="active"><a href="#general" data-toggle="tab"><?php echo strTranslate("Main_data");?></a></li>
			<li><a href="#statistics" data-toggle="tab"><?php echo strTranslate("Statistics");?></a></li>
			<li><a href="#permissions" data-toggle="tab"><?php echo strTranslate("Permissions");?></a></li>
		</ul>		
		
		<div class="tab-content">
			<div class="tab-pane fade in active" id="general">
				<div class="row">
					<div class="col-md-9 inset">	
						<form id="formData" role="form" name="formData" method="post" action="">
							<input type="hidden" name="level_user" value="3"/>
							<input type="hidden" id="id_username" name="id_username" value="<?php echo $elements[0]['username'];?>" />
							<div class="row">
								<div class="col-md-6">
									<label for="username"><small><?php echo strTranslate("Username");?>:</small></label>
									<input type="text" class="form-big form-control<?php if (isset($_REQUEST['id']) and $_REQUEST['id']!="") {echo ' TextDisabled" readonly="readonly';}?>" id="username" name="username" value="<?php echo $elements[0]['username'];?>" data-alert="<?php echo strTranslate("Required_field");?>" />
								</div>
								<div class="col-md-6">
									<label for="nick_user"><small><?php echo strTranslate("Nick");?>:</small></label>
									<input type="text" class="form-control TextDisabled" readonly="readonly" id="nick_user" name="nick_user" value="<?php echo $elements[0]['nick'];?>" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label for="user_password"><small><?php echo strTranslate("Password");?>:</small></label>
							  		<input type="text" class="form-control" id="user_password" name="user_password" value="<?php echo $elements[0]['user_password'];?>" data-alert="<?php echo strTranslate("Required_field");?>" />
								</div>
								<div class="col-md-6">
									<label for="perfil_user"><small><?php echo strTranslate("Profile");?>:</small></label>
							  		<select id="perfil_user" name="perfil_user" class="form-control" data-alert="<?php echo strTranslate("Required_field");?>">
							  			<option value="">--<?php echo strTranslate("Choose_profile");?>--</option>
							  			<?php ComboPerfiles($elements[0]['perfil']);?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label for="name_user"><small><?php echo strTranslate("Name");?>:</small></label>
									<input type="text" class="form-control" id="name_user" name="name_user" value="<?php echo $elements[0]['name'];?>" data-alert="<?php echo strTranslate("Required_field");?>" />
								</div>
								<div class="col-md-6">
									<label for="surname"><small><?php echo strTranslate("Surname");?>:</small></label>
									<input type="text" class="form-control" name="surname" value="<?php echo $elements[0]['surname'];?>" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label for="canal_user"><small><?php echo strTranslate("Channel");?>:</small></label>
									<select id="canal_user" name="canal_user" class="form-control" data-alert="<?php echo strTranslate("Required_field");?>">
										<option value="">--<?php echo strTranslate("Choose_channel");?>--</option>
										<?php ComboCanales($elements[0]['canal'], "");?>
									</select>
								</div>
								<div class="col-md-6">
									<label for="empresa_user"><small><?php echo strTranslate("Group_user");?>:</small></label>
									<select id="empresa_user" name="empresa_user" class="form-control" data-alert="<?php echo strTranslate("Required_field");?>">
										<option value="">--<?php echo strTranslate("Choose_group");?>--</option>
									  	<?php 
									  		  $users = new users();
									  		  $centros = $users->getTiendas("");
									  		  foreach($centros as $centro): ?>
									  			<option value="<?php echo $centro['cod_tienda'];?>" <?php if ($elements[0]['empresa']==$centro['cod_tienda']){ echo ' selected="selected" ';}?>><?php echo $centro['nombre_tienda'];?></option>	
									  	<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label for="telefono_user"><small>Teléfono:</small></label>
									<input type="text" class="form-control" name="telefono_user" value="<?php echo $elements[0]['telefono'];?>" />
								</div>
								<div class="col-md-6">
							 		<label for="email_user"><small>Email:</small></label>
									<input type="text" class="form-control" id="email_user" name="email_user" value="<?php echo $elements[0]['email'];?>" data-alert="<?php echo strTranslate("Required_email");?>" />
								</div>
							</div>
							<div class="row inset">
								<div class="col-md-4">
									<label checkbox-inline>
										<input type="checkbox" id="confirmed_user"  name="confirmed_user" <?php echo $elements[0]['confirmed']==1 ? "checked" : "";?>> <?php echo strTranslate("Confirmed");?>
									</label>
								</div>

								<div class="col-md-4">
									<label checkbox-inline>
										<input type="checkbox" id="registered_user"  name="registered_user" <?php echo $elements[0]['registered']==1 ? "checked" : "";?>> <?php echo strTranslate("Registered");?>
									</label>
								</div>

								<div class="col-md-4">
									<label checkbox-inline>
										<input type="checkbox" id="disabled_user"  name="disabled_user" <?php echo $elements[0]['disabled']==1 ? "checked" : "";?>> <?php echo strTranslate("Disabled");?>
									</label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary"><?php echo strTranslate("Save_data");?></button>
								</div>
							</div>
						</form>	
					</div>
					<div class="col-md-3 inset">
						<br />
						<div class="panel panel-default">
							<div class="panel-heading"><?php echo strTranslate("Picture");?></div>
							<div class="panel-body nopadding">
								  <img src="<?php echo PATH_USERS_FOTO.(($elements[0]['foto']=="") ? "user.jpg" : $elements[0]['foto']);?>" style="width:100%" class="responsive" /><br /><br />
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
							<tr><td><label><?php echo strTranslate("Date_add");?></label></td><td><?php echo getDateFormat($elements[0]['date_add'], "DATE_TIME");?></td></tr>
							<tr><td><label><?php echo ucfirst(strTranslate("APP_points"));?></label></td><td><?php echo $elements[0]['puntos'];?></td></tr>
							<tr><td><label><?php echo ucfirst(strTranslate("APP_shares"));?></label></td><td><?php echo $elements[0]['participaciones'];?></td></tr>
							<?php if (count($estadisticas)>0): ?>
								<?php foreach(array_keys($estadisticas) as $final): ?>
									<tr><td><label><?php echo $final;?></label></td><td><?php echo $estadisticas[$final];?></td></tr>
								<?php endforeach;?>
							<?php endif;?>
						</table>
						
					</div>
				</div>
			</div>

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
										<th><?php echo strTranslate(ucfirst($module['folder']));?></th>
										<th width="80px"><?php echo strTranslate("View");?></th>
										<th width="80px"><?php echo strTranslate("Edit");?></th>
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
											if ($permission['pagename'] == $page_name and $permission['permission_type'] == "view"){
												if ($permission['permission_type_value'] == 1){
													$permission_check_view = ' checked="checked" ';
													$permission_input_view = 1;
												}
												$permission_view_found = true;
											}

											if ($permission['pagename'] == $page_name and $permission['permission_type'] == "edit"){
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
											if (!$permission_view_found and (strpos($page_name, 'admin') !== 0)){
												$permission_check_view = ' checked="checked" ';
												$permission_input_view = 1;
											}

											if (!$permission_edit_found and (strpos($page_name, 'admin') !== 0)){
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
								<button type="submit" class="btn btn-default btn-xs pull-right"><?php echo strTranslate("Save");?> <?php echo strTranslate("Permissions");?></button>
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