<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<LINK rel="stylesheet" type="text/css" href="css/styles.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="includes/modules/muro/resources/js/muro-comentario.js"></script>
<script language="JavaScript" src="includes/modules/muro/resources/js/muro-respuestas-ajax.js"></script>     
</head>
<body> 
<?php
$base_dir = str_replace('modules/muro/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/class.users.php");
include_once($base_dir . "modules/muro/class.muro.php");

session::ValidateSessionAjax();
$muro=new muro();
  //VOTAR COMENTARIO
  if (isset($_REQUEST['idvc']) and $_REQUEST['idvc']!="") { 
    $mensaje=$insercion_comentario = $muro->InsertVotacion($_REQUEST['idvc'],$_SESSION['user_name']);
  }
?> 
</body>
</html>
