<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

$info = new info();
$elements=$info->getInfoTipos("");
?>
<h1>Tu documentación</h1>

<?php foreach($elements as $element):?>
	<div class="col-md-6">
		<center><a href="?page=info-det&id=<?php echo $element['id_tipo'];?>"><img src="images/banners/<?php echo $element['foto_info'];?>" /></a></center>
	</div>	  	  	
<?php endforeach;?>