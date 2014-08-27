<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

function ini_page_header ($ini_conf) {
?>	
	<script language="JavaScript" src="<?php echo getAsset("users");?>js/user.js"></script>
<?php 
}
function ini_page_body ($ini_conf){
  //CONTROL NIVEL DE ACCESO
  $session = new session();
  $perfiles_autorizados = array("admin");
  $session->AccessLevel($perfiles_autorizados);
  
  $accion = isset($_GET['act']) ? $_GET['act'] : "";
  $accion1 = isset($_GET['act1']) ? $_GET['act1'] : "";
  $accion2 = isset($_GET['accion2']) ? $_GET['accion2'] : "";
  
  $id = (isset($_GET['id']) ? $_GET['id'] : "");
  $elements = usersController::getItemAction();
  $estadisticas = usersController::getUserStatistics();

  if ($accion=='edit' and $accion2=='ok' and $accion1!="del"){ UpdateData();}
  elseif ($accion1=="del"){ DeleteFoto();}
  elseif ($accion=='new' and $accion2=='ok'){ $id=InsertData();$accion="edit";}



  //foto del usuario
  if ($elements[0]['foto']==""){$user_foto=PATH_USERS_FOTO."user.jpg";}
  else {$user_foto=PATH_USERS_FOTO.$elements[0]['foto'];}
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
				<form id="formData" role="form" name="formData" method="post" action="?page=user&act=<?php echo $accion;?>&amp;id=<?php echo $id;?>&amp;accion2=ok">
				<input type="hidden" name="level_user" value="3"/>
				<input type="hidden" id="id_username" name="id_username" value="<?php echo $elements[0]['username'];?>" />
				<table style="width:100%">
				  <tr><td width="30%" valign="top"><label><?php echo strTranslate("Username");?>:</label></td><td width="70%">
				  <input type="text" class="form-control<?php if ($accion=='edit') {echo ' TextDisabled" readonly="readonly';}?>" Size="40" id="username" name="username" value="<?php echo $elements[0]['username'];?>"/>
				  <span id="user-alert" class="alert-message alert alert-danger"></span>
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
				  <tr><td valign="top"><label>Perfil:</label></td><td>
				  <select id="perfil_user" name="perfil_user" class="form-control">
				  <option value="">--selecciona el perfil--</option>
				  	<?php ComboPerfiles($elements[0]['perfil']);?>
				  </select>
				  <span id="perfil-alert" class="alert-message alert alert-danger"></span>
				  </td>
				  </tr>
				  <tr><td valign="top"><label>Canal:</label></td><td>
				  <select id="canal_user" name="canal_user" class="form-control">
				  <option value="">--selecciona el canal--</option>
				  	<?php ComboCanales($elements[0]['canal']);?>
				  </select>
				  <span id="canal-alert" class="alert-message alert alert-danger"></span>
				  </td>
				  </tr>  
				  <tr><td valign="top"><label>Responsable:</label></td><td>
				  <input type="text" class="form-control" id="responsable_user" name="responsable_user" value="<?php echo $elements[0]['responsable'];?>"/>
				  <span id="responsable-alert" class="alert-message alert alert-danger"></span>
				  </td></tr>
				   <tr><td valign="top"><label>Sfid:</label></td><td>
				  <input type="text" class="form-control" id="sfid_user" name="sfid_user" value="<?php echo $elements[0]['sfid'];?>"/>
				  <span id="sfid-alert" class="sfid-message"></span>
				  </td></tr>
				  <tr><td valign="top"><label><?php echo strTranslate("Group_user");?>:</label></td><td>
				  <select id="empresa_user" name="empresa_user" class="form-control">
				  <option value="">--selecciona el centro--</option>
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
				  <tr><td valign="top"><label>Territorial:</label></td><td>
					<input type="text" class="form-control" id="territorial_user" name="territorial_user" value="<?php echo $elements[0]['territorial'];?>"/>
					<span id="territorial-alert" class="alert-message alert alert-danger"></span>
					</td>
				  </tr>
				  <tr><td><label>Provincia:</label></td><td>
					<input type="text" class="form-control" name="provincia_user" value="<?php echo $elements[0]['provincia'];?>"/>
					<span id="provincia-alert" class="alert-message alert alert-danger"></span>
					</td>
				  </tr>
				  <tr><td><label>Teléfono:</label></td><td>
				  <input type="text" class="form-control" name="telefono_user" value="<?php echo $elements[0]['telefono'];?>"/>
				  <span id="telefono-alert" class="alert-message alert alert-danger"></span>
				  </td></tr>
				  <tr><td valign="top"><label>Email:</label></td><td>
				  <input type="text" class="form-control" id="email_user" name="email_user" value="<?php echo $elements[0]['email'];?>"/>
				  <span id="email-alert" class="alert-message alert alert-danger"></span>
				  </td></tr>
				  <tr><td><label>Fecha de alta:</label></td><td>
					<input class="form-control" disabled readonly="readonly" type="text" name="date_add_user" value="<?php echo $elements[0]['date_add'];?>"/> </td>
				  </tr>
				  <tr><td><label>Puntos:</label></td><td><input class="form-control input-sm" disabled type="text" readonly="readonly" name="puntos_user" value="<?php echo $elements[0]['puntos'];?>"/></td>
				  </tr>
				  <tr><td><label>Participaciones:</label></td><td><input class="form-control input-sm" disabled type="text" readonly="readonly" name="participaciones_user" value="<?php echo $elements[0]['participaciones'];?>"/></td>
				  </tr>
				  <tr><td valign="top"><label>Confirmado:</label> (1=si; 0=no)</td><td>
				  <input type="text" class="form-control input-sm"  id="confirmed_user"  name="confirmed_user" value="<?php echo $elements[0]['confirmed'];?>"/>
				  <span id="confirmado-alert" class="alert-message alert alert-danger"></span>
				  </td></tr>
				  <tr><td valign="top"><label>Deshabilitado:</label> (1=si; 0=no)</td><td>
				  <input type="text" class="form-control input-sm"  id="disabled_user"  name="disabled_user" value="<?php echo $elements[0]['disabled'];?>"/>
				  <span id="disabled-alert" class="alert-message alert alert-danger"></span>
				  </td></tr>
				  <tr><td valign="top"><label>Registrado:</label> (1=si; 0=no)</td><td>
				  <input type="text" class="form-control input-sm"  id="registered_user"  name="registered_user" value="<?php echo $elements[0]['registered'];?>"/>
				  <span id="registrado-alert" class="alert-message alert alert-danger"></span>
				  </td></tr>		
				  <tr><td>&nbsp;</td><td>
				  <button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary"><?php echo strTranslate("Save_data");?></button>
				  </td></tr>
				</table>
				</form>	
				</div>

				<div class="tab-pane fade" id="statistics">
					<br />
					<p>Estadísticas de uso de la comunidad por el usuario <b><?php echo $id;?></b></p>
					<table class="table">
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
							  <img src="<?php echo $user_foto;?>" style="width:100%" class="responsive" /><br /><br />
							<?php
							echo '<div class="btn btn-primary btn-block" id="DeleteFoto" onClick="Confirma(\'¿Seguro que desea borrar la foto del usuario?\',
								\'?page=user&act1=del&act='.$accion.'&id='.$elements[0]['username'].'&f='.$elements[0]['foto'].'\')" 
								title="'.strTranslate("Delete_photo").'" />'.strTranslate("Delete_photo").'</div>';
							?>
						</div>
					</div>
				</div>
				<?php menu::adminMenu();?>
			</div>
<?php 
}
  
