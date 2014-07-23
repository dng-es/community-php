<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=0;
function ini_page_header ($ini_conf) { ?>
<script src="js/jquery.jtextarea.js"></script>
<script>
	$(document).ready(function(){
	   $(".jtextarea").jtextarea({maxSizeElement: 1000,
		 cssElement: { display: "inline-block",color: "#FF6600",background: "#fff"}});	
	})
</script>
<script src="<?php echo getAsset("core");?>js/contact-free.js?v=2"></script>
<?php }
function ini_page_body ($ini_conf){
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
}
  echo '<h1 class="h1Seccion">contactar</h1>'.$mensaje.'
		<p>Si lo deseas, puedes enviarnos un email con tus consultas:</p>

		<form enctype="multipart/form-data" id="contact_form" name="contact_form" method="post" action="" method="post">
			<table>
			<tr><td><label>Remitente:</label></td><td>
				<input type="text" name="email_form" id="email_form" size="50" />
			</td></tr>
			<tr><td colspan="2">
				<span class="message-form" id="message-form-email">Debe introducir un email v&aacute;lido.</span>
			</td></tr>
			<tr><td><label>Asunto:</label></td><td>
				<input type="text" name="subject_form" id="subject_form" size="50" />
			</td></tr>
			<tr><td colspan="2">
				<span class="message-form" id="message-form-subject">Debe introducir el asunto, m&iacute;nimo 2 caracteres.</span>			
			</td></tr>
			<tr><td colspan="2">
				<textarea cols="56" rows="8" name="body_form" id="body_form" class="jtextarea"></textarea><br />
				<span class="message-form" id="message-form-body">Debe escribir el mensaje, m&iacute;nimo 5 caracteres, m&aacute;ximo 1000.</span>
				<br /><input type="button" value="" class="enviarButton" id="EnviarForm" />
			</td></tr>
			</table>
		</form>';

}
?>