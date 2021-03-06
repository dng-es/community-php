<?php
/**
 * Print HTML reply form
 * @return	String						HTML form panel
 */
function replyMuro(){ ?>
<div id="muro-responder" class="panel panel-default">
	<div id="muro-responder-cerrar"><span class="fa fa-times"></span></div>
	<div class="panel-heading"><?php e_strTranslate("Reply_comment");?></div>
	<div id="muro-responder-content" class="panel-body">
		<span id="muro-respuesta-comentario"></span>
		<form action="" name="form-responder-muro" id="form-responder-muro" method="post" role="form" class="form-horizontal">
			<input type="hidden" id="id_comentario_responder" name="id_comentario_responder" value="" />
			<input type="hidden" name="tipo_muro" id="tipo_muro" value="" />
			<textarea maxlength="160" class="form-control" id="texto-responder" name="texto-responder"></textarea>
			<button id="muro-responder-submit" class="btn btn-primary btn-block" type="button"><?php e_strTranslate("Reply");?></button>
		</form>
		<span id="muro-responder-result"></span>
	</div>
</div>
<?php } ?>