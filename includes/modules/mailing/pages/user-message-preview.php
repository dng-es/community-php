<?php

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

templateload("emailfooter","mailing");

?>
<div class="row less-width row-top">
	<div class="col-md-12">
	<div class="textuppercase blue more-marginbottom"><h1 class="font-title">Previsualización del mensaje</h1></div>
	<div class="message-preview">
		<p class="message-preview-detail"><b>Asunto:</b> <?php echo $_POST['asunto_message']?></p>
		<p class="message-preview-detail"><b>Remitente:</b> <?php echo $_POST['nombre_message']." [".$_POST['email_message']."]";?></p>
		<?php echo mailingController::previewUserAction();?>
		<?php echo footerMail(array());?>
		</div>
	</div>
</div>