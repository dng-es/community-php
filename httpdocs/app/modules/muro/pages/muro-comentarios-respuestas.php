<?php
addJavascripts(array(getAsset("muro")."js/muro-comentarios-responder-ajax.js"));

$muro = new muro();
if (isset($_REQUEST['id']) and $_REQUEST['id']!="" ){$id_comentario=$_REQUEST['id'];}
else {$id_comentario=0;}

//OBTENER DATOS DEL COMENTARIO
$filtro_comentario = " AND id_comentario=".$id_comentario." ";					   
$comentario_muro = $muro->getComentarios($filtro_comentario);   
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>"Respuestas en el muro", "ItemClass"=>"active"),
		));
		?>		
		<section>
			<b><?php echo $comentario_muro[0]['nick'];?> escribió:</b> <em><?php echo $comentario_muro[0]['comentario'];?></em>
		</section>
		<div id="cargando" style="display:none">
			<i class="fa fa-spinner fa-spin ajax-load"></i>
		</div>
		<div id="destino"></div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<?php
			//SOLO LOS COMERCIALES,FORMADORES Y ADMIN PUEDEN INSERTAR COMENTARIOS
			if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='usuario' or $_SESSION['user_perfil']=='formador' or $_SESSION['user_perfil']=='responsable' or $_SESSION['user_perfil']=='forosIns') : ?>
			<form id="form-responder-muro" name="form-responder-muro" action="" method="post" role="form">
				<input type="hidden" name="id_comentario_responder" id ="id_comentario_responder" value="<?php echo $id_comentario;?>" />
				<h4><?php echo strTranslate("New_comment_on_wall");?>:</h4>
				<textarea maxlength="160" class="form-control" id="texto-responder" name="texto-responder"></textarea>
				<button class="btn btn-primary btn-block" type="button" id="muro-submit" name="muro-submit"><?php echo strTranslate("Reply");?></button>
			</form>	
			<div id="result-muro"></div>
			<?php endif; ?>
		</div>
	</div>
</div>