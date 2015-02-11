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
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Rankings"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Ranking_users"), "ItemClass"=>"active"),
		));
		?>
		<p><?php echo strTranslate("Ranking_users_text");?>:</p><br />

<!-- 		<div class="row container-fade">
			<?php for ($i=0;$i<=5;$i++){ ?>
			<div class="col-md-2 inset">
				<?php if (isset($puntos[$i])):
				$foto = PATH_USERS_FOTO. ($puntos[$i]['foto'] != "" ? $puntos[$i]['foto'] : "user.jpg");?>
				<img src="<?php echo $foto;?>" style="width:100%" />
				<br />
				<br />
				<p class="text-center"><i class="fa fa-trophy fa-medium"><small><?php echo ($i+1);?></small></i></p>
				<p class="text-center"><small><?php echo $puntos[$i]['name'].' '.$puntos[$i]['surname'];?><br />
				<span class="text-muted"><?php echo $puntos[$i]['nombre_tienda'];?></span><br />
				<span class="text-primary"><?php echo $puntos[$i]['puntos'].' '.strTranslate("APP_points");?></span></small></p>
				<?php endif; ?>
			</div>
			<?php } ?>
		</div>  -->
		<div class="row">
			<div class="col-md-12">
				<br />
				<table class="table table-striped">
					<?php
					//LOS 10 PRIMEROS DEL RANKING
					//$total_usuarios = connection::countReg("users"," AND confirmed=1 AND disabled=0 ORDER BY username");
					//echo '	<p>Los mejores en el ranking, total de usuarios activos: '.$total_usuarios.'</p>';

					for ($i=0;$i<=14;$i++){	
						if (isset($puntos[$i])):
							$foto = PATH_USERS_FOTO. ($puntos[$i]['foto'] != "" ? $puntos[$i]['foto'] : "user.jpg"); ?>
							<tr>
								<td class="table-number" width="40px"><i class="fa fa-trophy fa-medium"><small><?php echo ($i+1);?></small></i></td>
								<td width="50px"><img src="<?php echo $foto;?>" width="50px" height="50px" /></td>
								<td>
									<?php echo $puntos[$i]['name'].' '.$puntos[$i]['surname'];?>
									<p class="text-muted"><?php echo $puntos[$i]['nombre_tienda'];?><br />
									<span><?php echo $puntos[$i]['puntos'].' '.strTranslate("APP_points");?></span></p>
								</td>
								<td><?php $puntos[$i]['nombre_tienda'];?></td>
							</tr>
						<?php endif;
					} ?>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<?php $foto = PATH_USERS_FOTO. ($puntos_user[0]['foto'] != "" ? $puntos_user[0]['foto'] : "user.jpg");?>
			<img src="<?php echo $foto;?>" class="user-perfil-img" />   
			<h3><?php echo strTranslate("Your_ranking");?> <small><?php echo $posicion_user;?></small></h3>
			<p><?php echo $puntos_user[0]['name'].' '.$puntos_user[0]['surname'];?><br />
			<?php echo $puntos_user[0]['nombre_tienda'];?><br />
			<?php echo $puntos_user[0]['puntos'];?> <?php echo strTranslate("APP_points");?>
			</p>
			<a href="?page=ranking-empresas" class="btn btn-primary btn-block"><?php echo strTranslate("Go_to_companies_ranking");?></a>
		</div>
	</div>
</div>