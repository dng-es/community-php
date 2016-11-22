<?php
$base_dir = str_replace( ((strrpos( __DIR__ , "\\" ) === false) ? 'modules/users/pages' : 'modules\\users\\pages')  , '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");


session::ValidateSessionAjax();

if(isset($_POST['find_user'])){
	$users = new users();
	$usuario = sanitizeInput($_POST['find_user']);
	$filtro_canal = (($_SESSION['user_canal'] <> 'admin') ? " AND (canal ='".$_SESSION['user_canal']."' OR canal ='' OR canal ='admin')" : '');
	$result = $users->getUsers($filtro_canal." AND nick LIKE '%".$usuario."%' OR name LIKE '%".$usuario."%' OR surname LIKE '%".$usuario."%' ");
	$tot_result = count($result);
	if($usuario == ''){
		echo '<p class="text-danger text-center"><i class="fa fa-warning"></i> Intruduce el usuario a buscar. Puedes hacerlo por su nick, nombre y/o apellidos</p>';
	}
	elseif ($tot_result == 0){
		echo '<p class="text-danger text-center"><i class="fa fa-warning"></i> No se ha encontrado coincidencias</p>';
	}
	else{?>
		<div class="table-responsive">
			<table class="table table-hover table-stripped">
				<tr>
					<th></th>
					<th><?php e_strTranslate("Nick");?></th>
					<th><?php e_strTranslate("Name");?> <?php e_strTranslate("Surname");?></th>
				</tr>
				<?php foreach($result as $element):?>
				<tr>
					<td><a href="user-profile?n=<?php echo $element['nick'];?>"><i class="fa fa-user"></i></a></td>
					<td><?php echo $element['nick'];?></td>
					<td><?php echo $element['name'];?> <?php echo $element['surname'];?></td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>
	<?php }

}


?>