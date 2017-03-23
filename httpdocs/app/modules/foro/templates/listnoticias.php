<?php
/**
* Print HTML tema foro info. Used in foros, blog, áreas de trabajo
* @param 	Array 		$sub_tema 		Tema data
* @return 	String						HTML panel
*/
function ForoList($sub_tema){
	$num_comentarios = users::countReg("foro_comentarios", " AND estado=1 AND id_tema=".$sub_tema['id_tema']." ");
	$num_visitas = users::countReg("foro_visitas"," AND id_tema=".$sub_tema['id_tema']." ");
	$descripcion = strip_tags($sub_tema['descripcion']);
	if (strlen($descripcion) > 400) $descripcion = substr($descripcion, 0, 400)."...";
		//$destino_inscripcion=$this->foroInscripcion($sub_tema['id_tema']);
	if ($sub_tema['tipo_tema']) $tipo_tema = ' <span class="icon-kub-tag menuicon-foros" title="etiquetas del foro"></span><span class="contador-foro-counter">'.$sub_tema['tipo_tema'].'</span>';
	else $tipo_tema = "";
	echo '	<article class="noticias-foro">
				<a href="noticias-comentarios?id='.$sub_tema['id_tema'].'"><img src="'.PATH_FORO_FOTO.$sub_tema['imagen_tema'].'" /></a>
				<h3><a href="noticias-comentarios?id='.$sub_tema['id_tema'].'">'.$sub_tema['nombre'].'</a></h3>
				<p>'.$descripcion.'</p>
				<div class="contador-foro">
					<span class="icon-calendar-empty menuicon-foros" title="fecha"></span>
					<span class="contador-foro-counter">'.getDateFormat($sub_tema['date_tema'], 'SHORT').'</span>
					<span class="icon-comment-alt menuicon-foros" title="comentarios en el foro"></span>
					<span class="contador-foro-counter">'.$num_comentarios.'</span> 
					<span class="icon-eye-open menuicon-foros" title="visitas al foro"></span>
					<span class="contador-foro-counter">'.$num_visitas.'</span>'.$tipo_tema.'
				</div>
			</article>';
}
?>