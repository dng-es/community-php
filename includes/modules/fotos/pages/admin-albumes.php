<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=1;
function ini_page_header ($ini_conf) {?>

<?php }
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$session = new session();
	$perfiles_autorizados = array("admin");
	$session->AccessLevel($perfiles_autorizados);
	
	$fotos = new fotos();  
	$find_reg = "";
	$filtro = " AND activo=1 ORDER BY id_album DESC";
	if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') { $fotos->cambiarEstadoAlbum($_REQUEST['id'],0);}

	//SHOW PAGINATOR
	$reg = 35;
	if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
	if (!isset($pag)) { $inicio = 0; $pag = 1;}
	else { $inicio = ($pag - 1) * $reg;}
	$total_reg = $fotos->countReg("galeria_fotos_albumes",$filtro);

	
	//EXPORT EXCEL - SHOW AND GENERATE
	if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
		$elements=$fotos->getFotosAlbumes($filtro);
		$file_name='exported_file'.date("YmdGis");
		ExportExcel('./docs/export/',$file_name,$elements);}

	$elements=$fotos->getFotosAlbumes($filtro.' LIMIT '.$inicio.','.$reg);
	?>
	<div class="row row-top">
		<div class="col-md-9">
			<div id="page-info">Albumes de fotos</div>
			<div class="btn-group"> 
				<a href="?page=admin-albumes-new&act=new" title="<?php echo strTranslate("New_album");?>" class="btn btn-default"><?php echo strTranslate("New_album");?></a>  
			</div>
			<br /><br /> 
			<table class="table">
				<tr>
					<th width="40px"></th>
					<th>Álbum</th>
					<th><?php echo strTranslate("Date");?></th>
					<th><?php echo strTranslate("User");?></th>
					<th><?php echo strTranslate("Photos");?></th>
				</tr>
				<?php foreach($elements as $element):
				$num_fotos = $fotos->countReg("galeria_fotos", "AND estado=1 AND id_album=".$element['id_album']." ");
				echo '<tr>';
				echo '<td nowrap="nowrap">
						<span class="fa fa-edit icon-table" title="Ver/editar album"
							onClick="location.href=\'?page=admin-albumes-new&act=edit&id='.$element['id_album'].'\'">
						</span>
						
						<span class="fa fa-ban icon-table" title="'.strTranslate("Delete").'"
							onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'\',
							\'?page=admin-albumes&pag='.$pag.'&act=del&id='.$element['id_album'].'\')">
						</span>
					 </td>';
							
				echo '<td>'.$element['nombre_album'].'</td>';
				echo '<td>'.strftime(DATE_FORMAT_SHORT, strtotime($element['date_album'])).'</td>';
				echo '<td>'.$element['username_album'].'</td>';
				echo '<td>'.$num_fotos.'</td>';
				echo '</tr>';   
				endforeach;?>
			</table>
			<?php Paginator($pag,$reg,$total_reg, 'admin-albumes', strTranslate("Users"), $find_reg);?>
		</div>
		<?php menu::adminMenu();?>
	</div>
	<?php
}
?>