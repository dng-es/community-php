<?php
/**
* Print HTML tema foro info. Used in foros, blog, áreas de trabajo
*
* @param 	array 		$sub_tema 		tema data
* @param 	string		$destino 		Links destination (foros, blog, áreas de trabajo)
*/
function ForoList($sub_tema, $destino = "foro-comentarios"){
	$num_comentarios = connection::countReg("foro_comentarios", " AND estado=1 AND id_tema=".$sub_tema['id_tema']." ");
	$num_visitas = connection::countReg("foro_visitas", " AND id_tema=".$sub_tema['id_tema']." ");
	$descripcion = blogController::get_resume($sub_tema['descripcion']);
	$nombre = strip_tags($sub_tema['nombre']);
	?>
	
	<div class="panel panel-default panel-comunidad" value="<?php echo $sub_tema['id_tema'];?>">
		<div class="panel-footer">
			<h4><a href="<?php echo $destino.'?id='.$sub_tema['id_tema'];?>"><?php echo $nombre;?></a></h4>
			<span><?php echo getDateFormat($sub_tema['date_tema'], "LONG");?></span>
			<span class="fa fa-comment" title="comentarios en el foro"></span>
			<span class="contador-foro-counter"><?php echo $num_comentarios;?></span> <?php echo strTranslate("Comments");?> 
			<span class="fa fa-eye" title="visitas al foro"></span> 
			<span class="contador-foro-counter"><?php echo $num_visitas;?></span> <?php echo strTranslate("Visits");?> 
			<?php showTags($sub_tema['tipo_tema']);?>
		</div>
		<div class="panel-body">
			<p><?php echo $descripcion;?></p>
		</div>
	</div>
<?php
}
?>