<?php

function panelForos($tema = -1){
	$last_foros = foroController::getLastTemasAction(4, " AND t.id_area=0 AND ocio=0 ");?>

	<h3><?php e_strTranslate("Last_formus");?></h3>
	<p><?php e_strTranslate("Discover_last_formus");?>.</p>
	<ul class="list-funny">
	<?php foreach($last_foros as $last_foro): ?>
		<?php $foro_tema = foroController::getItemTemaAction($last_foro['id_tema']);?>
		<li class="ellipsis"><a href="foro-comentarios?id=<?php echo $foro_tema[0]['id_tema'];?>"><?php echo $foro_tema[0]['nombre'];?></a></li>
	<?php endforeach; ?>
	</ul>
	<div class="ver-mas">
		<a href="foro-subtemas"><span class="fa fa-search"></span> ver más foros</a>
	</div>
<?php }
?>