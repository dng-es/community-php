<?php
addCss(array("css/bootstrap-datetimepicker.min.css"));
addJavascripts(array("js/bootstrap.file-input.js", 
					 "js/bootstrap-datepicker.js", 
					 "js/bootstrap-datepicker.es.js",
					 getAsset("users")."js/registration.js"));
?>
<div id="confirm-container" class="row">			
	<div class="col-md-6">
		<img src="images/logo01.png" class="responsive login-img" />
	</div>
	<div class="col-md-6" style="border-left:1px solid #a1569d">
		<h2><?php echo strTranslate("Registration");?></h2>
		<?php
		session::getFlashMessage( 'actions_message' );

		//REGISTRO USUARIO
		if (isset($_POST['username-text']) and $_POST['username-text']!=""){
			$users = new users();
			$confirmar=$users->registerUser($_POST['username-text'],
										   $_POST['user-nick'],
										   $_POST['user-nombre'],
										   $_POST['user-apellidos'],
										   $_POST['user-pass'],
										   $_POST['user-email'],
										   $_FILES['nombre-fichero'],
										   '',
										   $_POST['user-date'],
										   $_POST['user-empresa']);


			if ($confirmar==1){
				$subject_mail = "Alta de usuario en ".$ini_conf['SiteName'];;
				$body_mail = ' Para confirmar tu registro en '.$ini_conf['SiteName'].' haz click en el siguiente enalce: '.$ini_conf['SiteUrl'].'/?page=registration-confirm&a='.sha1($_POST['username-text']).'&b='.sha1($_POST['user-email']).'&c='.sha1($_POST['user-pass']).'';
				
				//SendEmail($ini_conf['ContactEmail'],$_POST['user-email'],$subject_mail,$body_mail,0,$ini_conf['SiteName']);
				messageProcess($subject_mail, array($ini_conf['MailingEmail'] => $ini_conf['SiteName']), array($_POST['user-email']), $body_mail, null);
				redirectURL("?page=registration&m=1");
			}
			elseif ($confirmar==2){
				ErrorMsg("<p>Se ha producido algun error al confirmar sus datos.</p>");
			}
			elseif ($confirmar==3){
				ErrorMsg("<p>El nick <b>".$_POST['user-nick']."</b> ya existe.</p>");
			}	
			elseif ($confirmar==4){
				ErrorMsg("<p>El código de tienda introducido no es válido.</p>");
			}
			elseif ($confirmar==5){
				ErrorMsg("<p>El DNI/usuario ya existe.</p>");
			}	
		}

		if (isset($_REQUEST['m']) and $_REQUEST['m']==1){
			echo '<p>Tus datos se han registrado correctamente.<br />
					Recibirás en tu cuenta de correo un email para confirmar tu registro, sigue las instrucciones del mensaje para acceder.</p>';	
			echo '</div>';
		}
		else{
			ShowForm();
		}



///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////

