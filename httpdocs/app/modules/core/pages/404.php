<?php
header("HTTP/1.0 404 Not Found");
header("Status: 404 Not Found");
?>
<div class="row inset row-top">
	<div class="col-md-12">
		<h1><big><?php e_strTranslate("404_page_not_found");?></big></h1>
		<hr />
		<h2><i class="fa fa-chain-broken fa-big"></i> <?php e_strTranslate("404_page_not_found_title");?></h2>
		<p class="text-muted"><?php e_strTranslate("404_page_not_found_info");?></p>
	</div>
</div>