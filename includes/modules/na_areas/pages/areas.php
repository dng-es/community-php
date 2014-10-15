<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<h1>Cursos de formación</h1>
		<?php 
		session::getFlashMessage( 'actions_message' );
		na_areasController::apuntarseAction();
		$elements = na_areasController::getListAction(6, $filter=" AND estado=1 ORDER BY id_area DESC ");
		$i = 0;
		foreach($elements['items'] as $element):
			$acceso = connection::countReg("na_areas_users"," AND id_area=".$element['id_area']." AND username_area='".$_SESSION['user_name']."' "); ?>
		
			<?php if ($acceso==1 or $element['registro']==1) : ?>
				<?php if ($i==0) echo '<div class="row">';?>
				<div class="col-md-6">
					<div class="col-md-12 section">
						<section>

							
							<?php if ($acceso == 1): 
								echo '<a href="?page=areas_det&id='.$element['id_area'].'" class="btn btn-default btn-xs" style="position: absolute; right:-5px; top:10px;"><i class="fa fa-share"></i> Accede al curso</a>';
							else:
								if ($element['registro']==1){
									// verificar que no se haya elcanzado el límite de usuarios
									$total_users = connection::countReg("na_areas_users"," AND id_area=".$element['id_area']." ");
									if ($total_users < $element['limite_users']):
										echo '<a href="?page=areas&id='.$element['id_area'].'" class="btn btn-default btn-xs" style="position: absolute; right:-5px; top:10px;"><i class="fa fa-pencil"></i> Inscribirse en el curso</a>';
									else:
										echo '<span class="btn btn-default btn-xs" style="position: absolute; right:-5px; top:10px;"><i class="fa fa-times"></i> Inscripción cerrada</span>';
									endif;
								}
							endif; ?>
							<br />
							<h4 class="ellipsis"><?php echo $element['area_nombre'];?></h4>
							<p><?php echo $element['area_descripcion'];?></p>
						</section>
					</div>
				</div>
				<?php if ($i==1) {
					echo '</div><br />';
					$i = 0;
				}
				else $i++; ?>
			<?php endif; ?>
		<?php endforeach;?>
		<?php if ($i==1) echo '</div>'; ?>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
		<br />
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h4>Cursos de formación</h4>
			<p>Estos son los cursos que puedes realizar. Inscríbite en el curso que más te interese.</p>
		</div>
	</div>
</div>