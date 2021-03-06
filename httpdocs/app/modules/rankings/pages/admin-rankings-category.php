<?php
addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js",
					 "js/bootstrap.file-input.js", 
					 getAsset("rankings")."js/admin-ranking.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Listado de categorías"), "ItemUrl"=>"admin-rankings-categories"),
			array("ItemLabel"=>strTranslate("Rankings"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		rankingsController::createCategoryAction();
		rankingsController::updateCategoryAction();

		//OBTENER DATOS DEL Cuestionario
		$id_ranking = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		$ranking = rankingsController::getItemCategoryAction($id_ranking);
		
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form method="post" name="formRanking" id="formRanking" role="form" enctype="multipart/form-data">
					<input type="hidden" name="id_ranking" id="id_ranking" value="<?php echo $id_ranking;?>" />
					
					<div class="form-group">
						<label for="nombre"><?php e_strTranslate("Name");?>:</label>
						<input type="text" name="nombre" id ="nombre" class="form-control" value="<?php echo $ranking['ranking_category_name'];?>" />
						<div class="alert-message alert alert-danger" id="nombre-alert">Introduce el nombre del ranking</div>
					</div>

					<br />
					<button class="btn btn-primary" id="SubmitCuestionario" name="SubmitForm" type="submit"><?php e_strTranslate("Save_data");?></button>
					<br />
				<br />
				<?php if ($id_ranking > 0 ):?>
				<?php endif;?>
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>