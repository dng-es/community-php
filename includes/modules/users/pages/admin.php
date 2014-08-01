<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=1;
function ini_page_header ($ini_conf) {?>

<?php }
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$perfiles_autorizados = array("admin");
	session::AccessLevel($perfiles_autorizados);

	$num_users = number_format(connection::countReg("users", " AND disabled=0 AND registered=1 AND confirmed=1 "), 0, ',', '.');
	$num_access = number_format(connection::countReg("accesscontrol", " AND webpage<>'Inicio de sesion' "), 0, ',', '.');
	?>

	<div class="row row-top">
		<div class="col-md-9">
			<h1>Administración de la comunidad</h1>
			<br />
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body">
							<ul>
								<li>Total usuarios activos: <b><?php echo $num_users;?></b></li>
								<li>Perfiles activos: <b></b></li>
								<li>Canales activos: <b></b></li>
								<li>Páginas visitadas: <b><?php echo $num_access;?></b></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-6">
									
				</div>
			</div>
		</div>
		<?php menu::adminMenu();?>
	</div>
	<?php
}
?>