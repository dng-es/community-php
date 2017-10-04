<?php 
session::getFlashMessage('actions_message');

addJavascripts(array(getAsset("emociones")."js/emociones-insert.js"));
addCss(array(getAsset("emociones")."css/styles.css"));
templateload("insert", "emociones");
?>
<div class="row row-top">
	<br />
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h2 class="text-center"><?php e_strTranslate("Emotions_question");?></h2>
			<hr />
			<?php insertEmocion();?>
		</div>
	</div>
</div>