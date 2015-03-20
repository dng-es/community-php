<?php
addJavascripts(array("js/bootstrap.file-input.js", getAsset("mailing")."js/user-list.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Massive_Mailing"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Mailing_lists"), "ItemUrl"=>"user-lists"),
			array("ItemLabel"=>"Mi lista de envío", "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">
			<li><a href="user-list?act=new"><?php echo strTranslate("New_list")?></a></li>
			<li><a href="user-messages">Mis comunicaciones enviadas</a></li>
		</ul>
		<?php
		session::getFlashMessage( 'actions_message' );
		mailingListsController::createAction();
		mailingListsController::updateAction();
		$lista = mailingListsController::getItemAction();	
		?>
		<br />
		<form role="form" id="formData" name="formData" enctype="multipart/form-data" method="post" action="user-list?id=<?php echo $lista['id_list'];?>">
			<input type="hidden" id="id_list" name="id_list" value="<?php echo $lista['id_list'];?>" />

			<div class="form-group">
				<label for="asunto_message">Nombre de la lista:</label>
				<input class="form-control" type="text" id="name_list" name="name_list" value="<?php echo $lista['name_list']?>"/>
				<span id="name-alert" class="alert-message alert alert-danger"></span>
			</div> 

			<div class="form-group">
				<label for="nombre-fichero">Fichero:</label>
				<p>Selecciona un fichero Excel con los usuarios a cargar. El fichero deberá tener la estructura especificada, puedes descargar el fichero modelo <a href="docs/mailing_list.xls"><b><?php echo strTranslate("Click_here")?></b></a>.</p>
				<div class="row">
					<div class="col-md-3">
						<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary btn-block" title="Seleccionar fichero" />
					</div>	
					<div class="col-md-3">
						<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary">Guardar datos</button>
					</div>
				</div>		
			</div>		
		</form>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
				</span>
				<?php echo strTranslate("Mailing_lists")?></h4>
			<p>Estas son tus listas de envío.</p>
			<p class="text-center"><i class="fa fa-envelope-o fa-big"></i></p>
		</div>
	</div>
</div>