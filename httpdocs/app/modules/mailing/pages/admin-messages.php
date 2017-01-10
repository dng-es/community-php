<?php
//EXPORT CSV
mailingController::exportListAction();

//EXPORT MESSAGE CSV
mailingController::exportMessageAction();

$elements = mailingController::getListAction(20);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Massive_Mailing"), "ItemUrl"=>"admin-messages"),
			array("ItemLabel"=>"Comunicaciones enviadas", "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-message"><?php e_strTranslate("New_message");?></a></li>
					<li><a href="<?php echo $_REQUEST['page'];?>?export=true&q='.$elements['find_text'].'"><?php e_strTranslate("Export");?></a></li>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th>Asunto</th>
							<th>Estado</th>
							<th><?php e_strTranslate("Date");?></th>
							<th>Tot</th>
							<th>Env</th>
							<th>Pen</th>
							<th>Fallo</th>
						</tr>
						<?php
						foreach($elements['items'] as $element):
							$estado = $element['message_status'] == 'pending' ? 'label-warning' : 'label-success';
							?>
							<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs"><a href="admin-messages?exportm=true&id=<?php echo $element['id_message'];?>" class="fa fa-download icon-table" title="Descargar"></a></button>
							</td>
							<?php 
							echo '<td>'.$element['message_subject'].'</td>';
							echo '<td><a href="admin-message-proccess?id='.$element['id_message'].'" class="label '.$estado.'">'.$element['message_status'].'</a></td>';
							echo '<td>'.getDateFormat($element['date_add'], "SHORT").'</td>';
							echo '<td><span class="label">'.$element['total_messages'].'</span></td>'; 
							echo '<td><span class="label">'.$element['total_send'].'</span></td>';
							echo '<td><span class="label'.($element['total_pending'] > 0 ? " label-danger" : "").'">'.$element['total_pending'].'</span></td>';
							echo '<td><span class="label'.($element['total_failed'] > 0 ? " label-danger" : "").'">'.$element['total_failed'].'</span></td>';
							?>
							</tr> 
						<?php endforeach;?>
					</table>
				</div>
				<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>