<?php

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

$elements = mailingTemplatesController::getListAction(6, "activos");

?>
<div class="row inset row-top">
  	<div class="col-md-12"> 
  		<h2>Plantillas de comunicaciones</h2>
    	<p>Total <b><?php echo $elements['total_reg'];?></b> plantillas</p>
    	<div class="row">
			<?php 
			$columna = 1;
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