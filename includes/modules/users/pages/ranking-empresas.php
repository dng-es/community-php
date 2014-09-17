<?php

addJavascripts(array(getAsset("users")."js/ranking-empresas.js"));

$users = new users();
$puntos_empresa = $users->getPuntosEmpresa(" AND empresa='".$_SESSION['user_empresa']."' ");
$puntuacion_user = $puntos_empresa[0]['puntos_empresa'];
$posicion_empresa_user=users::posicionRankingEmpresa($_SESSION['user_empresa']);
if ($_SESSION['user_perfil']=='admin'){$posicion_empresa=0;}
$puntos = $users->getPuntosEmpresa(" AND empresa<>'' AND empresa<>'comunidad' ","ORDER BY puntos_empresa DESC,empresa ASC LIMIT 15");

?>
<div class="row inset row-top">
	<div class="col-md-9">
		<h1>Ranking empresas</h1>
		<div class="row">
			<div class="col-md-12">
				<p>Cada una de tus aportaciones ayuda a tu empresa a acumular <?php echo strTranslate("APP_points");?>. ¿Cuántos <?php echo strTranslate("APP_points");?>, tenéis? 
				¿estáis entre los primeros? descúbrelo en este ranking:</p>
				<h3><?php echo $puntos_empresa[0]['nombre_tienda'];?> <small><?php echo $puntos_empresa[0]['puntos_empresa']." ".strTranslate("APP_points");?></small> Posición <small><?php echo $posicion_empresa_user;?></small></h3>
				<table class="table">
					<?php 	
					//LOS 10 PRIMEROS DEL RANKING
					//$total_empresas=$users->getTotalEmpresas();
					//echo '	<p>Los mejores en el ranking, total de centros activos: '.$total_empresas.'</p>';
					echo '<table class="table">';
					for ($i=0;$i<=14;$i++){	
						if (isset($puntos[$i])): ?>
					<tr>
						<td class="table-number"><?php echo ($i+1);?></td>
						<td width="100%"><span class="color-ranking"><?php echo $puntos[$i]['nombre_tienda'];?></span><br />
						<?php echo $puntos[$i]['puntos_empresa'].' '.strTranslate("APP_points");?>
						</td>
					</tr>
						<?php endif;
					} ?>
				</table>									
			</div>
		</div>
	</div>
	<div class="col-md-3 lateral">	
		<a href="?page=ranking" class="btn btn-primary btn-block">Ir a ranking de usuarios</a>
		<br />
		<h4>¿Cómo ganar <?php echo strTranslate("APP_points");?>?</h4>
		<p><b><?php echo PUNTOS_ACCESO_SEMANA." ".strTranslate("APP_points");?> por...</b> entrar 1 vez a la semana en la comunidad<br /><br />
		<b><?php echo PUNTOS_FORO_SEMANA." ".strTranslate("APP_points");?> por...</b> participar 1 vez por semana en los foros<br /><br />
		<b><?php echo PUNTOS_VIDEO." ".strTranslate("APP_points");?> por...</b> subir un vídeo<br /><br />
		<b><?php echo PUNTOS_FOTO." ".strTranslate("APP_points");?> por...</b> por subir una foto<br />
		</p>
	</div>        
</div>