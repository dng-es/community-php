<?php
infoController::getZipAction();
addJavascripts(array("js/bootstrap.file-input.js", getAsset("info")."js/admin-info-doc.js"));
$elements = infoController::getItemAction($_GET['id']);
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Info_Documents"), "ItemUrl"=>"info-campaigns"),
			array("ItemLabel"=>$elements[0]['campana'], "ItemUrl"=>"user-info-all&id=".$elements[0]['id_campaign']),
			array("ItemLabel"=>$elements[0]['titulo_info'], "ItemClass"=>"active"),
		));?>
		<div class="panel panel-default">
			<div class="panel-heading">Datos del documento</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<label><?php echo strTranslate("Name");?>:</label> <?php echo $elements[0]['titulo_info'];?><br />
						<label><?php echo strTranslate("Campaign");?>:</label> <?php echo $elements[0]['campana']; ?><br />
						<label><?php echo strTranslate("Type");?>:</label> <?php echo $elements[0]['tipo']; ?><br />
						<label><?php echo strTranslate("Date");?>:</label> <?php echo getDateFormat($elements[0]['date_info'], "LONG"); ?><br /><br />
						<?php if ($elements[0]['download']==1): ?>
						<a target="_blank" href="user-info&exp=<?php echo $elements[0]['file_info'];?>" class="btn btn-primary"><?php echo strTranslate("Download_file");?></a>
						<?php else: ?>
						<a target="_blank" href="<?php echo $elements[0]['file_info'];?>" class="btn btn-primary">Ir a la documentación</a>
						<?php endif; ?>
					</div>
					<div class="col-md-4">
					</div>		
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-file fa-stack-1x fa-inverse"></i>
				</span>
				<?php echo strTranslate("Info_Documents");?>
			</h4>
			<p>Volver a <a href="user-info-all" class="comunidad-color">todos los documentos</a></p>
			<p class="text-center"><i class="fa fa-file-o fa-big"></i></p>
		</div>
	</div>
</div>