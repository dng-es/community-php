<?php
$base_dir = str_replace('modules/fotos/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/fotos/classes/class.fotos.php");
include_once($base_dir . "modules/users/templates/tipuser.php");
include_once($base_dir . "modules/fotos/controllers/controller.default.php");
include_once($base_dir . "modules/fotos/templates/gallery.php");

session::ValidateSessionAjax();
$fotos=new fotos();
$module_config = getModuleConfig("fotos");
$pagina = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1 );
$filtro_album = ((isset($_REQUEST['id']) and $_REQUEST['id']>0) ? " AND id_album=".$_REQUEST['id']." " : "" );
$filtro_nick = ((isset($_REQUEST['n']) and $_REQUEST['n']!="") ? " AND nick='".urldecode($_REQUEST['n'])."' " : "" );
$elements = fotosController::getListAction(18, $filtro_album.$filtro_nick." AND estado=1 ORDER BY id_file DESC ");
galleryPhotos($elements['items'],true,0,4, "fotos", $module_config['options']['allow_comments']);
?>