<?php
//EXPORT CSV
mailingListsController::exportListAction(" AND user_list='".$_SESSION['user_name']."' ");

//EXPORT EMAILS CSV
mailingListsController::exportUserListAction(" AND id_list IN (SELECT id_list FROM mailing_lists WHERE user_list='".$_SESSION['user_name']."') ");

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

session::getFlashMessage( 'actions_message' ); 
mailingListsController::deleteAction();
$elements = mailingListsController::getListAction(20, $_SESSION['user_name']);
?>
<div class="row inset row-top">
  	<div class="col-md-12"> 
  		<h1>Mis listas de envío</h1>
		<ul class="nav nav-pills navbar-default">
			<li><a href="?page=user-list&act=new">Nueva lista</a></li>
			<li><a href="?page=<?php echo $_REQUEST['page'];?>&export=true&q='.$elements['find_text'].'"><?php echo strTranslate("Export");?> CSV</a></li>
			<li><a href="?page=user-messages">Mis comunicaciones enviadas</a></li>
		</ul>
    	<p class="legend-table"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strTranslate("Items");?></p>
    	<div class="table-responsive">
			<table class="table">
				<tr>
					<th width="40px">&nbsp;</th>
					<th><?php echo strTranslate("Name");?></th>
					<th><?php echo strTranslate("Date");?></th>
					<th>Emails</th>
				</tr>
				<?php
				$mailing = new mailing();

				foreach($elements['items'] as $element):
					
					$total_emails = $mailing->countReg("mailing_lists_users"," AND id_list=".$element['id_list']." ");

					?>
					<tr>
					<td nowrap="nowrap">
						<a class="fa fa-edit icon-table" title="Ver/editar" onClick="location.href='?page=user-list&act=edit&id=<?php echo $element['id_list'];?>';return false">
						</a>
						<a href="?page=<?php echo $_REQUEST['page'];?>&exportm=true&id=<?php echo $element['id_list'];?>" class="fa fa-download icon-table" title="Descargar"></a>		
												<a class="fa fa-ban icon-table" title="Eliminar"
							onClick="Confirma('¿Seguro que deseas eliminar la lista?', '?page=user-lists&pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_list'];?>'); return false;">
						</a>
					</td>
					<?php			
					echo '<td>'.$element['name_list'].'</td>';
					echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_list'])).'</td>';
					echo '<td><span class="label label-success">'.$total_emails.'</span></td>'; 
					?>
					</tr> 
				<?php endforeach;?>
			</table>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
</div>
</div>