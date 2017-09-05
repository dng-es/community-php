<?php
addJavascripts(array(getAsset("emociones")."js/emociones-home.js"));
addCss(array(getAsset("emociones")."css/styles.css"));

function insertEmocion(){ 
	$emociones = emocionesController::getListAction(4000, " AND active=1 ");
	?>
	<div id="emociones-container">
		<?php foreach($emociones['items'] as $element):?>
			<div class="col-md-4 col-xs-4">
			<img class="emociones-sel" data-dest="<?php echo $element['id_emocion'];?>" data-name="<?php echo $element['name_emocion'];?>" style="width:100%" src="images/banners/<?php echo $element['image_emocion'];?>" />
			<h4><?php echo $element['name_emocion'];?><span style="display:none" class="destino-emocion" data-dest="<?php echo $element['id_emocion'];?>"></span></h4>
			</div>
		<?php endforeach;?>      
	</div>
	<div class="row" style="margin-top:30px">
		<form role="form" action="" method="post" class="form-media" name="emocionesForm" id="emocionesForm">
			<div class="col-md-9">
				<input type="hidden" name="id_emocion" id="id_emocion" value="" data-alert="Debes elegir una emoción." />
				<input type="hidden" name="name_emocion" id="name_emocion" value="" />
				<input type="text" placeholder="<?php e_strTranslate("Emotion_why");?>" name="mi_emocion" id="mi_emocion" class="form-control input-lg" data-alert="Debes explicar por qué te sientes así.">
				<p class="text-center"><small><a href="emociones"><?php e_strTranslate("Emotions_history");?></a></small></p>	
			</div>
			<div class="col-md-3" style="overflow:hidden">
				<button type="submit" class="btn btn-lg btn-primary btn-block"><?php e_strTranslate("Send");?> <i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
			</div>
		</form>
	</div>

	<div class="row">
		<br />
		<span id="emociones-alert" class="alert-message alert alert-danger" style="text-align:center"></span>	
	</div>
<?php } ?>