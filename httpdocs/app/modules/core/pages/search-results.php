<?php
addJavascripts(array(
	"js/jquery.geturlparam.js",
	getAsset("core")."js/search-results.js"
));

templateload("search", "core");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Search_results"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');

		$search_text = (isset($_REQUEST['search']) && $_REQUEST['search'] != '') ? sanitizeInput($_REQUEST['search']) : '';
		$mod = (isset($_REQUEST['mod']) && $_REQUEST['mod'] != '') ? sanitizeInput($_REQUEST['mod']) : '';
		?>

		<div id='cargando' class="text-center"><big><i class="fa fa-spinner fa-spin fa-3x"></i></big></div>
		<div id='destino'></div>

	</div>
	<div class="app-sidebar hidden-sm hidden-xs">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-support fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Buscador global");?>
			</h4>
			<?php mainSearch("search-results", $search_text, $mod);?>
		</div>
	</div>
</div>