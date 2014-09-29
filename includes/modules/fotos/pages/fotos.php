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
		<h1 style="text-align:center"><?php echo strTranslate("Photo_gallery");?></h1>
		<?php 
		session::getFlashMessage( 'actions_message' );
		fotosController::voteAction();
		fotosController::createAction();
		$albums = fotosAlbumController::getListAction();
		?>
		<section id="photos">

		</section>
		<div id="cargando-infinnite"><span class="btn btn-default">seguir cargando imagenes <i class="fa fa-arrow-circle-down"></i></span></div>
		<div class="clearfix"></div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<?php SearchPhoto("?page=fotos","searchForm","Buscar foto por título","buscar", "", "", "get");?>
			<?php PanelSubirFoto(0);?>
			<hr />
			<h4><?php echo strTranslate("Photo_albums");?></h4>
			<ul>
			<?php foreach($albums as $album): ?>
				<li><a href="?page=fotos&id=<?php echo $album['id_album'];?>"><?php echo $album['nombre_album'];?></a></li>
			<?php endforeach;?>
			</ul>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal modal-wide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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