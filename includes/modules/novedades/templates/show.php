<?php
templateload("player","videos");

function showNovedades(){
	$filter = " AND activo=1 ";
	if ($_SESSION['user_canal'] != "admin") $filter .= " AND canal='".$_SESSION['user_canal']."' ";
	$elements = novedadesController::getListAction(100, $filter);
	if (count($elements['items'])>0){
		?>
		<section>
			<?php foreach($elements['items'] as $element): ?>
			<h3><?php echo strTranslate("News").($_SESSION['user_canal']=='admin' ? " ".$element['canal'] : "");?></h3>
			<article>
				<?php echo $element['cuerpo'];?>
			</article>
			<?php endforeach; ?>
		</section>
	<?php }
}
?>