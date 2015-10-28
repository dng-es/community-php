<?php
infotopdfController::getHTMLtoPDF();

addJavascripts(array("js/jquery.numeric.js", 
					 "js/bootstrap-datepicker.js",
					 "js/bootstrap-datepicker.es.js", 
					 getAsset("infotopdf")."js/user-infotopdf.js"));
	
$elements = infotopdfController::getItemAction($_GET['id']);
$nombre_archivo = $elements[0]['file_info'];
$ext = strtoupper(substr($nombre_archivo, strrpos($nombre_archivo,".") + 1));
$nombre_sinext=substr($nombre_archivo,0,(strlen($nombre_archivo)-strlen($ext))-1);
$nombre_miniatura = "mini".$nombre_sinext.".jpeg";
$direccion = '';
$cod_postal = '';
$poblacion = '';
$provincia = '';
$telefono = '';
$web = '';
$email = '';
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Infotopdf_Documents"), "ItemUrl"=>"user-infotopdf-all"),
			array("ItemLabel"=>$elements[0]['titulo_info'], "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-heading">Datos del documento</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<label>Titulo del documento:</label> <?php echo $elements[0]['titulo_info'];?><br />
						<label>Campaña:</label> <?php echo $elements[0]['campana']; ?><br />
						<label>Tipo de documento:</label> <?php echo $elements[0]['tipo']; ?><br /><br />
						<form role="form" name="formDocumentos" id="formDocumentos" method="POST" action="" target="_blank">
							<input type="hidden" name="id_info" value="<?php echo $elements[0]['id_info'];?>" />
							<?php if (strpos($elements[0]['cuerpo_info'], '[USER_DIRECCION]') !== FALSE or strpos($elements[0]['cuerpo_info'], '[USER_DIRECCION_H]') !== FALSE): ?>
							<label for="calle_direccion">Calle:</label>
							<input type="text" class="form-control" id="calle_direccion" name="calle_direccion" value="<?php echo $direccion;?>" />

							<label for="postal_direccion">C. Postal:</label>
							<input type="text" class="form-control" id="postal_direccion" name="postal_direccion" value="<?php echo $cod_postal;?>" />

							<label for="poblacion_direccion">Población:</label>
							<input type="text" class="form-control" id="poblacion_direccion" name="poblacion_direccion" value="<?php echo $poblacion;?>" />

							<label for="provincia_direccion">Provincia:</label>
							<input type="text" class="form-control" id="provincia_direccion" name="provincia_direccion" value="<?php echo $provincia;?>" />

							<label for="telefono_direccion">Teléfono:</label>
							<input type="text" class="form-control" id="telefono_direccion" name="telefono_direccion" value="<?php echo $telefono;?>" />

							<label for="web_direccion">Web:</label>
							<input type="text" class="form-control" id="web_direccion" name="web_direccion" value="<?php echo $web;?>" />

							<label for="email_direccion">Email:</label>
							<input type="text" class="form-control" id="email_direccion" name="email_direccion" value="<?php echo $email;?>" />

							<?php endif; ?>

							<?php if (strpos($elements[0]['cuerpo_info'], '[CLAIM_PROMOCION]') !== FALSE): ?>
							<label for="claim_promocion">Mensaje:</label>
							<textarea class="form-control" id="claim_promocion" name="claim_promocion"></textarea>
							<?php endif; ?>

							<?php if (strpos($elements[0]['cuerpo_info'], '[DESCUENTO_PROMOCION]') !== FALSE): ?>
							<label for="descuento_promocion">Descuento %:</label>
							<input type="text" class="form-control numeric" id="descuento_promocion" name="descuento_promocion" />
							<?php endif; ?>

							<?php if (strpos($elements[0]['cuerpo_info'], '[DATE_PROMOCION]') !== FALSE): ?>
							<label for="date_promocion">Fecha fin promoción:</label>
							<div id="datetimepicker1" class="input-group date">
							    <input data-format="dd/MM/yyyy" readonly type="text" id="date_promocion" class="form-control" name="date_promocion"></input>
							    <span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
							<?php endif; ?>

							<br /><button type="sumbit" class="btn btn-primary">Generar PDF alta resolución</button>
						</form>
					</div>
					<div class="col-md-4">
						<img style="width:100%" src="docs/info/<?php echo $nombre_miniatura;?>" alt="banner" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-file fa-stack-1x fa-inverse"></i>
				</span>
				Comunicaciones impresas
			</h4>
			<a href="user-infotopdf-all" class="text-primary">Ir a todos los documentos</a>
			<p class="text-center"><i class="fa fa-file-pdf-o fa-big"></i></p>
		</div>
	</div>
</div>