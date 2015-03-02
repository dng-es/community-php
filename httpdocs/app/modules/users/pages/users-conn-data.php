<?php
$base_dir = str_replace('modules/users/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");

session::ValidateSessionAjax();

$pagina=$_REQUEST['pagina'];
$reg=56;
$inicio = ($pagina - 1) * $reg;

$users = new users();
if ($_SESSION['user_canal']=='exclusivo' or $_SESSION['user_canal']=='rt'){$filtroCanal=" AND (connection_canal='".$_SESSION['user_canal']."' or connection_canal='admin' or connection_canal='formador') ";}
else{$filtroCanal="";}
//$users_conn = $users->getUsers(" AND confirmed=1 LIMIT ".$inicio.",".$reg);  
$users_conn = $users->getUsersConn($filtroCanal." LIMIT ".$inicio.",".$reg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <LINK rel="stylesheet" type="text/css" href="css/styles.css" />
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
		$foto = ($user_conn['foto']=="" ? "user.jpg" : $user_conn['foto']);?>
		<div class="ficha-user" style="width: 90px !important; margin:0 5px 15px 0 !important; display: inline-block; overflow: hidden">
			<a href="#" class="trigger-msg" n="<?php echo $user_conn['nick'];?>"><img class="comment-mini-img"  style="width:90px !important; height: 90px !important" src="images/usuarios/<?php echo $foto;?>" /></a>
			<div style="display: inline-block; width: 90px; overflow: hidden;text-overflow: ellipsis; white-space: nowrap;">
				<?php echo $user_conn['nick'];?>
			</div>					
		</div>
		<?php endforeach; ?>
	<div>
</body>
</html>