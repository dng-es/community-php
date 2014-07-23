<?php

infoController::getZipAction();

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_select=5;
function ini_page_header ($ini_conf) {?>
<script language="JavaScript" src="js/bootstrap.file-input.js"></script>
<script type="text/javascript" src="<?php echo getAsset("info");?>js/admin-info-doc.js"></script>
<?php }
function ini_page_body ($ini_conf){

  	$elements = infoController::getItemAction($_GET['id']);



?>
  <div id="page-info">Gestión de documentos</div>
  <div class="row inset row-top">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Datos del documento</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<label>Titulo del documento:</label> <?php echo $elements[0]['titulo_info'];?><br />
						<label>Campaña:</label> <?php echo $elements[0]['campana']; ?><br />
						<label>Tipo de documento:</label> <?php echo $elements[0]['tipo']; ?><br /><br />
						<a target="_blank" href="?page=user-info&exp=<?php echo $elements[0]['file_info'];?>" class="btn btn-primary">Descargar documento</a>
					</div>
					<div class="col-md-4">
					</div>		
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Gestion de documentos</div>
			<div class="panel-body">
				<a href="?page=user-info-all" class="comunidad-color">Ir a todos los documentos</a>
			</div>
		</div>
	</div>
</div>
<?php 
}
?>