<?php

addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js",
					 "js/bootstrap.file-input.js", 
					 getAsset("infotopdf")."js/admin-infotopdf-doc.js"));

templateload("cmbCanales","users");
?>
<div class="row row-top">
	<div class="app-main">
		<?php

		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Infotopdf_Documents"), "ItemUrl"=>"admin-infotopdf"),
			array("ItemLabel"=>strTranslate("Edit")." ".strTranslate("Infotopdf_Documents"), "ItemClass"=>"active"),
		));

		$accion=$_GET['act'];
		$id ='';
		if ($accion == 'edit'){ $id=$_GET['id'];}
		if ($accion == 'edit' and (isset($_GET['accion2']) and $_GET['accion2'] == 'ok')) UpdateData($id);
		if ($accion == 'new' and (isset($_GET['accion2']) and $_GET['accion2'] == 'ok')){ $id = InsertData();$accion="edit";}

		$info = new infotopdf();
		$campaigns = new campaigns();
		$elements = infotopdfController::getItem();
		?>
		<div class="panel panel-default">
			<div class="panel-heading">Datos del documento</div>
			<div class="panel-body">
				<form id="formData" role="form" name="formData" method="post" enctype="multipart/form-data" action="admin-infotopdf-doc?act=<?php echo $accion;?>&amp;id=<?php echo $id;?>&amp;accion2=ok">
					<label>Titulo del documento:</label>
					<input class="form-control form-big" type="text" id="info_title" name="info_title" value="<?php echo $elements[0]['titulo_info'];?>" />
					<span id="title-alert" class="alert-message alert alert-danger"><?php e_strTranslate("Required_field");?></span>
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
						echo '<option value="'.$tipo['id_tipo'].'">'.$tipo['nombre_info'].'</option>';
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
					<div class="row">
						<div class="col-md-6">
							<label>Selecciona el documento:</label><br />
							<input name="info_file" id="info_file" type="file" class="btn btn-default" title="Seleccionar archivo" />
						</div>
						<div class="col-md-6">
						<?php
						if ($elements[0]['file_info'] != ""){ 
							$nombre_archivo = $elements[0]['file_info'];
							$ext = strtoupper(substr($nombre_archivo, strrpos($nombre_archivo,".") + 1));
							$nombre_sinext = substr($nombre_archivo,0,(strlen($nombre_archivo)-strlen($ext))-1);
							$nombre_miniatura = "mini".$nombre_sinext.".jpeg";
							echo '<img style="width:100%;border:0;height:auto" src="images/banners/'.$nombre_miniatura.'" alt="banner" />';
						}
						?>
						</div>
					</div>
					<span id="file-alert" class="alert-message"></span>

					<label for="cuerpo_info">Contenido de la plantilla:</label>
					<p>El contenido de la plantilla puede incluir las etiquetas [USER_LOGO], [USER_EMPRESA], [USER_DIRECCION], [DATE_PROMOCION], [CLAIM_PROMOCION], [DESCUENTO_PROMOCION].</p>
					<textarea cols="40" rows="5" id="cuerpo_info" name="cuerpo_info"><?php echo $elements[0]['cuerpo_info'];?></textarea>
					<script type="text/javascript">
						var editor=CKEDITOR.replace('cuerpo_info',{customConfig : 'config-page.js'});
						CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
					</script>

					<br /><br />
					<input type="button" name="SubmitData" id="SubmitData" class="btn btn-primary pull-right" value="Guardar documentación" />
				</form>	
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
<?php 

function insertData(){
	$info = new infotopdf();
	$resultado=$info->insertInfo($_FILES['info_file'], $_POST['info_title'], $_POST['info_canal'], $_POST['info_tipo'], $_POST['info_campana'], $_POST['cuerpo_info']);
	if ($resultado == ""){
		OkMsg('Registro insertado correctamente.');
		$id = connection::SelectMaxReg("id_info","infotopdf","");
		return $id;
	}
	else ErrorMsg($resultado);
}

function UpdateData($id){
	$info = new infotopdf();
	if ($info->updateInfo($id, $_FILES['info_file'], $_POST['info_title'], $_POST['info_canal'], $_POST['info_tipo'], $_POST['info_campana'], $_POST['cuerpo_info'])) 
		OkMsg('Registro modificado correctamente.');
	else
		ErrorMsg('Error al modificar el documento.');
}
?>