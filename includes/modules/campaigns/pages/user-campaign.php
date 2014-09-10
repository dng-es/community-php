<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

addJavascripts(array("js/bootstrap.file-input.js", getAsset("campaigns")."js/admin-campaign.js"));

session::getFlashMessage( 'actions_message' ); 
$templates = mailingTemplatesController::getListAction(400000, "activos", " AND t.id_campaign=".$_GET['id']);
$documentos = infotopdfController::getListAction(400000, " AND i.id_campaign=".$_GET['id']);
$ficheros = infoController::getListAction(400000, " AND i.id_campaign=".$_GET['id']);
$plantilla = campaignsController::getItemAction();	

?>
<div id="page-info">Campañas</div>
<div class="row inset row-top">	
	<div class="col-md-12">
		<h3><?php echo $plantilla['name_campaign'];?></h3>
		<p><?php echo $plantilla['novedad']==1 ? '<span class="label label-success">novedad</span> ' : '';?></p>
		<p><?php echo $plantilla['desc_campaign'];?></p>	
		<h4>Comunicaciones email</h4>
		<?php
			if (count($templates['items'])>0):
				echo '<ul>';
				foreach($templates['items'] as $element):
					echo '<li><a href="?page=user-message&act=new&id='.$element['id_template'].'">'.$element['template_name'].'</a></li>';
				endforeach;
				echo '</ul>';
			else:
				echo '<div class="alert alert-info">No hay documentos en la sección</div>';
			endif;
		?>
		<h4>Comunicaciones impresas</h4>
		<?php
			if (count($documentos['items'])>0):
				echo '<ul>';
				foreach($documentos['items'] as $element):
					echo '<li><a href="?page=user-infotopdf&id='.$element['id_info'].'">'.$element['titulo_info'].'</a></li>';
				endforeach;
				echo '</ul>';
			else:
				echo '<div class="alert alert-info">No hay documentos en la sección</div>';
			endif;
		?>	
		<h4>Documentos de apoyo</h4>
		<?php
			if (count($ficheros['items'])>0):
				echo '<ul>';
				foreach($ficheros['items'] as $element):
					echo '<li><a href="?page=user-info&id='.$element['id_info'].'">'.$element['titulo_info'].'</a></li>';
				endforeach;
				echo '</ul>';
			else:
				echo '<div class="alert alert-info">No hay documentos en la sección</div>';
			endif;
		?>			
	</div>
</div>