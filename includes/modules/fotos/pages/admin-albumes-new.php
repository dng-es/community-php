<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

addJavascripts(array(getAsset("fotos")."js/admin-albumes-new.js"));

//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

$accion = (isset($_GET['act']) ? $_GET['act'] : "");
$accion1 = (isset($_GET['act1']) ? $_GET['act1'] : "");
$id = 0;

$fotos = new fotos();
$elements = array();

if ($accion=='edit'){ $id=$_GET['id'];}
if ($accion=='edit' and (isset($_GET['accion2']) and $_GET['accion2']=='ok') and $accion1!="del"){ UpdateData();}
elseif ($accion=='new' and (isset($_GET['accion2']) and $_GET['accion2']=='ok')){ $id=InsertData();$accion="edit";}

//AGREGAR IMAGEN AL ALBUM
if (isset($_POST['file_id'])){
	if ($fotos->updateFotoAlbum($_POST['file_id'],$_POST['id_album'])){
		ErrorMsg("Foto agregada correctamente");
	}
	else{
		ErrorMsg("Error al agregar foto");
	}
}

//CANCELAR IMAGEN
if (isset($_REQUEST['act2']) and $_REQUEST['act2']=='foto_ko'){$fotos->cambiarEstado($_REQUEST['idc'],2,0);}
$elements = fotosAlbumController::getItemAction($id); ?>
<div class="row row-top">
	<div class="col-md-9">
		<h1>Albumes de fotos</h1>
		<div class="panel panel-default">
			<div class="panel-heading">Datos del album</div>
			<div class="panel-body">
				<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="?page=admin-albumes-new&act=<?php echo $accion;?>&amp;id=<?php echo $id;?>&amp;accion2=ok" role="form">
					<label for="nombre">Nombre del album</label>
					<input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $elements[0]['nombre_album'];?>" placeholder="título del album" />
					<br />
					<p><input type="submit" name="SubmitData" class="btn btn-primary" value="Guardar datos" /></p>
				</form>
			</div>
		</div>
		<?php if ($accion == 'edit'){ ?>

		<div class="panel panel-default">
			<div class="panel-heading">Agregar imagen al álbum</div>
			<div class="panel-body">
				<form action="" method="post" role="form">
					<input type="hidden" name="id_album" value="<?php echo $id;?>" />
					<label for="file_id">Introduce el ID de la foto:</label>
					<input type="text" class="form-control entero" name="file_id" id="file_id" />
					<br />
					<button type="submit" class="btn btn-primary">Agregar</button>
				</form>
			</div>
		</div>

		<h3>Fotos incluidas en el álbum</h3>
		<?php 
		$fotos = new fotos();
		$elements = $fotos->getFotos("AND estado=1 AND id_album=".$id." ");
		if (count($elements)==0):?>
			<div class="alert alert-warning">No existen fotos en el álbum</div>
		<?php else: ?>
			<table class="table">
				<tr>
					<th width="40px">&nbsp;</th>
					<th><?php echo strTranslate("Title");?></th>
					<th><?php echo strTranslate("Date");?></th>
					<th><?php echo strTranslate("User");?></th>
					<th><span class="fa fa-heart"></span></th>
					<th><span class="fa fa-comment"></span></th>
				</tr>
				<?php foreach($elements as $element):
					$num_comentarios = $fotos->countReg("galeria_fotos_comentarios"," AND estado=1 AND id_file=".$element['id_file']." ");?>
					<tr>
						<td nowrap="nowrap">
						<?php echo '<span class="fa fa-ban icon-table" onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'\',
										\'?page=admin-albumes-new&act=edit&act2=foto_ko&id='.$id.'&idc='.$element['id_file'].'&u='.$element['user_add'].'\')" 
										title="'.strTranslate("Delete").'" />
									</span>';
							echo'</td>
									<td><a href="#" data-img="'.$element['name_file'].'" class="abrir-modal">'.$element['titulo'].'</a>
									</td>
									<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_foto'])).'</td>
									<td>'.$element['user_add'].'</td>
									<td>'.$element['fotos_puntos'].'</td>
									<td>';
							if ($num_comentarios==0){ echo $num_comentarios;}
							else{ echo '<a href="?page=admin-fotos-comentarios&id='.$element['id_file'].'&ida='.$id.'">'.$num_comentarios.'</a>';}?>
						</td>
					</tr> 
				<?php endforeach;?>
				</table>
				<!-- Modal -->
				<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-images">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel"><?php echo strTranslate("Photo");?></h4>
							</div>
							<div class="modal-body">
								<img class="galeria-fotos" style="width:100%" />
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			<?php
			endif;
		}
		?>	
	</div>
	<?php menu::adminMenu();?>
</div>
<?php
	

function UpdateData()
{
	$fotos = new fotos();
	if ($fotos->updateAlbum($_REQUEST['id'],$_POST['nombre'],$_SESSION['user_name'])) {
			OkMsg("Album modificado correctamente.");}
}

function InsertData()
{
	$fotos = new fotos();
	if ($fotos->InsertAlbum($_POST['nombre'],$_SESSION['user_name'])) {
			OkMsg("Entrada insertada correctamente.");}
	return fotos::SelectMaxReg("id_album","galeria_fotos_albumes"," AND activo=1 ");
}


?>