<?php
$pages = new pages();
if (isset($_REQUEST['id']) and $_REQUEST['id'] != ""){
	$id = $_REQUEST['id'];
	$pagename = $pages->getPages(" AND page_name='".$id."' ");
	templateload("menu", "pages");?>

	<div class="row row-top">
		<div class="app-main">
			<div class="panel">
				<div class="panel-body">
					<h2><?php echo $pagename[0]['page_title'];?></h2>
					<?php echo $pagename[0]['page_content'];?>
				</div>
			</div>
		</div>
		<div class="app-sidebar">
			<?php if ($pagename[0]['page_menu'] == 1) menuPages();?>
		</div>
	</div>
<?php } ?>