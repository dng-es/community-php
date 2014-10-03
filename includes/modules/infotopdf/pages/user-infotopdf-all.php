<?php
$elements = infotopdfController::getListAction(20);
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php 
		$columna = 1;
		foreach($elements['items'] as $element): 
			if ($columna ==1){echo '<div class="row">';}
			$nombre_archivo = $element['file_info'];
			$ext = strtoupper(substr($nombre_archivo, strrpos($nombre_archivo,".") + 1));
			$nombre_sinext=substr($nombre_archivo,0,(strlen($nombre_archivo)-strlen($ext))-1);
			$nombre_miniatura = "mini".$nombre_sinext.".jpeg";
		?>	
			<div class="col-md-3">
				<a href="?page=user-infotopdf&id=<?php echo $element['id_info'];?>">
					<h3><?php echo $element['titulo_info'];?></h3>
					<p class="legend"><?php echo $element['campana'];?> (<?php echo $element['tipo'];?>)</p>
					<img src="docs/info/<?php echo $nombre_miniatura;?>" style="width:100%" />
				</a>
			</div>
		<?php 
			if ($columna == 4){echo '</div>';$columna=0;}
     		$columna++;
		endforeach;
		if ($columna == 2){echo '</div>';}
		?>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h3>Comunicaciones impresas</h3>
			<p>Puedes pesonalizar y descargar en PDF las comunicaciones</p>
		</div>
	</div>
</div>