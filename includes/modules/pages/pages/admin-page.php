<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=1;
function ini_page_header ($ini_conf) {?>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="js/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="<?php echo getAsset("pages");?>js/admin-page.js"></script>
<?php
}
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$perfiles_autorizados = array("admin");
	session::AccessLevel($perfiles_autorizados);

	session::getFlashMessage( 'actions_message' ); 
	pagesController::createAction();
	pagesController::updateAction();
	
	$page_name = isset($_REQUEST['p']) ? $_REQUEST['p'] : (isset($_POST['page_name']) ? $_POST['page_name'] : "");		

	$pages = new pages();
	$pagina= $pages->getPages(" AND page_name='".$page_name."' "); ?>
	
	<div class="row row-top">	
		<div class="col-md-9">
			<h1>Edición de páginas</h1>
			<form id="formData" name="formData" method="post" action="" role="form">
				<input type="hidden" name="page_name" id="page_name" value="<?php echo $page_name;?>" />

				<label for="page_name_new">Nombre de la página</label>
				<input type="text" name="page_name_new" id ="page_name_new" class="form-control" <?php echo $page_name!='' ? ' disabled="disabled" value="'.$page_name.'" ' : '' ?> />
				<br />
				<?php
					if ($page_name!=""){
						echo '<p>URL de la página: <a href="'.$ini_conf['SiteUrl'].'?page=pagename&id='.$page_name.'" target="_blank">'.$ini_conf['SiteUrl'].'?page=pagename&id='.$page_name.'</a></p>';
					}
				?>
				<label for="texto_destacado">Contenido de la página:</label></td></tr>
				<textarea cols="40" rows="5" id="page_content" name="page_content"><?php echo $pagina[0]['page_content'];?></textarea>
				<script type="text/javascript">
					var editor=CKEDITOR.replace('page_content',{customConfig : 'config-page.js'});
					CKFinder.setupCKEditor(editor, 'js/ckfinder/') ;
				</script>
				<br /><button class="btn btn-primary" id="SubmitData" name="SubmitData" type="submit">Guardar página</button>
			</form>	
		</div>
	<?php menu::adminMenu();?>
</div>
<?php 
}
?>