<?php 
addJavascripts(array("js/masonry.pkgd.min.js", getAsset("fotos")."js/foto-albums.js"));
addCss(array(getAsset("fotos")."css/styles.css"));
templateload("addalbum","fotos");

session::getFlashMessage('actions_message');

$filtro = " AND activo=1 ";
$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_album LIKE '%".$_SESSION['user_canal']."%' " : "");
$filtro .= $filtro_canal." ORDER BY nombre_album ASC";

session::getFlashMessage( 'actions_message' );
fotosAlbumController::createAction("foto-albums");
$elements = fotosAlbumController::getListAction(99999, $filtro);

$module_config = getModuleConfig("fotos");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=> strTranslate("Photo_albums"), "ItemClass"=>"active"),
		));
		?>

		<div class="dinamicRow grid">
		<?php if($elements['total_reg'] == 0):?>
			<p>No existen albumes.</p>
		<?php else: ?>
		<?php foreach($elements['items'] as $element):
			$foto_user = usersController::getUserFoto($element['foto_user']);
			$foto_album = fotosController::getItemAction(" AND f.id_album=".$element['id_album']." AND estado=1 ORDER BY id_file DESC LIMIT 1");
			$foto = (isset($foto_album['name_file']) ? PATH_FOTOS.$foto_album['name_file'] : 'images/nofile.jpg');
			$num_fotos = connection::countReg("galeria_fotos"," AND estado=1 AND id_album=".$element['id_album']." ");
			?>
			<div class="card-section grid-item">
				<h3 class=""><?php echo $element['nombre_album'];?> <span class="badge"><?php echo $num_fotos;?></span></h3>
				<a href="fotos?id=<?php echo $element['id_album'];?>">
					<img src="<?php echo $foto;?>" title="<?php echo $element['nombre_album'];?>" />
				</a>
			</div>
		<?php endforeach; ?>

		<?php //Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], 'shopproducts','Pedidos', $elements['find_reg']);?>
		<?php endif; ?>
		</div>

	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php subirAlbum();?>
		</div>
	</div>
</div>