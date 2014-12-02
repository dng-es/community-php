<?php
header("HTTP/1.0 404 Not Found");
header("Status: 404 Not Found");
?>
<div class="row inset row-top">
	<div class="col-md-12">
		<h1><?php echo strTranslate("404_page_not_found");?></h1>
		<h3><span class="fa fa-chain-broken" style="font-size: 30px"></span> <?php echo strTranslate("404_page_not_found_title");?></h3>
		<p><?php echo strTranslate("404_page_not_found_info");?></p>
	</div>
</div>