<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/alerts/pages' : 'modules\\alerts\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");


session::ValidateSessionAjax();
$users = new users(); 
if ($_REQUEST['tipo'] == 'user'){
	$filtro = " AND disabled=0 ";

	if ($_SESSION['user_perfil'] == 'usuario') $filtro .= " AND username='".$_SESSION['user_name']."' ";
	if ($_SESSION['user_perfil'] == 'responsable') $filtro .= " AND perfil='usuario' AND responsable_tienda='".$_SESSION['user_name']."' ";
	if ($_SESSION['user_perfil'] == 'regional') $filtro .= " AND perfil='usuario' AND regional_tienda='".$_SESSION['user_name']."' ";

	$destinations = $users->getUsers($filtro);
	$destination_field = "username";
	$destination_field_text = "username";
}
else{
	$filtro = " AND activa=1 ";
	$filtro .= ($_SESSION['user_perfil'] == 'admin' ? "" : " AND responsable_tienda='".$_SESSION['user_name']."' ");
	$destinations = $users->getTiendas($filtro);
	$destination_field = "cod_tienda";
	$destination_field_text = "nombre_tienda";
}
$destinatario = sanitizeInput($_REQUEST['sel']);
$destinatario_array = explode(',', $destinatario);

foreach($destinations as $destination):?>
	<option value="<?php echo $destination[$destination_field];?>" <?php if (in_array($destination[$destination_field], $destinatario_array)) echo 'selected="selected" ';?>>
		<?php echo $destination[$destination_field_text];?>
	</option>
<?php endforeach;?>
