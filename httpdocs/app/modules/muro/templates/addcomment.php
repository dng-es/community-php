<?php
templateload("cmbCanales", "users");

/**
 * Print HTML combo
 * @param	String 		$tipo_muro 		Tipo de muro en el que se insertaran los datos
 * @param	Boolean		$canal_sel 		Para mostrar o no el selector de canales
 * @param	String 		$title_label 	Texto del título del panel
 * @return	String						HTML panel
 */
function addComment($tipo_muro = 'principal', $canal_sel = true, $title_label = "New_comment_on_wall"){ ?>
	<h4>
		<span class="fa-stack fa-sx">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-share-alt fa-stack-1x fa-inverse"></i>
		</span>
		<?php e_strTranslate($title_label);?>
	</h4>
	<form id="muro-form" name="coment-form" action="" method="post" role="form">
		<input type="hidden" name="tipo_muro" id ="tipo_muro" value="<?php echo $tipo_muro;?>" />
		<textarea maxlength="160" class="form-control muro-texto" id="texto-comentario" name="texto-comentario" data-alert="<?php e_strTranslate("Required_field");?>"></textarea>
		<?php if ($_SESSION['user_canal'] == 'admin' && $canal_sel == true):?>
		<select name="canal_comentario" id="canal_comentario" class="form-control">
			<?php ComboCanales();?>
		</select>
		<?php endif;?>
		<button class="muro-enviar btn btn-primary btn-block" type="button" id="muro-submit" value="Enviar" name="coment-submit"><?php e_strTranslate("Send");?></button>
	</form>
<?php } ?>