<?php
templateload("tipuser","users");

addJavascripts(array(getAsset("users")."js/ranking.js"));
	
$users = new users();
$puntos_user = $users->getUsers(" AND username='".$_SESSION['user_name']."' ");
$puntuacion_user = $puntos_user[0]['puntos'];
$posicion_user=users::posicionRanking($_SESSION['user_name']);
if ($_SESSION['user_perfil']=='admin'){$posicion_user=0;}

$puntos = $users->getUsers(" AND perfil<>'admin' ORDER BY puntos DESC,username ASC LIMIT 15");

?>
<div class="row inset row-top">
	<div class="col-md-9">
		<h1>Ranking usuarios</h1>
		<p>Cada una de tus aportaciones te ayudan a acumular puntos. ¿Cuántos puntos tienes?, ¿estás entre los primeros? descúbrelo en este ranking:</p><br />

		<div class="row">
			<?php for ($i=0;$i<=5;$i++){ ?>
			<div class="col-md-2">
				<?php if (isset($puntos[$i])):
				$foto = PATH_USERS_FOTO. ($puntos[$i]['foto'] != "" ? $puntos[$i]['foto'] : "user.jpg");?>
				<img src="<?php echo $foto;?>" style="width:100%" />
				<h4>Posicion: <small><?php echo ($i+1);?></small></h4>
				<p><?php echo $puntos[$i]['name'].' '.$puntos[$i]['surname'];?><br />
				<?php echo $puntos[$i]['nombre_tienda'];?><br />
				<?php echo $puntos[$i]['puntos'].' '.strTranslate("APP_points");?></p>
				<?php endif; ?>
			</div>
			<?php } ?>
		</div> 
		<div class="row">
			<div class="col-md-12">
				<br /><br />
				<table class="table">
					<?php
					//LOS 10 PRIMEROS DEL RANKING
					//$total_usuarios=$users->countReg("users"," AND confirmed=1 AND disabled=0 ORDER BY username");
					//echo '	<p>Los mejores en el ranking, total de usuarios activos: '.$total_usuarios.'</p>';

					for ($i=6;$i<=14;$i++){	
						if (isset($puntos[$i])):
							$foto = PATH_USERS_FOTO. ($puntos[$i]['foto'] != "" ? $puntos[$i]['foto'] : "user.jpg"); ?>
							<tr>
								<td class="table-number"><?php echo ($i+1);?></td>
								<td><img src="<?php echo $foto;?>" width="50px" height="50px" /></td>
								<td>
									<?php echo $puntos[$i]['name'].' '.$puntos[$i]['surname'];?><br />
									<?php echo $puntos[$i]['puntos'].' '.strTranslate("APP_points");?>
								</td>
								<td><?php $puntos[$i]['nombre_tienda'];?></td>
							</tr>
						<?php endif;
					} ?>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-3 lateral">
		<?php $foto = PATH_USERS_FOTO. ($puntos_user[0]['foto'] != "" ? $puntos_user[0]['foto'] : "user.jpg");?>
		<img src="<?php echo $foto;?>" class="user-perfil-img" />   
		<h3>Tu posición: <small><?php echo $posicion_user;?></small></h3>
		<p><?php echo $puntos_user[0]['name'].' '.$puntos_user[0]['surname'];?><br />
		<?php echo $puntos_user[0]['nombre_tienda'];?><br />
		<?php echo $puntos_user[0]['puntos'];?> <?php echo strTranslate("APP_points");?>
		</p>
		<a href="?page=ranking-empresas" class="btn btn-primary btn-block">Ir a ranking de empresas</a>
	</div>
</div>