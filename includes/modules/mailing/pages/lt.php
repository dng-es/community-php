<?php

if ( (isset($_GET["u"]) && $_GET["u"]!="") && (isset($_GET["l"]) && $_GET["l"]!="") ) {
	ob_start();
	$er = error_reporting(0); 
	error_reporting($er);

	$base_dir = str_replace('modules/mailing/pages', '', realpath(dirname(__FILE__))) ;
	include_once($base_dir . "core/class.connection.php");
	include_once($base_dir . "modules/configuration/class.configuration.php");
	include_once($base_dir . "core/constants.php");
	include_once($base_dir . "core/functions.php");
	include_once($base_dir . "core/class.session.php");
	include_once($base_dir . "modules/mailing/class.mailing.php");

	$mailing = new mailing();


	$id_message_user = urldecode(base64_decode($_GET["u"]));
	$id_link = urldecode(base64_decode($_GET["l"]));



	//obtener datos del mensaje
	$message_data = $mailing->getMessagesUsersSimple(" AND id_message_user=".$id_message_user." ");

	//obtener datos del link
	$link_data = $mailing->getMessageLink(" AND id_link=".$id_link." ");	

	//insertar registro del link
	$mailing->insertMessageLinkUser($id_link, $message_data[0]['username_message'], $message_data[0]['email_message'], $message_data[0]['id_message']);

	//sumar click al link
	$mailing->sumMessageLink($id_link);

	@ob_end_clean();

	//echo "id_message_user: ".$id_message_user."<br />";
	//echo "id_link: ".$id_link."<br />";

	header("Location: " . $link_data[0]['url']);
	exit;
}

?>