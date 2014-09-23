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
					<span class="ficha-user-tip-info">Alias: <span>'.$user_data['nick'].'</span></span><br />
					<span class="ficha-user-tip-info">Nombre: <span>'.$user_data['name'].' '.$user_data['surname'].'</span></span><br />';
			if ($user_data['user_date']!=''){
				$dia=strftime(DATE_DAY,strtotime($user_data['user_date']));
				switch(strftime(DATE_MONTH,strtotime($user_data['user_date']))) {
				  case 1: $mes="Enero"; break;
				  case 2: $mes="Febrero"; break;
				  case 3: $mes="Marzo"; break;
				  case 4: $mes="Abril"; break;
				  case 5: $mes="Mayo"; break;
				  case 6: $mes="Junio"; break;
				  case 7: $mes="Julio"; break;
				  case 8: $mes="Agosto"; break;
				  case 9: $mes="Septiembre"; break;
				  case 10: $mes="Octubre"; break;
				  case 11: $mes="Noviembre"; break;
				  case 12: $mes="Diciembre"; break;
				  default: $mes="Enero";
			   } 
			   $fecha_nacimiento=$dia." de ".$mes;
				echo '<span class="ficha-user-tip-info">F.nacimiento: <span>'.$fecha_nacimiento.'</span></span><br />';}
			//echo '	<span class="ficha-user-tip-info">Centro de trabajo: <span>'.$user_data['nombre_tienda'].'</span></span><br />';
			//echo '	<span class="ficha-user-tip-info">Provincia: <span>'.$user_data['provincia'].'</span></span><br />';
			echo '	<span class="ficha-user-tip-info">Puntos: <span>'.$user_data['puntos'].'</span></span><br />';
			// echo '	<span class="ficha-user-tip-info">&iquest;En que piensas?:</span>
			// 		<span class="text-muted"><em>'.$user_data['user_comentarios'].'</em></span>';
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
	echo '				<a class="pull-left betterTip" id="a'.$user_data['id_comentario'].'" href="$a'.$user_data['id_comentario'].'Tip?width='.$tam_foto.'" title="Datos del usuario <em>'.$user_data['nick'].'</em>">
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