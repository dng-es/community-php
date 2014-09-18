<?php
templateload("player","videos");

function showNovedades(){
	$filter = " AND activo=1 ";
	if ($_SESSION['user_canal'] != "admin") $filter .= " AND canal='".$_SESSION['user_canal']."' ";
	$elements = novedadesController::getListAction(100, $filter);
	if (count($elements['items'])>0){
		?>
		<div class="novedades-container">
			<h3><?php echo strTranslate("News");?></h3>
			<?php foreach($elements['items'] as $element): ?>
				<div class="novedades-item">
					<?php echo $element['cuerpo'];?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php }
}
?>