<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

//EXPORT CSV
mailingController::exportListAction();

//EXPORT MESSAGE CSV
mailingController::exportMessageAction();

$elements = mailingController::getListAction(20);

?>
<div class="row row-top">
  	<div class="col-md-9"> 
  		<h1>Comunicaciones enviadas</h1>
  		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#">Total <b><?php echo $elements['total_reg'];?></b> registros</a></li>  
			<li><a href="?page=<?php echo $_REQUEST['page'];?>&export=true&q='.$elements['find_text'].'"><?php echo strTranslate("Export");?></a></li>
		</ul>
		<table class="table">
			<tr>
				<th width="40px">&nbsp;</th>
				<th>Asunto</th>
				<th>Estado</th>
				<th><?php echo strTranslate("Date");?></th>
				<th>Tot</th>
				<th>Env</th>
				<th>Pen</th>
				<th>Fallo</th>
			</tr>
			<?php
			foreach($elements['items'] as $element):
				$estado = $element['message_status']=='pending' ? 'label-warning' : 'label-success';
				?>
				<tr>
				<td nowrap="nowrap">
					<a href="?page=admin-messages&exportm=true&id=<?php echo $element['id_message'];?>" class="fa fa-download icon-table" title="Descargar"></a>		
				</td>
				<?php			
				echo '<td>'.$element['message_subject'].'</td>';
				echo '<td><a href="?page=admin-message-proccess&id='.$element['id_message'].'" class="label '.$estado.'">'.$element['message_status'].'</a></td>';
				echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_add'])).'</td>';
				echo '<td><span class="label">'.$element['total_messages'].'</span></td>'; 
				echo '<td><span class="label">'.$element['total_send'].'</span></td>';
				echo '<td><span class="label'.($element['total_pending']>0 ? " label-danger" : "").'">'.$element['total_pending'].'</span></td>';
				echo '<td><span class="label'.($element['total_failed']>0 ? " label-danger" : "").'">'.$element['total_failed'].'</span></td>';
				?>
				</tr> 
			<?php endforeach;?>
		</table>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>