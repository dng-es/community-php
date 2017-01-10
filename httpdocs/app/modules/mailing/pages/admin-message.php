<?php
addJavascripts(array("js/jquery.numeric.js", 
					 "js/libs/ckeditor/ckeditor.js", 
					 "js/bootstrap.file-input.js",
					 getAsset("mailing")."js/admin-message.js", 
					 getAsset("mailing")."js/admin-message-test.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Massive_Mailing"), "ItemUrl"=>"#"),
			array("ItemLabel"=>"Comunicaciones enviadas", "ItemUrl"=>"admin-messages"),
			array("ItemLabel"=>"Envío de comunicaciones", "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');

		$mailing = new mailing();
		$id=0;
		$accion = isset($_GET['act']) == true ? $_GET['act'] : "";
		$accion1 = isset($_GET['act1']) == true ? $_GET['act1'] : "";
		$accion2 = isset($_GET['accion2']) == true ? $_GET['accion2'] : "";
		
		if ($accion=='edit'){ $id=$_GET['id'];}
		//if ($accion=='edit' and $accion2=='ok' and $accion1!="del"){ UpdateData();}
		elseif ($accion=='new' and $accion2=='ok'){ 
			$id = mailingController::createAction();
			$accion = "edit";
		}
		else{
			$elements=$mailing->getMessages(" AND id_message=".$id." ");
			ShowData($elements,$id,$accion);
		}
		?>
	</div>
	<?php menu::adminMenu();?>
</div>


<?php
function ShowData($elements, $id, $accion){
	global $ini_conf;
	$mailing = new mailing();
	$na_areas = new na_areas();
	$users = new users();
	?>
	<div class="panel panel-default">
			<div class="panel-heading">Datos del mensaje</div>
			<div class="panel-body">
				<form role="form" id="formData" name="formData" enctype="multipart/form-data" method="post" action="admin-message?act=<?php echo $accion;?>&amp;id=<?php echo $id;?>&amp;accion2=ok">
					<h2>PASO 1: Datos generales</h2>
					<div class="form-group">
						<label for="email_message">Email remitente:</label>
						<input class="form-control" type="text" id="email_message" name="email_message" value="<?php echo $ini_conf['MailingEmail']?>"/>
						<span id="email-alert" class="alert-message alert alert-danger"></span>
					</div>

					<div class="form-group">
						<label for="nombre_message">Nombre completo remitente:</label>
						<input class="form-control" type="text" id="nombre_message" name="nombre_message" value="<?php echo $ini_conf['SiteName']?>"/>
						<span id="nombre-alert" class="alert-message alert alert-danger"></span>
					</div>

					<div class="form-group">
						<label for="asunto_message">Asunto del mensaje:</label>
						<input class="form-control" type="text" id="asunto_message" name="asunto_message" value=""/>
						<span id="asunto-alert" class="alert-message alert alert-danger"></span>
					</div>

					<?php if (isset($_REQUEST['id']) and $_REQUEST['id']>0):?>
						<input type="hidden" id="template_message" name="template_message" value="<?php echo $_REQUEST['id'];?>" />
					<?php else: ?>
					<div class="form-group">
						<label for="template_message">Plantilla del mensaje:</label>
						<select id="template_message" name="template_message" class="form-control">
							<option value="">--selecciona la plantilla--</option>
					<?php
					//obtener templates
					$templates = $mailing->getTemplates("");
					foreach($templates as $template):
						echo '<option value="'.$template['id_template'].'">'.$template['template_name'].'</option>';
					endforeach;

					?>		
						</select>
						<span id="template-alert" class="alert-message alert alert-danger"></span>
					</div>
					<?php endif; ?>

					<h2>PASO 2: Ficheros adjuntos</h2>
					<p>Si lo deseas, puedes adjuntar un fichero al mensaje.</p>
					<div class="form-group">
						<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary" title="Seleccionar adjunto" />
					</div>

					<h2>PASO 3: Cuerpo del mensaje</h2>
					<div class="form-group">
						<label for="texto_message">Texto mensaje.</label>
						<span>Puedes emplear las siguientes etiquetas: [USER_USERNAME], [USER_NAME], [USER_SURNAME], [USER_TIENDA].</span><br /><br />
						<textarea class="form-control" id="texto_message" name="texto_message" style="height:120px"></textarea>
						<span id="texto-alert" class="alert-message alert alert-danger"></span>
					</div>

					<h2>PASO 4: Lista de envío</h2>
					<label for="lista_message">Seleccionar una de las siguientes opciones:</label>
						<div class="radio">
							<label>
								<input type="radio" value="lista todos" id="lista_todos" name="lista_message" checked="checked"> Todos los usuarios
							</label>
						</div>

						<div class="radio">
							<label>
								<input type="radio" value="lista comerciales" id="lista_comerciales" name="lista_message"> Todos los comerciales
							</label>
						</div>

						<div class="radio">
							<label>
								<input type="radio" value="lista responsables" id="lista_responsables" name="lista_message"> Todos los responsables (tiendas propias + franquiciados)
							</label>
						</div>

						<div class="radio">
							<label>
								<input type="radio" value="lista regionales" id="lista_regionales" name="lista_message"> Todos los regionales
							</label>
						</div>	

						<div class="radio">
							<label>
								<input type="radio" value="lista sede" id="lista_sede" name="lista_message"> Todos los SEDE
							</label>
						</div>

						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" value="lista curso" id="lista_curso" name="lista_message"> Curso 
								</label>
							</div>
						</div>
						<select id="lista_curso_sel" name="lista_curso_sel" class="form-control">
							<option value="">--selecciona el curso--</option>
							<?php
							//obtener cursos/areas para agregar como lista
							$cursos = $na_areas->getAreas(" AND estado=1 ");
							foreach($cursos as $curso):
								echo '<option value="lista curso : '.$curso['id_area'].'">'.$curso['area_nombre'].'</option>';
							endforeach;
							?>
						</select>
						<span id="curso-alert" class="alert-message alert alert-danger"></span>

						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" value="lista tienda" id="lista_tienda" name="lista_message"> Tienda 
								</label>
							</div>
						</div>
						<select id="lista_tienda_sel" name="lista_tienda_sel" class="form-control">
							<option value="">--selecciona la tienda--</option>
							<?php
							//obtener tiendas para agregar como lista
							$tiendas = $users->getTiendas(" ORDER BY nombre_tienda");
							foreach($tiendas as $tienda):
								echo '<option value="lista tienda : '.$tienda['cod_tienda'].'">'.$tienda['nombre_tienda'].'</option>';
							endforeach;
							?>
						</select>
						<span id="tienda-alert" class="alert-message alert alert-danger"></span>

						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" value="lista tienda tipo" id="lista_tienda_tipo" name="lista_message"> Tipo Tienda 
								</label>
							</div>
						</div>
						<select id="lista_tienda_tipo_sel" name="lista_tienda_tipo_sel" class="form-control">
							<option value="">--selecciona tipo tienda--</option>
							<?php
							//obtener tipos tiendas para agregar como lista
							$tiendas_tipos = $users->getTiendasTipos("");
							foreach($tiendas_tipos as $tiendas_tipo):
								echo '<option value="lista tienda tipo : '.$tiendas_tipo['tipo_tienda'].'">'.$tiendas_tipo['tipo_tienda'].'</option>';
							endforeach;
							?>
						</select>
						<span id="tienda-tipo-alert" class="alert-message alert alert-danger"></span>

						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" value="lista usuarios" id="lista_usuarios" name="lista_message"> Usuarios
								</label>
								<span>. Introduce los usuarios separados por comas.</span>
							</div>
						</div>
						<input type="text" name="lista_users" id="lista_users" value="" class="form-control" />
						<span id="lista-users-alert" class="alert-message alert alert-danger"></span>

					<br />
					<h2>PASO 5: Crear mensaje</h2>
					<p>Para finalizar, pulsa en el botón "crear mensaje".</p>
					<hr />
					<div class="input-group">
						<input type="text" name="email_test" id="email_test" value="" class="form-control" />
						<div class="input-group-btn">
							<button type="button" id="SubmitTest" name="SubmitTest" class="btn btn-primary"><i class="glyphicon glyphicon-envelope"></i> Enviar prueba</button>	
						</div>
					</div>
					<hr />
					<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary">Crear mensaje</button>
				</form>
		</div>
	</div>
	<?php
}
?>