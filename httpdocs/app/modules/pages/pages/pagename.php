<?php
$pages = new pages();
if (isset($_REQUEST['id']) and $_REQUEST['id'] != ""){
	$id = $_REQUEST['id'];
	$pagename = $pages->getPages(" AND page_name='".$id."' ");?>
	<div class="row row-top">
		<div class="app-main">
			<?php echo $pagename[0]['page_content'];?>
		</div>
		<div class="app-sidebar">
			<div class="panel-interior hidden-xs hidden-sm"></div>
		</div>
	</div>
<?php } ?>