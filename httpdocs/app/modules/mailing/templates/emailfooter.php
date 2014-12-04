<?php


function footerMail($usuario_email){
	global $ini_conf;

	$messageid = isset($usuario_email['id_message_user']) ? urlencode(base64_encode($usuario_email['id_message_user'])) : "";
	$messageemail = isset($usuario_email['email_message']) ? $usuario_email['email_message'] : "";

	$footer_final = '<img src="'.$ini_conf['SiteUrl'].'/app/modules/mailing/pages/ut.php?u='.$messageid.'" />';
	$footer_final .= '<p style="text-align:center; font-size:12px;color:#999">Si no desea recibir más emails piche <a href="'.$ini_conf['SiteUrl'].'/?page=unsuscribe&u='.$messageemail.'&ua='.sha1($messageemail).'">aquí</a></p>';

	return $footer_final;
}
?>