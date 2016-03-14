<?php
templateload("player", "videos");

function panelNovedades(){
	$filter = " AND activo=1 ";
	if ($_SESSION['user_canal'] != "admin") $filter .= " AND n.canal='".$_SESSION['user_canal']."' ";
	$elements = novedadesController::getListAction(100, $filter);?>	
		<?php if (count($elements['items']) > 0):?>
		<?php foreach($elements['items'] as $element):?>
		<h3><?php e_strTranslate("News").($_SESSION['user_canal'] == 'admin' ? " ".$element['canal_name'] : "");?></h3>
		<span class="text-muted"><small><?php echo ucfirst(getDateFormat( $element['date_novedad'], "LONG"));?></small></span>
		<article>
			<?php echo $element['cuerpo'];?>
		</article>
		<?php endforeach; ?>
		<?php else: ?>
			<h3><?php e_strTranslate("News");?></h3>
		<?php endif; ?>
<?php }
?>