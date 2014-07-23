<?php

infotopdfController::getHTMLtoPDF();

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_select=5;
function ini_page_header ($ini_conf) {?>
<script language="JavaScript" src="js/bootstrap.file-input.js"></script>
<script type="text/javascript" src="<?php echo getAsset("infotopdf");?>js/admin-infotopdf-doc.js"></script>
<?php }
function ini_page_body ($ini_conf){

	
  	$elements = infotopdfController::getItemAction($_GET['id']);
	$nombre_archivo = $elements[0]['file_info'];
	$ext = strtoupper(substr($nombre_archivo, strrpos($nombre_archivo,".") + 1));
	$nombre_sinext=substr($nombre_archivo,0,(strlen($nombre_archivo)-strlen($ext))-1);
	$nombre_miniatura = "mini".$nombre_sinext.".jpeg";


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
						<a target="_blank" href="?page=user-infotopdf&idp=<?php echo $elements[0]['id_info'];?>" class="btn btn-primary">Generar PDF alta resolución</a>
					</div>
					<div class="col-md-4">
						<img style="width:100%" src="docs/info/<?php echo $nombre_miniatura;?>" alt="banner" />
					</div>		
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Gestion de documentos</div>
			<div class="panel-body">
				<a href="?page=user-infotopdf-all" class="comunidad-color">Ir a todos los documentos</a>
			</div>
		</div>
	</div>
</div>
<?php 
}
?>