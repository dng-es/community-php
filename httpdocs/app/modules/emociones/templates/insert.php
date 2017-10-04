<?php
emocionesController::createUserAction($_SERVER['REQUEST_URI']);

function insertEmocion(){ 
	$emociones = emocionesController::getListAction(4000, " AND active=1 ");
	?>
	<div id="emociones-container">
		<?php foreach($emociones['items'] as $element):?>
			<div class="col-md-3 col-xs-3">
				<div class="emociones-sel" data-dest="<?php echo $element['id_emocion'];?>" data-name="<?php echo $element['name_emocion'];?>">
					<img src="images/emociones/<?php echo $element['image_emocion'];?>" class="faa-tada animated-hover" />
					<h4><b><?php echo $element['name_emocion'];?><span style="display:none" class="destino-emocion" data-dest="<?php echo $element['id_emocion'];?>"></span></b></h4>
				</div>
			</div>
		<?php endforeach;?>      
	</div>
	<div class="row" style="margin-top:30px; clear: both">
		<form role="form" action="" method="post" class="form-media" name="emocionesForm" id="emocionesForm">
			<div class="col-md-9">
				<input type="hidden" name="id_emocion" id="id_emocion" value="" data-alert="<?php e_strTranslate("Choose_emition");?>" />
				<input type="hidden" name="name_emocion" id="name_emocion" value="" />
				<input type="text" placeholder="<?php e_strTranslate("Emotion_why");?>" name="mi_emocion" id="mi_emocion" class="form-control input-lg" data-alert="<?php e_strTranslate("Emotion_why");?>">
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