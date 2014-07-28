<?php
//EXPORT CSV
mailingListsController::exportListAction(" AND user_list='".$_SESSION['user_name']."' ");

//EXPORT EMAILS CSV
mailingListsController::exportUserListAction(" AND id_list IN (SELECT id_list FROM mailing_lists WHERE user_list='".$_SESSION['user_name']."') ");

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_select=5;

function ini_page_header ($ini_conf) {?>

<?php }
function ini_page_body ($ini_conf){

	session::getFlashMessage( 'actions_message' ); 
	mailingListsController::deleteAction();
	$elements = mailingListsController::getListAction(20, $_SESSION['user_name']);

	?>
	<div class="row less-width row-top">
	  	<div class="col-md-12"> 
	  		<div class="textuppercase blue more-marginbottom"><h1 class="font-title">Mis listas de envío</h1></div>
  			<nav class="navbar navbar-default" role="navigation">
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		            <ul class="nav navbar-nav">
		              <li><a href="?page=user-list&act=new">Nueva lista</a></li>
		              <li><a href="?page=<?php echo $_REQUEST['page'];?>&export=true&q='.$elements['find_text'].'">Exportar CSV</a></li>
		            </ul>
  				</div>
        	</nav>
        	<p>Total <b><?php echo $elements['total_reg'];?></b> registros</p>
			<table class="table">
				<tr>
					<th width="40px">&nbsp;</th>
					<th>Nombre</th>
					<th>Fecha</th>
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
			<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
		</div>
	</div>
	</div>
<?php
}
?>