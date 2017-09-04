<?php
templateload("showbatallas", "batallas");
templateload("paginator", "batallas");
templateload("tipuser", "users");

addJavascripts(array("js/jquery.numeric.js", getAsset("batallas")."js/batallas.js"));

$usuario = usersController::getPerfilAction($_SESSION['user_name']);
$module_config = getModuleConfig("batallas");
$puntos_batalla = $module_config['options']['battle_points'];

$puntos_reservados = connection::sumReg("batallas", "puntos", " AND finalizada=0 AND (user_create='".$_SESSION['user_name']."' or user_retado='".$_SESSION['user_name']."') ");
$puntos_disponibles = $usuario['puntos'] - $puntos_reservados;

//resultados de las batallas
$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_batalla='".$_SESSION['user_canal']."' " : "");
$filtro =  $filtro_canal." AND finalizada=1 AND ganador='".$_SESSION['user_name']."' ";
$ganadas_total_reg = connection::countReg("batallas", $filtro);

$filtro =  $filtro_canal." AND finalizada=1 AND ganador<>'' AND ganador<>'".$_SESSION['user_name']."' AND (user_create='".$_SESSION['user_name']."' OR user_retado='".$_SESSION['user_name']."') ";
$perdidas_total_reg = connection::countReg("batallas",$filtro);

$filtro =  $filtro_canal." AND finalizada=0 AND user_retado='".$_SESSION['user_name']."' AND id_batalla NOT IN ( SELECT id_batalla FROM batallas_luchas WHERE user_lucha='".$_SESSION['user_name']."' ) ";
$pendientes_usuario_total_reg = connection::countReg("batallas", $filtro);

$filtro =  $filtro_canal." AND finalizada=0 AND user_create='".$_SESSION['user_name']."' AND id_batalla NOT IN ( SELECT id_batalla FROM batallas_luchas WHERE user_lucha<>'".$_SESSION['user_name']."' )";
$pendientes_contrincario_total_reg = connection::countReg("batallas", $filtro);
?>
<!-- Modal Batallas-->
<div class="modal modal-wide fade" id="BatallaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Nueva batalla</h4>
			</div>
			<div class="modal-body">
			preguntas
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Battles"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' );
		batallasController::responderBatallaAction();
		batallasController::responderContrincarioBatallaAction();
		?>
		<div class="tab-container">
			<ul class="nav nav-tabs">
				<li <?php echo ((!isset($_GET['f']) || ($_GET['f'] != 2 && $_GET['f'] != 3 && $_GET['f'] != 4)) ? ' class="active"' : '');?>><a href="#ganadas" data-toggle="tab">Ganadas (<?php echo $ganadas_total_reg;?>)</a></li>
				<li <?php echo ((isset($_GET['f']) && $_GET['f'] == 2) ? ' class="active"' : '');?>><a href="#perdidas" data-toggle="tab">Perdidas (<?php echo $perdidas_total_reg;?>)</a></li>
				<li <?php echo ((isset($_GET['f']) && $_GET['f'] == 3) ? ' class="active"' : '');?>><a href="#pendientes" data-toggle="tab">Pendientes (<?php echo $pendientes_usuario_total_reg;?>)</a></li>
				<li <?php echo ((isset($_GET['f']) && $_GET['f'] == 4) ? ' class="active"' : '');?>><a href="#pendientes_contrincario" data-toggle="tab">Pendientes jugador (<?php echo $pendientes_contrincario_total_reg;?>)</a></li>
			</ul>

			<div class="tab-content">
				<div class="inset tab-pane fade <?php echo ((!isset($_GET['f']) || ($_GET['f'] != 2 && $_GET['f'] != 3 && $_GET['f'] != 4)) ? ' in active' : '');?>" id="ganadas">
					<?php showBatallas("ganadas", $ganadas_total_reg, $usuario);?>
				</div>

				<div class="inset tab-pane fade <?php echo ((isset($_GET['f']) && $_GET['f'] == 2) ? ' in active' : '');?>" id="perdidas">
					<?php showBatallas("perdidas", $perdidas_total_reg, $usuario);?>
				</div>
				<div class="inset tab-pane fade <?php echo ((isset($_GET['f']) && $_GET['f'] == 3) ? ' in active' : '');?>" id="pendientes">
					<?php showBatallas("pendientes usuario", $pendientes_usuario_total_reg, $usuario);?>
				</div>

				<div class="inset tab-pane fade <?php echo ((isset($_GET['f']) && $_GET['f'] == 4) ? ' in active' : '');?>" id="pendientes_contrincario">
					<?php showBatallas("pendientes contrincario", $pendientes_contrincario_total_reg, $usuario);?>
				</div>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-bomb fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Battles");?>
			</h4>
			<p>
				Reta a otros jugadores a una batalla.
				En cada batalla te juegas <big><span class="text-primary"><?php echo $puntos_batalla;?></span></big> <?php e_strTranslate("APP_points");?>.
				Cuando retes a otro jugador los <?php e_strTranslate("APP_points");?> quedarán pendientes hasta que se acepte tu reto.
			</p>

			<?php if($_SESSION['user_canal'] != '' && $_SESSION['user_canal'] != 'admin'):?>
			<form action="" method="post" name="form-batalla" id="form-batalla">
			<?php if($module_config['options']['choose_battle_category'] == false):?>
				<input type="hidden" name="batalla-categoria" id="batalla-categoria" value="" />
			<!--
				<div class="form-group">
					<label for="batalla-contrincario"><i class="fa fa-user"></i> Contrincante - 
					<span>Seleccionalo introduciendo su nick</span></label>
					<input type="text" name="batalla-contrincario" id="batalla-contrincario" class="form-control" />
				</div>
					<div class="form-group">
					<label for="batalla-puntos"><i class="fa fa-calendar-o"></i> Puntos - 
					<span>Introduce los puntos a jugar</span></label>
					<input type="text" name="batalla-puntos" id="batalla-puntos" class="form-control" />
				</div> -->

			<?php else:
			$batallas = new batallas();
			$module_channels = getModuleChannels($module_config['channels'], $_SESSION['user_canal']);
			$filtro_canal_categorias = " AND (canal_pregunta IN (".$module_channels.") OR canal_pregunta='') ";
			$categorias = $batallas->getBatallaCategorias($filtro_canal_categorias." AND activa=1 GROUP BY pregunta_tipo HAVING COUNT(pregunta_tipo)>=3 ORDER BY categoria ASC");
			?>
				<div class="form-group">
					<label for="batalla-categoria"><?php echo ucfirst(strTranslate("choose_battle_category"));?></label>
					<select name="batalla-categoria" id="batalla-categoria" class="form-control">
						<option value="">--- Cualquier categoria ---</option>
						<?php foreach($categorias as $categoria): ?>
							<option value="<?php echo $categoria['categoria'];?>"><?php echo $categoria['categoria'];?></option>
						<?php endforeach;?>
					</select>
				</div>
			<?php endif?>
				<br />
				<div class="alert alert-danger" id="alertas-batalla" style="display: none"><?php e_strTranslate("Required_all_fields");?></div>
				<input class="btn btn-primary btn-block" type="submit" name="batalla-btn" id="batalla-btn" value="<?php e_strTranslate("Start_battle");?>" />
				<div id="cargando" style="display:none; margin-top:0px; top: 0; position: relative"><i class="fa fa-spinner fa-spin ajax-load" style="margin-top:15px"></i></div>
			</form>
			<?php else:?>
			<p class="alert alert-warning">Selecciona un canal para crear batallas</p>
			<?php endif;?>
		</div>
	</div>
</div>