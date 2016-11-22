<?php
addCss(array(getAsset("configuration")."css/admin-home.css"));
addJavascripts(array(getAsset("configuration")."js/admin-home.js"));

session::getFlashMessage('actions_message');


global $modules_data;
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Configuration"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Home"), "ItemClass"=>"active"),
		));?>

		<div class="panel panel-default">
			<div class="panel-body">
				<div class="container">
					<div class="row">
						<div class="col-md-9">
							<div id="drop-container">
								<div class="row nopadding">
									<div class="col-md-6">
										<div id="drop1" class="drop-container"></div>
									</div>
									<div class="col-md-6">
										<div id="drop2" class="drop-container"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div id="drag1" class="drag" draggable="true">Modulo 1</div>
							<div id="drag2" class="drag" draggable="true">Modulo 2</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>