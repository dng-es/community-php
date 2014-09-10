<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

addJavascripts(array("js/bootstrap.file-input.js", getAsset("users")."js/admin-cargas.js"));

//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);
?>
<div class="row row-top">
	<div class="col-md-9">
		<h1><?php echo strTranslate("Users_import")?></h1>
		<p>Selecciona un fichero Excel con los usuarios a cargar. El fichero deberá tener la estructura especificada, puedes descargar el fichero modelo <a href="docs/model_users.xls"><b><?php echo strTranslate("Click_here")?></b></a>.</p>
		<form id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="?page=cargas-user-process" role="form">
			<label for="nombre-fichero"><?php echo strTranslate("Choose_file")?> Excel (.xls): </label><br />
			<input id="nombre-fichero" name="nombre-fichero" type="file" class="btn btn-default" title="<?php echo strTranslate("Choose_file")?>" />
			<span id="fichero-alert" class="alert-message"></span>
			<input type="button" id="inputFile" name="inputFile" value="<?php echo strTranslate("Import_file")?>" class="btn btn-primary" />
		</form>
	</div>
	<?php menu::adminMenu();?>
</div>