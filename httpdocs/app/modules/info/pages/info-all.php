<?php
infoController::getZipAction();
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Info_Documents"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		$elements = campaignsController::getListAction(8);
		?>
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<p><?php echo strTranslate("Info_collapse");?></p>
						<p class="text-muted"><small>Total <?php echo strTranslate("Campaigns");?> <?php echo $elements['total_reg'];?></small></p>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php foreach($elements['items'] as $element): 
					$filtro = " AND i.id_campaign=" . $element['id_campaign'] . " ";
					$elements_info = infoController::getListAction(2000000, $filtro);
					$num_docs = $elements_info['total_reg'];
					?>
					<div class="panel panel-danger">
						<div class="panel-heading" role="tab" id="heading<?php echo $element['id_campaign'];?>">
							<h4 class="panel-title">
						        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $element['id_campaign'];?>" aria-expanded="false" aria-controls="collapse<?php echo $element['id_campaign'];?>">
									<i class="fa fa-folder"></i> 
									<?php echo $element['name_campaign'];?> 
									<small><?php echo $num_docs;?> documentos</small>
								</a>
							</h4>
						</div>
						<div id="collapse<?php echo $element['id_campaign'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $element['id_campaign'];?>">
							<div class="panel-body">
								<?php foreach($elements_info['items'] as $elements_info): 
								$enlace = ($elements_info['download']==1 ? ' href="?page=info-all&id='.$element['id_info'].'&exp='.$elements_info['file_info'].'" ' : ' target="_blank" href="'.$elements_info['file_info'].'" ');
								?>
									<div class="row">
										<div class="col-md-12">
											<h5><a title="<?php echo strTranslate("Download_file");?>" <?php echo $enlace;?> >
												<i class="fa fa-file-o"></i> <?php echo $elements_info['titulo_info'];?></a><br /><small><?php echo $elements_info['tipo']; ?> - <?php echo getDateFormat($elements_info['date_info'], "LONG"); ?></small></h5>
										</div>
									</div>
								<?php endforeach;?>
								<?php if ($num_docs == 0):?>
									<p class="text-muted">No existen documentos en esta <?php echo strtolower(strTranslate("Campaign"));?>.</p>
								<?php endif;?>
							</div>
						</div>
					</div>
				<?php endforeach;?>
				</div>
				<br />
			</div>
		</div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h4><?php echo strTranslate("Info_Documents");?></h4>
			<p>toda la documentación que necesitas, ordenada por <?php echo strtolower(strTranslate("Campaigns"));?>.</p>
			<p class="text-center"><i class="fa fa-newspaper-o fa-big"></i></p>
		</div>
	</div>
</div>