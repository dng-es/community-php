<?php

function userTip($id,$user_data,$estrellas_print){
		$foto = ($user_data['foto'] == "" ? "user.jpg" : $user_data['foto']);
		$output = '<div id="a'.$id.'Tip" class="text-left tooltip-media">							
				<table cellpadding="3" cellspacing="0">
				<tr><td valign="top">
				<img alt="'.$user_data['nick'].'" src="'.PATH_USERS_FOTO.$foto.'" class="imgUserTip" />
				</td>
				<td>
				<span>
				<span>'.strTranslate("Nick").': <span class="ficha-user-tip-info">'.$user_data['nick'].'</span></span><br />
				<span>'.strTranslate("Name").': <span class="ficha-user-tip-info">'.$user_data['name'].' '.$user_data['surname'].'</span></span><br />';
		if ($_SESSION['user_perfil'] == 'admin'){
			$output .= '<span>'.strTranslate("Profile").': <span class="ficha-user-tip-info">'.$user_data['perfil'].'</span></span><br />
				<span>'.strTranslate("Channel").': <span class="ficha-user-tip-info">'.$user_data['canal'].'</span></span><br />';
		}
		if ($user_data['user_date'] != ''){
			$dia = getDateFormat($user_data['user_date'], "DAY");
			$mes = getDateFormat($user_data['user_date'], "MONTH_LONG");		
			$fecha_nacimiento=$dia." de ".$mes;
			$output .= '<span>'.strTranslate("Born_date").': <span class="ficha-user-tip-info">'.$fecha_nacimiento.'</span></span><br />';
		}
		//echo '	<span class="ficha-user-tip-info">Centro de trabajo: <span>'.$user_data['nombre_tienda'].'</span></span><br />';
		//echo '	<span class="ficha-user-tip-info">Provincia: <span>'.$user_data['provincia'].'</span></span><br />';
		$output .=  '	<span>'.ucfirst(strTranslate("APP_points")).': <span class="ficha-user-tip-info">'.$user_data['puntos'].'</span></span><br />';
		$output .=  (trim($user_data['user_comentarios'])!="" ? '<span class="text-muted"><em><small>'.$user_data['user_comentarios'].'</small></em></span><br />' : "");
		$output .=  '	</span>
				<span>'.$estrellas_print.'</span>
				</td>
				</tr>
				</table>
			</div>';

		return $output;
}

function userFicha($user_data){
	$foto = ($user_data['foto'] == "" ? "user.jpg" : $user_data['foto']);
	$estrellas_print = userEstrellas($user_data['participaciones']);					
	echo '<a data-html="true" class="user-tip pull-left" title="'.str_replace('"', '\'', userTip($user_data['id_comentario'],$user_data,$estrellas_print)).'" id="a'.$user_data['id_comentario'].'" href="user-profile?n='.$user_data['nick'].'" >
			<img alt="'.$user_data['nick'].'" class="comment-mini-img" src="'.PATH_USERS_FOTO.$foto.'" />';							
	echo $estrellas_print;
	echo '</a>';
}

function userEstrellas($participaciones){
	$estrellas=$participaciones/APORTACIONES_VALORACION;
	$estrellas_print="";
	for ($i=1;$i<=5;$i++) {
		if ($estrellas>=$i) {$clase="fa fa-star star-on";}
		else {$clase="fa fa-star star-off";}
		$estrellas_print.='<span class="'.$clase.'"></span>';
	}
	return $estrellas_print;
}
?>