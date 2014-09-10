<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

addJavascripts(array("js/jquery.jtextarea.js", getAsset("core")."js/contact-free.js"));

$mensaje='';
if (isset($_POST['subject_form'])) {
	//Enviar correo
	$asunto='EMAIL DESDE '.strtoupper($ini_conf['SiteName']).': '.$_POST['subject_form'];
	$cuerpo_mensaje=$_POST['email_form'].', escribio: 
	
	'.$_POST['body_form'];
	if (SendEmail($_POST['email_form'],$ini_conf['ContactEmail'],$asunto,$cuerpo_mensaje,0)) {
		$mensaje='<div class="message-form-ok">
					Su mensaje ha sido enviado correctamente, en breve nos pondremos en contacto.<br />
					Gracias por tu consulta.
				  </div>';
	}
	else { $mensaje='<div style="color: red;">Se ha producido un error durante el envío, Por favor intentelo más tarde.</div>';}
}?>
	<div id="page-info"><?php echo strTranslate("Contact");?></div>
	<?php echo $mensaje;?>
	<p><?php echo strTranslate("Send_us_an_email");?></p>

	<form enctype="multipart/form-data" id="contact_form" name="contact_form" method="post" action="" method="post">
		<label for="email_form" class="sr-only">Remitente:</label>
		<input type="text" name="email_form" id="email_form" class="form-control" />
		<div class="message-form" id="message-form-email">Debe introducir un email válido.</div>
		<label for="subject_form">Asunto:</label>
		<input type="text" name="subject_form" id="subject_form" class="form-control" placeholder="<?php echo strTranslate('Message_subject');?>" />
		<div class="message-form" id="message-form-subject"><?php echo strTranslate('Introduce_subject');?></div>
		<textarea class="form-control jtextarea" name="body_form" id="body_form" placeholder="<?php echo strTranslate('Your_message');?>"></textarea>
		<div class="message-form" id="message-form-body"><?php echo strTranslate('Introduce_your_message');?></div>
		<br /><button type="submit" value="" class="btn btn-primary" id="EnviarForm"><?php echo strTranslate("Send");?></button>
	</form>