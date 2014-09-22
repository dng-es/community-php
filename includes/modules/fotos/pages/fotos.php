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
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<h1><?php echo strTranslate("Photo_gallery");?></h1>
		<div class="message-form" id="alert alert-danger" style="display: none"></div>

		<div>
			<a href="?page=fotos&o=1&f=<?php echo $elements['find_reg'];?>" class="Tam11"><?php echo strTranslate("Order_photos_by_votes");?> &raquo;</a>  
			<a href="?page=fotos&o=2&f=<?php echo $elements['find_reg'];?>" class="Tam11"><?php echo strTranslate("Order_photos_by_date");?> &raquo;</a>
		</div>

		<div class="gallery clearfix">
			<?php galleryPhotos($elements['items'],true,0,4);?>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<?php SearchForm($elements['reg'],"?page=fotos","searchForm","Buscar foto por título","buscar");?>
			<?php PanelSubirFoto(0);?>
		</div>
	</div>
</div>