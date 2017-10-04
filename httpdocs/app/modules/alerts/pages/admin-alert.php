<?php
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
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("MOD_Alerts"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("MOD_Alert_list"), "ItemUrl"=>"admin-alerts"),
			array("ItemLabel"=>strTranslate("MOD_Alert"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' );
		alertsController::updateAction();
		alertsController::createAdminAction();
		$id = (isset($_REQUEST['ida']) ? sanitizeInput($_REQUEST['ida']) : 0);
		?>
		<div class="panel panel-default">
			<div class="panel-body">		
				<?php addAlert($id);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>