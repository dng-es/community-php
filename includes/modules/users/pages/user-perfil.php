<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

addCss(array("css/bootstrap-datetimepicker.min.css"));

addJavascripts(array("js/bootstrap.file-input.js", 
					"js/bootstrap-datepicker.js", 
					"js/bootstrap-datepicker.es.js", 
					getAsset("users")."js/user-perfil.js"));

session::getFlashMessage( 'actions_message' ); 
usersController::updatePerfilAction();
usersSucursalesController::createAction();
usersSucursalesController::deleteAction();
$usuario = usersController::getPerfilAction();
$sucursales = usersSucursalesController::getListAction(-1, $_SESSION['user_name']);
?>

<div id="page-info"><?php echo strTranslate("My_profile");?></div>
<div class="row inset row-top">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
		<li <?php echo (!(isset($_GET['t'])) ? ' class="active"' : '');?>><a href="#general" data-toggle="tab">Datos generales</a></li>
		<li <?php echo ((isset($_GET['t']) and $_GET['t']==2) ? ' class="active"' : '');?>><a href="#sucursales" data-toggle="tab">Sucursales activas</a></li>
	</ul>	
	
	<div class="tab-content">
		<div class="tab-pane fade in <?php echo (!(isset($_GET['t'])) ? ' active' : '');?>" id="general">
			<div class="row inset"> 
				<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form">
			  		<div class="col-md-9">
						<input type="hidden" name="user-username" id="user-username" value="<?php echo $_SESSION['user_name'];?>">
						<table border="0" cellpadding="2" cellspacing="0" width="100%">
							<tr valign="top">
								<td><label for="user-empresa"><?php echo strTranslate("Group_user");?>:</label></td>
								<td>
								  <input type="text" name="user-empresa" id="user-empresa" class="form-control" disabled="disabled" value="<?php echo $usuario['nombre_tienda'];?>" />
								</td>
							</tr>
							<tr valign="top">
								<td><label for="username-text"><?php echo strTranslate("Username");?>:</label></td>
								<td>
								  <input type="text" name="username-text" id="username-text" class="form-control" disabled="disabled" value="<?php echo $_SESSION['user_name'];?>" />
								</td>
							</tr>
							<tr valign="top">
								<td><label for="user-nick"><?php echo strTranslate("Nick");?>:</label></td>
								<td>
								  <input maxlength="100" name="user-nick" id="user-nick" type="text" class="form-control" value="<?php echo $usuario['nick'];?>" />
								  <span id="user-nick-alert" class="alert-message alert alert-danger"></span>
								</td>
							</tr>
							<tr valign="top">
								<td><label for="user-nombre"><?php echo strTranslate("Name");?>:</label></td>
								<td>
								  <input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="<?php echo $usuario['name'];?>" />
								  <span id="user-nombre-alert" class="alert-message alert alert-danger"></span>
								</td>
							</tr>
							<tr valign="top">
								<td><label for="user-apellidos"><?php echo strTranslate("Surname");?>:</label></td>
								<td>
								  <input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="<?php echo $usuario['surname'];?>" />
								  <span id="user-apellidos-alert" class="alert-message alert alert-danger"></span>
								</td>
							</tr>					
							<tr valign="top">
								<td><label for="user-date"><?php echo strTranslate("Born_date");?>:</label></td>
								<td>

									  <div id="datetimepicker1" class="input-group date">
									    <input data-format="yyyy/MM/dd" readonly type="text" id="user-date" class="form-control" name="user-date"></input>
									      <span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
									  </div>

									  <script>
										jQuery(document).ready(function(){
											$("#datetimepicker1").datetimepicker({
										      language: "es-ES",
										      startDate: "2014/01/01"
										    });
		<?php 								    
		if ($usuario['user_date']!=null){
			echo "							var fecha = '".date('D M d Y H:i:s O',strtotime($usuario['user_date']))."';";
			echo '							$("#datetimepicker1").data("datetimepicker").setLocalDate(new Date (fecha));';
		}
		?>								});
									  </script>

									<span id="user-date-alert" class="alert-message alert alert-danger"></span>
								</td>
							</tr>
							
							<tr valign="top">
								<td><label for="user-email">Email:</label></td>
								<td>
								  <input maxlength="100" name="user-email" id="user-email" type="text" class="form-control" value="<?php echo $usuario['email'];?>" />
								  <span id="user-email-alert" class="alert-message alert alert-danger"></span>
								</td>
							</tr>
							<tr valign="top">
								<td><label for="user-pass"><?php echo strTranslate("Password");?>:</label></td>
								<td>
								  <input maxlength="100" name="user-pass" id="user-pass" type="password" class="form-control" value="<?php echo $usuario['user_password'];?>" />
								  <span id="user-pass-alert" class="alert-message alert alert-danger"></span>
								</td>
							</tr>
							<tr valign="top">
								<td nowrap="nowrap"><label for="user-repass"><?php echo strTranslate("Password_re");?>:</label></td>
								<td>
								  <input maxlength="100" name="user-repass" id="user-repass" type="password" class="form-control" value="<?php echo $usuario['user_password'];?>" />
								  <span id="user-repass-alert" class="alert-message alert alert-danger"></span>
								</td>
							</tr>
							</tr>
							<tr valign="top">
								<td nowrap="nowrap"><label for="user-comentarios"><?php echo strTranslate("Address");?>:</label></td>
								<td>
								  <textarea name="user-comentarios" id="user-comentarios" class="form-control"><?php echo $usuario['user_comentarios'];?></textarea>
								  <span id="user-comentarios-alert" class="alert-message alert alert-danger"></span>
								</td>
							</tr>					
						</table>
					</div>
			  		<div class="col-md-3">
						<img src="<?php echo $usuario['user_foto'];?>" style="width:100%" /><br />
						<p>Selecciona una imagen para tu perfil en formato JPG, PNG o GIF. El tamaño de la imagen no podrá exceder de 1MG.</p>
						<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary btn-block" title="<?php echo strTranslate("Change_picture");?>" /><br />
						<input type="submit" class="btn btn-primary btn-block" id="confirm-submit" name="confirm-submit" value="<?php echo strTranslate("Save_data");?>" />
					</div>
				</form>
			</div>
		</div>
		<div class="tab-pane fade <?php echo ((isset($_GET['t']) and $_GET['t']==2) ? ' in active' : '');?>" id="sucursales">
			<div class="row">
				<div class="col-md-5">
					<br /><p>Puedes agregar nuevas sucursales a tu tienda:</p>
					<div class="panel panel-default">
						<div class="panel-heading"><i class="fa fa-plus-square"></i> Agregar sucursal</a></div>
						<div class="panel-body">
							<form id="form-sucursal" method="post" action="?page=user-perfil&t=2" role="form">
								<label for="sucursal_name"><?php echo strTranslate("Name");?></label>
								<input type="text" name="sucursal_name" id="sucursal_name" class="form-control" />
								<span id="sucursal-name-alert" class="alert-message alert alert-danger"></span>
								<label for="sucursal_direccion"><?php echo strTranslate("Address");?></label>
								<input type="text" name="sucursal_direccion" id="sucursal_direccion" class="form-control" />
								<span id="sucursal-direccion-alert" class="alert-message alert alert-danger"></span>					
								<br />
								<button class="btn btn-primary" type="submit"><?php echo strTranslate("Save_data");?></button>
							</form>
						</div>
					</div>				
				</div>
				<div class="col-md-7">
					<br /><p>Tus sucursales dadas de alta</p>
					<?php if (count($sucursales['items'])>0):?>
						<table class="table">
						<tr>
							<th width="30px">&nbsp;</th>
							<th>Nombre</th>
							<th>Dirección</th>
						</tr>
						<?php foreach($sucursales['items'] as $sucursal): ?>
						<tr>
							<td nowrap="nowrap">
								<a class="fa fa-ban icon-table" title="Eliminar"
									onClick="Confirma('¿Seguro que deseas eliminar la sucursal?', '?page=user-perfil&t=2&act=del&id=<?php echo $sucursal['id_sucursal'];?>'); return false;">
								</a>
							</td>	
							<td><?php echo $sucursal['name_sucursal'];?></td>
							<td><?php echo $sucursal['address_sucursal'];?></td>
						</tr>
						<?php endforeach;?>
						</table>
					<?php else:?>
						<div class="alert alert-warning">Todavia no has dado de alta sucursales</div>
					<?php endif;?>
				</div>
			</div>			
		</div>
	</div>
</div>