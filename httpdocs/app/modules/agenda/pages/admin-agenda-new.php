<?php
//addCss(array("css/bootstrap-timepicker.min.css"));
addJavascripts(array("js/libs/ckeditor/ckeditor.js",
					"js/libs/ckfinder/ckfinder.js",
					"js/bootstrap.file-input.js",
					"js/bootstrap-datepicker.js",
					"js/bootstrap-datepicker.es.js",
					getAsset("agenda")."js/admin-agenda-new.js"));

templateload("cmbAgenda","agenda");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Diary_and_offers"), "ItemUrl"=>"admin-agenda"),
			array("ItemLabel"=>"Entrada en ".strTranslate("Diary_and_offers"), "ItemClass"=>"active"),
		));
		//si tiene id, se trata de la edición de una actividad.
		$id = (isset($_GET['id']) ? $_GET['id'] : 0);
		session::getFlashMessage( 'actions_message' );
		agendaController::createAction();
		agendaController::updateAction();
		$elements = agendaController::getItemAction($id);

		if (isset($elements[0])){
			$accion = "edit";
			$nombre = $elements[0]['titulo'];
			$descripcion = $elements[0]['descripcion'];
			$banner = $elements[0]['banner'];
			if (!(is_null($elements[0]['date_ini']))){$date_ini = date('d/m/Y',strtotime($elements[0]['date_ini']));}else{$date_ini ='';}
			if (!(is_null($elements[0]['date_fin']))){$date_fin = date('d/m/Y',strtotime($elements[0]['date_fin']));}else{$date_fin ='';}
			$fichero = $elements[0]['archivo'];
			$tipo =  $elements[0]['tipo'];
			$canal = $elements[0]['canal'];
			$activo = $elements[0]['activo'];
			$etiquetas = $elements[0]['etiquetas'];
		}
		else{
			$accion = "new";
			$nombre = "";
			$descripcion = "";
			$etiquetas = "";
			$canal = "";
			$date_ini = "";
			$date_fin = "";
		}

		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="" role="form">
				<input type="hidden" name="id" value="<?php echo $id;?>" />
				<div class="col-md-9 nopadding">
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="nombre" class="sr-only">Título de la entrada:</label>
							<input type="text" class="form-control form-big" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="título de la entrada" data-alert="Título de la actividad requerido" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 form-group">
							<select name="canal[]" id="canal" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" multiple data-actions-box="true" data-none-selected-text="<?php e_strTranslate("Choose_channel");?>" data-deselect-all-text="<?php e_strTranslate('deselect_all');?>"  data-select-all-text="<?php e_strTranslate('select_all');?>">
								<?php ComboCanales($canal);?>
							</select>
						</div>
						<div class="col-md-4 form-group">
							<select name="tipo" id="tipo" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%">
								<?php  ComboTipo($tipo);?>
							</select>
						</div>

						<div class="col-md-4 form-group">
							<div class="checkbox checkbox-primary">
								<input class="styled" type="checkbox" id="activo" value="1" name="activo" <?php echo $activo == 1 ? "checked" : "";?>>
								<label for="activo"><?php e_strTranslate("Active");?></label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="descripcion" class="sr-only">Cuerpo de la entrada:</label>
							<textarea cols="40" rows="5" name="descripcion"><?php echo $descripcion;?></textarea>
							<script type="text/javascript">
								var editor=CKEDITOR.replace('descripcion',{customConfig : 'config-blog.js'});
								CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
							</script>
						</div>
					</div>
					<div class="form-group col-md-6">
						<label class="control-label" for="date_ini">Inicio</label>
						<div id="datetimepicker1" class="input-group date">
							<input value="<?php echo $date_ini;?>" data-format="dd/MM/yyyy"  type="text" id="date_ini" class="form-control" name="date_ini" data-alert="<?php e_strTranslate("Required_date");?>"></input>
							<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
					<div class="form-group col-md-6">
						<label class=" control-label" for="date_fin">Fin</label>
						<div id="datetimepicker2" class="input-group date">
							<input value="<?php echo $date_fin;?>" data-format="dd/MM/yyyy"  type="text" id="date_fin" class="form-control" name="date_fin" data-alert="<?php e_strTranslate("Required_date");?>"></input>
							<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
					<div class=" col-md-3">
						<input type="submit" name="SubmitData" class="btn btn-primary btn-block" value="Guardar actividad" />
					</div>
				</div>
				<div class="col-md-3 nopadding">
					<div class="panel panel-default">
						<div class="panel-heading">Banner de la actividad</div>
						<div class="panel-body">
							<small><label for="banner">Selecciona el banner de la actividad:</small></label>
							<?php
							if (isset($elements[0]['banner']) and $elements[0]['banner'] != ""){
								echo '<img src="images/banners/'.$elements[0]['banner'].'" style="width: 100%" class="responsive" />';
							}
							?>
							<input type="file" name="banner" id="banner" class="btn btn-primary btn-block" title="seleccionar banner"  />
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">Voucher descargable</div>
						<div class="panel-body">

							<small><label for="fichero">Selecciona el documento:</label></small>
							<br /><input name="fichero" id="fichero" type="file" class="btn btn-primary btn-block" title="<?php e_strTranslate("Choose_file");?>" />
							<span id="file-alert" class="alert-message"></span>
							<?php
							if ($fichero != ""){
								$enlace = 'docs/showfile.php?file='.$fichero ;
								echo '<br><a target="_blank" href="'.$enlace.'"><b><u>Ver documento actual</u></b></a>';
							}
							?>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading">Etiquetas</div>
						<div class="panel-body">
							<p>Introduce las etiquetas de la entrada:</p>
							<input type="text" name="etiquetas" id="etiquetas" class="form-control" value="<?php echo $etiquetas;?>" />
							<br /><span class="text-muted">Etiquetas existentes: </span>
							<?php
							$agenda = new agenda();
							$categorias = $agenda->getCategorias("");
							foreach($categorias as $categoria):
								echo '<label>'.$categoria.'</label> ';
							endforeach;
							?>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>