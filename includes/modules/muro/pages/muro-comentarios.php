<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

addJavascripts(array(getAsset("muro")."js/muro-comentarios-todos-ajax.js"));

templateload("reply","muro");

//OBTENCION DE LOS COMENTARIOS DEL MURO
$muro = new muro();	
if (isset($_REQUEST['id'])){$nombre_muro=$_REQUEST['id'];}
if (isset($_POST['tipo_responder'])){$nombre_muro=$_POST['tipo_responder'];}
if (isset($_POST['tipo_muro'])){$nombre_muro=$_POST['tipo_muro'];}
if ($nombre_muro==""){$nombre_muro="principal";}  
if (isset($_REQUEST['pag'])){$pagina=$_REQUEST['pag'];}
else{$pagina=1;}

?>
<div id="page-info">El muro</div>
<div class="row inset row-top">
	<div class="col-md-9">
		<span id="tipo_muro" value="<?php echo $nombre_muro;?>"></span>
		<span id="pagina" value="<?php echo $pagina;?>"></span>
		<div id="muro-insert">
			<form id="muro-form" name="coment-form" action="" method="post" role="form">
				<input type="hidden" name="tipo_muro" id ="tipo_muro" value="principal" />	  
				<p><?php echo strTranslate("New_comment_on_wall");?></p>
				<textarea maxlength="160" class="form-control muro-texto" id="texto-comentario" name="texto-comentario"></textarea>
				<?php if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'):?>
				<select name="canal_comentario" id="canal_comentario" class="form-control">
					<option value="comercial">Canal comerciales</option>
					<option value="gerente">Canal gerentes</option>
				</select>
				<?php endif;?>
				<button class="muro-enviar btn btn-primary" type="button" id="muro-submit" value="Enviar" name="coment-submit">Enviar</button>   
			</form>
		</div>	
		<div id="result-muro"></div>
		<div id="destino">
			<div id="cargando" style="display:none"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
		</div>	
	</div>
</div>
<?php replyMuro();?>