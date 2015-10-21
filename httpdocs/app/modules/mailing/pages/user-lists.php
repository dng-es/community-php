<?php
//EXPORT CSV
mailingListsController::exportListAction(" AND user_list='".$_SESSION['user_name']."' ");

//EXPORT EMAILS CSV
mailingListsController::exportUserListAction(" AND id_list IN (SELECT id_list FROM mailing_lists WHERE user_list='".$_SESSION['user_name']."') ");

session::getFlashMessage( 'actions_message' ); 
mailingListsController::deleteAction();
$elements = mailingListsController::getListAction(20, $_SESSION['user_name']);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Massive_Mailing"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Mailing_lists"), "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>  
			<li><a href="user-list?act=new"><?php echo strTranslate("New_list")?></a></li>
			<li><a href="<?php echo $_REQUEST['page'];?>?export=true&q='.$elements['find_text'].'"><?php echo strTranslate("Export");?> CSV</a></li>
			<li><a href="user-messages">Mis comunicaciones enviadas</a></li>
		</ul>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th width="40px">&nbsp;</th>
					<th><?php echo strTranslate("Name");?></th>
					<th><?php echo strTranslate("Date");?></th>
					<th>Emails</th>
				</tr>
				<?php
				foreach($elements['items'] as $element):
					$total_emails = connection::countReg("mailing_lists_users"," AND id_list=".$element['id_list']." ");
					?>
					<tr>
					<td nowrap="nowrap">
						<a class="fa fa-edit icon-table" title="Ver/editar" onClick="location.href='user-list?act=edit&id=<?php echo $element['id_list'];?>';return false">
						</a>
						<a href="<?php echo $_REQUEST['page'];?>?exportm=true&id=<?php echo $element['id_list'];?>" class="fa fa-download icon-table" title="Descargar"></a>		
						<a class="fa fa-ban icon-table" title="Eliminar" onClick="Confirma('¿Seguro que deseas eliminar la lista?', 'user-lists?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_list'];?>'); return false;">
						</a>
					</td>
					<?php 
					echo '<td>'.$element['name_list'].'</td>';
					echo '<td>'.getDateFormat($element['date_list'], "SHORT").'</td>';
					echo '<td><span class="label label-success">'.$total_emails.'</span></td>'; 
					?>
					</tr> 
				<?php endforeach;?>
			</table>
		</div>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
				</span>
				<?php echo strTranslate("Mailing_lists")?></h4>
			<p>Estas son tus listas de envío.</p>
			<p class="text-center"><i class="fa fa-envelope-o fa-big"></i></p>
		</div>
	</div>
</div>