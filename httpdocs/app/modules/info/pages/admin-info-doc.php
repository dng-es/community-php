<?php

addJavascripts(array("js/bootstrap.file-input.js", getAsset("info")."js/admin-info-doc.js"));

templateload("cmbCanales","users");

$accion = (isset($_GET['act']) ? $_GET['act'] : "new");
$id = (isset($_GET['id']) ? $_GET['id'] : 0);
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Info_Documents"), "ItemUrl"=>"admin-info"),
			array("ItemLabel"=>strTranslate("Edit")." ".strTranslate("Info_Document"), "ItemClass"=>"active"),
		));
		
		session::getFlashMessage( 'actions_message' ); 
		infoController::createAction();
		infoController::updateAction($id);
		$elements = infoController::getItemAction($id);

		$info = new info();
		$campaigns = new campaigns();
		?>
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo strTranslate("Edit")." ".strTranslate("Info_Document");?></div>
			<div class="panel-body">
				<form id="formData" role="form" name="formData" method="post" enctype="multipart/form-data" action="">
					<input type="hidden" name="id" value="<?php echo $id;?>" />
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<small><label for="info_title"><?php echo strTranslate("Title");?>:</label></small>
								<input class="form-control form-bigi" type="text" id="info_title" name="info_title" value="<?php echo $elements[0]['titulo_info'];?>" />
								<span id="title-alert" class="alert-message alert alert-danger"><?php echo strTranslate("Required_field");?></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<small><label for="info_canal"><?php echo strTranslate("Channel");?>:</label></small>
								<select name="info_canal" id="info_canal" class="form-control">
								<option tp="1" value="todos" <?php if ($elements[0]['canal_info']=='todos'){ echo ' selected="selected" ';}?>>todos los canales</option>
								<?php ComboCanales($elements[0]['canal_info']); ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<small><label for="info_tipo"><?php echo strTranslate("Type");?>:</label></small>
								<select name="info_tipo" id="info_tipo" class="form-control">
								<?php
								$tipo_info = $info->getInfoTipos("");
								foreach($tipo_info as $tipo):
									echo '<option value="'.$tipo['id_tipo'].'" '.($tipo['id_tipo']==$elements[0]['tipo_info'] ? 'selected="selected"' : '').'>'.$tipo['nombre_info'].'</option>';    
								endforeach;
								?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<small><label for="info_campana"><?php echo strTranslate("Campaign");?>:</label></small>
								<select name="info_campana" id="info_campana" class="form-control">
								<?php
								$tipo_campana = $campaigns->getCampaigns(" AND active=1 ");
								foreach($tipo_campana as $campana):
									echo '<option value="'.$campana['id_campaign'].'" '.($campana['id_campaign']==$elements[0]['id_campaign'] ? 'selected="selected"' : '').'>'.$campana['name_campaign'].'</option>';    
								endforeach;
								?>
								</select>
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">

								<small><label for="download">
									<input type="checkbox" name="download" id="download" <?php echo $elements[0]['download']==1 ? 'checked="checked"' : '';?>> Fichero descargable <span class="text-muted">(si no marcas esta opción introducir URL del documento)</span>
								</label></small>

								<input class="form-control" type="text" id="info_url" name="info_url" value="<?php echo $elements[0]['download']==1 ? "" : $elements[0]['titulo_info'];?>" />
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group">
								<small><label for="info_file">Selecciona el documento:
								<?php
								if ($elements[0]['file_info']!=""){ 
									$enlace = ($elements[0]['download']==1 ? 'docs/showfile.php?file='.$elements[0]['file_info'] : $elements[0]['file_info']);
									echo '<a target="_blank" href="'.$enlace.'">Ver documento actual</a>';
								}
								?>
								</label></small>
								<br /><input name="info_file" id="info_file" type="file" class="btn btn-primary" title="<?php echo strTranslate("Choose_file");?>" />
								<span id="file-alert" class="alert-message"></span>
							</div>
						</div>
					</div>

					 
					<br /><br />
					<input type="button" name="SubmitData" id="SubmitData" class="btn btn-primary pull-right" value="<?php echo strTranslate("Save_data");?>" />
				</form>	
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>