function ShowForm()
{
	$pages = new pages();
	$politica= $pages->getPages(" AND page_name='policy' ");
	$declaracion= $pages->getPages(" AND page_name='declaracion' ");

	$user_name = "";
	$user_nombre = "";
	$user_apellidos = "";
	$user_email = "";
	$user_nick = "";
	$user_pass = "";
	$user_repass = "";
	$user_empresa = "";
	$user_date = "";

	if (isset($_POST['username-text'])) {
		$user_name=$_POST['username-text'];
		$user_nombre=$_POST['user-nombre'];
		$user_apellidos=$_POST['user-apellidos'];
		$user_email=$_POST['user-email'];
		$user_nick = $_POST['user-nick'];
		$user_pass = $_POST['user-pass'];
		$user_repass = $_POST['user-repass'];
		$user_empresa = $_POST['user-empresa'];
		$user_date = $_POST['user-date'];
	}

	echo '<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form" class="form-signin">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr valign="top">
					<td><label for="username-text">'.strTranslate("Username").':</label></td>
					<td colspan="2">
					  <input name="username-text" id="username-text" type="text" class="form-control" value="'.$user_name.'" placeholder="Intruduce tu DNI" />
					  <span id="username-text-alert" class="alert-message alert alert-danger"></span>
					</td>
				</tr>
				<tr valign="top">
					<td><label for="user-empresa">'.strTranslate("Group_user").':</label></td>
					<td>
					  <input name="user-empresa" id="user-empresa" date-c="0" type="text" class="form-control" value="'.$user_empresa.'" placeholder="Código de centro" />
					  <span id="user-empresa-alert" class="alert-message alert alert-danger"></span>
					</td>
					<td>
					  <input name="user-empresa-nombre" id="user-empresa-nombre" type="text" class="form-control" disabled="disabled" value="" />
					</td>
				</tr>
				<tr><td></td><td colspan="2"><span id="tienda-alert" class="alert-message alert alert-danger"></span></td></tr>					
				<tr valign="top">
					<td><label for="user-nick">'.strTranslate("Nick").':</label></td>
					<td colspan="2">
					  <input maxlength="100" name="user-nick" id="user-nick" type="text" class="form-control" value="'.$user_nick.'" placeholder="Intruduce tu nick" />
					  <span id="user-nick-alert" class="alert-message alert alert-danger"></span>
					</td>
				</tr>
				<tr valign="top">
					<td><label for="user-nombre">'.strTranslate("Name").':</label></td>
					<td colspan="2">
					  <input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="'.$user_nombre.'" placeholder="Intruduce tu nombre" />
					  <span id="user-nombre-alert" class="alert-message alert alert-danger"></span>
					</td>
				</tr>
				<tr valign="top">
					<td><label for="user-apellidos">'.strTranslate("Surname").':</label></td>
					<td colspan="2">
					  <input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="'.$user_apellidos.'" placeholder="Intruduce tus apellidos" />
					  <span id="user-apellidos-alert" class="alert-message alert alert-danger"></span>
					</td>
				</tr>					
				<tr valign="top">
					<td><label for="user-date">Fecha nacimiento:</label></td>
					<td colspan="2">
						  <div id="datetimepicker1" class="input-group date">
							<input data-format="yyyy/MM/dd" readonly type="text" id="user-date" class="form-control" name="user-date"></input>
							  <span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
						  </div>

						  <script>
							jQuery(document).ready(function(){
								$("#datetimepicker1").datetimepicker({
								  language: "es-ES",
								  startDate: "2014/01/01"
								});';
if (isset($user_date) and $user_date!=""){
	echo "							var fecha = '".date('D M d Y H:i:s O',strtotime($user_date))."';";
	echo'							$("#datetimepicker1").data("datetimepicker").setLocalDate(new Date (fecha));';
}
echo '							});
							  </script>							

							<span id="user-date-alert" class="alert-message alert alert-danger"></span>
						</td>
					</tr>
					<tr valign="top">
						<td><label for="user-email">Email:</label></td>
						<td colspan="2">
						  <input maxlength="100" name="user-email" id="user-email" type="text" class="form-control" value="'.$user_email.'" placeholder="Intruduce tu email" />
						  <span id="user-email-alert" class="alert-message alert alert-danger"></span>
						</td>
					</tr>
					<tr valign="top">
						<td><label for="user-pass">'.strTranslate("Password").':</label></td>
						<td colspan="2">
						  <input maxlength="100" name="user-pass" id="user-pass" type="password" class="form-control" value="'.$user_pass.'" />
						  <span id="user-pass-alert" class="alert-message alert alert-danger"></span>
						</td>
					</tr>
					<tr valign="top">
						<td nowrap="nowrap"><label for="user-repass">'.strTranslate("Password_re").':</label></td>
						<td colspan="2">
						  <input maxlength="100" name="user-repass" id="user-repass" type="password" class="form-control" value="'.$user_repass.'" />
						  <span id="user-repass-alert" class="alert-message alert alert-danger"></span>
						</td>
					</tr>
					<tr valign="top">
						<td><label for="nombre-fichero">Foto:</label></td>
						<td colspan="2">
						  <input name="nombre-fichero" id="nombre-fichero" type="file"  class="btn btn-default" title="'.strTranslate("Choose_file").'" />
						</td>
					</tr>
					<tr><td colspan="2">
					 <input id="user-declaracion" name="user-declaracion" type="checkbox" value="1" /> '.strTranslate("Acept").' 
					  <a href="#" id="declaracion-trigger">'.strTranslate("Terms_and_conditions").'</a>
					  <span id="user-declaracion-alert" class="alert-message alert alert-danger"></span>				 					 
					<td align="center"><br />
					<button type="submit" name="confirm-submit" id="confirm-submit" class="btn btn-primary btn-block">'.strTranslate("Register").'</button>
					</td></tr>
				</table>
			</form>
			<br />
			</div>
		</div>


		<!-- Modal -->
		<div class="modal modal-wide fade" id="declaracionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Aceptar términos</h4>
					</div>
					<div class="modal-body">
					'.$declaracion[0]['page_content'].'
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->';

}
?>
