<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_select=5;

function ini_page_header ($ini_conf) {?>

<?php }
function ini_page_body ($ini_conf){

	$elements = campaignsController::getListAction(4, " AND c.id_campaign_type=".$_REQUEST['f']);
	$plantilla = campaignsController::getItemTypesAction();	

	?>
	<div class="row inset row-top">
	  	<div class="col-md-12"> 
	  		<h2><?php echo $plantilla['campaign_type_name']?> (Total <b><?php echo $elements['total_reg'];?></b> campañas)</h2>
	  		<p><?php echo $plantilla['campaign_type_desc']?></p>

			<?php 
			$columna = 1;
			foreach($elements['items'] as $element): 
				if ($columna ==1){echo '<div class="row">';}
			?>	
				<div class="col-md-3">
					<a href="?page=user-campaign&id=<?php echo $element['id_campaign'];?>">
						<h3><?php echo $element['name_campaign'];?></h3>
						<img src="images/banners/<?php echo $element['imagen_mini']?>" style="width:100%" />
						<p class="legend"><?php echo $element['novedad']==1 ? '<span class="label label-success">novedad</span> ' : '';?><?php echo $element['desc_campaign'];?></p>
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
	</div>
	</div>
<?php
}
?>