<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=0;
$menu_sel = 6;
function ini_page_header ($ini_conf) { ?>
	<script src="js/jquery.jtextarea.js"></script>
	<script>
		$(document).ready(function(){
			$(".jtextarea").jtextarea({maxSizeElement: 1000,
				cssElement: { display: "inline-block",color: "#999999",background: "transparent"}});	
		})
	</script>
	<script src="<?php echo getAsset("core");?>js/contact.js"></script>
<?php }
function ini_page_body ($ini_conf){
	?>
	<div id="page-info">Contactar</div>
	<div class="row inset row-top">
		<div class="col-md-8">
	<?php 
	//MESSAGES
	session::getFlashMessage( 'actions_message' );

	//EMAIL SEND
	if (isset($_POST['subject_form'])) {
		$asunto='EMAIL DESDE '.strtoupper($ini_conf['SiteName']).': '.$_POST['subject_form'];
		$cuerpo_mensaje=$_SESSION['user_name'].' - nick: '.$_SESSION['user_nick'].', escribio: 
		
		'.$_POST['body_form'];
		//if (SendEmail($_SESSION['user_email'],$ini_conf['ContactEmail'],$asunto,$cuerpo_mensaje,0)) {
		if (messageProcess($asunto, array($ini_conf['MailingEmail'] => 'Contactar'), array($ini_conf['ContactEmail']), $cuerpo_mensaje, null)){
			session::setFlashMessage( 'actions_message', "Su mensaje ha sido enviado correctamente, en breve nos pondremos en contacto.<br />Gracias por tu consulta.", "alert alert-success");
		}
		else { session::setFlashMessage( 'actions_message', "Se ha producido un error durante el envío, Por favor inténtalo más tarde.", "alert alert-danger");}
		redirectURL($_SERVER['REQUEST_URI']);
	} ?>
			<p>Si lo deseas, puedes enviarnos un email con tus consultas:</p>
			<form id="contact_form" name="contact_form" method="post" action="" method="post" role="form">
				<label for="subject_form" class="sr-only">Asunto:</label>
				<input type="text" name="subject_form" id="subject_form" class="form-control"placeholder="Introduce al asunto del mensaje" />
				<div class="message-form alert alert-danger" id="message-form-subject">Debes introducir el asunto, mínimo 2 caracteres.</div>				
				<br /><textarea cols="56" rows="8" name="body_form" id="body_form" class="jtextarea form-control" placeholder="Tu mensaje"></textarea>
				<div class="message-form alert alert-danger" id="message-form-body">Debes escribir el mensaje, mínimo 5 caracteres, máximo 1000.</div>
				<br /><br />
				<button type="submit" class="btn btn-primary" id="EnviarForm" value="Enviar">Enviar mensaje</button>
			</form>
		</div>
	</div>
<?php
}
?>