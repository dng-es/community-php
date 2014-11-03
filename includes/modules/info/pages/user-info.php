<?php
infoController::getZipAction();
addJavascripts(array("js/bootstrap.file-input.js", getAsset("info")."js/admin-info-doc.js"));
$elements = infoController::getItemAction($_GET['id']);
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<div class="panel panel-default">
			<div class="panel-heading">Datos del documento</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<label><?php echo strTranslate("Name");?>:</label> <?php echo $elements[0]['titulo_info'];?><br />
						<label><?php echo strTranslate("Campaign");?>:</label> <?php echo $elements[0]['campana']; ?><br />
						<label><?php echo strTranslate("Type");?>:</label> <?php echo $elements[0]['tipo']; ?><br />
						<label><?php echo strTranslate("Date");?>:</label> <?php echo getDateFormat($elements[0]['date_info'], "LONG"); ?><br /><br />
						<a target="_blank" href="?page=user-info&exp=<?php echo $elements[0]['file_info'];?>" class="btn btn-primary"><?php echo strTranslate("Download_file");?></a>
					</div>
					<div class="col-md-4">
					</div>		
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h3><?php echo strTranslate("Info_Documents");?></h3>
			<p>Volver a <a href="?page=user-info-all" class="comunidad-color">todos los documentos</a></p>
		</div>
	</div>
</div>