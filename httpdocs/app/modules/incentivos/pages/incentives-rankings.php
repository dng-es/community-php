<?php

addJavascripts(array("js/libs/amcharts/amcharts.js"));

$id_objetivo = (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);

session::getFlashMessage( 'actions_message' ); 

$elements = incentivosObjetivosController::getListAction( 1, " AND id_objetivo=".$id_objetivo." ");
$incentivos = new incentivos();
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"incentives-targets"),
			array("ItemLabel"=>"Rankings", "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-12">
				<?php foreach($elements['items'] as $element):?>
				<?php $ranking = incentivosController::getRankingAction($element);?>
				<div class="panel panel-default">	
					<div class="panel-heading"><?php echo $element['nombre_objetivo'];?></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-striped table-hover">
								<?php for ($i = 0; $i < 10; $i++){ 
									if ($element['tipo_objetivo']=='Usuario'){
										$texto_usuario = '<a href="user-profile?n='.$ranking[$i]['nick'].'">'.(isset($ranking[$i]) ? $ranking[$i]['usuario_nombre'] : "").'</a>';
									}
									else{
										$texto_usuario = (isset($ranking[$i]) ? $ranking[$i]['usuario_nombre'] : "");
									}
								?>
									<tr>
										<td width="60px"><center><big><?php echo $i+1;?></big></center></td>
										<td><?php echo $texto_usuario;?></td>
										<td><center><?php echo (isset($ranking[$i]) ? round($ranking[$i]['porcentaje'], 2) : 0);?>%</center></td>
									</tr>
								<?php } ?>
								</table>
							</div>
						</div>
					</div>
				</div>  
				<?php endforeach; ?>
			</div>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<h4><?php echo strTranslate("Incentives");?></h4>
			<p>Estos son los rankings de cada objetivo, ¿estas entre los primeros? descúbrelo!!!.</p>
			<p class="text-center"><i class="fa fa-gift fa-big"></i></p>
		</div>
	</div>
</div>