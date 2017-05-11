<?php
/**
 * Print HTML rankings
 * @return	String						HTML rankings
 */
function panelRankings(){
	$filtro_perfil = incentivosObjetivosController::getFiltroPerfil($_SESSION['user_perfil']);
	$filtro_canal = (($_SESSION['user_canal'] == 'admin') ? "" : " AND canal_objetivo LIKE '%".$_SESSION['user_canal']."%' ");
	$rankings = incentivosObjetivosController::getListAction(99, $filtro_perfil.$filtro_canal." AND activo_objetivo=1 AND ranking_objetivo=1 ");
	foreach($rankings['items'] as $ranking):
		panelRanking($ranking['id_objetivo']);
	endforeach;
}

/**
 * Print HTML ranking panel for for a given ID
 * @param	Int 		$id_objetivo 	Id del objetivo a mostrar el ranking
 * @return	String						HTML panel
 */
function panelRanking($id_objetivo){
	$filtro_perfil = incentivosObjetivosController::getFiltroPerfil($_SESSION['user_perfil']);
	$objetivos = incentivosObjetivosController::getListAction(1, $filtro_perfil." AND id_objetivo=".$id_objetivo." AND ranking_objetivo=1 AND NOW() BETWEEN date_ini_objetivo AND date_fin_objetivo ");
	if ($objetivos['total_reg'] > 0):
		$filtro_tienda = incentivosObjetivosController::getFiltroTienda($_SESSION['user_perfil'], $_SESSION['user_name'], $_SESSION['user_empresa']);
		$ranking = incentivosController::getRankingAction($objetivos['items'][0], $filtro_tienda);
		$posicion_user = (isset($ranking['posicion_user'][0]['rownum']) ? $ranking['posicion_user'][0]['rownum'] : 0) ;
		$total_user = (isset($ranking['posicion_user'][0]['suma']) ? $ranking['posicion_user'][0]['suma'] : 0);
		$usuario = usersController::getPerfilAction($_SESSION['user_name']);
		?>
		<div class="col-md-12 section panel">
			<div class="row overflow-visible">
				<?php if (isset($objetivos['items'][0])): ?>
				<h3><?php echo $objetivos['items'][0]['nombre_objetivo'];?> <small><a href="incentives-rankings?id=<?php echo $objetivos['items'][0]['id_objetivo'];?>">
					<?php e_strTranslate("Go_to");?>
				</a></small></h3>
				<?php endif; ?>
			</div>
			<div class="row">
				<?php
				if (count($ranking['ranking']) > 0):
					$limite = ($posicion_user > 0 ? 5 : 6);
					for($i = 0; $i < $limite; $i++){ ?>
						<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 incentivos-ranking-user text-center <?php if((($i + 1) % 2) == 0 && isset($ranking['ranking'][$i])) { echo 'back-rank';} ?>">
							<?php if (isset($ranking['ranking'][$i])):
								$ranking_user = $ranking['ranking'][$i];
								?>
								<span class="font-white"><strong><?php echo ($i + 1);?>&deg;</strong></span><br />
								<img width="100%" title="<?php echo $ranking_user['nick'];?>: <?php echo $ranking_user['suma'];?> <?php e_strTranslate("Incentives_points");?>" src="<?php echo usersController::getUserFoto($ranking_user['foto']);?>" />
								<div class="text-center ellipsis">
									<div class="text-center text-user ellipsis font-white"><?php echo $ranking_user['nick'];?></div>
									<small class="text-primary"><?php echo $ranking_user['suma'];?> <?php e_strTranslate("Incentives_points");?></small>
								</div>
							<?php endif;?>
						</div>
					<?php } ?>
					<?php if($posicion_user > 0): ?>
						<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 incentivos-ranking-user2 bg-red">
							<div class="font-white text-center incentivos-ranking-user2-title ellipsis"><?php e_strTranslate("your_position");?></div>
							<img width="100%" src="<?php echo usersController::getUserFoto($usuario['foto']);?>" title="<?php echo $usuario['nick'];?>: <?php echo $total_user;?> <?php e_strTranslate("Incentives_points");?>" />
							<div class="text-center incentivos-ranking-user2-div ellipsis">
								<big><strong class="font-white incentivos-ranking-user2-puntos"><?php echo $posicion_user;?>&deg;</strong></big><br />
								<span class="font-white"><small><?php echo $total_user;?> <?php e_strTranslate("Incentives_points");?></small></span>
							</div>
						</div>
					<?php endif; ?>
				<?php else: ?>
						<p>No existen datos actualmente, serán cargados próximamente.</p>
				<?php endif; ?>
			</div>
			<br />
		</div>
	<?php endif; ?>
<?php } ?>