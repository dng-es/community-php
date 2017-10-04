<?php
templateload("graph", "emociones");

addJavascripts(array(getAsset("emociones")."js/emociones-graph.js"));
addCss(array(getAsset("emociones")."css/styles.css"));

$elements = emocionesController::getListUserAction(20, " AND user_emocion='".$_SESSION['user_name']."' AND e.active=1 ");
?>
<div class="row row-top">
	<br />
	<div class="row">
		<div class="col-md-5 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-body">
					<h2><?php echo strTranslate("Emotions_history");?></h2>
					<a class="pull-right" href="emociones-home"><small>Nueva emoción <i class="fa fa-angle-double-right" aria-hidden="true"></i></small></a>
					<div class="table-responsive">
						<table class="table table-striped">	
							<?php foreach($elements['items'] as $element):?>
								<tr>
								<td nowrap="nowrap" width="60px">
									<img style="height: 50px" src="images/emociones/<?php echo $element['image_emocion'];?>" />
								</td>					
								<td>
									<b><?php echo $element['name_emocion'];?></b><br />
									<?php echo $element['desc_emocion_user'];?>									
									<small class="text-muted pull-right"><?php echo ucfirst(getDateFormat($element['date_emocion'], "LONG"));?> - 
									<?php echo getDateFormat($element['date_emocion'], 'TIME');?></small>
								</td>
								</tr>
							<?php endforeach;?>
						</table>
					</div>
					<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<?php graphEmocion(true, false);?>
		</div>
	</div>
</div>