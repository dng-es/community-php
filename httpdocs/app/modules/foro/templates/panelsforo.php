<?php

function PanelForosUltimos($tema = -1){
	$filtro_visitados = " AND t.id_tema_parent=".$tema." AND t.activo=1 AND t.ocio=0 AND t.id_tema IN (
		SELECT DISTINCT com.id_tema 
		FROM foro_comentarios com 
		LEFT JOIN foro_temas tem ON com.id_tema=tem.id_tema
		WHERE com.estado=1 AND com.user_comentario='".$_SESSION['user_name']."' AND tem.activo=1
		ORDER BY com.date_comentario DESC 
	)";
	$foro = new foro();
	$sub_temas = $foro->getTemasComentarios($filtro_visitados,' LIMIT 5');

	foreach($sub_temas as $sub_tema):
		temaForoInfo($sub_tema);
	endforeach;

	if (count($sub_temas) == 0) echo '<p>Todavia no has participado en los foros.</p>';
}

function PanelLastForos(){
	$foro = new foro();
	$id_tema = "1";
	$filtro_subtemas = " AND t.id_tema_parent in (".$id_tema.") AND t.activo=1 AND c.estado = 1 AND t.ocio=0 order by c.date_comentario DESC";
	$sub_temas = $foro->getComentariosPanel($filtro_subtemas);

	$array_tema = array();
	$i = 0;
	foreach($sub_temas as $sub_tema):
	$nombre_tema = '';
	if (!in_array($sub_tema['id_tema'],$array_tema)){
		$array_tema[$i] = $sub_tema['id_tema'];
		$i += 1;
		temaForoInfo($sub_tema);
		if ($i == 3) break;
	}
	endforeach;
	if (count($sub_temas) == 0){ echo '<p>No existen foros activos.</p>';}
}

function temaForoInfo($sub_tema){
	$foro = new foro();
	$num_comentarios = connection::countReg("foro_comentarios", " AND estado=1 AND id_tema=".$sub_tema['id_tema']." ");
	$num_visitas = connection::countReg("foro_visitas", " AND id_tema=".$sub_tema['id_tema']." "); 
	echo '<div class="panel-foros-info" value="'.$sub_tema['id_tema'].'">     
				<a href="foro-comentarios?id='.$sub_tema['id_tema'].'">
				'.$sub_tema['nombre'].'</a> 
				<p>
				'.$num_comentarios.' <span>mensajes</span> - 
				'.$num_visitas.' <span>visitas</span>
				</p>
			</div>';
}
?>