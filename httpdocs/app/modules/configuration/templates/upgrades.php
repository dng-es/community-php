<?php 

function showUpdates(){ 
	$file = "UPGRADE.yaml";
	if (is_file($file)):
		$upgrade_notes = readYml($file);
		?>
		<h3>Control de versiones</h3>
		<ul>
		<?php foreach($upgrade_notes['upgrades'] as $upgrade_note): ?>
		<li>
			<span class="text-primary">Version: <?php echo $upgrade_note['version'];?></span> 
			<small><?php echo nl2br($upgrade_note['notes']);?></small>
		</li>
		<?php endforeach;?>
	<?php else:
	echo "No es file";
	endif;
}
?>