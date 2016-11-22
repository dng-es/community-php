<?php
templateload("gallery","fotos");
templateload("addfile","fotos");
templateload("cmbAlbumes","fotos");
templateload("addalbum","fotos");
templateload("searchfile","fotos");

addJavascripts(array("js/bootstrap.file-input.js", 
					 "js/jquery.geturlparam.js", 
					 getAsset("fotos")."js/fotos.js"));

?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Photo_gallery"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		fotosController::voteAction();
		fotosController::createAction();

		$filtro_canal_fotos = ($_SESSION['user_canal'] == 'admin' ? "" : " AND canal='".$_SESSION['user_canal']."' ");
		$albums = fotosAlbumController::getListAction(1000, " AND activo=1 ORDER BY nombre_album ");
		?>
		<section id="photos">

		</section>
		<div id="cargando-infinnite"><span class="btn btn-default"><?php e_strTranslate("More_photos");?> <i class="fa fa-arrow-circle-down"></i></span></div>
		<div id="cargando-infinnite-end"><span class="btn btn-default alert-info"><?php e_strTranslate("No_more_photos");?> <i class="fa fa-info-circle"></i></span></div>
		<div class="clearfix"></div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php SearchPhoto("fotos","searchForm", strTranslate("Search_Photo_by_title"), strTranslate("Search"), "", "", "get");?>
			<?php PanelSubirFoto(0, $albums['items']);?>
			

			<br />
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-folder fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Photo_albums");?>
			</h4>
			<ul class="lista-lateral">
			<?php foreach($albums['items'] as $album): ?>
				<?php 
				$num_fotos = connection::countReg("galeria_fotos",$filtro_canal_fotos." AND estado=1 AND id_album=".$album['id_album']." ");
				if($num_fotos > 0): ?>
				<li><a href="fotos?id=<?php echo $album['id_album'];?>"><?php echo $album['nombre_album'];?> <span class="badge"><?php echo $num_fotos;?></span></a></li>
				<?php endif;?>
			<?php endforeach;?>
			</ul>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal modal-wide fade" id="fotosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><?php e_strTranslate("Photos");?></h4>
			</div>
			<div class="modal-body"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php ModalSubirAlbum();?>