<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Info_Documents"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		$elements = campaignsController::getListAction(8);
		$i = 0;
		foreach($elements['items'] as $element): 
			$nun_docs = connection::countReg("info", " AND id_campaign=".$element['id_campaign']." ");
			if ($i==0) echo '<div class="row">';?>
			<div class="col-md-3">
				<div class="col-md-12 section full-height section-hover">
					<section>
						<a href="user-info-all?id=<?php echo $element['id_campaign'];?>" >
						<i class="fa fa-newspaper-o section-icon"></i><br />
							<h3><?php echo $element['name_campaign'];?></h3>
							<h5><?php echo $nun_docs;?> documentos</h5>
						</a>
					</section>
				</div>
			</div>
			<?php if ($i==3){
				echo '</div><br />';
				$i = 0;
			}
			else $i++; ?>
		<?php endforeach;?>
		<?php if ($i <= 3 and $i > 0) echo '</div>';?>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
		<br />
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<h4><?php e_strTranslate("Info_Documents");?></h4>
			<p>toda la documentación que necesitas, ordenada por categorías.</p>
			<p class="text-center"><i class="fa fa-newspaper-o fa-big"></i></p>
		</div>
	</div>
</div>