<?php

function panelForos($tema = -1){
	$last_foros = foroController::getLastTemasAction(3, " AND t.id_area=0 AND ocio=0 ");
	?>
	<div class="col-md-12 section panel">
		<h3><?php e_strTranslate("Last_formus");?></h3>
		<!--<p><?php //e_strTranslate("Discover_last_formus");?>.</p> -->
		<ul class="list-funny">
		<?php foreach($last_foros as $last_foro): ?>
			<li class="ellipsis"><a href="foro-comentarios?id=<?php echo $last_foro['id_tema'];?>"><?php echo $last_foro['nombre'];?></a></li>
		<?php endforeach; ?>
		</ul>
		<div class="ver-mas">
			<a href="foro-subtemas"><span class="fa fa-search"></span> <?php e_strTranslate("More_contents");?></a>
		</div>
	</div>
<?php }
?>