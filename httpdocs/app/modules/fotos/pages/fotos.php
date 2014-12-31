<?php

templateload("gallery","fotos");
templateload("addfile","fotos");
templateload("searchfile","fotos");

addJavascripts(array("js/bootstrap.file-input.js", 
					 "js/jquery.bettertip.pack.js", 
					 "js/jquery.geturlparam.js", 
					 getAsset("fotos")."js/fotos.js"));

?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php 

		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Photo_gallery"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		fotosController::voteAction();
		fotosController::createAction();
		$albums = fotosAlbumController::getListAction(100, " AND activo=1 ORDER BY nombre_album ");
		?>
		<section id="photos">

		</section>
		<div id="cargando-infinnite"><span class="btn btn-default">seguir cargando imagenes <i class="fa fa-arrow-circle-down"></i></span></div>
		<div id="cargando-infinnite-end"><span class="btn btn-default alert-info">No hay más imágenes <i class="fa fa-info-circle"></i></span></div>
		<div class="clearfix"></div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<?php SearchPhoto("fotos","searchForm","Buscar foto por título","buscar", "", "", "get");?>
			<?php PanelSubirFoto(0);?>
			<br />
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-folder fa-stack-1x fa-inverse"></i>
				</span>
				<?php echo strTranslate("Photo_albums");?>
			</h4>
			<ul class="list-funny">
			<?php foreach($albums['items'] as $album): ?>
				<li><a href="?page=fotos&id=<?php echo $album['id_album'];?>"><?php echo $album['nombre_album'];?></a></li>
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
				<h4 class="modal-title" id="myModalLabel"><?php echo strTranslate("Photos");?></h4>
			</div>
			<div class="modal-body">
				...
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->