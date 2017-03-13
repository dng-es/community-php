<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/alerts/pages' : 'modules\\alerts\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/alerts/classes/class.alerts.php");
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
		$alerts = new alerts(); 
		$filtro = " AND activa=1 AND (NOW() BETWEEN date_ini AND date_fin) AND ((type_alert='user' AND destination_alert='".$_SESSION['user_name']."') OR (type_alert='group' AND destination_alert='".$_SESSION['user_empresa']."') OR destination_alert='') ORDER BY priority, date_alert";

		$messages_group = $alerts->getAlerts($filtro);
		if (count($messages_group) > 0):?>
		<div id="messagesGroup"> 
			<h5>Avisos pendientes</h5>
			<ul class="list-unstyled">
				<?php foreach($messages_group as $message_group):?>
				<li>
					<span class="<?php echo $message_group['priority'];?>"></span>
					<?php echo $message_group['text_alert'];?>
				</li>
				<?php endforeach;?>
			</ul>
		</div>
		<?php endif;?>
	</body>
</html>