function InsertData()
{
	$users = new users();
		//VERIFICAR NOMBRE USUARIO YA EXISTE
		if (count($users->getUsers(" AND username='".$_POST['username']."' "))==0){
			if ($users->insertUser($_POST['username'],
						$_POST['user_password'],
						$_POST['email_user'],
						$_POST['name_user'],
						$_POST['confirmed_user'],
						$_POST['disabled_user'],
						$_POST['responsable_user'],
						$_POST['empresa_user'],
						$_POST['territorial_user'],
						$_POST['canal_user'],
						$_POST['perfil_user'],
						$_POST['telefono_user'],				
						$_POST['provincia_user'],						
						$_POST['sfid_user'],
						$_POST['surname'],
						$_POST['registered_user']
						)) {
				OkMsg("usuario insertado correctamente.");
				return $_POST['username'];
			}
		}
		else { ErrorMsg("el usuario ya existe.");return 0;}
}

function UpdateData()
{
	$users = new users();
	if ($users->updateUser($_POST['id_username'],
						$_POST['user_password'],
						$_POST['email_user'],
						$_POST['name_user'],
						$_POST['confirmed_user'],
						$_POST['disabled_user'],
						$_POST['responsable_user'],
						$_POST['empresa_user'],
						$_POST['territorial_user'],
						$_POST['canal_user'],
						$_POST['perfil_user'],
						$_POST['telefono_user'],				
						$_POST['provincia_user'],
						$_POST['sfid_user'],
						$_POST['surname'],
						$_POST['registered_user'])) {
				OkMsg("usuario modificado correctamente.");}
	else { ErrorMsg("se ha producido algun error durante la modificacion de los datos.");}
}

function DeleteFoto()
{
	$users = new users();
	if (isset($_REQUEST['f']) and $_REQUEST['f']!=""){
		if ($users->deleteFoto($_REQUEST['id'],$_REQUEST['f'])) { OkMsg("foto borrada correctamente.");}
		else { ErrorMsg("no se ha podido eliminar la foto.");}
	}
}

?>