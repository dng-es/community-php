<?php
addJavascripts(array(getAsset("guides")."js/guides.js"));
addCss(array(getAsset("guides")."css/styles.css"));
templateload('cmbTypes', 'guides');

$usuario = usersController::getPerfilAction($_SESSION['user_name']);

session::getFlashMessage( 'actions_message' );
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Guides"), "ItemUrl"=>"guides"),
			array("ItemLabel"=> strTranslate("Guides_list"), "ItemClass"=>"active"),
		));
		?>
		<div class="context-ajax-ini row"></div>
		<div id="content-ajax" class="row"></div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<input type="hidden" name="guiaIni" id="guiaIni" value="<?php echo $usuario['perfil'];?>" />
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-folder fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Guides");?>
			</h4>
			<?php if($_SESSION['user_perfil'] == 'admin'): ?>
				<div class="form-group">
					<label for="tipo_guia"><?php e_strTranslate("Guide_type"); ?></label>
					<select name="tipo_guia" class="tipo_guia form-control">
						<?php ComboTypes($usuario['perfil']); ?>
					</select>
				</div>
			<?php endif; ?>
			<p class="text-center"><span class="fa fa-asterisk fa-big"></span></p>
		</div>
	</div>
</div>