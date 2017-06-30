<?php 
function creditsShow($id_externo){ 
		$puntos = prestashopCreditsController::getCredits($id_externo);
		?>
		<div class="text-center credits-available inset">
			<p><?php echo ucfirst(strTranslate("APP_Credits_available"));?></p>
			<big><?php echo $puntos;?></big>
		</div>
<?php } ?>