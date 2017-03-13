<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/users/pages' : 'modules\\users\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
		
session::ValidateSessionAjax();
?>
<!DOCTYPE html>
	<html lang="es">
		<head>
			<meta charset="utf-8">
			<link rel="stylesheet" type="text/css" href="<?php echo $ini_conf['SiteUrl'];?>/themes/<?php echo $_SESSION['user_theme'];?>/css/styles.css" />
			<script type="text/javascript" src="js/main.min.js"></script>
		</head>
		<body>
		<?php
		$pagina = $_REQUEST['pagina'];
		$reg = 10;
		$inicio = ($pagina - 1) * $reg;
		if ($_SESSION['user_canal'] != 'admin') $filtroCanal = " AND (connection_canal='".$_SESSION['user_canal']."' or connection_canal='admin') ";
		else{$filtroCanal="";}
		$users_conn = users::getUsersConn($filtroCanal." LIMIT ".$inicio.",".$reg);
		echo '<div class="users-connected" id="users-connected-'.$pagina.'" ><p>Total conectados: '.count($users_conn).'</p>';
		foreach($users_conn as $user_conn):
			$foto_user_conn = ($user_conn['foto'] == "" ? "user.jpg" : $user_conn['foto']); ?>
			<div class="media">
				<img class="media-object pull-left" src="images/usuarios/<?php echo $foto_user_conn;?>" alt="<?php echo $user_conn['nick'];?>">
				<div class="media-body">
				<p class="media-heading"><?php echo $user_conn['nick'];?></p>
				<?php echo $user_conn['name'];?> <?php echo $user_conn['surname'];?>
				</div>
			</div>
		<?php endforeach;?>
		</div>
	</body>
</html>