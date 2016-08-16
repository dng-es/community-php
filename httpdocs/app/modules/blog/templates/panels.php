<?php
function panelBlog2(){
	$filtro_blog = ($_SESSION['user_canal'] == 'admin' ? "" : " AND (canal='".$_SESSION['user_canal']."' OR canal='todos') ");
	$last_blog = foroController::getListTemasAction(1, $filtro_blog." AND ocio=1 AND activo=1 AND id_tema_parent=0 ORDER BY id_tema DESC "); ?>

<div class="col-md-12 section panel">
	<h3><?php e_strTranslate("Last_blog");?></h3>
	<?php if (isset($last_blog['items'][0])): ?>
	<div class="media-preview-container">
		<big><a href="blog"><?php echo $last_blog['items'][0]['nombre'];?></a></big><br />
		<span class="text-muted"><small><?php echo ucfirst(getDateFormat($last_blog['items'][0]['date_tema'], "LONG"));?></small></span>
		<p><?php echo blogController::get_resume($last_blog['items'][0]['descripcion']);?></p>
	</div>
	<?php else: ?>
		<div class="text-muted">Todavía no se han creado entradas</div>
	<?php endif; ?>	
</div>

<?php }


function panelBlog(){
	$filtro_blog = ($_SESSION['user_canal'] == 'admin' ? "" : " AND (canal='".$_SESSION['user_canal']."' OR canal='todos') ");
	$last_blog = foroController::getListTemasAction(1, $filtro_blog." AND ocio=1 AND activo=1 AND id_tema_parent=0 ORDER BY id_tema DESC "); ?>

<div class="col-md-12 section panel">
	<h3><?php e_strTranslate("Last_blog");?></h3>
	<?php if (isset($last_blog['items'][0])): ?>


		<div class="media-preview-container">
			<a href="blog"><img class="media-preview" src="images/foro/<?php echo $last_blog['items'][0]['imagen_tema'];?>" alt="<?php echo prepareString($last_blog['items'][0]['nombre']);?>" /></a>
			<div>
				<a href="blog"><?php echo $last_blog['items'][0]['nombre'];?></a><br />
				<span><small><?php echo ucfirst(getDateFormat($last_blog['items'][0]['date_tema'], "LONG"));?></small></span>
			</div>
		</div>

	<?php else: ?>
		<div class="text-muted">Todavía no se han creado entradas</div>
	<?php endif; ?>	
</div>

<?php } ?>