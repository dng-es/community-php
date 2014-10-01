<?php
$base_dir = str_replace('modules/fotos/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/class.users.php");
include_once($base_dir . "modules/fotos/class.fotos.php");
include_once($base_dir . "modules/users/templates/tipuser.php");
include_once($base_dir . "modules/fotos/controllers/controller.default.php");
include_once($base_dir . "modules/fotos/templates/gallery.php");

session::ValidateSessionAjax();
$fotos=new fotos();
$pagina = (isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1 );
$filtro_album = ((isset($_REQUEST['id']) and $_REQUEST['id']>0) ? " AND id_album=".$_REQUEST['id']." " : "" );
$regs = 18;
$inicio = ($pagina*$regs);
$elements = fotosController::getListAction($regs, $filtro_album." AND estado=1 ORDER BY id_file DESC LIMIT ".$inicio.", ".$regs);
galleryPhotos($elements['items'],true,0,4);
?>