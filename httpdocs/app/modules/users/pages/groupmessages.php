<?php
$base_dir = str_replace('modules/users/pages', '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");


?>
<!DOCTYPE html>
<html lang="es">
	<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/styles.css" />
	</head>
	<body>
		<?php
		session::ValidateSessionAjax();
		$users = new users(); 
		$filtro = " AND activa=1 ORDER BY priority, date_message";

		$messages_group = $users->getUsersTiendasMessages($filtro);
		if (count($messages_group) > 0):
		?>
		<div id="messagesGroup"> 
			<h5>Avisos pendientes</h5>
			<ul class="list-unstyled">
		<?php foreach($messages_group as $message_group):?>
				<li>
					<span class="<?php echo $message_group['priority'];?>"></span>
					<?php echo $message_group['text_message'];?>
				</li>
		<?php endforeach;?>
			</ul>
		</div>
		<?php endif;?>
	</body>
</html>