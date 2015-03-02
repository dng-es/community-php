<?php
$info = new infotopdf();
echo '<h1>Tu documentación</h1>';

//TODOS LOS DOCUMENTOS
$elements=$info->getInfoTipos("");
foreach($elements as $element):
	echo '<div class="col-md-6">
				<center><a href="infotopdf-det?id='.$element['id_tipo'].'"><img src="images/banners/'.$element['foto_info'].'" /></a></center>
			</div>';	  	  	
endforeach;
?>