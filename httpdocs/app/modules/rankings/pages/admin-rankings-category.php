<?php

addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js",
					 "js/bootstrap.file-input.js", 
					 getAsset("rankings")."js/admin-ranking.js"));

//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

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

		session::getFlashMessage( 'actions_message' );
		rankingsController::createCategoryAction();
		rankingsController::updateCategoryAction();

		//OBTENER DATOS DEL Cuestionario
		$id_ranking = (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		if ($id_ranking>0){
			$ranking=rankingsController::getItemCategoryAction($id_ranking);
			$ranking_nombre = $ranking[0]['ranking_category_name'];
		}
		else{
			$ranking_nombre = "";
		}
		?>
		<form method="post" name="formRanking" id="formRanking" role="form" enctype="multipart/form-data">
			<input type="hidden" name="id_ranking" id="id_ranking" value="<?php echo $id_ranking;?>" />
			
			<div class="form-group">
				<label for="nombre"><?php echo strTranslate("Name");?>:</label>
				<input type="text" name="nombre" id ="nombre" class="form-control" value="<?php echo $ranking_nombre;?>" />
				<div class="alert-message alert alert-danger" id="nombre-alert">Introduce el nombre del ranking</div>
			</div>

			<br />
			<button class="btn btn-primary" id="SubmitCuestionario" name="SubmitForm" type="submit"><?php echo strTranslate("Save_data");?></button>
			<br />
		<br />
		<?php if ($id_ranking>0 ): ?>
		<?php endif; ?>
		</form>
	</div>
	<?php menu::adminMenu();?>
</div>