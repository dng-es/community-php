<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/fotos/pages' : 'modules\\fotos\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/fotos/classes/class.fotos.php");
include_once($base_dir . "modules/fotos/controllers/controller.album.php");

session::ValidateSessionAjax();

//INSERTAR ALBUM
if (isset($_POST['nombre'])){
	$nombre = sanitizeInput($_POST['nombre']);
	$result = fotosAlbumController::newAlbum($nombre);
	echo json_encode($result);
}

//OBTEBNER ALBUMES
if (isset($_REQUEST['albums']) && $_REQUEST['albums'] == true){
	$fotos = new fotos();
	$elements = $fotos->getFotosAlbumes(" AND activo=1 ORDER BY nombre_album ");?>
	<option value="0">---Selecciona el album---</option>
	<?php foreach($elements as $element):?>
		<option value="<?php echo $element['id_album'];?>"><?php echo $element['nombre_album'];?></option>
	<?php endforeach;
}
?>