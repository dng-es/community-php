<?php
addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js", 
					 "js/jquery.numeric.js", 
					 getAsset("pages")."js/admin-page.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Pages"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Pages_list"), "ItemUrl"=>"admin-pages"),
			array("ItemLabel"=>strTranslate("Edit")." ".strTranslate("Pages"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' ); 
		pagesController::createAction();
		pagesController::updateAction();

		$page_name = isset($_REQUEST['p']) ? $_REQUEST['p'] : (isset($_POST['page_name']) ? $_POST['page_name'] : "");
		$pages = new pages();
		$pagina = $pages->getPages(" AND page_name='".$page_name."' ");

		$page_title = (isset($pagina[0]['page_title']) ? $pagina[0]['page_title'] : "");
		$page_content = (isset($pagina[0]['page_content']) ? $pagina[0]['page_content'] : "");
		$page_menu = (isset($pagina[0]['page_menu']) ? $pagina[0]['page_menu'] : 0);
		$page_order = (isset($pagina[0]['page_order']) ? $pagina[0]['page_order'] : 0);
		$page_user_menu = (isset($pagina[0]['page_user_menu']) ? $pagina[0]['page_user_menu'] : 0);
		$page_user_menu_order = (isset($pagina[0]['page_user_menu_order']) ? $pagina[0]['page_user_menu_order'] : 0);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" name="formData" method="post" action="" role="form">
					<input type="hidden" name="page_name" id="page_name" value="<?php echo $page_name;?>" />

					<div class="row">
						<div class="form-group col-md-4">
							<label for="page_name_new"><?php e_strTranslate("Name");?></label>
							<input type="text" name="page_name_new" id ="page_name_new" class="form-control" <?php echo $page_name != '' ? ' disabled="disabled" value="'.$page_name.'" ' : '' ?> />
						</div>

						<div class="form-group col-md-8">
							<label for="page_title"><?php e_strTranslate("Title");?></label>
							<input type="text" name="page_title" id ="page_title" class="form-control" value="<?php echo $page_title;?>" />
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-4">
							<label for="page_canal"><?php e_strTranslate("Channel");?>:</label>
							<select id="page_canal" name="page_canal" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>">
								<option value="">--Todos los canales--</option>
								<?php ComboCanales($page_canal);?>
							</select>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<div class="checkbox checkbox-primary">
									<input class="styled" type="checkbox" id="page_user_menu"  name="page_user_menu" <?php echo $page_user_menu == 1 ? "checked" : "";?>>
									<label for="page_user_menu"><?php e_strTranslate("show_user_menu");?></label>
								</div>
							</div>
							<div class="form-group">
								<label for="page_user_menu_order"><?php e_strTranslate("user_menu_position");?></label>
								<input type="text" name="page_user_menu_order" id ="page_user_menu_order" class="form-control numeric" value="<?php echo $page_user_menu_order;?>" />
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<div class="checkbox checkbox-primary">
									<input class="styled" type="checkbox" id="page_menu"  name="page_menu" <?php echo $page_menu == 1 ? "checked" : "";?>>
									<label for="page_menu">Submenu</label>
								</div>
							</div>
							<div class="form-group">
								<label for="page_order">Orden en el submenú</label>
								<input type="text" name="page_order" id ="page_order" class="form-control numeric" value="<?php echo $page_order;?>" />
							</div>
						</div>
			
					</div>
					
					<?php
						if ($page_name != ""){
							echo '<p>URL: <a href="'.$ini_conf['SiteUrl'].'/pagename?id='.$page_name.'" target="_blank">'.$ini_conf['SiteUrl'].'/pagename?id='.$page_name.'</a></p>';
						}
					?>
					<div class="form-group">
						<label for="page_content" class="sr-only">Contenido de la página</label>
						<textarea cols="40" rows="5" id="page_content" name="page_content"><?php echo $page_content;?></textarea>
						<script type="text/javascript">
							var editor=CKEDITOR.replace('page_content',{customConfig : 'config-page.js'});
							CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
						</script>
					</div>
					
					<div class="form-group">
						<button class="btn btn-primary" id="SubmitData" name="SubmitData" type="submit"><?php e_strTranslate("Save_data");?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>