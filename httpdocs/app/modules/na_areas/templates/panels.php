<?php
/**
 * Print HTML Areas panel. Used in home page
 * @return	String						HTML panel
 */
function panelAreas(){
	$na_areas = new na_areas();
	$elements = $na_areas->getAreas(" AND estado=1 ");
	$i = 0; ?>
	<div class="col-md-12 section panel">
		<h3><?php e_strTranslate("Na_areas");?></h3>
		<ul class="list-funny">
		<?php foreach($elements as $element):
			$acceso = connection::countReg("na_areas_users", " AND id_area=".$element['id_area']." AND username_area='".$_SESSION['user_name']."' ");
			if (($acceso == 1 || ($_SESSION['user_canal'] == 'admin')) && $i < 3){
				echo '<li class="ellipsis"><a href="areas_det?id='.$element['id_area'].'">'.$element['area_nombre'].': '.ShortText($element['area_descripcion'],50).'</a></li>';
				$i++;
			}
		endforeach; ?>
		</ul>
		<?php if($i == 0): ?>
			<p><?php e_strTranslate("No_enrollments_yet");?></p>
		<?php endif; ?>

		<div class="ver-mas">
			<a href="areas"><span class="fa fa-search"></span> <?php e_strTranslate("More_contents");?></a>
		</div>
	</div>
<?php } ?>