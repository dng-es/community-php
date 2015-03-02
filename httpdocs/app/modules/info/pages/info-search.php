<?php
$filtro = ((isset($_POST['find_reg']) and $_POST['find_reg']!="") ? " AND titulo_info LIKE '%".sanitizeInput($_POST['find_reg'])."%' " : "");
$elements = infoController::getListAction(20, $filtro);
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Info_Documents"), "ItemUrl"=>"info-all"),
			array("ItemLabel"=>strTranslate("Search_results"), "ItemClass"=>"active"),
		));?>
		<h3><?php echo strTranslate("Search_results");?>: <span class="text-primary"><em><?php echo sanitizeInput($_POST['find_reg']);?></em> (<?php echo $elements['total_reg'];?> <?php echo strtolower(strTranslate("Items"));?>)</span></h3>
		<?php foreach($elements['items'] as $elements_info): 
		$enlace = ($elements_info['download']==1 ? ' href="info-all?id='.$element['id_info'].'&exp='.$elements_info['file_info'].'" ' : ' target="_blank" href="'.$elements_info['file_info'].'" ');
		?>
			<div class="row">
				<div class="col-md-12">
					<h4><a title="<?php echo strTranslate("Download_file");?>" <?php echo $enlace;?> >
						<i class="fa fa-file-o"></i> <?php echo $elements_info['titulo_info'];?></a> <small>(<?php echo $elements_info['tipo']; ?>)</small><br /><small><span class="text-primary">validez:</span> <?php echo getDateFormat($elements_info['validez'], "LONG"); ?></small></h4>
				</div>
			</div>
		<?php endforeach;  ?>

		<?php if ($elements['total_reg']==0):?>
		<div class="alert alert-warning">no existen documentos en la campaña</div>
		<?php endif;?>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>

	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<?php echo SearchForm(0, "info-search", "searchForm", strTranslate("Info_search"), strTranslate("Search"), "", "");?>
			<h4><?php echo strTranslate("Info_Documents");?></h4>
			<p><?php echo strTranslate("Info_Documents_Text");?>.</p>
			<ul class="list-funny">
				<li><a href="info-all">volver a todos los documentos</a></li>
			</ul>
			<p class="text-center"><i class="fa fa-newspaper-o fa-big"></i></p>
		</div>	
	</div>
</div>