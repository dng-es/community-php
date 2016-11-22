<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/users/pages' : 'modules\\users\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/users/templates/tipuser.php");

session::ValidateSessionAjax();

$pagina = $_REQUEST['pagina'];
$reg = 56;
$inicio = ($pagina - 1) * $reg;

if ($_SESSION['user_canal'] != 'admin') $filtroCanal = " AND (connection_canal='".$_SESSION['user_canal']."' or connection_canal='admin') ";
else $filtroCanal = "";
$users_conn = users::getUsersConn($filtroCanal." LIMIT ".$inicio.",".$reg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<LINK rel="stylesheet" type="text/css" href="<?php echo $ini_conf['SiteUrl'];?>/themes/<?php echo $_SESSION['user_theme'];?>/css/styles.css" />
		<script type="text/javascript" src="js/main.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".trigger-msg").click(function(e){
					e.preventDefault();
					var nick = $(this).attr("n");
					if (nick!=""){location.href="inbox?n="+nick;}
				});
			});
		</script>
	</head>
	<body>	
		<div id="users-connected-<?php echo $pagina;?>" style="display: none">
			<?php foreach($users_conn as $user_conn):
			$foto = usersController::getUserFoto($user_conn['foto']);
			?>
			<div class="ficha-user panel panel-default">
				<div class="panel-body">
					<a href="#" class="trigger-msg" n="<?php echo $user_conn['nick'];?>">
					<img class="comment-mini-img" src="<?php echo $foto;?>" /></a>
					<div class="ellipsis">
						<?php echo $user_conn['nick'];?><br />
						<?php echo userEstrellas($user_conn['participaciones']);?>
					</div>
				</div>
			</div>
			<?php endforeach;?>
		</div>
	</body>
</html>