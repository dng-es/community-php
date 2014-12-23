<?php
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
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Wall"), "ItemClass"=>"active"),
		));
		?>
		<span id="tipo_muro" data-val="<?php echo $nombre_muro;?>"></span>
		<span id="pagina" data-val="<?php echo $pagina;?>"></span>
		<div id="destino">
			<div id="cargando" style="display:none"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
		</div>	
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<form id="muro-form" name="coment-form" action="" method="post" role="form">
				<input type="hidden" name="tipo_muro" id ="tipo_muro" value="principal" />	  
				<h4><?php echo strTranslate("New_comment_on_wall");?></h4>
				<textarea maxlength="160" class="form-control muro-texto" id="texto-comentario" name="texto-comentario"></textarea>
				<?php if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'):?>
				<select name="canal_comentario" id="canal_comentario" class="form-control">
					<?php ComboCanales();?>
				</select>
				<?php endif;?>
				<button class="muro-enviar btn btn-primary btn-block" type="button" id="muro-submit" value="Enviar" name="coment-submit">Enviar</button>   
			</form>	
			<br /><div id="result-muro"></div>
		</div>
	</div>
</div>
<?php replyMuro();?>