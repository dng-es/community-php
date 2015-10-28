<?php
templateload("tipuser", "users");

addJavascripts(array(getAsset("users")."js/ranking.js"));

$users = new users();
$puntos_user = $users->getUsers(" AND username='".$_SESSION['user_name']."' ");
$puntuacion_user = $puntos_user[0]['puntos'];
$posicion_user = users::posicionRanking($_SESSION['user_name']);
if ($_SESSION['user_perfil'] == 'admin') $posicion_user = 0;

$puntos = $users->getUsers(" AND perfil<>'admin' AND confirmed=1 AND disabled=0 ORDER BY puntos DESC,username ASC LIMIT 15");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Rankings"), "ItemUrl"=>"ranking"),
			array("ItemLabel"=>strTranslate("Ranking_users"), "ItemClass"=>"active"),
		));
		?>
		<p><?php e_strTranslate("Ranking_users_text");?>:</p><br />

		<div class="row">
			<div class="col-md-12">
				<br />
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<?php
						//LOS 10 PRIMEROS DEL RANKING
						//$total_usuarios = connection::countReg("users"," AND confirmed=1 AND disabled=0 ORDER BY username");
						//echo '	<p>Los mejores en el ranking, total de usuarios activos: '.$total_usuarios.'</p>';

						for ($i=0;$i<=14;$i++){	
							if (isset($puntos[$i])): ?>
								<tr>
									<td class="table-number" width="40px"><i class="fa fa-trophy fa-medium"><small><?php echo ($i + 1);?></small></i></td>
									<td width="60px">
										<?php userFicha($puntos[$i]); ?>
									</td>
									<td>
										<a href="user-profile?n=<?php echo $puntos[$i]['nick'];?>"><?php echo $puntos[$i]['nick'];?></a> - <?php echo $puntos[$i]['name'].' '.$puntos[$i]['surname'];?>
										<p class="text-muted"><?php echo $puntos[$i]['nombre_tienda'];?><br />
										<span><?php echo $puntos[$i]['puntos'].' '.strTranslate("APP_points");?></span></p>
									</td>
									<td><?php $puntos[$i]['nombre_tienda'];?></td>
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
			<a href="ranking-empresas" class="btn btn-primary btn-block"><?php e_strTranslate("Go_to_companies_ranking");?></a>
			<h3><?php e_strTranslate("Your_ranking");?> <small><?php echo $posicion_user;?></small></h3>
			<p><?php echo $puntos_user[0]['name'].' '.$puntos_user[0]['surname'];?><br />
			<?php echo $puntos_user[0]['nombre_tienda'];?><br />
			<?php echo $puntos_user[0]['puntos'];?> <?php e_strTranslate("APP_points");?>
			</p>
			<hr />
			<h3>¿Cómo ganar <?php e_strTranslate("APP_points");?>?</h3>
			<ul class="list-funny">
			<li><span class="text-primary"><?php echo PUNTOS_ACCESO_SEMANA." ".strTranslate("APP_points");?></span> por entrar 1 vez a la semana en la comunidad</li>
			<li><span class="text-primary"><?php echo PUNTOS_FORO_SEMANA." ".strTranslate("APP_points");?></span> por participar 1 vez por semana en los foros</li>
			<li><span class="text-primary"><?php echo PUNTOS_VIDEO." ".strTranslate("APP_points");?></span> por subir un vídeo</li>
			<li><span class="text-primary"><?php echo PUNTOS_FOTO." ".strTranslate("APP_points");?></span> por por subir una foto</li>
			</ul>
		</div>
	</div>
</div>