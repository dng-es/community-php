<?php
$elements = mailingTemplatesController::getListAction(6, "activos");
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Massive_Mailing"), "ItemUrl"=>"#"),
			array("ItemLabel"=>"Plantillas de comunicaciones", "ItemClass"=>"active"),
		));
		?>
    	<div class="row">
			<?php 
			$columna = 1;
			foreach($elements['items'] as $element): 
				if ($columna ==1){echo '<div class="row">';}
			?>	
				<div class="col-md-4">
					<a href="?page=user-message&id=<?php echo $element['id_template'];?>">
						<h3><?php echo $element['template_name'];?></h3>
						<p class="legend"><?php echo $element['tipo'];?> - <?php echo $element['campana'];?></p>
						<img src="images/mailing/<?php echo $element['template_mini'];?>" style="width:100%" />
					</a>
				</div>
			<?php 
				if ($columna == 3){echo '</div>';$columna=0;}
	     		$columna++;
			endforeach;
			if ($columna >2){echo '</div>';}
			?>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
				</span>
				Plantillas de comunicaciones</h4>
			<p>Puedes personalizar y enviar por email las comunicaciones. Crea tus listas de envío con los destinatarios de tu comunicaciones.</p>
			<p class="text-center"><i class="fa fa-envelope-o fa-big"></i></p>
		</div>
	</div>
</div>