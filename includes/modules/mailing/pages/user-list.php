<?php

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

function ini_page_header ($ini_conf) {

?>	

<script language="JavaScript" src="js/bootstrap.file-input.js"></script>
<script language="JavaScript" src="<?php echo getAsset("mailing");?>js/user-list.js"></script>
<?php }
function ini_page_body ($ini_conf){
	echo '<div id="page-info">Listas de envío</div>';
	echo '<div class="row inset row-top">';
	echo '  <div class="col-md-9">';  

	session::getFlashMessage( 'actions_message' );
	mailingListsController::createAction();
	mailingListsController::updateAction();
	$lista = mailingListsController::getItemAction();	

	
	?>
	<div class="panel panel-default">
			<div class="panel-heading">Datos de la lista</div>
			<div class="panel-body">
				<form role="form" id="formData" name="formData" enctype="multipart/form-data" method="post" action="?page=user-list&amp;id=<?php echo $lista['id_list'];?>">
					<input type="hidden" id="id_list" name="id_list" value="<?php echo $lista['id_list'];?>" />

					<div class="form-group">
						<label for="asunto_message">Nombre de la lista:</label>
						<input class="form-control" type="text" id="name_list" name="name_list" value="<?php echo $lista['name_list']?>"/>
						<span id="name-alert" class="alert-message alert alert-danger"></span>
					</div> 

					<div class="form-group">
						<label for="nombre-fichero">Fichero:</label>
						<div class="row">
							<div class="col-md-3">
								<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary btn-block" title="Seleccionar fichero" />
							</div>	
						</div>		
					</div>																			
									
					<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary">Guardar datos</button>						

				</form>
		</div>
	</div>
	</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">Envío de comunicaciones</div>
					<div class="panel-body">
						<a href="?page=user-lists" class="comunidad-color">Ir a todas las listas</a><br />
						<a href="?page=user-list&act=new" class="comunidad-color">Nueva lista</a><br />
						<a href="?page=user-messages" class="comunidad-color">Mis comunicaciones enviadas</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php	
}
?>