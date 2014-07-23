<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=1;
function ini_page_header ($ini_conf) {?>
	<script type="text/javascript" src="js/bootstrap.file-input.js"></script>
	<script language="JavaScript" src="<?php echo getAsset("users");?>js/admin-cargas.js"></script>
<?php }
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$session = new session();
	$perfiles_autorizados = array("admin");
	$session->AccessLevel($perfiles_autorizados);
	?>

	<div class="row inset row-top">
		<div class="col-md-8">
			<h2><?php echo strTranslate("Users_import")?></h2>
			<p>Selecciona un fichero Excel con los usuarios a cargar.<br />
			El fichero deberá tener la estructura especificada, 
			puedes descargar el fichero modelo <a href="docs/model_users.xls"><b><?php echo strTranslate("Click_here")?></b></a>.</p>
			<form id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="?page=cargas-user-process" role="form">
				<label for="nombre-fichero"><?php echo strTranslate("Choose_file")?> Excel (.xls): </label><br />
				<input id="nombre-fichero" name="nombre-fichero" type="file" class="btn btn-default" title="<?php echo strTranslate("Choose_file")?>" />
				<span id="fichero-alert" class="alert-message"></span>
				<input type="button" id="inputFile" name="inputFile" value="<?php echo strTranslate("Import_file")?>" class="btn btn-primary" />
			</form>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo strTranslate("Users")?></div>
				<div class="panel-body">
					<a href="?page=users"><?php echo strTranslate("Users_list")?></a><br />
					<a href="?page=user&act=new"><?php echo strTranslate("New_user")?></a><br />
					<a href="?page=cargas-users"><?php echo strTranslate("Users_import")?></a><br />
				</div>
			</div>
		</div>

	</div>
<?php
}
?>