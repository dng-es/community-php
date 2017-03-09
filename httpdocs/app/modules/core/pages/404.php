<?php
header("HTTP/1.0 404 Not Found");
header("Status: 404 Not Found");
?>
<div class="row inset row-top">
	<div class="col-md-6 col-md-offset-3">
		<br />
		<br />
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>Error 404 - <?php e_strTranslate("404_page_not_found");?></h2>
			</div>
			<div class="panel-body text-center">
				<h3><i class="fa fa-chain-broken fa-big"></i><br /><?php e_strTranslate("404_page_not_found_title");?></h3>
				<p class="text-muted"><?php e_strTranslate("404_page_not_found_info");?></p>
			</div>
		</div>
	</div>
</div>