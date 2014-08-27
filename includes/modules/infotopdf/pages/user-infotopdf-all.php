<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

function ini_page_header ($ini_conf) {?>

<?php }
function ini_page_body ($ini_conf){

	$elements = infotopdfController::getListAction(20);
	?>
	<div id="page-info">Comunicaciones impresas</div>
	<div class="row inset row-top">
		<div class="col-md-12">
			<div class="row">
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
			</div>
			<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
		</div>
	</div>
<?php
}
?>