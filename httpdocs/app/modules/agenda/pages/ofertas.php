<?php templateload("tags","agenda");?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=> "Biblioteca Deslumbras", "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal LIKE '%".$_SESSION['user_canal']."%' " : "");
		$elements = agendaController::getListAction(4, $filtro_canal." AND tipo=2 AND activo=1  ORDER BY date_ini DESC,id_agenda DESC ");

		foreach($elements['items'] as $element): ?>
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12 nopadding full-height">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="col-md-3">
								<?php if ($element['banner']<>''){
									echo '<p><img src="images/banners/'.$element['banner'].'" width="100%" alt="'.$element['titulo'].'" ></p>';
								 }?>
							</div>
							<div class="col-md-9">
								<h3><b><?php echo $element['titulo'];?></b></h3>
								<?php if (!is_null($element['date_ini']) && !is_null($element['date_fin'])){
									echo '<small class="text-muted">'.ucfirst(getDateFormat($element['date_ini'], 'LONG')).' al '.getDateFormat($element['date_fin'], 'LONG').'</small>';
								}?>
								<?php showTags($element['etiquetas']);?>
								<p><?php echo $element['descripcion'];?></p>
								<?php if ($element['archivo'] <> ''):?>
									<br><a target="_blank" href="docs/showfile.php?file=<?php echo $element['archivo'];?>"><b><u>Descargar Voucher</u></b></a>
								<?php endif;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach;?>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
		<br />
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<div class="tags">
				<h4>
					<span class="fa-stack fa-sx">
						<span class="fa fa-circle fa-stack-2x"></span>
						<span class="fa fa-tags fa-stack-1x fa-inverse"></span>
					</span>
					<?php e_strTranslate("Tags");?>
				</h4>
				<?php
				$agenda = new agenda();
				$tags = $agenda->getTags(" AND tipo=2 ");
				$diferencia = max($tags) - min($tags);
				$diferencia = ($diferencia != 0 ? $diferencia : 1);
				ksort($tags);
				foreach(array_keys($tags) as $key){
					if ($diferencia > 0) $valor_relativo = round((($tags[$key] - min($tags)) / $diferencia) * 10);
					else $valor_relativo = 1;
					echo '<a href="ofertas?f='.$key.'" class="tag'.$valor_relativo.'">'.$key.'</a> ';
				}?>
			</div>
		</div>
	</div>
</div>