<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_select=5;
function ini_page_header ($ini_conf) {?>

<?php }
function ini_page_body ($ini_conf){

	$elements = infoController::getListAction(20);
	?>
	<div id="page-info">Documentación</div>
	<div class="row inset row-top">
		<div class="col-md-12">
			<table class="table">
				<tr>
					<th>Documento</th>
					<th>Tipo</th>
					<th>Campaña</th>
				</tr>
				<?php foreach($elements['items'] as $element): ?>
				<tr>   
					<td><a href="?page=user-info&id=<?php echo $element['id_info'];?>"><?php echo $element['titulo_info'];?></a></td>
					<td><?php echo $element['tipo'];?></td>
					<td><?php echo $element['campana'];?></td>
				</tr>   
				<?php endforeach;  ?>
			</table>
			<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
		</div>
	</div>
<?php
}
?>