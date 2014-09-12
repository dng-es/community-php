<?php
//CANCEL MESSAGE
mailingController::cancelMessageAction();

//EXPORT CSV
mailingController::exportListAction(" AND username_add='".$_SESSION['user_name']."' ");

//EXPORT MESSAGE CSV
mailingController::exportMessageAction(" AND id_message IN (SELECT id_message FROM mailing_messages WHERE username_add='".$_SESSION['user_name']."') ");

//EXPORT LINKS
mailingController::exportLinksAction(" AND username_add='".$_SESSION['user_name']."' ");

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

$elements = mailingController::getListAction(20, " AND username_add='".$_SESSION['user_name']."' ");
?>
<div class="row inset row-top">
  	<div class="col-md-12"> 
  		<h2>Comunicaciones enviadas</h2>
		<nav class="navbar navbar-default" role="navigation">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	            <ul class="nav navbar-nav">
	              <li><a href="?page=<?php echo $_REQUEST['page'];?>&export=true&q='.$elements['find_text'].'">Exportar CSV</a></li>
	            </ul>
			</div>
    	</nav>
    	<p>Total <b><?php echo $elements['total_reg'];?></b> registros</p>
		<table class="table">
			<tr>
				<th width="40px">&nbsp;</th>
				<th>Asunto</th>
				<th>Estado</th>
				<th>Creado</th>
				<th>Programado</th>
				<th>Tot</th>
				<th>Env</th>
				<th>Pen</th>
				<th>Fallo</th>
				<th>Visto</th>
				<th>Links</th>
			</tr>
			<?php
			foreach($elements['items'] as $element):
				$estado = $element['message_status']=='pending' ? 'label-warning' : ($element['message_status']=='cancelled' ? 'label-danger' : 'label-success');
				$date_scheduled = ($element['date_scheduled'] != null) ? (strftime(DATE_FORMAT_SHORT,strtotime($element['date_scheduled']))) : "";
				$total_views = connection::countReg("mailing_messages_users", " AND views>0 AND id_message=".$element['id_message']."");
				$total_links = connection::countReg("mailing_messages_links_users", " AND id_message=".$element['id_message']."");
				?>
				<tr>
				<td nowrap="nowrap">
					<a href="?page=user-messages&exportm=true&id=<?php echo $element['id_message'];?>" class="fa fa-download icon-table" title="Descargar"></a>
					<span class="fa fa-ban icon-table" 
					<?php if ($element['message_status']=='pending'):?>
						onClick="Confirma('¿Seguro que desea cancelar el envío?','?page=user-messages&del=true&id=<?php echo $element['id_message'];?>')" 
					<?php else: ?>
						disabled="disabled" 
					<?php endif;?>
					title="Cancelar" ></span>
				</td>
				<?php			
				echo '<td>'.$element['message_subject'].'</td>';
				echo '<td><a href="?page=admin-message-proccess&id='.$element['id_message'].'" class="label '.$estado.'">'.$element['message_status'].'</a></td>';
				echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_add'])).'</td>';
				echo '<td>'.$date_scheduled.'</td>';
				echo '<td><span class="label">'.$element['total_messages'].'</span></td>'; 
				echo '<td><span class="label">'.$element['total_send'].'</span></td>';
				echo '<td><span class="label'.($element['total_pending']>0 ? " label-danger" : "").'">'.$element['total_pending'].'</span></td>';
				echo '<td><span class="label'.($element['total_failed']>0 ? " label-danger" : "").'">'.$element['total_failed'].'</span></td>';
				echo '<td><span class="label">'.$total_views.'</span></td>';
				echo '<td><span class="label"><a href="?page=user-messages&exp=links&id='.$element['id_message'].'">'.$total_links.'</a></span></td>';
				?>
				</tr> 
			<?php endforeach;?>
		</table>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
</div>