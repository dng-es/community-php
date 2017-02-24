<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
infoController::getZipAction();

addJavascripts(array("js/bootstrap.file-input.js", getAsset("info")."js/admin-info-doc.js"));
$elements = infoController::getItemAction(intval($_GET['id']));
?>
<div class="row row-top">
	<div class="app-main">
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
						<label><?php e_strTranslate("Name");?>:</label> <?php echo $elements[0]['titulo_info'];?><br />
						<label><?php e_strTranslate("Campaign");?>:</label> <?php echo $elements[0]['campana']; ?><br />
						<label><?php e_strTranslate("Type");?>:</label> <?php echo $elements[0]['tipo']; ?><br />
						<label><?php e_strTranslate("Date");?>:</label> <?php echo getDateFormat($elements[0]['date_info'], "LONG"); ?><br /><br />
						<?php if ($elements[0]['download'] == 1): ?>
						<a target="_blank" href="user-info&exp=<?php echo $elements[0]['file_info'];?>" class="btn btn-primary"><?php e_strTranslate("Download_file");?></a>
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
	<div class="app-sidebar">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-file fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Info_Documents");?>
			</h4>
			<p>Volver a <a href="user-info-all" class="text-primary">todos los documentos</a></p>
			<p class="text-center"><i class="fa fa-file-o fa-big"></i></p>
		</div>
	</div>
</div>