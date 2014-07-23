<?php


function footerMail($username){
	global $ini_conf;
	$users = new users();
	$user_data = $users->getUsers(" AND username='".$username."' ");
	$footer_final='
	<table>
		<tr>
			<td valign="top"><img src="'.$ini_conf['SiteUrl'].'/images/usuarios/'.$user_data[0]['foto'].'" width="50px" height="50px" style="width:50px;height:50px" /></td>
			<td valign="top" style="font-size:11px">
				'.$user_data[0]['name'].' '.$user_data[0]['surname'].'<br />
				'.$user_data[0]['email'].'<br />
				'.$user_data[0]['nombre_tienda'].'<br />
				'.nl2br($user_data[0]['user_comentarios']).'
			</td>
		</tr>
	</table>';

	return $footer_final;
}
?>