<?php
$pages = new pages();
if (isset($_REQUEST['id']) and $_REQUEST['id']!=""){
	$id = $_REQUEST['id'];
	$page = $pages->getPages(" AND page_name='".$id."' ");?>

	<div class="row row-top">
		<div class="col-md-11 inset">
			<?php echo $page[0]['page_content'];?>
		</div>
	</div>

<?php } ?>