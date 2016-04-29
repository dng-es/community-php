<?php
function creditosUser($username) {
	$elements = shopCreditosController::getCreditosAction($username); ?>
	
	<h3><?php echo ucfirst(strTranslate("APP_Credits"));?> conseguidos</h3>
	<ul class="list-funny">
	<?php foreach($elements as $element):?>
		<li><?php echo $element['credito_motivo'];?>: <small class="text-muted"><?php echo $element['puntuacion'];?> <?php e_strTranslate("APP_Credits");?></small></li>
	<?php endforeach;?>
	</ul>
<?php } ?>