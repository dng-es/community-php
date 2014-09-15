<?php

templateload("gallery","fotos");
templateload("addfile","fotos");

addJavascripts(array("js/bootstrap.file-input.js", 
					 "js/jquery.bettertip.pack.js", 
					 getAsset("fotos")."js/fotos.js"));

session::getFlashMessage( 'actions_message' );
fotosController::voteAction();
fotosController::createAction();
$elements = fotosController::getListAction(4, " AND estado=1 ");
?>
<div id="page-info"><?php echo strTranslate("Photo_gallery");?></div>
<div class="row row-top">
	<div class="col-md-9 inset">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<div class="message-form" id="alert alert-danger" style="display: none"></div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<a href="?page=fotos&o=1&f=<?php echo $elements['find_reg'];?>" class="Tam11"><?php echo strTranslate("Order_photos_by_votes");?> &raquo;</a>  
					<a href="?page=fotos&o=2&f=<?php echo $elements['find_reg'];?>" class="Tam11"><?php echo strTranslate("Order_photos_by_date");?> &raquo;</a>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12"> 
					<?php SearchForm($elements['reg'],"?page=fotos","searchForm","Buscar foto por título","buscar");?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
      				<div class="gallery clearfix">
						<?php galleryPhotos($elements['items'],true,0,4);?>
      				</div>
    			</div>
			</div>

		</div>
	</div>
	<div class="col-md-3 lateral">
		<?php PanelSubirFoto(0);?>
	</div>
</div>