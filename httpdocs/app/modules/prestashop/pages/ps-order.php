<?php 
$id_product = (isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0);
prestashopOrdersController::newOrder($id_product);
?>