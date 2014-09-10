<?php
header("HTTP/1.0 404 Not Found");
header("Status: 404 Not Found");

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
?>

<div id="page-info">Página no encontrada</div>
<div class="row inset row-top">
	<div class="col-md-12">
		<h2><span class="fa fa-chain-broken" style="font-size: 30px"></span> La página que has solicitado no se encuentra.</h2>
		<p>Si estas seguro de que esta página existe y se ha producido un error, porfavor informa al administrador del problema.</p>
	</div>
</div>