<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Info_Documents"), "ItemUrl"=>"info-all"),
			array("ItemLabel"=>strTranslate("Search_results"), "ItemClass"=>"active"),
		));
		$filtro = ((isset($_REQUEST['find_reg']) and $_REQUEST['find_reg']!="") ? " AND titulo_info LIKE '%".sanitizeInput($_REQUEST['find_reg'])."%' " : "");
		$elements = infoController::getListAction(20, $filtro);

		?>
		<h3><?php e_strTranslate("Search_results");?>: <span class="text-primary"><em><?php echo sanitizeInput($_REQUEST['find_reg']);?></em> (<?php echo $elements['total_reg'];?> <?php echo strtolower(strTranslate("Items"));?>)</span></h3>
		<?php foreach($elements['items'] as $elements_info): 
		//$enlace = ($elements_info['download'] == 1 ? ' href="info-all?id='.$element['id_info'].'&exp='.$elements_info['file_info'].'" ' : ' target="_blank" href="'.$elements_info['file_info'].'" ');
		$enlace = ($elements_info['download'] == 1 ? ' href="docs/showfile.php?file='.$elements_info['file_info'].'&i='.$elements_info['id_info'].'" ' : ' target="_blank" href="'.$elements_info['file_info'].'" ');
		?>
			<div class="row">
				<div class="col-md-12">
					<h4><a title="<?php e_strTranslate("Download_file");?>" <?php echo $enlace;?> >
						<i class="fa fa-file-o"></i> <?php echo $elements_info['titulo_info'];?></a> <small>(<?php echo $elements_info['tipo']; ?>)</small><br /><small> <?php echo getDateFormat($elements_info['date_info'], "LONG"); ?></small></h4>
				</div>
			</div>
		<?php endforeach;?>

		<?php if ($elements['total_reg'] == 0):?>
		<div class="alert alert-warning">no existen documentos en la campaña</div>
		<?php endif;?>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>

	<div class="app-sidebar">
		<div class="panel-interior">
			<?php echo SearchForm(0, "info-search", "searchForm", strTranslate("Info_search"), strTranslate("Search"), "", "", "get");?>
			<h4><?php e_strTranslate("Info_Documents");?></h4>
			<p><?php e_strTranslate("Info_Documents_Text");?>.</p>
			<ul class="list-funny">
				<li><a href="info-all">volver a todos los documentos</a></li>
			</ul>
			<p class="text-center"><i class="fa fa-newspaper-o fa-big"></i></p>
		</div>
	</div>
</div>