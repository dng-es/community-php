<?php
/**
 * Imprime el panel de la agenda
 * @return 	string       		HTML panel
 */
function panelAgenda(){
	$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal LIKE '%".$_SESSION['user_canal']."%' " : "");
	$filter = $filtro_canal." AND activo=1 AND tipo=1 AND (NOW() BETWEEN date_ini AND date_fin)";
	$elements = agendaController::getListAction(100, $filter);
	$elements = $elements['items'];
	$i = 0;?>
	<div class="col-md-12 panel-sidebar">
		<h4>
			<span class="fa-stack fa-sx">
				<i class="fa fa-circle fa-stack-2x"></i>
				<i class="fa fa-newspaper-o fa-stack-1x fa-inverse"></i>
			</span>
			<?php e_strTranslate("Diary");?>
		</h4>
		<?php if (count($elements) > 0):?>
			<?php if (count($elements) == 1):?>
				<a href="agenda">
					<img style="width: 100%" src="images/banners/<?php echo $elements[0]['banner'];?>" alt="<?php echo $elements[0]['titulo'];?>" />
					<br />
					<p class="text-white" style="margin-left:15px; margin-right:15px"><?php echo get_resume($elements[0]['descripcion']);?></p>
				</a>
			<?php else: ?>
				<div id="carousel-agenda" class="carousel slide" data-ride="carousel">
				  <!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<?php foreach($elements as $element):?>
							<div class="item <?php echo ($element === reset($elements) ? 'active' : '');?>">
								<a href="agenda">
									<img style="width: 100%" src="images/banners/<?php echo $element['banner'];?>" alt="<?php echo $element['titulo'];?>" />
									<br />
									<p class="text-white" style="margin-left:15px; margin-right:15px"><?php echo get_resume($element['descripcion']);?></p>
								</a>
							</div>
						<?php endforeach;?>
					</div>
					<!-- Controls -->
					<a class="left carousel-control" href="#carousel-agenda" role="button" data-slide="prev">
						<span class="control-icon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#carousel-agenda" role="button" data-slide="next">
						<span class="control-icon glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
		<?php endif;
	endif;?>
</div>
<?php } ?>