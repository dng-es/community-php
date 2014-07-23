<?php
/**
* Print HTML tema foro info. Used in foros, blog, áreas de trabajo
*
* @param 	array 		$sub_tema 		tema data
* @param 	string		$destino 		Links destination (foros, blog, áreas de trabajo)
*/
function ForoList($sub_tema,$destino = "foro-comentarios")
{
	$num_comentarios=users::countReg("foro_comentarios"," AND estado=1 AND id_tema=".$sub_tema['id_tema']." ");
	$num_visitas=users::countReg("foro_visitas"," AND id_tema=".$sub_tema['id_tema']." ");
	$descripcion = strip_tags($sub_tema['descripcion']);
	$nombre = strip_tags($sub_tema['nombre']);

	if (strlen($descripcion)>400) {$descripcion = substr($descripcion,0,400)."...";}
		//$destino_inscripcion=$this->foroInscripcion($sub_tema['id_tema']);
	if ($sub_tema['tipo_tema']){$tipo_tema=' <span class="icon-tags menuicon-foros" title="etiquetas del foro"></span><span class="contador-foro-counter">'.$sub_tema['tipo_tema'].'</span>';}
	else{$tipo_tema="";} ?>
	
	<div class="panel panel-default panel-comunidad" value="<?php echo $sub_tema['id_tema'];?>">
		<div class="panel-body">
			<h4><a href="?page=<?php echo $destino.'&id='.$sub_tema['id_tema'];?>"><?php echo $nombre;?></a></h4>
			<p><?php echo $descripcion;?></p>
		</div>
		<div class="panel-footer">
			<span class="fa fa-comment" title="comentarios en el foro"></span>
			<span class="contador-foro-counter"><?php echo $num_comentarios;?></span> comentarios 
			<span class="fa fa-eye" title="visitas al foro"></span> 
			<span class="contador-foro-counter"><?php echo $num_visitas;?></span> visitas 
			<!--<span class="fa fa-tag"></span> Etiquetas: <?php echo $tipo_tema;?>-->
		</div>
	</div>
<?php
}
?>