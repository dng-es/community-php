<?php

addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js", 
					 getAsset("novedades")."js/admin-novedades.js"));
?>
<div class="row row-top">
	<div class="col-md-9 inset">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"?page=admin"),
			array("ItemLabel"=>strTranslate("News"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("News_update"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' ); 
		novedadesController::updateAction();
		?>
		<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="" role="form">

			<label><?php echo strTranslate("Channel");?>:</label>
			<select name="canal" id="canal" class="form-control">
			<?php ComboCanales();?>
			</select>

			<label checkbox-inline>
				<input type="checkbox" id="activo"  name="activo" checked="checked"> <?php echo strTranslate("Active");?>
			</label>
			
			<textarea cols="40" rows="5" name="texto"></textarea>
			<script type="text/javascript">
				var editor=CKEDITOR.replace('texto',{customConfig : 'config-page.js'});
				CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
			</script>
			<br />	
			<input type="submit" name="SubmitData" class="btn btn-primary" value="<?php echo strTranslate("Save_data");?>" />
			<br /><br />
		</form>	
	</div>
	<?php menu::adminMenu();?>
</div>