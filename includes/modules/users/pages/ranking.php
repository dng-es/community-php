<?php
templateload("tipuser","users");

addJavascripts(array(getAsset("users")."js/ranking.js"));
	
$users = new users();
$puntos_user = $users->getUsers(" AND username='".$_SESSION['user_name']."' ");
$puntuacion_user = $puntos_user[0]['puntos'];
$posicion_user=users::posicionRanking($_SESSION['user_name']);
if ($_SESSION['user_perfil']=='admin'){$posicion_user=0;}

$puntos = $users->getUsers(" AND perfil<>'admin' ORDER BY puntos DESC,username ASC LIMIT 15");

?>
<div class="row inset row-top">
	<div class="col-md-9">
		<h1>Ranking usuarios</h1>
		<p>Cada una de tus aportaciones te ayudan a acumular puntos. ¿Cuántos puntos tienes?, ¿estás entre los primeros? descúbrelo en este ranking:</p><br />

		<div class="row">
			<?php for ($i=0;$i<=5;$i++){ ?>
			<div class="col-md-4">
				<?php if (isset($puntos[$i])) userdatos($puntos[$i],1);?>
			</div>
			<?php } ?>
		</div> 
		<div class="row">
			<div class="col-md-12">
				<br /><br />
				<table class="table">
					<?php
					//LOS 10 PRIMEROS DEL RANKING
					$total_usuarios=$users->countReg("users"," AND confirmed=1 AND disabled=0 ORDER BY username");
					//echo '	<p>Los mejores en el ranking, total de usuarios activos: '.$total_usuarios.'</p>';

					for ($i=6;$i<=14;$i++){	
						if (isset($puntos[$i]))userRanking($puntos[$i],$puntos[0]['puntos'],$i,($i+1));
					}?>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-3 lateral">
		<?php rankingUsuario($puntos_user[0],$puntos[0]['puntos'],20,$posicion_user);?>
	</div>
</div>


<?php
///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////
function userdatos($puntos,$posicion_ranking){
	$foto = PATH_USERS_FOTO. ($puntos['foto'] != "" ? $puntos['foto'] : "user.jpg");
	echo '<div class="ranking-user-img-container"><img src="'.$foto.'" /></div>
				<div  class="ranking-user-info-container"><span>'.$posicion_ranking.'</span> '.$puntos['name'].' '.$puntos['surname'].'<br />
				'.$puntos['puntos'].' '.strTranslate("APP_points").'</div>';

}
function userRanking($puntos,$max_puntos,$i,$posicion_ranking){
	$foto = PATH_USERS_FOTO. ($puntos['foto'] != "" ? $puntos['foto'] : "user.jpg");

	echo '<tr>
					<td class="table-number">'.$posicion_ranking.'</td>
					<td><a id="a'.$i.'" href="$a'.$i.'Tip?width=350" class="betterTip" title="Datos del usuario <em>'.$puntos['nick'].'</em>">
							<img src="'.$foto.'" width="50px" height="50px" />
							</a>
					</td>
					<td>
				'.$puntos['name'].' '.$puntos['surname'].'
					<br />'.$puntos['puntos'].' '.strTranslate("APP_points");							
		userTip($i,$puntos,userEstrellas($puntos['participaciones']));
		echo '</td>
					<td>'.$puntos['empresa'].'</td>
				</tr>';	
}

function rankingUsuario($puntos,$max_puntos,$i,$posicion_ranking){
	$foto = PATH_USERS_FOTO. ($puntos['foto'] != "" ? $puntos['foto'] : "user.jpg");

	echo '<div class="user-ranking">
				<p>Tu posición en el ranking</p>
				<img src="'.$foto.'" />   
				<div class="user-ranking-info"><span>'.$posicion_ranking.'</span>
					<div>'.$puntos['name'].' '.$puntos['surname'].'<br />
					'.$puntos['empresa'].'<br />
					'.$puntos['puntos'].' '.strTranslate("APP_points").'
					</div>
				</div>
		</div>';  
}
?>
