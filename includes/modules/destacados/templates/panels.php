<?php
function PanelLastDestacado(){
  $destacados = new destacados();
  $filtro_destacado=" AND activo=1 ";
  if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='admin_responsables' and $_SESSION['user_perfil']!='formador'and $_SESSION['user_perfil']!='foros') {
	  //$filtro_destacado.=" AND canal_destacado='".$_SESSION['user_canal']."' "; 
  }
  $destacado=$destacados->getDestacados($filtro_destacado);
  $destacado_file=$destacados->getDestacadosFile(" AND d.activo=1 ".$filtro_destacado,$destacado[0]['destacado_tipo']);   

  if ($destacado[0]['destacado_tipo']=='foto') {
		echo '<h3><a target="_blank" href="docs/fotos/'.$destacado_file[0]['name_file'].'">DESTACADO</a></h3>
			  <a target="_blank" href="docs/fotos/'.$destacado_file[0]['name_file'].'"><img src="" data-src="docs/fotos/'.$destacado_file[0]['name_file'].'" class="blanco-negro nomobile" /></a>';
  }
  elseif ($destacado[0]['destacado_tipo']=='video') { 
    echo '<h3><a target="_blank" href="docs/fotos/'.$destacado_file[0]['name_file'].'">DESTACADO</a></h3>
    	  <a href="?page=video&id='.$destacado_file[0]['id_file'].'"><img src="" data-src="'.PATH_VIDEOS.$destacado_file[0]['name_file'].'.jpg" class="blanco-negro nomobile" /></a>';
  }	
}
?>