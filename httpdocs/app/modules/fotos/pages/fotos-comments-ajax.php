<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/fotos/pages' : 'modules\\fotos\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/fotos/classes/class.fotos.php");
include_once($base_dir . "modules/users/templates/tipuser.php");
include_once($base_dir . "modules/fotos/templates/gallery.php");
include_once($base_dir . "modules/fotos/templates/tags.php");
include_once($base_dir . "modules/notifications/controllers/controller.default.php");
include_once($base_dir . "modules/notifications/templates/notifications.php");

$module_config = getModuleConfig("fotos");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="stylesheet" type="text/css" href="<?php echo $ini_conf['SiteUrl'];?>/themes/<?php echo $_SESSION['user_theme'];?>/css/styles.css" />
		<script type="text/javascript" src="js/main.min.js"></script>
		<script src="<?php echo getAsset("fotos");?>js/fotos-gallery-ajax.js"></script>
	</head>
	<body>
	<?php
	session::ValidateSessionAjax();

	$fotos = new fotos();
	$id_file = 0;
	if(isset($_REQUEST['id']) && $_REQUEST['id'] != "") $id_file = $_REQUEST['id'];
	//OBTENCION DE LAS FOTOS
	$filtro = " AND estado=1 AND id_file=".$id_file." ";
	//if ($_SESSION['user_canal'] != 'admin') $filtro .= " AND f.canal='".$_SESSION['user_canal']."' ";
	$filtro .= ($_SESSION['user_canal'] != 'admin' ? " AND canal_album LIKE '%".$_SESSION['user_canal']."%' " : "");

	$files_galeria = $fotos->getFotos($filtro." ORDER BY id_file DESC ");

	notificationsController::deleteNotification($id_file, 'fotos');
	?>
	<div class="row">
		<div class="col-md-12">
			<?php showFotoModal($files_galeria[0], true, 0, 0);?>
			<?php if ($module_config['options']['allow_comments'] == true): ?>
			<form action="" method="post" role="form" id="form-comentario-fotos" name="form-comentario-fotos" class="panel-interior">
				<label for="respuesta-texto"><?php e_strTranslate("Photo_comment_new");?></label>
				<input type="hidden" name="id_file" id="id_file" value="<?php echo $files_galeria[0]['id_file'];?>" />
				<textarea class="form-control" name="respuesta-texto" id="respuesta-texto"></textarea>
				<button type="submit" class="btn btn-primary btn-block"><?php e_strTranslate("Send");?></button>
				<div id="respuesta-alert" class="alert-message alert alert-danger"></div>
			</form>
			<div id="respuestas-result" class="alert-message alert alert-success"></div>
			<div id="respuestas-textos"></div>
			<?php endif; ?>
		</div>
	</div>
	</body>
</html>


<?php
function showFotoModal($file_galeria, $votaciones = true, $movil = 0, $reto = 0){
	$fotos = new fotos();
	//$titulo = (strlen($file_galeria['titulo']) > 30 ? substr($file_galeria['titulo'], 0, 28)."..." : $file_galeria['titulo']);
	$nick = ($file_galeria['nick'] == "" ? "(sin nick)" : $file_galeria['nick']);
	$votado = connection::countReg("galeria_fotos_votaciones", " AND id_file=".$file_galeria['id_file']." AND user_votacion='".$_SESSION['user_name']."' ");

	echo '<div class="thumbnail photo-comment">
			<a href="'.PATH_FOTOS.$file_galeria['name_file'].'" target="_blank">
			<img title="'.$file_galeria['titulo'].'" src="'.PATH_FOTOS.$file_galeria['name_file'].'" id="modal-img-main" /></a>
			<div class="caption">
			<span id="image-titulo">'.$file_galeria['titulo'].'</span><br />
			<span class="text-muted"><a target="_blank" href="'.PATH_FOTOS.$file_galeria['name_file'].'" title="'.strTranslate("Full_screen").'" ><i class="fa fa-desktop"></i></a> 
			'.$nick.' - '.getDateFormat($file_galeria['date_foto'], "SHORT");
	if ($_SESSION['user_perfil'] == 'admin') echo ' - ID: '.$file_galeria['id_file'];
	echo ' - <a href="#" data-id="'.$file_galeria['id_file'].'" data-v="'.$votado.'"  title="'.strTranslate("Photo_vote").'" class="fa fa-heart trigger-votar"> '.$file_galeria['fotos_puntos'].'</a>';
	echo '</span><br />';
	fotoNotifications($file_galeria['id_file']);
	showTags($file_galeria['tipo_foto']);
	echo '<div class="alert-votacion text-danger"></div>';
	echo '</div></div>';
}
?>