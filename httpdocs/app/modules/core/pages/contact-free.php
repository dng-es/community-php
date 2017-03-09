<?php addJavascripts(array("js/jquery.jtextarea.js", getAsset("core")."js/contact-free.js"));?>
<div class="row" id="login-container-deg">
	<div class="col-md-5">
		<img src="themes/<?php echo $_SESSION['user_theme'];?>/images/logo01.png" alt="<?php echo $ini_conf['SiteName'];?>" class="responsive login-img" />
	</div>
	<div class="col-md-6 login-container">
		<?php 
		$mensaje = '';
		if (isset($_POST['subject_form'])){
			//Enviar correo
			$subject_form = sanitizeInput($_POST['subject_form']);
			$email_form = sanitizeInput($_POST['email_form']);
			$asunto = 'EMAIL DESDE '.strtoupper($ini_conf['SiteName']).': '.$subject_form;
			$cuerpo_mensaje = $email_form.', escribio: 
			
			'.$_POST['body_form'];
			if (SendEmail($_POST['email_form'], $ini_conf['ContactEmail'], $asunto, $cuerpo_mensaje,0)) {
				$mensaje = '<div class="message-form-ok">
							Su mensaje ha sido enviado correctamente, en breve nos pondremos en contacto.<br />
							Gracias por tu consulta.
						</div>';
			}
			else $mensaje = '<div style="color: red;">Se ha producido un error durante el envío, Por favor intentelo más tarde.</div>';
		}?>
		<h1 class="inset"><?php e_strTranslate("Contact");?></h1>
		<?php echo $mensaje;?>
		<p><?php e_strTranslate("Send_us_an_email");?></p>
		<form enctype="multipart/form-data" id="contact_form" name="contact_form" method="post" action="" method="post" class="">
			<div class="form-group">
				<label for="email_form" class="sr-only">Remitente:</label>
				<input type="text" name="email_form" id="email_form" class="form-control" placeholder="Remitente" />
				<div class="message-form" id="message-form-email">Debe introducir un email válido.</div>
			</div>
			<div class="form-group">
				<label for="subject_form" class="sr-only">Asunto:</label>
				<input type="text" name="subject_form" id="subject_form" class="form-control" placeholder="<?php e_strTranslate('Message_subject');?>" />
				<div class="message-form" id="message-form-subject"><?php e_strTranslate('Introduce_subject');?></div>
			</div>
			
			<div class="form-group">
				<textarea class="form-control jtextarea" name="body_form" id="body_form" placeholder="<?php e_strTranslate('Your_message');?>"></textarea>
				<div class="message-form" id="message-form-body"><?php e_strTranslate('Introduce_your_message');?></div>
			</div>
			<div class="form-group">
				<button type="submit" value="" class="btn btn-primary" id="EnviarForm">Enviar consulta</button>
			</div>
		</form>
	</div>
</div>