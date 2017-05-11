<?php
set_time_limit(0);
ini_set('memory_limit', '-1');

$id_objetivo = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
$id_group = ((isset($_REQUEST['idg']) && $_REQUEST['idg'] != "") ? $_REQUEST['idg'] : "");

session::getFlashMessage( 'actions_message' );

$users = new users();

$filtro_tipo = "";
$tipo_informe = "usuarios";

$filtro_tiendas = ($_SESSION['user_perfil'] == 'regional' ? " AND (regional_tienda='".$_SESSION['user_name']."') " : "");
$filtro_tiendas .= ($_SESSION['user_perfil'] == 'responsable' ? " AND responsable_tienda='".$_SESSION['user_name']."' " : "");
$filtro_tiendas .= ($_SESSION['user_perfil'] == 'usuario' ? " AND cod_tienda='".$_SESSION['user_empresa']."' " : "");

$filtro_perfil = incentivosObjetivosController::getFiltroPerfil($_SESSION['user_perfil']);

if (isset($_REQUEST['t']) && $_REQUEST['t'] == 'todos'){
	$filtro_tipo = "todos";
	$filtro_tienda = "";
}
elseif ((isset($_REQUEST['t']) && $_REQUEST['t'] == 'tiendas') && ($_SESSION['user_perfil'] == 'regional' || $_SESSION['user_perfil'] == 'admin' || $_SESSION['user_perfil'] == 'visualizador')){
	$filtro_tipo = "tiendas";
	$filtro_tienda = "";
	$tipo_informe = "tiendas";
}
elseif ((isset($_REQUEST['t']) && $_REQUEST['t'] == 'tiendas_global') && ($_SESSION['user_perfil'] == 'regional')){
	$filtro_tipo = "tiendas_global";
	$filtro_tienda = "";
	$tipo_informe = "tiendas_global";
}
else{
	$filtro_tienda = incentivosObjetivosController::getFiltroTienda($_SESSION['user_perfil'], $_SESSION['user_name'], $_SESSION['user_empresa']);
}

$filtro_tienda .= ($id_group != '' ? " AND u.empresa='".$id_group."' " : "");

$groups = $users->getTiendas($filtro_tiendas." AND activa=1 ORDER BY nombre_tienda");

$filtro_canal = (($_SESSION['user_canal'] == 'admin') ? "" : " AND canal_objetivo LIKE '%".$_SESSION['user_canal']."%' ");

$elements = incentivosObjetivosController::getListAction( 1, $filtro_canal.$filtro_perfil." AND id_objetivo=".$id_objetivo." ");
$element = $elements['items'][0];

//exportar datos
incentivosController::getRankingUsuarioTiendaActionExport($element, $filtro_tienda, $tipo_informe);
if ($tipo_informe == "tiendas"){
	$titulo_columna = strTranslate("Group_user");
	$ranking_total = incentivosController::getRankingUsuarioTiendaAction($element, $filtro_tiendas);
}
elseif ($tipo_informe == "tiendas_global"){
	$titulo_columna = strTranslate("Group_user");
	$ranking_total = incentivosController::getRankingUsuarioTiendaAction($element, "");
}
else{
	$titulo_columna = strTranslate("User");
	$ranking_total = incentivosController::getRankingUsuarioAction($element, $filtro_tienda);
}

$usuario = usersController::getPerfilAction($_SESSION['user_name']);

$posicion = 0;
$total_user = 0;
$tipo_objetivo = "";
$incentivos = new incentivos();

