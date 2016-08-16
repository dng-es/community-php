<?php
include_once ("app/core/loader.php");
ob_start();
include_once(pageRouter($page . ".php"));
$output = ob_get_contents();
ob_end_clean();

//Template page header
headers::PageHeader();

//Template page body
headers::PageBody($page);

//Template page body
echo $output;

//Template page footer
footer::PageFooter();
?>