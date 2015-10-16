<?php
addJavascripts(array(getAsset("users")."js/ranking-empresas.js"));

$users = new users();
$puntos_empresa = $users->getPuntosEmpresa(" AND empresa='".$_SESSION['user_empresa']."' ");
$puntuacion_user = $puntos_empresa[0]['puntos_empresa'];
$posicion_empresa_user=users::posicionRankingEmpresa($_SESSION['user_empresa']);
if ($_SESSION['user_perfil']=='admin') $posicion_empresa = 0;
$puntos = $users->getPuntosEmpresa(" AND empresa<>'' AND empresa<>'comunidad' ","ORDER BY puntos_empresa DESC,empresa ASC LIMIT 15");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Rankings"), "ItemUrl"=>"ranking"),
			array("ItemLabel"=>strTranslate("Ranking_companies"), "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-12 container-fade">
				<p>Cada una de tus aportaciones ayuda a tu empresa a acumular <?php echo strTranslate("APP_points");?>. ¿Cuántos <?php echo strTranslate("APP_points");?>, tenéis? 
				¿estáis entre los primeros? descúbrelo en este ranking:</p>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<?php 	
						//LOS 10 PRIMEROS DEL RANKING
						//$total_empresas=$users->getTotalEmpresas();
						for ($i = 0; $i <= 14; $i++){	
							if (isset($puntos[$i])): ?>
						<tr>
							<td class="table-number" width="40px"><i class="fa fa-trophy fa-medium"><small><?php echo ($i+1);?></small></i></td>
							<td width="100%"><span class="color-ranking"><?php echo $puntos[$i]['nombre_tienda'];?></span>
							<p class="text-muted"><?php echo $puntos[$i]['puntos_empresa'].' '.strTranslate("APP_points");?></p>
							</td>
						</tr>
							<?php endif;
						} ?>
					</table>
				</div>								
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<a href="ranking" class="btn btn-primary btn-block"><?php echo strTranslate("Go_to_users_ranking");?></a>
			<h3>Posición <small><?php echo $posicion_empresa_user;?></small></h3>
			<p><?php echo $puntos_empresa[0]['nombre_tienda'];?><br />
			<?php echo $puntos_empresa[0]['puntos_empresa'];?> <?php echo strTranslate("APP_points");?></p>
		</div>
	</div>        
</div>