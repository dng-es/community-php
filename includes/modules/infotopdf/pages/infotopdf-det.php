<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);


echo '<h1>Tu documentación</h1>';

if (isset($_REQUEST['id']) and $_REQUEST['id'] != ""){
	$info = new infotopdf();
	$info_tipo = $_REQUEST['id'];
	$tipo_info = $info->getInfoTipos(" AND id_tipo=".$info_tipo);
	echo '<h2>Documentación <span>'.$tipo_info[0]['nombre_info'].'</span></h2>
			<p><a href="?page=infotopdf">Volver a toda la documentación</a></p>';

	if ($_SESSION['user_canal']==CANAL2 or ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador')){
		//CONTENIDOS CANAL2
		$elements=$info->getInfo(" AND canal_info='".CANAL2."' AND tipo_info = ".$info_tipo." ");
		foreach($elements as $element):
			echo '<p><a target="_blank" href="docs/showfile.php?file='.$element['file_info'].'">'.$element['titulo_info'].'</a></p>';	  	  	
		endforeach;																											
	}
	
	if ($_SESSION['user_canal']==CANAL1 or ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador')){
		//CONTENIDOS CANAL1
		$elements=$info->getInfo(" AND canal_info='".CANAL1."' AND tipo_info = ".$info_tipo." ");
		foreach($elements as $element):
			echo '<p><a target="_blank" href="docs/showfile.php?file='.$element['file_info'].'">'.$element['titulo_info'].'</a></p>';	  	  	
		endforeach;	 			
	}

	//CONTENIDOS TODOS LOS USUARIOS
	$elements=$info->getInfo(" AND canal_info='todos' AND tipo_info = ".$info_tipo." ");
	foreach($elements as $element):
		echo '<p><a target="_blank" href="docs/showfile.php?file='.$element['file_info'].'">'.$element['titulo_info'].'</a></p>';	  	  	
	endforeach;
}
?>