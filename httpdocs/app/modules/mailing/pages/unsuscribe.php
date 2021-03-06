<div id="confirm-container" class="row">
	<div class="col-md-6">
		<img src="images/logo01.png" alt="<?php echo $ini_conf['SiteName'];?>" class="responsive login-img" />
	</div>
	<div class="col-md-6" style="border-left:1px solid #1d7493">
		<h1>Confirmación de baja</h1>
		<?php 
		session::getFlashMessage( 'actions_message' );
		mailingController::createBlackAction();
		if (sha1($_GET['u']) == $_GET['ua']):?>
			<p>Desea darse de baja de nuestro servicio con el email: <b><?php echo sanitizeInput($_GET['u']);?></b></p>
			<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form" class="form-signin">
				<input type="hidden" name="email_black" id="email_black" value="<?php echo $_GET['u'];?>">
				<input type="submit" class="btn btn-primary" value="Confirmar baja" />
			</form>
		<?php endif;?>
	</div>
</div>