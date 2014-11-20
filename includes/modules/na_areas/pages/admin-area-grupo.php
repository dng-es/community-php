<?php
$na_areas = new na_areas();
$id_area=$_REQUEST['a'];
$id_grupo=$_REQUEST['g'];

//agregar usuario al area
if (isset($_POST['id_grupo_add']) and $_POST['id_grupo_add']!=""){
  $na_areas->insertGrupoUser($_POST['id_grupo_add'],$_POST['user_add']);}
//quitar usuario del area
if (isset($_POST['id_grupo_del']) and $_POST['id_grupo_del']!=""){
  $na_areas->deleteGrupoUser($_POST['id_grupo_del'],$_POST['user_del']);}

//usuarios del area
$usuarios_area = $na_areas->getAreasUsers(" AND id_area=".$id_area." AND username_area NOT IN (SELECT grupo_username FROM na_areas_grupos_users WHERE id_grupo=".$id_grupo.") ");

//uauarios del grupo
$usuarios_grupo = $na_areas->getGruposUsersUsuarios(" AND id_grupo=".$id_grupo." ");
?>
<div class="row row-top">
	<div class="col-md-9 inset">
		<ol class="breadcrumb">
			<li><a href="?page=home"><?php echo strTranslate("Home");?></a></li>
			<li><a href="?page=admin"><?php echo strTranslate("Administration");?></a></li>
			<li><a href="#"><?php echo strTranslate("Na_areas");?></a></li>
			<li><a href="?page=admin-areas"><?php echo strTranslate("Na_areas_list");?></a></li>
			<li class="active">Asignación de usuarios al grupo</li>
		</ol>
		<ul class="nav nav-pills navbar-default">     
			<li><a href="?page=admin-area&act=edit&id=<?php echo $id_area;?>"><i class="fa fa-mail-reply"></i> <?php echo strTranslate("Go_back");?></a></li>
		</ul>
		<div class="row">
			<div class="col-md-5">
				<form id="formData" name="formData" method="post" action="">
				<input type="hidden" name="id_grupo_add" id="id_grupo_add" value="<?php echo $id_grupo;?>" />
				<h3>usuarios</h3>
				<select class="grupos-container-cmb form-control" size="15" name="user_add" id="user_add">
				<?php
				foreach($usuarios_area as $usuario_area):
				  echo '<option value="'.$usuario_area['username_area'].'">'.$usuario_area['username_area'].'</option>';
				endforeach;
				?>
				</select>
			</div>

			<div class="col-md-1 center-block">
				<br />
				<br />
				<br />
				<br />
				<button class="btn btn-primary btn-block" type="submit">></button><br />
				</form>
				<form id="formData" name="formData" method="post" action="">
				<button class="btn btn-primary btn-block" type="submit"><</button>
			</div>

			<div class="col-md-5">
				<input type="hidden" name="id_grupo_del" id="id_grupo_del" value="<?php echo $id_grupo;?>" />
				<h3>usuarios del grupo</h3>
				<select class="grupos-container-cmb form-control" id="user_del" name="user_del" size="15">
				<?php
				foreach($usuarios_grupo as $usuario_grupo):
				  echo '<option value="'.$usuario_grupo['grupo_username'].'">'.$usuario_grupo['grupo_username'].'</option>';
				endforeach;
				?>
				</select>
				</form>
			</div>
		</div>
	</div>

	<?php menu::adminMenu();?>
</div>