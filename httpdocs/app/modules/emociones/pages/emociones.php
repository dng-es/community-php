<?php
	$elements = emocionesController::getListUserAction(20, " AND user_emocion='".$_SESSION['user_name']."' ");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Emotions"), "ItemUrl"=>"incentives-targets"),
		));
		?>
		<div class="row">
			<div class="col-md-12">

				<p><?php echo strtolower(strTranslate("Total"));?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></p>
				<div class="table-responsive">
					<table class="table" >
						<tr>
						<th width="40px"></th>
						<th>emoción</th>
						<th>motivo</th>
						<th>fecha</th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<img style="height: 50px" src="images/banners/<?php echo $element['image_emocion'];?>" />
							</td>					
							<td><?php echo $element['name_emocion'];?></td>
							<td><?php echo $element['desc_emocion_user'];?></td>
							<td><?php echo getDateFormat($element['date_emocion'], "LONG");?><br />
							<?php echo getDateFormat($element['date_emocion'], 'TIME');?>
							</td>
							</tr>  
						<?php endforeach; ?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>

			</div>
		</div>
	</div>
</div>