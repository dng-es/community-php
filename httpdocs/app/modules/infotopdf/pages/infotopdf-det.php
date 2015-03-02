<?php
echo '<h1>Tu documentación</h1>';

if (isset($_REQUEST['id']) and $_REQUEST['id'] != ""){
	$info = new infotopdf();
	$info_tipo = $_REQUEST['id'];
	$tipo_info = $info->getInfoTipos(" AND id_tipo=".$info_tipo);
	echo '<h2>Documentación <span>'.$tipo_info[0]['nombre_info'].'</span></h2>
			<p><a href="infotopdf">Volver a toda la documentación</a></p>';

	if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador') $filtro_canal_info = "";
	else $filtro_canal_info = " AND (canal_info='".$_SESSION['user_perfil']."' OR canal_info='todos' ) ";

	$elements=$info->getInfo($filtro_canal_info." AND tipo_info = ".$info_tipo." ");
	foreach($elements as $element):
		echo '<p><a target="_blank" href="docs/showfile.php?file='.$element['file_info'].'">'.$element['titulo_info'].'</a></p>';	  	  	
	endforeach;
}
?>