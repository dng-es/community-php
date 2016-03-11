<?php
function panelDestacado(){
	$destacados = new destacados();
	$filtro_destacado = "";
	if ($_SESSION['user_canal'] != 'admin' ) $filtro_destacado .= " AND canal_destacado='".$_SESSION['user_canal']."' ";
	$destacado = $destacados->getDestacados($filtro_destacado." AND activo=1 ");
	if (count($destacado) > 0):
		$destacado_file = $destacados->getDestacadosFile(" AND d.activo=1 ".$filtro_destacado, $destacado[0]['destacado_tipo']);
		?>
		<h3><?php e_strTranslate("Highlights");?></h3>
		<div class="media-preview-container">
			<?php
			if ($destacado[0]['destacado_tipo'] == 'foto'){
				echo '<a target="_blank" href="docs/fotos/'.$destacado_file[0]['name_file'].'">
					<img src="docs/fotos/'.$destacado_file[0]['name_file'].'" class="media-preview" alt="'.prepareString($destacado_file[0]['titulo']).'" /></a>';
			}
			elseif ($destacado[0]['destacado_tipo'] == 'video'){ 
				echo '<a href="videos?id='.$destacado_file[0]['id_file'].'">
				<img src="'.PATH_VIDEOS.$destacado_file[0]['name_file'].'.jpg" class="media-preview" alt="'.prepareString($destacado_file[0]['titulo']).'" /></a>';
			}
			?>
			<div>
				<p>
					<a href="<?php echo ($destacado[0]['destacado_tipo'] == 'foto' ? 'fotos' : 'videos?id='.$destacado_file[0]['id_file']);?>"><?php echo $destacado_file[0]['destacado_texto'];?></a><br />
					<?php echo $destacado_file[0]['nick'];?><br />
					<span><small><?php echo ucfirst(getDateFormat($destacado[0]['destacado_fecha'], "LONG"));?></small></span><br />
				</p>
			</div>
		</div>
	<?php else:?>
		<div class="text-muted">No hay destacado en día de hoy</div>
	<?php endif;?>
<?php } ?>