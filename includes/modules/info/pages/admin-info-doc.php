<?php

addJavascripts(array("js/bootstrap.file-input.js", getAsset("info")."js/admin-info-doc.js"));

$accion = (isset($_GET['act']) ? $_GET['act'] : "new");
$id = (isset($_GET['id']) ? $_GET['id'] : 0);
?>
<div class="row row-top">
	<div class="col-md-9 inset">
		<ol class="breadcrumb">
			<li><a href="?page=home"><?php echo strTranslate("Home");?></a></li>
			<li><a href="?page=admin"><?php echo strTranslate("Administration");?></a></li>
			<li><a href="?page=admin-info"><?php echo strTranslate("Info_Documents");?></a></li>
			<li class="active"><?php echo strTranslate("Edit");?> <?php echo strTranslate("Info_Document");?></li>
		</ol>
		<?php
		session::getFlashMessage( 'actions_message' ); 
		infoController::createAction();
		infoController::updateAction($id);
		$elements = infoController::getItemAction($id);

		$info = new info();
		$campaigns = new campaigns();
		?>
		<div class="panel panel-default">
			<div class="panel-heading">Datos del documento</div>
			<div class="panel-body">
				<form id="formData" role="form" name="formData" method="post" enctype="multipart/form-data" action="">
					<input type="hidden" name="id" value="<?php echo $id;?>" />
					<label>Titulo del documento:</label>
					<input class="form-control" type="text" id="info_title" name="info_title" value="<?php echo $elements[0]['titulo_info'];?>" />
					<span id="title-alert" class="alert-message alert alert-danger"><?php echo strTranslate("Required_field");?></span>
					<label>Canal del documento:</label>
					<select name="info_canal" id="info_canal" class="form-control">
					<option tp="1" value="todos" <?php if ($elements[0]['canal_info']=='todos'){ echo ' selected="selected" ';}?>>todos los canales</option>
					<?php ComboCanales($elements[0]['canal_info']); ?>
					</select>
					<label>Tipo de documento:</label>
					<select name="info_tipo" id="info_tipo" class="form-control">
					<?php
					$tipo_info = $info->getInfoTipos("");
					foreach($tipo_info as $tipo):
						echo '<option value="'.$tipo['id_tipo'].'" '.($tipo['id_tipo']==$elements[0]['tipo_info'] ? 'selected="selected"' : '').'>'.$tipo['nombre_info'].'</option>';    
					endforeach;
					?>
					</select>
					<label>Campaña de documento:</label>
					<select name="info_campana" id="info_campana" class="form-control">
					<?php
					$tipo_campana = $campaigns->getCampaigns("");
					foreach($tipo_campana as $campana):
						echo '<option value="'.$campana['id_campaign'].'" '.($campana['id_campaign']==$elements[0]['id_campaign'] ? 'selected="selected"' : '').'>'.$campana['name_campaign'].'</option>';    
					endforeach;
					?>
					</select>		
					<br />

					<label checkbox-inline>
						<input type="checkbox" id="download"  name="disabled_user" <?php echo $elements[0]['download']==1 ? "checked" : "";?>> Fichero descargable
					</label>

					<label>(si no marcas esta opción introducir URL del documento):</label>
					<input class="form-control" type="text" id="info_url" name="info_url" value="<?php echo $elements[0]['download']==1 ? "" : $elements[0]['titulo_info'];?>" />

					<div class="row">
						<div class="col-md-6">
							<label>Selecciona el documento:</label><br />
							<input name="info_file" id="info_file" type="file" class="btn btn-default" title="Seleccionar archivo" />
						</div>
						<div class="col-md-6">
						<?php
						if ($elements[0]['file_info']!=""){ 
							$enlace = ($elements[0]['download']==1 ? 'docs/showfile.php?file='.$elements[0]['file_info'] : $elements[0]['file_info']);
						  	echo '<a target="_blank" href="'.$enlace.'">Ver documento actual</a>';
						}

						?>
						</div>
					</div>
					 
					<span id="file-alert" class="alert-message"></span>
					<br /><br />
					<input type="button" name="SubmitData" id="SubmitData" class="btn btn-primary pull-right" value="<?php echo strTranslate("Save");?>" />
				</form>	
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>