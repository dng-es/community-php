<?php
/**
 * Print HTML credits list for a given users
 * @param	String 		$username 		Usuario del que se muestran los creditos asignados
 * @return	String						HTML list
 */
function creditosUser($username){
	$elements = usersCreditosController::getCreditosAction($username); ?>
	<h3><?php echo ucfirst(strTranslate("APP_Credits"));?> conseguidos</h3>
	<ul class="list-funny">
	<?php foreach($elements as $element): ?>
		<li><?php echo $element['credito_motivo'];?>: <small class="text-muted"><?php echo $element['puntuacion'];?> <?php e_strTranslate("APP_Credits");?></small></li>
	<?php endforeach; ?>
	</ul>
<?php } 

function creditsShow($username){ 
		$usuario = usersController::getPerfilAction($username);
		?>
		<div class="text-center credits-available inset">
			<p><?php echo ucfirst(strTranslate("APP_Credits_available"));?></p>
			<big><?php echo $usuario['creditos'];?></big>
		</div>
<?php } ?>