<?php
function panelAreas(){
	$na_areas = new na_areas();
	$elements = $na_areas->getAreas(" AND estado=1 ");
	$i = 0; ?>

	<h3><?php e_strTranslate("Na_areas");?></h3>
	<ul class="list-funny">
	<?php foreach($elements as $element):
		$acceso = connection::countReg("na_areas_users"," AND id_area=".$element['id_area']." AND username_area='".$_SESSION['user_name']."' ");
		if (($acceso == 1 or ($_SESSION['user_canal'] == 'admin')) and $i < 3){
			echo '<li><a href="areas_det?id='.$element['id_area'].'">'.$element['area_nombre'].': '.ShortText($element['area_descripcion'],50).'</a></li>';
			$i++;
		}
	endforeach;?>
	</ul>
	<?php if($i == 0):?>
		<p><?php e_strTranslate("No_enrollments_yet");?></p>
	<?php endif;?>

	<div class="ver-mas">
		<a href="areas"><span class="fa fa-search"></span> <?php e_strTranslate("More_contents");?></a>
	</div>

<?php } ?>