<?php
addJavascripts(array(getAsset("users")."js/ranking-empresas.js"));

$users = new users();
$filtro_usuarios = " AND puntos>0 AND perfil<>'admin' AND confirmed=1 AND disabled=0 ";
$puntos_empresa = $users->getPuntosEmpresa($filtro_usuarios." AND empresa='".$_SESSION['user_empresa']."' ");
$puntuacion_user = $puntos_empresa[0]['puntos_empresa'];
$posicion_empresa_user = users::posicionRankingEmpresa($_SESSION['user_empresa']);
$puntos = $users->getPuntosEmpresa($filtro_usuarios." AND empresa<>'' AND empresa<>'comunidad' ","ORDER BY puntos_empresa DESC,empresa ASC LIMIT 15");
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
		<div class="panel panel-default">
			<div class="panel-body">
				<p>Cada una de tus aportaciones ayuda a tu empresa a acumular <?php e_strTranslate("APP_points");?>. ¿Cuántos <?php e_strTranslate("APP_points");?>, tenéis? 
				¿estáis entre los primeros? descúbrelo en este ranking:</p><br />
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<?php 	
						//LOS X PRIMEROS DEL RANKING
						for ($i = 0; $i <= 14; $i++){
							if (isset($puntos[$i])) userRanking($puntos[$i], $puntos[0]['puntos'], $i);
						} ?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<a href="ranking" class="btn btn-primary btn-block"><?php e_strTranslate("Go_to_users_ranking");?></a>
			<h3>Posición <small><?php echo $posicion_empresa_user;?></small></h3>
			<p><?php echo $puntos_empresa[0]['nombre_tienda'];?><br />
			<?php echo round($puntos_empresa[0]['puntos_empresa'], 2);?> <?php e_strTranslate("APP_points");?></p>
		</div>
	</div>
</div>

<?php function userRanking($puntos, $max_puntos, $posicion_user){ ?>
<tr>
	<td class="table-number" width="40px">
		<i class="fa fa-trophy fa-medium"><small><?php echo ($posicion_user + 1);?></small></i>
	</td>
	<td width="100%">
		<span class="color-ranking"><?php echo $puntos['nombre_tienda'];?></span>
		<p class="text-muted"><?php echo round($puntos['puntos_empresa'], 2).' '.strTranslate("APP_points");?></p>
	</td>
</tr>
<?php }?>