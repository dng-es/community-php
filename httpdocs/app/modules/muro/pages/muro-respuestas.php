<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/muro/pages' : 'modules\\muro\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/muro/classes/class.muro.php");

session::ValidateSessionAjax();
?>
<html>
	<head>
		<LINK rel="stylesheet" type="text/css" href="<?php echo $ini_conf['SiteUrl'];?>/themes/<?php echo $_SESSION['user_theme'];?>/css/styles.css" />
		<script type="text/javascript" src="js/main.min.js"></script>
		<script language="JavaScript" src="app/modules/muro/resources/js/muro-comentario.js"></script>
		<script language="JavaScript" src="app/modules/muro/resources/js/muro-respuestas-ajax.js"></script>
	</head>
	<body>
		<?php 
		$muro = new muro();
		//VOTAR COMENTARIO
		if (isset($_REQUEST['idvc']) and $_REQUEST['idvc'] != "") { 
			$mensaje = $insercion_comentario = $muro->InsertVotacion(intval($_REQUEST['idvc']), $_SESSION['user_name']);
		}
		?>
	</body>
</html>