<?php

addJavascripts(array(getAsset("muro")."js/muro-comentario-ajax.js", 
					 getAsset("core")."js/home_new.js",
					 getAsset("alerts")."js/alerts.js",
					 getAsset("novedades")."js/show.js",
					 "js/jcolumn.min.js"));


templateload("panels", "alerts");
templateload("panels", "blog");
templateload("panels", "destacados");
templateload("panels", "foro");
templateload("panels", "fotos");
templateload("panels", "muro");
templateload("panels", "na_areas");
templateload("panels", "novedades");
templateload("panels", "users");
templateload("panels", "videos");

$configuration = new configuration();
$elements_rows = $configuration->getPanelsRows(" AND page_name='home' AND panel_visible=1 ORDER BY panel_row ");
?>
<div class="row row-top">
	<br />
		<?php foreach($elements_rows as $element_row):
				$elements = $configuration->getPanels(" AND panel_row=".$element_row['rows']." AND page_name='home' AND panel_visible=1 ORDER BY panel_pos ");
				?>
				<div class="row dinamicRow">
					<?php foreach($elements as $element): ?>
						<div class="col-md-<?php echo $element['panel_cols'];?>">
							<?php if (function_exists($element['panel_name'])):
								$element['panel_name']();
							endif;?>
						</div>
					<?php 
					endforeach;?>
				</div>	
		<?php endforeach; ?>
</div>
<?php popupNovedades();?>