<?php
$elements = infotopdfController::getListAction(20);
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Infotopdf_Documents"), "ItemClass"=>"active"),
		));

		$columna = 1;
		foreach($elements['items'] as $element): 
			if ($columna == 1){echo '<div class="row">';}
			$nombre_archivo = $element['file_info'];
			$ext = strtoupper(substr($nombre_archivo, strrpos($nombre_archivo,".") + 1));
			$nombre_sinext = substr($nombre_archivo,0,(strlen($nombre_archivo)-strlen($ext))-1);
			$nombre_miniatura = "mini".$nombre_sinext.".jpeg";
		?>	
		<div class="col-md-3">
			<a href="user-infotopdf?id=<?php echo $element['id_info'];?>">
				<h3><?php echo $element['titulo_info'];?></h3>
				<p class="legend"><?php echo $element['campana'];?> (<?php echo $element['tipo'];?>)</p>
				<img src="<?php echo PATH_BANNERS.$nombre_miniatura;?>" style="width:100%" />
			</a>
		</div>
		<?php 
			if ($columna == 4){echo '</div>'; $columna = 0;}
			$columna++;
		endforeach;
		if ($columna == 2){echo '</div>';}
		?>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
	</div>
	<div class="app-sidebar hidden-sm hidden-xs">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-file fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Infotopdf_Documents");?></h4>
			<p>Puedes pesonalizar y descargar en PDF las comunicaciones</p>
			<p class="text-center"><i class="fa fa-file-pdf-o fa-big"></i></p>
		</div>
	</div>
</div>