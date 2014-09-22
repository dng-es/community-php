<?php
templateload("player","videos");

function showNovedades(){
	$filter = " AND activo=1 ";
	if ($_SESSION['user_canal'] != "admin") $filter .= " AND canal='".$_SESSION['user_canal']."' ";
	$elements = novedadesController::getListAction(100, $filter);
	if (count($elements['items'])>0){
		?>
		<section>
			<h3><?php echo strTranslate("News");?></h3>
			<?php foreach($elements['items'] as $element): ?>
			<article>
				<?php echo $element['cuerpo'];?>
			</article>
			<?php endforeach; ?>
		</section>
	<?php }
}
?>