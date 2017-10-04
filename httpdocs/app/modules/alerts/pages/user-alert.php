<?php
$perfiles_autorizados = array("admin", "responsable", "regional");
session::AccessLevel($perfiles_autorizados);

addJavascripts(array(
	"js/bootstrap.file-input.js", 
	"js/bootstrap-datepicker.js", 
	"js/bootstrap-datepicker.es.js", 
	"js/bootstrap-timepicker.min.js", 
	"js/jquery.numeric.js", 
	"js/bootstrap-textarea.min.js",
	getAsset("alerts")."js/addalert.js"
));

addCss(array(
	"css/bootstrap-datetimepicker.min.css",
	"css/bootstrap-timepicker.min.css"
));

templateload("addalert", "alerts");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("My_team"), "ItemUrl"=>"mygroup"),
			array("ItemLabel"=>strTranslate("MOD_Alert"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' );
		alertsController::createUserAction();
		alertsController::updateAction();
		$id = (isset($_REQUEST['ida']) ? sanitizeInput($_REQUEST['ida']) : 0);
		?>
		<div class="panel panel-default">
			<div class="panel-body">		
				<?php addAlert($id);?>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior hidden-xs hidden-sm">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-calendar fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("MOD_Alerts");?>
			</h4>
			<p class="text-center"><i class="fa fa-calendar fa-big"></i></p>
		</div>
	</div>
</div>