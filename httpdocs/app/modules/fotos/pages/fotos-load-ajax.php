<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/fotos/pages' : 'modules\\fotos\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/fotos/classes/class.fotos.php");
include_once($base_dir . "modules/users/templates/tipuser.php");
include_once($base_dir . "modules/fotos/controllers/controller.default.php");
include_once($base_dir . "modules/fotos/templates/gallery.php");

session::ValidateSessionAjax();
$fotos = new fotos();
$module_config = getModuleConfig("fotos");
$pagina = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1 );
//$filtro_canal = ($_SESSION['user_canal'] == 'admin' ? "" : " AND (f.canal='".$_SESSION['user_canal']."' OR f.canal='todos') ");
$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_album LIKE '%".$_SESSION['user_canal']."%' " : "");
$filtro_album = ((isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? " AND f.id_album=".$_REQUEST['id']." " : "" );
$filtro_tags = ((isset($_REQUEST['tags']) && $_REQUEST['tags'] != '') ? " AND tipo_foto LIKE '%".str_replace('%20', ' ', $_REQUEST['tags'])."%' " : "" );
$filtro_promocion = ((isset($_REQUEST['idp']) && $_REQUEST['idp'] > 0) ? " AND id_promocion=".$_REQUEST['idp']." " : "" );
$filtro_nick = ((isset($_REQUEST['n']) && $_REQUEST['n'] != "") ? " AND nick='".urldecode($_REQUEST['n'])."' " : "" );
$id_promocion = ((isset($_REQUEST['idp']) && $_REQUEST['idp'] > 0) ? $_REQUEST['idp'] : 0 );
$id_album = ((isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? $_REQUEST['id'] : 0 );
$tag = ((isset($_REQUEST['tags']) && $_REQUEST['tags'] != '') ? $_REQUEST['tags'] : 0 );
$elements = fotosController::getListAction(18, $filtro_canal.$filtro_tags.$filtro_album.$filtro_nick.$filtro_promocion." AND estado=1 ORDER BY id_file DESC ");
$destino = ((isset($_REQUEST['idp']) && $_REQUEST['idp'] > 0) ? 'reto' : 'fotos' );
galleryPhotos($elements['items'], true, $id_promocion, $destino, $module_config['options']['allow_comments'], $id_album, $tag);
?>