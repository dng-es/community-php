<?php

addJavascripts(array("js/libs/highcharts/highcharts.js",
					 "js/libs/highcharts/modules/exporting.js"));

$referencia_acelerador = (isset($_REQUEST['ref']) ? $_REQUEST['ref'] : 0);

session::getFlashMessage( 'actions_message' ); 
$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_objetivo='".$_SESSION['user_canal']."' " : "");
$elements = incentivosObjetivosController::getListAction(35, $filtro_canal." AND NOW() BETWEEN date_ini_objetivo AND date_fin_objetivo ");
$incentivos = new incentivos();
$users = new users();
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"incentives-targets"),
			array("ItemLabel"=>strTranslate("Incentives_my_targets"), "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-12">

	
				<?php foreach($elements['items'] as $element):
				//comprobar que el objetivo es para el usuario o para la tienda del usuario
				$filtro_usuario = ($element['tipo_objetivo'] == 'Usuario' ? "='".$_SESSION['user_name']."'": ($_SESSION['user_perfil'] == 'regional' ? " IN (SELECT cod_tienda FROM users_tiendas WHERE regional_tienda='".$_SESSION['user_name']."')" : "='".$_SESSION['user_empresa']."'"));
				$filtro_objetivo = ($element['tipo_objetivo'] == 'Usuario' ? "='".$_SESSION['user_name']."'": " IN (SELECT username FROM users WHERE empresa='".$_SESSION['user_empresa']."') ");

				$objetivos = $incentivos->getIncentivesObjetivosDetalle(" AND id_objetivo=".$element['id_objetivo']." AND destino_objetivo".$filtro_usuario." ");
				?>
				<div class="panel panel-default">
			
					<div class="panel-heading"><?php echo $element['nombre_objetivo'];?></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-7">
								<p>Tipo de objetivo: <?php echo $element['tipo_objetivo'];?><br />
								<?php echo strTranslate("Date_start");?>: <?php echo getDateFormat( $element['date_ini_objetivo'], 'SHORT');?> - 
								<?php echo strTranslate("Date_end");?>: <?php echo getDateFormat( $element['date_fin_objetivo'], 'SHORT');?></p>
								<p><small><a href="incentives-rankings?id=<?php echo $element['id_objetivo'];?>">ver ranking del objetivo</a></small></p>
								<?php 
								if (count($objetivos)>0):
									$total_objetivo = 0;
									$total_conseguido = 0;
								?>
								<div class="table-responsive">
									<table class="table table-striped table-hover">
										<tr>
											<th><?php echo strTranslate("Incentives_product");?></th>
											<th><center><?php echo strTranslate("Incentives_sales");?></center></th>
											<th><center><?php echo strTranslate("Incentives_target");?></center></th>
											<th><center>%</center></th>
										</tr>
									<?php foreach($objetivos as $objetivo):?>
										<?php
										$total_ventas = connection::sumReg("incentives_ventas", "cantidad_venta", " AND id_producto=".$objetivo['id_producto']." AND fecha_venta BETWEEN '".$element['date_ini_objetivo']."' AND '".$element['date_fin_objetivo']."' AND username_venta".$filtro_objetivo." ");
										$total_conseguido += $total_ventas;
										$total_objetivo += floatval($objetivo['valor_objetivo']);
										$porcentaje = ($total_ventas==0 ? 0 : (($total_ventas/$objetivo['valor_objetivo'])*100));
										?>
										<tr>
											<td>
												<?php echo $objetivo['referencia_producto'];?><br />
												<small><em class="text-muted"><?php echo $objetivo['nombre_producto'];?> - <?php echo $objetivo['nombre_fabricante'];?></em></small>
												<?php if($_SESSION['user_perfil'] == 'regional'): 
													//obtener datos de la tienda
													$datos_tienda = $users->getTiendas(" AND cod_tienda='".$objetivo['destino_objetivo']."' ");
													if (count($datos_tienda) > 0) echo '<br /><small>'.$datos_tienda[0]['cod_tienda'].' - '.$datos_tienda[0]['nombre_tienda'].'</small>';
												?>
												<?php endif;?>
											</td>
											<td><center><?php echo $total_ventas;?></center></td>
											<td><center><?php echo $objetivo['valor_objetivo'];?></center></td>
											<td><center><?php echo round($porcentaje, 2);?>%</center></td>
										</tr>
									<?php endforeach; ?>
									</table>
								</div>
								<?php else: ?>
									<div class="text-warning"><i class="fa fa-warning"></i> No tienes objetivos fijados</div>
								<?php endif; ?>
							</div>
							<div class="col-md-5">
								<?php 
								if (count($objetivos)>0):
									$pendiente = ($total_conseguido >= $total_objetivo ? 0 : ($total_objetivo - $total_conseguido));
									showGraph($element['id_objetivo'], $total_conseguido, $pendiente);
								endif;
								?>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>

			</div>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h4><?php echo strTranslate("Incentives");?></h4>
			<p>Estos son tus incentivos y el porcentaje de consecución. Tambien puedes ver el ranking de cada objetivo y comprobar quienes son los mejores.</p>
			<p class="text-center"><i class="fa fa-gift fa-big"></i></p>
		</div>
	</div>
</div>

<?php

function showGraph($id_target, $conseguido, $pendiente){
?>
<script type="text/javascript">
	var chartData<?php echo $id_target;?>=[{name: "Pendiente",y: <?php echo floatval($pendiente);?>},{name: "Conseguido",y: <?php echo floatval($conseguido);?>}];
	$(function () {
		$('#container<?php echo $id_target;?>').highcharts({
			credits: false,
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false,
	            type: 'pie'
	        },
	        title: {
	            text: 'Consecucion objetivo'
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: false
	                },
	                showInLegend: true
	            }
	        },
	        series: [{
	            name: "Porcentaje",
	            colorByPoint: true,
	            data: chartData<?php echo $id_target;?>
	        }]
	    });   
});   
</script>
<div id="container<?php echo $id_target;?>" class="container-graph"></div>
<?php 
}
?>