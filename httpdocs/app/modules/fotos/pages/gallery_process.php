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
include_once($base_dir . "modules/fotos/templates/comment.php");
include_once($base_dir . "modules/notifications/classes/class.notifications.php");
include_once($base_dir . "modules/notifications/controllers/controller.default.php");

session::ValidateSessionAjax();
$fotos = new fotos();

//INSERTAR COMENTARIO
if (isset($_POST['respuesta-texto']) && $_POST['respuesta-texto'] != ""){
	$id = sanitizeInput($_POST['id_file']);
	$texto_comentario = nl2br(sanitizeInput($_POST['respuesta-texto']));
	echo $fotos->InsertComentario($id, $texto_comentario, $_SESSION['user_name'], 1);
	notificationsController::insertNotifications($id, 'fotos');
}

//NOTIFICACIONES
if (isset($_POST['idn']) && $_POST['idn'] > 0){
	$notifications = new notifications();
	$id = intval($_POST['idn']);
	$opt = intval($_POST['opt']);

	if ($opt == 1)
		$notifications->insertNotificationInscription($_SESSION['user_name'], 'fotos', $id);
	elseif ($opt == 0)
		$notifications->deleteNotificationInscription($_SESSION['user_name'], 'fotos', $id);
}

//VOTAR FOTO
if (isset($_POST['idv']) && $_POST['idv'] != ""){
	$id = sanitizeInput($_POST['idv']);
	echo $fotos->InsertVotacion($id, $_SESSION['user_name']);
}
else{
?>
<!DOCTYPE html>
	<html lang="es">
		<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo $ini_conf['SiteUrl'];?>/themes/<?php echo $_SESSION['user_theme'];?>/css/styles.css" />
		<script type="text/javascript" src="<?php echo $ini_conf['SiteUrl'];?>/js/main.min.js"></script>
	</head>
	<body>
	<?php
	//MOSTRAR COMENTARIOS
	if (isset($_REQUEST['idf']) && $_REQUEST['idf'] != ""){
		$elements = $fotos->getComentariosFoto(" AND id_file=".$_REQUEST['idf']." AND estado=1 ORDER BY id_comentario DESC");
		foreach($elements as $element):
			commentFoto($element);
		endforeach;
	}
	?>
	</body>
</html>
<?php } ?>