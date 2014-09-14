<?php

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

addJavascripts(array("js/bootstrap.file-input.js", getAsset("mailing")."js/user-list.js"));
?>
<div class="row inset row-top">
	<div class="col-md-12">
		<h2>Listas de envío</h2>
		<ul class="nav nav-pills navbar-default">
			<li><a href="?page=user-list&act=new">Nueva lista</a></li>
			<li><a href="?page=user-lists">Ir a todas las listas</a></li>
			<li><a href="?page=user-messages">Mis comunicaciones enviadas</a></li>
		</ul>
		<?php
		session::getFlashMessage( 'actions_message' );
		mailingListsController::createAction();
		mailingListsController::updateAction();
		$lista = mailingListsController::getItemAction();	
		?>
		<br />
		<form role="form" id="formData" name="formData" enctype="multipart/form-data" method="post" action="?page=user-list&amp;id=<?php echo $lista['id_list'];?>">
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
</div>