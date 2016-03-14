<?php
function panelFotos(){
	$last_photo = fotosController::getListAction(1, " AND estado=1 ORDER BY id_file DESC ");
	?>
	<h3><?php e_strTranslate("Last_photos");?></h3>
	<?php if (isset($last_photo['items'][0])): ?>
	<div class="media-preview-container">
		<a href="fotos"><img class="media-preview" src="<?php echo PATH_FOTOS.$last_photo['items'][0]['name_file'];?>" alt="<?php echo prepareString($last_photo['items'][0]['titulo']);?>" /></a>
		<div>
			<a href="fotos"><?php echo $last_photo['items'][0]['titulo'];?></a><br />
			<?php echo $last_photo['items'][0]['nick'];?><br />
			<span><small><?php echo ucfirst(getDateFormat($last_photo['items'][0]['date_foto'], "LONG"));?></small></span><br />
			<div class="ver-mas pull-right">
				<a href="fotos"><span class="fa fa-search"></span> <?php e_strTranslate("More_contents");?></a>
			</div>
		</div>
	</div>
	<?php else: ?>
		<div class="text-muted">Todavía no se han subido fotos</div>
	<?php endif; ?>
<?php } ?>