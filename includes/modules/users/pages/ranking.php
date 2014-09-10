<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

templateload("tipuser","users");

addJavascripts(array(getAsset("users")."js/ranking.js"));

  
$users = new users();
$huellas_user = $users->getUsers(" AND username='".$_SESSION['user_name']."' ");
$puntuacion_user = $huellas_user[0]['puntos'];
$posicion_user=users::posicionRanking($_SESSION['user_name']);
if ($_SESSION['user_perfil']=='admin'){$posicion_user=0;}
$huellas = $users->getUsers(" AND perfil<>'admin' ORDER BY puntos DESC,username ASC LIMIT 15");


echo '<div id="page-info">Ranking colaboradores</div>';
echo '<div class="row inset row-top">
        <div class="col-md-9">';
echo '  <p>Cada una de tus aportaciones te ayudan a acumular estrellas. ¿Cuántas estrellas tienes?<br />
        ¿estás entre los primeros? descúbrelo en este ranking:</p><br />'; 

echo '<div class="row">';
echo '  <div class="col-md-4">';
userdatos($huellas[0],1);
echo '  </div>';
echo '  <div class="col-md-4">';
userdatos($huellas[1],2);
echo '  </div>';
    echo '  <div class="col-md-4">';
userdatos($huellas[2],3);
echo '  </div>';
echo '</div>';
echo '<div class="row">';
echo '  <div class="col-md-4">';
userdatos($huellas[3],4);
echo '  </div>';
echo '  <div class="col-md-4">';
userdatos($huellas[4],5);
echo '  </div>';
    echo '  <div class="col-md-4">';
userdatos($huellas[5],6);
echo '  </div>';
echo '</div>';  

echo '<div class="row">
        <div class="col-md-12">';

  
//LOS 10 PRIMEROS DEL RANKING
$total_usuarios=$users->countReg("users"," AND confirmed=1 AND disabled=0 ORDER BY username");
//echo '	<p>Los mejores en el ranking, total de usuarios activos: '.$total_usuarios.'</p>';
echo '  <br /><br />
        <table class="table">';
for ($i=6;$i<=14;$i++){	
	  $posicion=($i+1);
    userRanking($huellas[$i],$huellas[0]['puntos'],$i,$posicion);
}
echo '</table>
      </div>
    </div>';  							

echo '  </div>
        <div class="col-md-3 lateral">';
//RANKING DEL USUARIO
rankingUsuario($huellas_user[0],$huellas[0]['puntos'],20,$posicion_user);
echo '    <a href="?page=ranking_centros" class="btn btn-primary btn-block">ir a ranking de centros</a>';
echo '  </div>
    </div>';


///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////
function userdatos($huellas,$posicion_ranking){
  $foto = "user.jpg";
  if ($huellas['foto'] != ""){$foto = $huellas['foto'];}
  echo '<div class="ranking-user-img-container"><img src="'.PATH_USERS_FOTO.$huellas['foto'].'" /></div>
        <div  class="ranking-user-info-container"><span>'.$posicion_ranking.'</span> '.$huellas['name'].' '.$huellas['surname'].'<br />
        '.$huellas['puntos'].' estrellas</div>';

}
function userRanking($huellas,$max_puntos,$i,$posicion_ranking){
  $foto = "user.jpg";
  if ($huellas['foto'] != ""){$foto = $huellas['foto'];}
	echo '<tr>
          <td class="table-number">'.$posicion_ranking.'</td>
          <td><a id="a'.$i.'" href="$a'.$i.'Tip?width=350" class="betterTip" title="Datos del usuario <em>'.$huellas['nick'].'</em>">
              <img src="'.PATH_USERS_FOTO.$huellas['foto'].'" width="50px" height="50px" />
              </a>
          </td>
  			  <td>
  			'.$huellas['name'].' '.$huellas['surname'].'
          <br />'.$huellas['puntos'].' estrellas';							
  	userTip($i,$huellas,userEstrellas($huellas['participaciones']));
  	echo '</td>
  			  <td>'.$huellas['empresa'].'</td>
  		  </tr>';	
}

function rankingUsuario($huellas,$max_puntos,$i,$posicion_ranking){
  $foto = "user.jpg";
  if ($huellas['foto'] != ""){$foto = $huellas['foto'];}

  echo '<div class="user-ranking">
        <p>Tu posición en el ranking</p>
        <img src="'.PATH_USERS_FOTO.$huellas['foto'].'" />   
        <div class="user-ranking-info"><span>'.$posicion_ranking.'</span>
          <div>'.$huellas['name'].' '.$huellas['surname'].'<br />
          '.$huellas['empresa'].'<br />
          '.$huellas['puntos'].' estrellas
          </div>
        </div>
    </div>';  
}
?>
