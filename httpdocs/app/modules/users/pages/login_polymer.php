<?php
usersController::loginRedirectAction(); 
addJavascripts(array(getAsset("users")."js/login.js", "js/bower_components/webcomponentsjs/webcomponents-lite.min.js"));
session::getFlashMessage('actions_message');
$module_config = getModuleConfig("users");
?>
<link rel="import" href="js/bower_components/polymer/polymer.html">
<link rel="import" href="js/bower_components/paper-input/paper-input.html">
<div class="row" id="login-container-deg">
	<div class="col-md-4">
		<img src="images/logo01.png" alt="<?php echo $ini_conf['SiteName'];?>" class="responsive login-img" />
	</div>
	<div class="col-md-8 login-container">
		<h1 class="inset"><?php e_strTranslate("Identify_to_access");?></h1>
		<?php session::getFlashMessage('actions_message');?>
		<form method="post" action="" name="form-login" id="form-login" role="form" class="form-horizontal">          
			<div class="row">
				<div class="col-md-4"> 
					<paper-input name="form-login-user" label="<?php e_strTranslate("Username");?>"></paper-input>
				</div>
				<div class="col-md-4">
					<paper-input name="form-login-password" label="<?php e_strTranslate("Password");?>" type="password"></paper-input>
				</div>
				<div class="col-md-3">
					<br /><button type="submit" name="loginSubmit" id="loginSubmit" class="btn btn-primary btn-block"><?php e_strTranslate("Enter");?></button>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-md-11">
					<a href="remember" class="login-link"><?php e_strTranslate("Forgot_your_password");?> <i class="fa fa-chevron-circle-right"></i></a>
					<?php if ($module_config['options']['allow_registration'] === true)  echo '<br /><a href="registration" class="login-link">'.strTranslate("Register").' <i class="fa fa-chevron-circle-right"></i></a>';?>
				</div>
			</div>
			<br />
		</form>
	</div>
</div>