addJavascripts(array(getAsset("incentivos")."js/incentives-rankings.js"));
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"incentives-targets"),
			array("ItemLabel"=>"Rankings", "ItemClass"=>"active"),
		));

		if ($element['ranking_objetivo'] == 1): ?>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php
							if ($element['tipo_objetivo'] == 'Usuario'):
								$posicion = (isset($ranking_total['posicion_user'][0]) ? $ranking_total['posicion_user'][0]['rownum'] : 0);
								$total_user = (isset($ranking_total['posicion_user'][0]) ? $ranking_total['posicion_user'][0]['suma'] : 0);
								$ranking = $ranking_total['ranking'];
								$tipo_objetivo = "Usuario";
							else:
								$posicion = array_search($_SESSION['user_empresa'], arraycolumn($ranking, 'usuario'));
								$ranking = $ranking_total;
								$tipo_objetivo = "Tienda";
							endif;
						?>
						<a class="btn btn-default btn-xs pull-right" href="<?php echo $_SERVER['REQUEST_URI'];?>&export=true"><i class="fa fa-download"></i> <?php e_strTranslate("Download");?> ranking</a>
						<h2>
							<b>
							<?php echo $element['nombre_objetivo'];?></b>
							<small><?php echo getDateFormat( $element['date_ini_objetivo'], 'SHORT');?> - <?php echo getDateFormat( $element['date_fin_objetivo'], 'SHORT');?></small>
						</h2>
						<br />
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default panel-app">
									<div class="panel-body">
										<div class="row">
											<div class="text-right col-md-4">
												<label for="tipo_ranking" class=""><?php e_strTranslate("Ranking_type");?>:</label>
											</div>
											<div class="col-md-4">
												<select name="tipo_ranking" id="tipo_ranking" class="form-control input-xs" data-idg="<?php echo $id_objetivo;?>">
													<option value="" <?php echo ($filtro_tipo == "" ? ' selected="selected"' : "");?>'>Ranking de <?php e_strTranslate("Users");?></option>
													<?php if ($_SESSION['user_perfil'] !='admin'):?>
													<option value="todos" <?php echo ($filtro_tipo == "todos" ? ' selected="selected"' : "");?>'>Ranking de todos los <?php e_strTranslate('Users');?></option>
													<?php endif;?>

													<?php if ($_SESSION['user_perfil'] == 'regional' || $_SESSION['user_perfil'] == 'admin'): ?>
													<option value="tiendas" <?php echo ($filtro_tipo == "tiendas" ? ' selected="selected"' : "");?>'>Ranking de mis <?php e_strTranslate("Groups_user");?></option>
														<?php if ($_SESSION['user_perfil'] == 'regional'): ?>
															<option value="tiendas_global" <?php echo ($filtro_tipo == "tiendas_global" ? ' selected="selected"' : "");?>'>Ranking de <?php e_strTranslate(Groups_user);?></option>
														<?php endif; ?>
													<?php endif; ?>
												</select>
											</div>
											<?php if ($_SESSION['user_perfil'] != 'usuario'):?>
											<div class="col-md-4" id="groups_user_container">
												<select id="groups_user" name="groups_user" class="form-control input-xs" data-idg="<?php echo $id_objetivo;?>">
													<option value="">--Todas mis <?php e_strTranslate('Groups_user');?>--</option>
													<?php foreach($groups as $group): ?>
													<option value="<?php echo $group['cod_tienda'];?>" <?php echo ($group['cod_tienda'] == $id_group ? ' selected="selected" ' : '');?>><?php echo $group['nombre_tienda'];?> (<?php echo $group['cod_tienda'];?>)</option>
													<?php endforeach;?>
												</select>
											</div>
											<?php endif;?>
										</div>
									</div>
								</div>
								<table class="table">
									<tr>
										<th><?php e_strTranslate("Position");?></th>
										<th <?php echo ($tipo_informe == "usuarios" ? 'colspan="2"' : '');?>><?php echo $titulo_columna;?></th>
										<th class="text-center"><?php e_strTranslate("Incentives_points");?></th>
										<th class="text-center" width="60px"></th>
									</tr>
								<?php for ($i = 0; $i < 999; $i++){
									$tendencia = "";
									if (isset($ranking[$i]) && $ranking[$i]['suma'] > 0){
										$mostrar_fila = true;
										if ($element['tipo_objetivo'] == 'Usuario' && (isset($ranking[$i]['nick']) && $ranking[$i]['nick'] <> '') && $tipo_informe == "usuarios"){
											$texto_usuario = $ranking[$i]['name'].' '.$ranking[$i]['surname'].' <small><a class="text-warning'.(($i + 1) == $posicion ? " label label-info" : "").'" href="user-profile?n='.$ranking[$i]['nick'].'">'.(isset($ranking[$i]) ? $ranking[$i]['nick'] : "").'</a></small><br /><em class="text-muted">'.$ranking[$i]['nombre_tienda'].'</em>';
											$tendencia_user = $incentivos->getVentasTendenciaUser($filtro_tienda." AND username_venta='".$ranking[$i]['username_venta']."' ORDER BY fecha_venta DESC LIMIT 1", $id_objetivo);
											$tendencia = (isset($tendencia_user[0]['tendencia_venta']) ? $tendencia_user[0]['tendencia_venta'] : '');
										}
										elseif($tipo_informe == "tiendas" || $tipo_informe == "tiendas_global"){
											$texto_usuario = (isset($ranking[$i]) ? $ranking[$i]['nombre_tienda'].'<br /><em class="text-muted">'.$ranking[$i]['provincia_tienda'].' - '.$ranking[$i]['territorial_tienda'].'</em>' : "");

											if ($ranking[$i]['empresa'] == $_SESSION['user_empresa']) {
												$posicion = ($i +1);
												$total_user = (isset($ranking[$i]) ? round($ranking[$i]['suma'], 2) : 0);
											}
										}
										else{
											//$texto_usuario = (isset($ranking[$i]) ? $ranking[$i]['username_venta'] : "");
											$texto_usuario = "";
										}

										$tendencia = ($tendencia == 'SUBE' ? ' <i title="SUBE" class="fa fa-long-arrow-up fa-2x text-success"></i>' : $tendencia);
										$tendencia = ($tendencia == 'BAJA' ? ' <i title="BAJA" class="fa fa-long-arrow-down fa-2x text-danger"></i>' : $tendencia);
										$tendencia = ($tendencia == 'IGUAL' ? ' <i title="IGUAL" class="fa fa-exchange fa-2x text-warning"></i>' : $tendencia);
										
										if ($mostrar_fila == true):
										?>
										<tr>
											<td width="60px"><center><big><span class="badge font-white"><?php echo $i+1;?></span></big></center></td>
											<?php if ($tipo_objetivo == 'Usuario' && $tipo_informe == "usuarios"):?>
											<td width="40px"><img style="width:40px" src="<?php echo usersController::getUserFoto($ranking[$i]['foto']);?>" /></td>
											<?php endif;?>
											<td><?php echo $texto_usuario;?></td>
											<td class="text-center">
												<strong>
													<?php echo (isset($ranking[$i]) ? round($ranking[$i]['suma'], 2) : 0); ?>
												</strong>
											</td>
											<td class="text-center"><?php echo $tendencia;?></td>
										</tr>
										<?php endif;?>
									<?php } 
									else break; ?>
								<?php } ?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endif;?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-pie-chart fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Incentives");?>
			</h4>
			<p><?php e_strTranslate("Incentives_ranking_text");?></p>

			<div class=" col-md-6 col-md-offset-3 incentivos-ranking-user2">
				<!-- <div class="text-center incentivos-ranking-user2-title"><?php //echo $usuario['nick'];?></div> -->
				<div class="incentivos-ranking-user2-div">
					<img src="<?php echo usersController::getUserFoto($usuario['foto']);?>" />
				</div>
			</div>

			<?php if($posicion > 0): ?>
			<div class="clearfix"></div><br /><h3 class="text-center"><span class="label label-danger">Tu posición: <big><strong class="incentivos-ranking-user2-puntos"><?php echo $posicion;?></strong></big></span></h3>
			<h3 class="text-center"><span class="label label-danger">Puntos: <big><strong class="incentivos-ranking-user2-puntos"><?php echo $total_user;?></strong></big></span></h3>
			<?php endif; ?>
		</div>
	</div>
</div>