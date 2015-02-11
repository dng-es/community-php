<?php
templateload("player","videos");

function showNovedades(){
	$filter = " AND activo=1 ";
	if ($_SESSION['user_canal'] != "admin") $filter .= " AND n.canal='".$_SESSION['user_canal']."' ";
	$elements = novedadesController::getListAction(100, $filter);?>
		<div class="col-md-12 section full-height" style="background-color:#c0c0c0">
			<section style="background-color:#c0c0c0">
				<?php if (count($elements['items'])>0): ?>
				<?php foreach($elements['items'] as $element): ?>
				<h3><?php echo strTranslate("News").($_SESSION['user_canal']=='admin' ? " ".$element['canal_name'] : "");?></h3>
				<article>
					<?php echo $element['cuerpo'];?>
				</article>
				<?php endforeach; ?>
				<?php else: ?>
					<h3><?php echo strTranslate("News");?></h3>
				<?php endif; ?>
			</section>
		</div>
<?php }
?>