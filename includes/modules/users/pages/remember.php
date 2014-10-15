<?php
addJavascripts(array(getAsset("users")."js/remember.js"));
?>
<div class="row" id="login-container-deg">
	<div class="col-md-6">
		<img src="images/logo01.png" class="responsive login-img" />
	</div>
	<div class="col-md-6 login-container">
		<div class="row noppading">
			<h1><?php echo strTranslate("Recover_password");?></h1>            
			<?php
			session::getFlashMessage( 'actions_message' ); 
			usersController::recoverPasswordAction();?>
			<form method="post" action="" name="formRemember" id="formRemember" role="form" class="form-signin form-horizontal">
				<p><?php echo strTranslate("Recover_password_info");?></p>
				<label for="form-lostpw-user" class="sr-only"><?php echo strTranslate("Username");?>:</label>
				<input type="text" name="form-lostpw-user" id="form-lostpw-user" class="form-control" placeholder="<?php echo strTranslate("Username");?>" required autofocus />
				<br />
				<button type="submit" name="rememberSubmit" id="rememberSubmit" class="btn btn-primary"><?php echo strTranslate("Recover_password");?></button>
				<a href="?page=login" class="btn btn-default"><?php echo strTranslate("Identify_to_access");?></a>
			</form>		
		</div>
		<br /><br />
		<p><?php echo strTranslate("If_not_registered");?> <a  href="?page=registration"><?php echo strTranslate("Register");?></a></p>
	</div>
</div>