<?php
templateload("tipuser", "users");

addJavascripts(array(getAsset("users")."js/ranking.js"));

$module_config = getModuleConfig("users");
$module_channels = getModuleChannels($module_config['channels'], $_SESSION['user_canal']);
$filtro_canal = ($_SESSION['user_canal'] == 'admin' ? "" : " AND canal IN (".$module_channels.") ");

$user_data = usersController::getPerfilAction($_SESSION['user_name']);
$posicion_user = users::posicionRanking($_SESSION['user_name'], " AND confirmed=1 AND disabled=0 ".$filtro_canal);
if ($_SESSION['user_perfil'] == 'admin') $posicion_user = 0;

$users = new users();
$puntos = $users->getUsers($filtro_canal." AND puntos>0 AND perfil<>'admin' AND confirmed=1 AND disabled=0 ORDER BY puntos DESC,username ASC LIMIT 15");
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
				<?php if (count($puntos) > 0):?>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<?php 
						//LOS X PRIMEROS DEL RANKING
						for ($i = 0; $i <= 14; $i++){
							if (isset($puntos[$i])): 
								userRanking($puntos[$i], $puntos[0]['puntos'],$i);
							endif;
						} ?>
					</table>
				</div>
				<?php else:?>
					<div class="alert alert-info">No hay datos para el ranking</div>
				<?php endif;?>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<a href="ranking-empresas" class="btn btn-primary btn-block"><?php e_strTranslate("Go_to_companies_ranking");?></a>
			<h3><?php e_strTranslate("Your_ranking");?> <small><?php echo $posicion_user;?></small></h3>
			<p><?php echo $user_data['name'].' '.$user_data['surname'];?><br />
			<?php echo $user_data['nombre_tienda'];?><br />
			<?php echo $user_data['puntos'];?> <?php e_strTranslate("APP_points");?>
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

<?php function userRanking($puntos,$max_puntos,$posicion_user){ ?>
<tr>
	<td class="table-number" width="40px">
		<i class="fa fa-trophy fa-medium"><small><?php echo ($posicion_user + 1);?></small></i>
	</td>
	<td width="60px">
		<?php userFicha($puntos); ?>
	</td>
	<td>
		<a href="user-profile?n=<?php echo $puntos['nick'];?>"><?php echo $puntos['nick'];?></a> - <?php echo $puntos['name'].' '.$puntos['surname'];?>
		<p class="text-muted"><?php echo $puntos['nombre_tienda'];?><br />
		<span><?php echo $puntos['puntos'].' '.strTranslate("APP_points");?></span></p>
	</td>
	<td><?php $puntos['nombre_tienda'];?></td>
</tr>
<?php }?>