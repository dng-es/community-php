<?php
include_once ("app/core/loader.php");
ob_start();
include_once(pageRouter($page . ".php"));
$output = ob_get_contents();
ob_end_clean();

//TEMPLATE PAGE HEADERS
headers::PageHeader();

//TEMPLATE PAGE BODY
headers::PageBody($ini_conf,$page);

//PAGE BODY
echo $output;

//TEMPLATE PAGE FOOTER
footer::PageFooter();
?>