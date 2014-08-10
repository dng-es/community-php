<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=0;
$menu_sel = 6;
function ini_page_header ($ini_conf) { ?>
	<script src="js/jquery.jtextarea.js"></script>
	<script src="<?php echo getAsset("core");?>js/contact.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".jtextarea").jtextarea({maxSizeElement: 1000, textElement: "<?php echo strTranslate('Characters');?>", 
						cssElement: { display: "inline-block",color: "#999999",background: "transparent"}});	
		});
	</script>
<?php }
function ini_page_body ($ini_conf){
	?>
	<div id="page-info"><?php echo strTranslate("Contact");?></div>
	<div class="row inset row-top">
		<div class="col-md-8">
	<?php 
	//MESSAGES
	session::getFlashMessage( 'actions_message' );
	coreContactController::contactAction();
	?>
			<p><?php echo strTranslate("Send_us_an_email");?></p>
			<form id="contact_form" name="contact_form" method="post" action="" method="post" role="form">
				<label for="subject_form" class="sr-only">Asunto:</label>
				<input type="text" name="subject_form" id="subject_form" class="form-control"placeholder="<?php echo strTranslate('Message_subject');?>" />
				<div class="message-form alert alert-danger" id="message-form-subject"><?php echo strTranslate('Introduce_subject');?></div>				
				<br /><textarea cols="56" rows="8" name="body_form" id="body_form" class="jtextarea form-control" placeholder="<?php echo strTranslate('Your_message');?>"></textarea>
				<div class="message-form alert alert-danger" id="message-form-body"><?php echo strTranslate('Introduce_your_message');?></div>
				<br /><br />
				<button type="submit" class="btn btn-primary" id="EnviarForm" value="Enviar"><?php echo strTranslate("Send");?></button>
			</form>
		</div>
	</div>
<?php
}
?>