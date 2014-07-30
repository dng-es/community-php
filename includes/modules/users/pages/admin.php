<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=1;
function ini_page_header ($ini_conf) {?>


<?php }
function ini_page_body ($ini_conf){
  //CONTROL NIVEL DE ACCESO
  $perfiles_autorizados = array("admin");
  session::AccessLevel($perfiles_autorizados);
    
  echo '<div id="page-info">Administración de la comunidad</div>';
  echo '<div class="row inset">
  		<div class="col-md-12"><h3>Gestión de contenidos</h3></div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-file"></i> Documentación a PDF</a></div>
				<div class="panel-body">';
echo '			<p><a href="?page=admin-infotopdf-doc&act=new" class="comunidad-color">Nuevo documento.</a></p>';
echo '			<p><a href="?page=admin-infotopdf" class="comunidad-color">Listado de documentos.</a></p>';
echo '		</div>
			</div>	
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-file"></i> Documentación</a></div>
				<div class="panel-body">';
echo '			<p><a href="?page=admin-info-doc&act=new" class="comunidad-color">Nuevo documento.</a></p>';
echo '			<p><a href="?page=admin-info" class="comunidad-color">Listado de documentos.</a></p>';
echo '		</div>
			</div>	
		</div>';

// echo '<div class="col-md-4">
// 			<div class="panel panel-default">
// 				<div class="panel-heading"><i class="fa fa-bookmark"></i> Cursos de formación</a></div>
// 				<div class="panel-body">';
// echo '			<p><a href="?page=admin-area&act=new" class="comunidad-color">Nuevo curso.</a></p>';
// echo '			<p><a href="?page=admin-areas" class="comunidad-color">Listado de cursos.</a></p>';
// echo '		</div>
// 			</div>
// 		</div>';

echo '	<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-envelope"></i> Envío de comunicaciones</a></div>
				<div class="panel-body">';
//echo '			<p><a href="?page=admin-message&act=new" class="comunidad-color">Nueva comunicación.</a></p>';
echo '			<p><a href="?page=admin-messages" class="comunidad-color">Comunicaciones enviadas.</a></p>';
echo '			<p><a href="?page=admin-templates" class="comunidad-color">Plantillas de comunicaciones.</a></p>';
echo '			</div>
			</div>
		</div>';
		
echo '<div class="row inset">';
// echo '	<div class="col-md-4">
// 			<div class="panel panel-default">
// 				<div class="panel-heading"><i class="fa fa-shopping-cart"></i> Mystery Shoping</a></div>
// 				<div class="panel-body">';
// echo '			<p><a href="?page=admin-mystery" class="comunidad-color">Gestión del Mystery Shoping.</a></p>';
// echo '			</div>
// 			</div>
// 		</div>';
// 		
echo '	<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-table"></i> Campañas</a></div>
				<div class="panel-body">';
echo '			<p><a href="?page=admin-campaign&act=new" class="comunidad-color">Nueva campaña.</a></p>';
echo '			<p><a href="?page=admin-campaigns" class="comunidad-color">Listado de campañas.</a></p>';
echo '			<p><a href="?page=admin-campaigns-types" class="comunidad-color">Tipos de campañas.</a></p>';
echo '			</div>
			</div>
		</div>';

echo '	<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-table"></i> '.strTranslate("Videos").'</a></div>
				<div class="panel-body">';
echo '			<p><a href="?page=admin-videos" class="comunidad-color">'.strTranslate("Video_list").'.</a></p>';
echo '			<p><a href="?page=admin-validacion-videos" class="comunidad-color">'.strTranslate("Video_validation").'.</a></p>';
echo '			</div>
			</div>
		</div>';


echo '	<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-table"></i> '.strTranslate("Photos").'</a></div>
				<div class="panel-body">';
echo '			<p><a href="?page=admin-albumes" class="comunidad-color">'.strTranslate("Photo_list").'.</a></p>';
echo '			<p><a href="?page=admin-validacion-fotos" class="comunidad-color">'.strTranslate("Photo_validation").'.</a></p>';
echo '			</div>
			</div>
		</div>';		
echo '</div>';
echo '<div class="row inset">';
echo '	<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-comment"></i> Foros</a></div>
				<div class="panel-body">';
echo '			<p><a href="?page=admin-validacion-foro-temas" class="comunidad-color">Temas en los foros.</a></p>';
echo '			<p><a href="?page=admin-validacion-foro-comentarios" class="comunidad-color">Comentarios en los foros.</a></p>';				
echo '		</div>
			</div>	
		</div>';

echo '	<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-comment"></i> Muro</a></div>
				<div class="panel-body">';
echo '			<p><a href="?page=admin-validacion-muro" class="comunidad-color">Comentarios en el muro</a></p>';			
echo '		</div>
			</div>	
		</div>';		

echo '</div>';
echo '</div>

		<div class="row inset">
		<div class="col-md-12"><h3>'.strTranslate("Tools").'</h3></div>	

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-gear"></i>Configuración</a></div>
				<div class="panel-body">';
  echo '		  <p><a href="?page=admin-config" class="comunidad-color">Datos generales.</a></p>';
  //echo '		  <p><a href="?page=admin-page&p=manifest" class="comunidad-color">Términos y condiciones.</a></p>';
  echo '		  <p><a href="?page=admin-page&p=policy" class="comunidad-color">Política de privacidad.</a></p>';
  echo '		  <p><a href="?page=admin-page&p=declaracion" class="comunidad-color">Derechos y responsabilidades.</a></p>';		 				  			
  echo '		</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-user"></i>'.strTranslate("Users").'</a></div>
				<div class="panel-body">';
  echo '		  <p><a href="?page=users" class="comunidad-color">'.strTranslate("Users_list").'</a></p>';
  echo '		  <p><a href="?page=users-tiendas" class="comunidad-color">'.strTranslate("Users_groups_list").'</a></p>';
  echo '		  <p><a href="?page=cargas-users" class="comunidad-color">'.strTranslate("Users_import").'</a></p>';				
				  //ASIGNACION DE HUELLAS
				  //getAsignacionPuntos();  
  echo '		</div>
			</div>
		</div>		

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-file-text-o"></i>Informes</a></div>
				<div class="panel-body">';
  echo '		  <p><a href="?page=informe-accesos" class="comunidad-color">Accesos a la comunidad.</a></p>';
  echo '		  <p><a href="?page=informe-participaciones" class="comunidad-color">Informe de participaciones.</a></p>';
   echo '		  <p><a href="?page=informe-puntuaciones" class="comunidad-color">Informe de puntuaciones.</a></p>';			  				  			
  echo '		</div>
			</div>
		</div>		
	
		</div>';
}

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////


function getAsignacionPuntos(){
	echo '<p><a href="?page=admin-puntos" class="comunidad-color">Asignar puntos a los usuarios.</a></p>';
}
?>