<?php
templateload("player", "videos");

function panelNovedades(){
	$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND n.canal LIKE '%".$_SESSION['user_canal']."%' " : "");
	$filtro_perfil = ($_SESSION['user_perfil'] != 'admin' ? " AND (n.perfil='".$_SESSION['user_perfil']."' OR n.perfil='') " : "");
	$filter = $filtro_canal.$filtro_perfil." AND activo=1 AND tipo='slider' ORDER BY orden ASC ";
	$elements = novedadesController::getListAction(100, $filter);

	$i = 0;
	if (count($elements['items']) > 0): ?>
		<?php if (count($elements['items']) == 1): ?>
			<div class="section panel">
				<?php echo $elements['items'][0]['cuerpo'];?>
			</div>
		<?php else: ?>
		<div class="section panel">
			<div id="carousel-novedades" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<?php foreach($elements['items'] as $element): ?>
						<li data-target="#carousel-novedades" data-slide-to="<?php echo $i;?>" <?php echo ($i == 0 ? ' class="active" ' : '');?>></li>
						<?php 
						$i++;
					endforeach;?>
				</ol>
				<!-- Wrapper for slides -->

				<div class="carousel-inner" role="listbox">
					<?php foreach($elements['items'] as $element): ?>
						<div class="item <?php echo ($element === reset($elements['items']) ? 'active' : '');?>">
							<?php echo $element['cuerpo'];?>
						</div>
					<?php endforeach;?>
				</div>

				<!-- Controls -->
				<a class="left carousel-control" href="#carousel-novedades" role="button" data-slide="prev">
					<span class="control-icon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#carousel-novedades" role="button" data-slide="next">
					<span class="control-icon glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	<?php endif;
	endif;
}

function panelNovedadesBanner(){
	$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND n.canal LIKE '%".$_SESSION['user_canal']."%' " : "");
	$filtro_perfil = ($_SESSION['user_perfil'] != 'admin' ? " AND (n.perfil='".$_SESSION['user_perfil']."' OR n.perfil='') " : "");
	$filter = $filtro_canal.$filtro_perfil." AND activo=1 AND tipo='banner' ORDER BY orden ASC ";
	$elements = novedadesController::getListAction(100, $filter);
	
	$i = 0;
	if (count($elements['items']) > 0):?>
		<?php if (count($elements['items']) == 1): ?>
			<div class="panel">
				<?php echo $elements['items'][0]['cuerpo'];?>
			</div>
		<?php else: ?>
		<div class="col-md-12 nopadding panel">
			<div id="carousel-novedades-banner" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<?php foreach($elements['items'] as $element): ?>
						<li data-target="#carousel-novedades-banner" data-slide-to="<?php echo $i;?>" <?php echo ($i == 0 ? ' class="active" ' : '');?>></li>
						<?php 
						$i++;
					endforeach;?>
				</ol>
				<!-- Wrapper for slides -->

				<div class="carousel-inner" role="listbox">
					<?php foreach($elements['items'] as $element):?>
						<div class="item <?php echo ($element === reset($elements['items']) ? 'active' : '');?>">
							<?php echo $element['cuerpo'];?>
						</div>
					<?php endforeach;?>
				</div>

				<!-- Controls -->
				<a class="left carousel-control" href="#carousel-novedades-banner" role="button" data-slide="prev">
					<span class="control-icon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#carousel-novedades-banner" role="button" data-slide="next">
					<span class="control-icon glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	<?php endif;
	endif;
}

function popupNovedades(){
	$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND n.canal LIKE '%".$_SESSION['user_canal']."%' " : "");
	$filtro_perfil = ($_SESSION['user_perfil'] != 'admin' ? " AND (n.perfil='".$_SESSION['user_perfil']."' OR n.perfil='') " : "");
	$filter = $filtro_canal.$filtro_perfil." AND activo=1 AND tipo='popup' ORDER BY orden ASC ";
	$elements = novedadesController::getListAction(1, $filter);

	if ((count($elements['items']) > 0) && (!isset($_SESSION['modal_home']) or $_SESSION['modal_home'] != 1)): ?>
        <!-- Modal Derechos y responsabilidades (declaración)-->
		<div class="modal modal-wide fade" id="modalNovedades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><?php echo $elements['items'][0]['titulo'];?></h4>
					</div>
					<div class="modal-body">
						<?php echo $elements['items'][0]['cuerpo'];?>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<?php 
						
		$_SESSION['modal_home'] = 1;
	endif; 
}
?>