<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

function ini_page_header ($ini_conf) { ?>
<?php }
function ini_page_body ($ini_conf){ ?>

	<div id="page-info">Cursos de formación</div>
	<div class="row inset row-top">
			<div class="col-md-12">
				<?php PanelCentral();?>
			</div>
	</div>
<?php 
}

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////


function PanelCentral(){
	
	session::getFlashMessage( 'actions_message' );
	
	//apuntarse al curso
	if (isset($_REQUEST['id']) and $_REQUEST['id']!=""){
		$id_area = $_REQUEST['id'];
		$na_areas = new na_areas();
		//verificar si ya se ha alcanzado el limite de usuarios
		$datos_area = $na_areas->getAreas(" AND id_area=".$id_area." ");
		$limite_users = $datos_area[0]['limite_users'];
		$total_users = connection::countReg("na_areas_users"," AND id_area=".$id_area." ");
		if ($total_users<$limite_users):	
			if ($na_areas->insertUserArea($id_area,$_SESSION['user_name']))
				session::setFlashMessage( 'actions_message', "Inscrito correctamente en el curso.", "alert alert-success");  
			else
				session::setFlashMessage( 'actions_message', "Se ha producido un error al apuntarte al curso. Por favor, inténtalo más tarde.", "alert alert-danger");
		else:
			session::setFlashMessage( 'actions_message', "Ya se ha alcanzo el límite de usuarios para este curso.", "alert alert-danger");
		endif;
		redirectURL("?page=areas");   
	}

	echo '<p>Estos son los cursos que puedes realizar:</p>';
	$na_areas = new na_areas();
	$elements=$na_areas->getAreas(" AND estado=1 ORDER BY id_area DESC ");
	$columna = 1;
	foreach($elements as $element):
		$acceso = $na_areas->countReg("na_areas_users"," AND id_area=".$element['id_area']." AND username_area='".$_SESSION['user_name']."' ");

		if ($columna ==1){echo '<div class="row">';}
		echo '<div class="col-md-6">';
		echo '<div class="panel panel-default panel-comunidad col-panel panel-areas">
						<div class="panel-body">
						<h4>'.$element['area_nombre'].'</h4>';
		echo '<p>'.$element['area_descripcion'].'</p>';
		if ($acceso == 1){
			echo '<a href="?page=areas_det&id='.$element['id_area'].'" class="btn btn-default pull-right">Accede al curso</a>';
		}
		else{
			// verificar que no se haya elcanzado el límite de usuarios
			$limite_users = $element['limite_users'];
			$total_users = connection::countReg("na_areas_users"," AND id_area=".$element['id_area']." ");
			if ($total_users<$limite_users):
				echo '<a href="?page=areas&id='.$element['id_area'].'" class="btn btn-primary pull-right">Inscribirse al curso</a>';
			else:
				echo '<span class="btn btn-default pull-right">Inscripción cerrada</span>';
			endif;
		}

		echo '<br />';
		echo '</div>';
		echo '</div>';
		echo "</div>";

		if ($columna == 2){echo '</div>';$columna=0;}
		$columna++;    
	endforeach;
	if ($columna == 1){echo '</div>';}
}
?>