<?php
function panelUser(){ 
	global $ini_conf; ?>
	<div class="panel panel-default panel-ranking">
		<div class="panel-body nopadding">
			<div class="row">
				<div class="col-md-8 col-xs-8 inset">
					<h4>
						<?php e_strTranslate("Hello");?> <?php echo $_SESSION['user_nick'];?>
					</h4>
					<small><?php e_strTranslate("Wellcome_to");?> <?php echo $ini_conf['SiteName'];?>.</small>
				</div>
				<div class="col-md-4 col-xs-4 label-success inset panel-color">
					<p class="text-center"><big><?php echo $_SESSION['user_puntos'];?></big><br />
						<?php echo ucfirst(strTranslate("APP_points"));?>
					</p>
				</div>
			</div>
		</div>
	</div>
<?php }

function panelConnected(){ 
	$filtroCanal = ($_SESSION['user_canal'] != "admin" ? " AND (connection_canal='".$_SESSION['user_canal']."' or connection_canal='admin') " : "");
	$users_conn = count(users::getUsersConn($filtroCanal));?>
	<div class="panel panel-default panel-ranking">
		<div class="panel-body nopadding">
			<div class="row">
				<div class="col-md-8 col-xs-8 inset">
					<h4>
						<?php e_strTranslate("Users_connected");?>
					</h4>
					<small><?php e_strTranslate("Go_to");?> <a href="users-conn"><?php e_strTranslate("Users_connected");?></a></small>
				</div>
				<div class="col-md-4 col-xs-4 label-info inset panel-color">
					<p class="text-center"><big><?php echo $users_conn;?></big><br />
						<?php e_strTranslate(($users_conn > 1 ? "Users" : "User"));?>
					</p>
				</div>
			</div>
		</div>
	</div>
<?php }
?>