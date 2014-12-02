<?php
function PanelLastDestacado(){
	$destacados = new destacados();
	$filtro_destacado=" AND activo=1 ";
	if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='admin_responsables' and $_SESSION['user_perfil']!='formador'and $_SESSION['user_perfil']!='foros') {
		//$filtro_destacado.=" AND canal_destacado='".$_SESSION['user_canal']."' "; 
	}
	$destacado=$destacados->getDestacados($filtro_destacado);
	$destacado_file=$destacados->getDestacadosFile(" AND d.activo=1 ".$filtro_destacado,$destacado[0]['destacado_tipo']);   
	?>
	<div class="media-preview-container">
		<?php
		if ($destacado[0]['destacado_tipo']=='foto') {
			echo '<a target="_blank" href="docs/fotos/'.$destacado_file[0]['name_file'].'">
				  <img src="docs/fotos/'.$destacado_file[0]['name_file'].'" class="media-preview" alt="'.$destacado_file[0]['titulo'].'" /></a>';
		}
		elseif ($destacado[0]['destacado_tipo']=='video') { 
			echo '<a href="?page=video&id='.$destacado_file[0]['id_file'].'">
			<img src="'.PATH_VIDEOS.$destacado_file[0]['name_file'].'.jpg" class="media-preview" alt="'.$destacado_file[0]['titulo'].'" /></a>';
		}
		?>
		<div>
			<p>
				<big><a href="?page=<?php echo ($destacado[0]['destacado_tipo']=='foto' ? 'fotos' : 'video&id='.$destacado_file[0]['id_file']);?>"><?php echo $destacado_file[0]['destacado_texto'];?></a></big><br />
				<span><?php echo $destacado_file[0]['nick'];?> - <?php echo getDateFormat($destacado[0]['destacado_fecha'], "LONG");?></span><br />
				
			</p>
		</div>
	</div>

<?php } ?>