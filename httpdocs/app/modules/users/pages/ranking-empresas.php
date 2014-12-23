<?php

addJavascripts(array(getAsset("users")."js/ranking-empresas.js"));

$users = new users();
$puntos_empresa = $users->getPuntosEmpresa(" AND empresa='".$_SESSION['user_empresa']."' ");
$puntuacion_user = $puntos_empresa[0]['puntos_empresa'];
$posicion_empresa_user=users::posicionRankingEmpresa($_SESSION['user_empresa']);
if ($_SESSION['user_perfil']=='admin'){$posicion_empresa=0;}
$puntos = $users->getPuntosEmpresa(" AND empresa<>'' AND empresa<>'comunidad' ","ORDER BY puntos_empresa DESC,empresa ASC LIMIT 15");

?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Rankings"), "ItemUrl"=>"#"),
			array("ItemLabel"=>"Ranking de empresas", "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-12 container-fade">
				<p>Cada una de tus aportaciones ayuda a tu empresa a acumular <?php echo strTranslate("APP_points");?>. ¿Cuántos <?php echo strTranslate("APP_points");?>, tenéis? 
				¿estáis entre los primeros? descúbrelo en este ranking:</p>
				<h3><?php echo $puntos_empresa[0]['nombre_tienda'];?> <small><?php echo $puntos_empresa[0]['puntos_empresa']." ".strTranslate("APP_points");?></small> Posición <small><?php echo $posicion_empresa_user;?></small></h3>
				<table class="table table-striped">
					<?php 	
					//LOS 10 PRIMEROS DEL RANKING
					//$total_empresas=$users->getTotalEmpresas();
					for ($i=0;$i<=14;$i++){	
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
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">	
			<h3>¿Cómo ganar <?php echo strTranslate("APP_points");?>?</h3>
			<ul class="list-unstyled">
			<li><span class="text-primary"><?php echo PUNTOS_ACCESO_SEMANA." ".strTranslate("APP_points");?></span> por entrar 1 vez a la semana en la comunidad</li>
			<li><span class="text-primary"><?php echo PUNTOS_FORO_SEMANA." ".strTranslate("APP_points");?></span> por participar 1 vez por semana en los foros</li>
			<li><span class="text-primary"><?php echo PUNTOS_VIDEO." ".strTranslate("APP_points");?></span> por subir un vídeo</li>
			<li><span class="text-primary"><?php echo PUNTOS_FOTO." ".strTranslate("APP_points");?></span> por por subir una foto</li>
			</ul>
			<a href="?page=ranking" class="btn btn-primary btn-block">Ir a ranking de usuarios</a>
		</div>
	</div>        
</div>