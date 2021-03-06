<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=> strTranslate("Na_areas"), "ItemClass"=>"active"),
		));
		
		session::getFlashMessage( 'actions_message' );
		na_areasController::apuntarseAction();
		$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND area_canal LIKE '%".$_SESSION['user_canal']."%' " : "");
		$filtro_acceso = ($_SESSION['user_canal'] == 'admin' ? "" : " AND (id_area IN (SELECT id_area FROM na_areas_users WHERE username_area='".$_SESSION['user_name']."') OR registro=1) ");
		$elements = na_areasController::getListAction(6, $filtro_canal.$filtro_acceso." AND estado=1 ");
		$i = 0;
		foreach($elements['items'] as $element):
			$acceso = ( $_SESSION['user_canal'] == 'admin' ? 1 : connection::countReg("na_areas_users"," AND id_area=".$element['id_area']." AND username_area='".$_SESSION['user_name']."' "));?>
		
			<?php if ($i == 0) echo '<div class="row">';?>
			<div class="col-md-6">
				<div class="col-md-12 nopadding full-height">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title ellipsis"><?php echo $element['area_nombre'];?></h3>
						</div>
						<div class="panel-body">
							<p class="ellipsis"><?php echo $element['area_descripcion'];?></p>
							<?php if ($acceso == 1): 
								echo '<a href="areas_det?id='.$element['id_area'].'" class="btn btn-primary btn-xs pull-right"><i class="fa fa-share"></i> '.strTranslate("Access_course").'</a>';
							else:
								if ($element['registro'] == 1){
									// verificar que no se haya elcanzado el límite de usuarios
									$total_users = connection::countReg("na_areas_users"," AND id_area=".$element['id_area']." ");
									if ($total_users < $element['limite_users']):
										echo '<a href="areas?id='.$element['id_area'].'" class="btn btn-primary btn-xs pull-right"><i class="fa fa-pencil"></i> '.strTranslate("Enroll_course").'</a>';
									else:
										echo '<span class="btn btn-default btn-xs pull-right"><i class="fa fa-times"></i> '.strTranslate("Registration_closed").'</span>';
									endif;
								}
							endif;?>
							<br />
						</div>
					</div>
				</div>
			</div>
			<?php if ($i == 1){
				echo '</div>';
				$i = 0;
			}
			else $i++;?>

		<?php endforeach;?>
		<?php if ($i == 1) echo '</div>';?>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
		<br />
	</div>
	<div class="app-sidebar hidden-sm hidden-xs">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-bookmark fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Na_areas");?>
			</h4>
			<p><?php e_strTranslate("Registration_text");?></p>
			<p class="text-center"><i class="fa fa-mortar-board fa-big"></i></p>
		</div>
	</div>
</div>