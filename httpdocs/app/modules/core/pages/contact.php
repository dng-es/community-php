<?php
$base_dir = str_replace('modules/core/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "modules/class.headers.php");

addJavascripts(array("js/jquery.jtextarea.js", getAsset("core")."js/contact.js"));

?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<h1><?php echo strTranslate("Contact");?></h1>
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
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">

		</div>
	</div>
</div>