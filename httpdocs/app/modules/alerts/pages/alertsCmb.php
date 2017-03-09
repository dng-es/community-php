<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/alerts/pages' : 'modules\\alerts\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
?>
<!DOCTYPE html>
<html lang="es">
	<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo $ini_conf['SiteUrl'];?>/themes/<?php echo $_SESSION['user_theme'];?>/css/styles.css" />
	</head>
	<body>
		<?php
		session::ValidateSessionAjax();
		$users = new users(); 
		if ($_REQUEST['tipo'] == 'user'){
			$filtro = " AND disabled=0 ";
			$filtro .= ($_SESSION['user_perfil'] == 'admin' ? "" : " AND perfil='usuario' AND responsable_tienda='".$_SESSION['user_name']."' ");
			$destinations = $users->getUsers($filtro);
			$destination_field = "username";
			$destination_field_text = "username";
			if ($_SESSION['user_perfil'] == 'admin') echo '<option value="">--- Todos los usuarios ---</option>';
		}
		else{
			$filtro = " AND activa=1 ";
			$filtro .= ($_SESSION['user_perfil'] == 'admin' ? "" : " AND responsable_tienda='".$_SESSION['user_name']."' ");
			$destinations = $users->getTiendas($filtro);
			$destination_field = "cod_tienda";
			$destination_field_text = "nombre_tienda";
			if ($_SESSION['user_perfil'] == 'admin') echo '<option value="">--- Todas las tiendas ---</option>';
		}

		foreach($destinations as $destination):?>
			<option value="<?php echo $destination[$destination_field];?>">
				<?php echo $destination[$destination_field_text];?>
			</option>
		<?php endforeach;?>
	</body>
</html>