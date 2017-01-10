<?php 

function showUpdates(){ 
	$file = "UPGRADE.yaml";
	if (is_file($file)):
		$upgrade_notes = readYml($file);
		?>
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Control de versiones <small><i class="fa fa-archive pull-right text-muted"></i></small></h3></div>
			<div class="panel-body">
				<ul>
					<?php foreach($upgrade_notes['upgrades'] as $upgrade_note):?>
					<li>
						<span class="text-primary">Version: <?php echo $upgrade_note['version'];?></span> 
						<small><?php echo nl2br($upgrade_note['notes']);?></small>
					</li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>
	<?php else:
	//echo "No es file";
	endif;
}
?>