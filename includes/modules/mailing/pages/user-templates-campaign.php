<?php

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_select=5;

function ini_page_header ($ini_conf) {?>

<?php }
function ini_page_body ($ini_conf){
	$elements = mailingTemplatesController::getListAction(20, "activos","AND t.id_campaign=".$_GET['id']);

	?>
	<div class="row less-width row-top">
	  	<div class="col-md-12">
	  		<div class="textuppercase blue more-marginbottom"><h1 class="font-title">Plantillas de comunicaciones</h1></div>
        	<p>Total <b><?php echo $elements['total_reg'];?></b> plantillas</p>
        	<div class="row">
			<?php
			$columna = 1;
			if (count($elements['items']) == 0) {
				echo '<div class="alert alert-warning">No hay registros</div>';
			}
			foreach($elements['items'] as $element):
				if ($columna ==1){echo '<div class="row">';}
			?>
				<div class="col-md-4">
					<a href="?page=user-message&id=<?php echo $element['id_template'];?>">
						<h3><?php echo $element['template_name'];?></h3>
						<p class="legend"><?php echo $element['tipo'];?> - <?php echo $element['campana'];?></p>
						<img src="images/mailing/<?php echo $element['template_mini'];?>" style="width:100%" />
					</a>
				</div>
			<?php
				if ($columna == 3){echo '</div>';$columna=0;}
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