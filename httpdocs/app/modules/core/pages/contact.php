<?php
$base_dir = str_replace('modules/core/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "modules/class.headers.php");
include_once($base_dir . "modules/blog/classes/class.blog.php");
include_once($base_dir . "modules/blog/controllers/controller.default.php");
include_once($base_dir . "modules/info/classes/class.info.php");
include_once($base_dir . "modules/info/controllers/controller.default.php");

addJavascripts(array("js/jquery.jtextarea.js", getAsset("core")."js/contact.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Contact"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		coreContactController::contactAction();
		?>
		<div class="row">
			<div class="col-md-4 col-md-push-8">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><?php echo $ini_conf['SiteName'];?></h4>
						<ul class="list-unstyled">
							<li><?php echo $ini_conf['SiteUrl'];?></li>
							<li><?php echo $ini_conf['ContactEmail'];?></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-8 col-md-pull-4">
				<p class="hidden-md hidden-lg"><?php e_strTranslate("Send_us_an_email");?></p>
				<form id="contact_form" name="contact_form" method="post" action="" method="post" role="form">
					<div class="form-group">
						<label for="subject_form" class="sr-only">Asunto:</label>
						<input type="text" name="subject_form" id="subject_form" class="form-control"placeholder="<?php e_strTranslate('Message_subject');?>" />
						<div class="message-form alert alert-danger" id="message-form-subject"><?php e_strTranslate('Introduce_subject');?></div>
						<br /><textarea cols="56" rows="8" name="body_form" id="body_form" class="jtextarea form-control" placeholder="<?php e_strTranslate('Your_message');?>"></textarea>
						<div class="message-form alert alert-danger" id="message-form-body"><?php e_strTranslate('Introduce_your_message');?></div>
					</div>
					<div class="form-group col-md-4 nopadding">
						<button type="submit" class="btn btn-primary btn-block" id="EnviarForm" value="Enviar"><?php e_strTranslate("Send");?></button>
					</div>
					<br />
				</form>
			</div>
		</div>
	</div>
	<div class="app-sidebar hidden-sm hidden-xs">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Contact");?></h4>
			<p><?php e_strTranslate("Send_us_an_email");?></p>
			<p class="text-center"><i class="fa fa-envelope fa-big"></i></p>
		</div>
	</div>
</div>