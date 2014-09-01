<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
function ini_page_header ($ini_conf) { 
	usersController::loginRedirectAction(); ?>
	<script src="<?php echo getAsset("users");?>js/login.js"></script>
<?php
}
function ini_page_body ($ini_conf){
	?>
	<div class="row" id="login-container-deg">
		<div class="col-md-6">
			<img src="images/logo01.png" class="responsive login-img" />
		</div>
		<div class="col-md-6 login-container">
			<div class="col-md-12 noppading">	            
				<h2><?php echo strTranslate("Identify_to_access");?></h2>
				<?php session::getFlashMessage( 'actions_message' );?>
	            <form method="post" action="" name="form-login" id="form-login" role="form" class="form-horizontal">          
	                <div class="row">
		                <div class="col-md-6"> 
			                <div class="form-group">
							    <label for="form-login-user" class="col-sm-4 control-label"><?php echo strTranslate("Username");?></label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="form-login-user" name="form-login-user" placeholder="<?php echo strTranslate("Username");?>">
							    </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							    <label for="form-login-password" class="col-sm-4 control-label"><?php echo strTranslate("Password");?></label>
							    <div class="col-sm-8">
							      <input type="password" class="form-control" id="form-login-password" name="form-login-password" placeholder="<?php echo strTranslate("Password");?>">
							    </div>
							</div>
						</div>
					</div>
	                <button type="submit" name="loginSubmit" id="loginSubmit" class="btn btn-primary pull-right"><?php echo strTranslate("Enter");?></button>
	                <p><?php echo strTranslate("Forgot_your_password");?> <a href="?page=remember" ><?php echo strTranslate("Click_here");?></a></p>
	            </form>
			</div>
			<div class="col-md-12" style="border-top:1px solid #1d7493;padding-top:20px;margin-top:20px">
				<p><?php echo strTranslate("If_not_registered");?>: <a href="?page=registration"><?php echo strTranslate("Register");?></a></p>
			</div>
		</div>
	</div>
	<?php 
}
?>