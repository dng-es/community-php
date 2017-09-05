<?php 
templateload("insert", "emociones");
?>
<div class="row row-top">

		<?php

		session::getFlashMessage('actions_message');
		emocionesController::createUserAction($_SERVER['REQUEST_URI']);
		?>
		<br />
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<?php insertEmocion();?>
			</div>
		</div>

</div>