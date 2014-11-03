<?php
//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);
	

$na_areas = new na_areas();
$id_area=$_REQUEST['a'];
$id_tarea=$_REQUEST['id'];

//agregar grupo a la tarea
if (isset($_POST['id_tarea_add']) and $_POST['id_tarea_add']!=""){
	$na_areas->insertGrupoTarea($_POST['id_grupo_add'],$_POST['id_tarea_add']);
	$id_area = $_POST['id_area'];
	$id_tarea = $_POST['id_tarea_add'];
}
//quitar grupo de la tarea
if (isset($_POST['id_tarea_del']) and $_POST['id_tarea_del']!=""){
	$na_areas->deleteGrupoTarea($_POST['id_grupo_del'],$_POST['id_tarea_del']);
	$id_area = $_POST['id_area'];
	$id_tarea = $_POST['id_tarea_del'];
}

//grupos de la tarea
$grupos_area = $na_areas->getGruposUsers(" AND id_area=".$id_area." AND id_grupo NOT IN (SELECT id_grupo FROM na_tareas_grupos WHERE id_tarea=".$id_tarea.") ");

//grupos del area
$grupos_tarea = $na_areas->getGruposTareas(" AND id_area=".$id_area." AND id_tarea=".$id_tarea." ");
?>

<div class="row row-top">
	<div class="col-md-9">
		<h1 class="inset">Asignación de grupos a la tarea</h1>
		<ul class="nav nav-pills navbar-default"> 
			<li><a href="?page=admin-area&act=edit&id=<?php echo $id_area;?>"><i class="fa fa-mail-reply"></i> <?php echo strTranslate("Go_back");?></a></li>
		</ul>
		<div class="row">
			<form id="formData" name="formData" method="post" action="">
				<div class="col-md-5">
					<input type="hidden" name="id_tarea_add" id="id_tarea_add" value="<?php echo $id_tarea;?>" />
					<input type="hidden" name="id_area" id="id_area" value="<?php echo $id_area;?>" />
					<h3>grupos</h3>
					
					<select class="grupos-container-cmb form-control" size="15" name="id_grupo_add" id="id_grupo_add">
					<?php
					foreach($grupos_area as $grupo_area):
						echo '<option value="'.$grupo_area['id_grupo'].'">'.$grupo_area['grupo_nombre'].'</option>';
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
					<input type="hidden" name="id_tarea_del" id="id_tarea_del" value="<?php echo $id_tarea;?>" />
					<input type="hidden" name="id_area" id="id_area" value="<?php echo $id_area;?>" />
					<h3>grupos de la tarea</h3>
					<select class="grupos-container-cmb form-control" id="id_grupo_del" name="id_grupo_del" size="15">
					<?php
					foreach($grupos_tarea as $grupo_tarea):
						echo '<option value="'.$grupo_tarea['id_grupo'].'">'.$grupo_tarea['grupo_nombre'].'</option>';
					endforeach;
					?>
					</select>
				</div>
			</form>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>