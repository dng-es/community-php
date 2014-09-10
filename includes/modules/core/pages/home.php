<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

addJavascripts(array(getAsset("muro")."js/muro-comentario-ajax.js", 
					 getAsset("users")."js/users-conn-ajax.js", 
					 getAsset("core")."js/home.js"));


templateload("reply","muro");
$plantillas = mailingTemplatesController::getListAction(4, "activos");
$documentos = infotopdfController::getListAction(3);
$ficheros = infoController::getListAction(4);
$campanas = campaignsController::getListTypesAction(3);
?>
<div class="row">	
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
      </ol>
      <!-- Carousel items -->
      <div class="carousel-inner">
		<?php $i=0; ?>
		<?php foreach($plantillas['items'] as $element): ?>
			 <?php if ($i==0): ?>
			 	<?php $i++;?>
			 	<div class="active item">
			 <?php else: ?>
				<div class="item">
			 <?php endif; ?>
			 	<a href="?page=user-message&act=new&id=<?php echo $element['id_template'];?>">
			 		<img style="width:100%" src="images/mailing/<?php echo $element['template_mini'];?>" alt="banner" />
			 	</a>
				<div class="carousel-caption">
					<h3><?php echo $element['template_name'];?></h3>
					<p><?php echo strTranslate("Email_customer_info");?></p>					
				</div>
			</div>
		<?php endforeach;?>   
      </div>
      <!-- Carousel nav -->
      <a class="carousel-control left" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="carousel-control right" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div>
</div>
<div class="row" style="background-color:#c0c0c0">
	<div class="col-md-6 nopadding">
		<div class="row" style="background-color:#c0c0c0;color:#555;border-top: 10px solid #f0f0f0">
			<div class="col-md-6" style="background-color:#ccc;">
				<h2 style="margin-left:40px">Tipos de campañas</h2>
				<?php foreach($campanas['items'] as $element): ?>
					<div class="inset">
						<h3><a href="?page=user-campaigns&f=<?php echo $element['id_campaign_type'];?>"><?php echo $element['campaign_type_name'];?></a></h3>
						<p class="legend"><?php echo shortText($element['campaign_type_desc'], 100);?></p>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="col-md-6">
				<h2><?php echo strTranslate("Users_connected");?></h2>
				<div id="mensajes">
					<div class="mensaje"><div id="cargando-users-conn"><i class="fa fa-spinner fa-spin ajax-load"></i></div></div>
				</div>
			</div>
		</div>		
	</div>
	<div class="col-md-6" style="border-top: 10px solid #f0f0f0">
		<div id="muro-insert">
			<form id="muro-form" name="coment-form" action="" method="post" role="form">
				<input type="hidden" name="tipo_muro" id ="tipo_muro" value="principal" />   
				<label for="texto-comentario"><?php echo strTranslate("New_comment_on_wall");?></label>
				<textarea maxlength="160" class="form-control" id="texto-comentario" name="texto-comentario"></textarea>
				<?php if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'):?>
				<select name="canal_comentario" id="canal_comentario" class="form-control">
				<option value="comercial">Canal comerciales</option>
				<option value="gerente">Canal gerentes</option>
				</select>
				<?php endif;?>
				<button class="btn btn-primary btn-sm" type="button" id="muro-submit" name="coment-submit"><?php echo strTranslate("Send");?></button>
			</form>
		</div>
		<div id="result-muro"></div>
		<div id="destino" class="panel-muro">
				<div id="cargando" style="display:none"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
		</div>
		<?php replyMuro();?>
	</div>
</div>

<div class="row" style="border-top: 10px solid #f0f0f0;">
	<div class="col-md-8" style="background-color: #e5e5e5">
		<div style="margin:0 2%; width:96%">
			<h2>Comunicaciones impresas</h2>
			<p>Imprime las comunicaciones para tus clientes. Descargalas en PDF de alta resolución.</p>
			<br />
			<div class="row">
				<?php foreach($documentos['items'] as $element): ?>
				<?php
					$nombre_archivo = $element['file_info'];
					$ext = strtoupper(substr($nombre_archivo, strrpos($nombre_archivo,".") + 1));
					$nombre_sinext=substr($nombre_archivo,0,(strlen($nombre_archivo)-strlen($ext))-1);
					$nombre_miniatura = "mini".$nombre_sinext.".jpeg";
				?>
				<div class="col-md-4">
					<div class="inset" style="background-color: #f0f0f0;min-height:160px;margin-bottom:20px;padding-top: 1px;border:0px solid #e5e5e5">
						<h4><a href="?page=user-infotopdf&id=<?php echo $element['id_info'];?>"><?php echo $element['titulo_info'];?></a></h4>
						<p class="legend"><?php echo $element['campana'];?> (<?php echo $element['tipo'];?>)</p>
						<a href="?page=user-infotopdf&id=<?php echo $element['id_info'];?>">
							<img style="width:100%;border:0" src="docs/info/<?php echo $nombre_miniatura;?>" alt="banner" />
						</a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="ver-mas">
			<a href="?page=user-infotopdf-all">
			<span class="fa fa-search"></span> ver todas las comunicaciones</a>
		</div>
	</div>

	<div class="col-md-4" style="background-color: #c8d6ec; color: #1d7493">
		<div style="text-align:center">
			<h2><a href="?page=user-templates" style="color:#1d7493">Comunicaciones email</a></h2>
			<p>Envía comunicaciones por email a tus contactos.</p><br />
			<div class="row">
				<div class="col-md-6">
					<div class="inset" style="text-align:center;">
						<a href="?page=user-templates&f=1" style="font-size:130px; margin-top:10px; line-height:100px; color: #1d7493">
							<i class="fa fa-briefcase"></i>
						</a>
						<h4><a href="?page=user-templates&f=1" style="color: #1d7493">Emails de Productos</a></h4>
					</div>
				</div>
				<div class="col-md-6">
					<div class="inset" style="text-align:center">
						<a href="?page=user-templates&f=2" style="font-size:130px; margin-top:10px; line-height:100px; color: #1d7493">
							<i class="fa fa-flask"></i>
						</a>
						<h4><a href="?page=user-templates&f=2" style="color: #1d7493">Emails de Servicios</a></h4>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>

<div class="row" style="background-color:#c0c0c0;color:#555;border-top: 10px solid #f0f0f0">
	<h2 style="margin-left:40px">Documentos de apoyo</h2>
	<p style="margin-left:40px">Toda la cocumentación que necesitas de cada campaña. <a href="?page=user-info-all">Ver todos los documentos</a></p>
</div>

<div class="row">
	<?php foreach($ficheros['items'] as $element): 
	$img_sec = "file";
	if ($element['tipo']=='Fichero'){$img_sec = "file";}
	if ($element['tipo']=='SMS'){$img_sec = "mobile";}
	if ($element['tipo']=='Video'){$img_sec = "video-camera";}
	if ($element['tipo']=='Audio'){$img_sec = "volume-up";}
	?>
	<div class="col-md-3" style="text-align:center;background-color:#ccc;">
		<div class="inset">
			<span class="fa fa-<?php echo $img_sec;?>" style="font-size:80px; color:#999"></span>
			<h3><a href="?page=user-info&id=<?php echo $element['id_info'];?>"><?php echo $element['titulo_info'];?></a></h3>
			<p class="legend">Categoría: <b><?php echo $element['tipo'];?></b> - 
			Campaña: <b><?php echo $element['campana'];?></b></p>
		</div>
	</div>
	<?php endforeach; ?>
</div>