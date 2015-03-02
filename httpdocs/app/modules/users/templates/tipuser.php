<?php

function userTip($id,$user_data,$estrellas_print,$movil=0){
		//var_dump($user_data);
		$path_foto="";
		if ($user_data['foto']==""){$foto="user.jpg";}
		else {$foto=$user_data['foto'];}
			echo '<div id="a'.$id.'Tip" class="ficha-user-tip">							
					<table cellpadding="3" cellspacing="0">
					<tr><td valign="top">
					<img src="'.$path_foto.PATH_USERS_FOTO.$foto.'" class="imgUserTip" />
					</td>
					<td>
					<span>
					<span class="ficha-user-tip-info">'.strTranslate("Nick").': <span>'.$user_data['nick'].'</span></span><br />
					<span class="ficha-user-tip-info">'.strTranslate("Name").': <span>'.$user_data['name'].' '.$user_data['surname'].'</span></span><br />';
			if ($user_data['user_date']!=''){
				$dia = getDateFormat($user_data['user_date'], "DAY");
				$mes = getDateFormat($user_data['user_date'], "MONTH_LONG");		
				$fecha_nacimiento=$dia." de ".$mes;
				echo '<span class="ficha-user-tip-info">'.strTranslate("Born_date").': <span>'.$fecha_nacimiento.'</span></span><br />';}
			//echo '	<span class="ficha-user-tip-info">Centro de trabajo: <span>'.$user_data['nombre_tienda'].'</span></span><br />';
			//echo '	<span class="ficha-user-tip-info">Provincia: <span>'.$user_data['provincia'].'</span></span><br />';
			echo '	<span class="ficha-user-tip-info">'.ucfirst(strTranslate("APP_points")).': <span>'.$user_data['puntos'].'</span></span><br />';
			echo (trim($user_data['user_comentarios'])!="" ? '<span class="text-muted"><em><small>'.$user_data['user_comentarios'].'</small></em></span><br />' : "");
			echo '	</span>
					<span>'.$estrellas_print.'</span>
					</td>
					</tr>
					</table>
				</div>';
}

function userFicha($user_data,$movil=0){
	$path_foto="";
	if ($movil==1){$path_foto="../";$tam_foto="180";}
	else {$tam_foto="350";}
	$path_foto.=PATH_USERS_FOTO;
	if ($user_data['foto']==""){$foto="user.jpg";}
	else {$foto=$user_data['foto'];}
	$estrellas_print = userEstrellas($user_data['participaciones']);
	echo '				<a class="pull-left betterTip" id="a'.$user_data['id_comentario'].'" href="$a'.$user_data['id_comentario'].'Tip?width='.$tam_foto.'" title="'.strTranslate("User_info").' <em>'.$user_data['nick'].'</em>">
						<img class="comment-mini-img" src="'.$path_foto.$foto.'" />';							
	userTip($user_data['id_comentario'],$user_data,$estrellas_print,$movil);						
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