<?php
$pages = new pages();
if (isset($_REQUEST['id']) && $_REQUEST['id'] != ""){
	$id = $_REQUEST['id'];
	$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND (page_canal='".$_SESSION['user_canal']."' OR page_canal='') " : "");
	$pagename = $pages->getPages($filtro_canal." AND page_name='".$id."' ");
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