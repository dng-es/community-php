<?php
incentivosController::exportUserReportAction();

addJavascripts(array("js/libs/highcharts/highcharts.js",
					 "js/libs/highcharts/modules/exporting.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"incentives-targets"),
			array("ItemLabel"=>strTranslate("Incentives_my_targets"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		$referencia_acelerador = intval(isset($_REQUEST['ref']) ? $_REQUEST['ref'] : 0);
		$filtro_perfil = incentivosObjetivosController::getFiltroPerfil($_SESSION['user_perfil']);
		$filtro_canal = (($_SESSION['user_canal'] == 'admin') ? "" : " AND canal_objetivo LIKE '%".$_SESSION['user_canal']."%' ");
		$filtro_tienda = incentivosObjetivosController::getFiltroTienda($_SESSION['user_perfil'], $_SESSION['user_name'], $_SESSION['user_empresa']);
		$elements = incentivosObjetivosController::getListAction(35, $filtro_canal.$filtro_perfil." AND NOW() BETWEEN date_ini_objetivo AND date_fin_objetivo ORDER BY id_objetivo ASC");
		$incentivos = new incentivos();
		?>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<?php foreach($elements['items'] as $element):
				//comprobar que el objetivo es para el usuario o para la tienda del usuario
				$filtro_usuario = ($element['tipo_objetivo'] == 'Usuario' ? "='".$_SESSION['user_name']."'": ($_SESSION['user_perfil'] == 'regional' ? " IN (SELECT cod_tienda FROM users_tiendas WHERE regional_tienda='".$_SESSION['user_name']."')" : "='".$_SESSION['user_empresa']."'"));
				$filtro_objetivo = ($element['tipo_objetivo'] == 'Usuario' ? "='".$_SESSION['user_name']."'": " IN (SELECT username FROM users WHERE empresa='".$_SESSION['user_empresa']."') ");
				//$objetivos = $incentivos->getIncentivesObjetivosDetalle(" AND id_objetivo=".$element['id_objetivo']." AND destino_objetivo".$filtro_usuario." ");
				//$objetivos = $incentivos->getIncentivesObjetivosDetalle(" AND id_objetivo=".$element['id_objetivo']." ORDER BY nombre_producto");
				$objetivos = array();
				?>
				<div class="panel panel-default">
					<div class="panel-body">
						<h3><b>
							<?php echo $element['nombre_objetivo'];?>
							<?php
							//se muestra el ranking solo si el objetivo lo permite
							if ($element['ranking_objetivo'] == 1): ?>
								<small><a href="incentives-rankings?id=<?php echo $element['id_objetivo'];?>"><?php e_strTranslate("View_ranking");?> <i class="fa fa-angle-double-right"></i></a></small>
							<?php endif;?>
						</b></h3>
						<div class="row">
							<div class="col-md-12">
								<p>
									<!-- Tipo de objetivo: <?php //echo $element['tipo_objetivo'];?><br /> -->
									<?php e_strTranslate("Date_start");?>: <?php echo getDateFormat( $element['date_ini_objetivo'], 'SHORT');?> -
									<?php e_strTranslate("Date_end");?>: <?php echo getDateFormat( $element['date_fin_objetivo'], 'SHORT');?>
									<!-- <a href="incentives-targets?export=ventas&tipo=<?php //echo $element['tipo_objetivo'];?>&id=<?php //echo $element['id_objetivo'];?>">descargar ventas <i class="fa fa-angle-double-right"></i></a> -->
									<a href="incentives-targets?export=ventas&tipo=<?php echo $element['tipo_objetivo'];?>&id=<?php echo $element['id_objetivo'];?>"><?php e_strTranslate("Download");?> <i class="fa fa-angle-double-right"></i></a>
								</p>
								<?php 
								$posicion_user = $incentivos->getPosicionRankingUser($filtro_tienda, $_SESSION['user_name'], $element['id_objetivo']);
								$posicion = (isset($posicion_user[0]['rownum']) ? $posicion_user[0]['rownum'] : " - ");
								
								$tendencia_user = $incentivos->getVentasTendenciaUser(" AND username_venta='".$_SESSION['user_name']."' ORDER BY fecha_venta DESC LIMIT 1", $element['id_objetivo']);
								$tendencia = (isset($tendencia_user[0]['tendencia_venta']) ? $tendencia_user[0]['tendencia_venta'] : ' - ');

								$total_user = (isset($posicion_user[0]) ? $posicion_user[0]['suma'] : 0);

								$color = 'muted';
								$color = ($tendencia == 'SUBE' ? 'success' : $color);
								$color = ($tendencia == 'BAJA' ? 'danger' : $color);
								$color = ($tendencia == 'IGUAL' ? 'warning' : $color);
								?>
	
								<table class="table table-condensed">
									<tr>
										<td class="<?php echo $color;?>">&nbsp;</td><td><small class="text-muted">Posición: <big><b><?php echo $posicion;?></b></big></small></td>
										<td class="<?php echo $color;?>">&nbsp;</td><td><small class="text-muted">Tendencia: <big><b><?php echo $tendencia;?></b></big></small></td>
										<td class="<?php echo $color;?>">&nbsp;</td><td><small class="text-muted">Puntos: <big><b><?php echo $total_user;?></b></big></small></td>
									</tr>
								</table>
								<?php
								if (count($objetivos) > 0):
									$total_puntos_user = 0;
									?>
									<!-- <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapse<?php //echo $element['id_objetivo'];?>" aria-expanded="false" aria-controls="collapseExample">ver detalle</a> -->
									<div class="table-responsive collapse" id="collapse<?php echo $element['id_objetivo'];?>">
										<br />
										<table class="table">
											<tr>
												<th><?php e_strTranslate("Incentives_product");?></th>
												<th><center>Pedidos</center></th>
												<th><center><?php echo ucfirst(strTranslate("APP_Credits"));?></center></th>
											</tr>
										<?php foreach($objetivos as $objetivo):?>
											<?php
											$total_ventas = connection::sumReg("incentives_ventas", "cantidad_venta", " AND id_producto=".$objetivo['id_producto']." AND fecha_venta BETWEEN '".$element['date_ini_objetivo']."' AND '".$element['date_fin_objetivo']."' AND username_venta".$filtro_objetivo." ");
											$total_puntos = connection::sumReg("incentives_ventas_puntos", "puntuacion_venta", " AND id_producto_venta=".$objetivo['id_producto']." AND date_venta BETWEEN '".$element['date_ini_objetivo']."' AND '".$element['date_fin_objetivo']."' AND username_puntuacion".$filtro_objetivo." ");

											$total_puntos_user += $total_puntos;
											if ($total_ventas > 0):
											?>
											<tr>
												<td>
													<?php echo $objetivo['nombre_producto'];?><br />
													<em class="text-muted"><small><?php echo $objetivo['nombre_fabricante'];?></small></em>
												</td>
												<td width="120px"><center><?php echo $total_ventas;?></center></td>
												<td width="120px"><center><?php echo $total_puntos;?></center></td>
											</tr>
											<?php endif;?>
										<?php endforeach;?>
										</table>
									</div>
									<?php if($total_puntos_user > 0):?>
									<p>Total <?php e_strTranslate("APP_Credits");?> conseguidos: <?php echo $total_puntos_user;?></p>
									<?php endif; ?>
								<?php else: ?>
									<!-- <div class="text-warning"><i class="fa fa-warning"></i> No tienes objetivos fijados</div> -->
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior hidden-xs hidden-sm">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-pie-chart fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Incentives");?>
			</h4>
			<p><?php e_strTranslate("Incentives_text");?></p>
		</div>
	</div>
</div>