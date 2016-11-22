<?php
templateload("reply", "muro");

function panelMuro(){ ?>
	<div id="muro-insert">
		<form id="muro-form" name="coment-form" action="" method="post" role="form">
			<input type="hidden" name="tipo_muro" id ="tipo_muro" value="principal" />   
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-comment fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("New_comment_on_wall");?>
			</h4>
			<textarea maxlength="160" class="form-control" id="texto-comentario" name="texto-comentario"></textarea>
			<?php if ($_SESSION['user_canal'] == 'admin'):?>
			<select name="canal_comentario" id="canal_comentario" class="form-control">
			<?php ComboCanales();?>
			</select>
			<?php endif;?>
			<button class="btn btn-primary btn-block" type="button" id="muro-submit" name="coment-submit"><?php e_strTranslate("Send");?></button>
		</form>
	</div>
	<div id="result-muro"></div>
	<div id="destino" class="panel-muro">
			<div id="cargando" style="display:none"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
	</div>
	<?php replyMuro();?>
<?php } ?>