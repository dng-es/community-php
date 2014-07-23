<?php
///////////////////////////////////////////////////////////////////////////////////
// FRAMEWORK_DA
// Author: David Noguera Gutierrez
// License: GPL
// Date: 2010-09-18
// Please don't remove these lines
///////////////////////////////////////////////////////////////////////////////////
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_select=5;
function ini_page_header ($ini_conf) {?>
<script language="JavaScript" src="js/bootstrap.file-input.js"></script>
<script type="text/javascript" src="<?php echo getAsset("infotopdf");?>js/admin-infotopdf-doc.js"></script>
<?php }
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$perfiles_autorizados = array("admin");
	session::AccessLevel($perfiles_autorizados);

	$accion=$_GET['act'];
	if ($accion=='edit'){ $id=$_GET['id'];}
	if ($accion=='edit' and $_GET['accion2']=='ok'){ UpdateData($id);}
	if ($accion=='new' and $_GET['accion2']=='ok'){ $id=InsertData();$accion="edit";}  

	ShowData($id,$accion);
}

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////
function ShowData($id,$accion)
{
  $info = new infotopdf();
  $campaigns = new campaigns();
  if ($id!=''){  
	$elements=$info->getInfo(" AND id_info=".$id);
  }  
?>
  <div id="page-info">Gestión de documentos</div>
  <div class="row inset row-top">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Datos del documento</div>
			<div class="panel-body">
				<form id="formData" role="form" name="formData" method="post" enctype="multipart/form-data" action="?page=admin-infotopdf-doc&act=<?php echo $accion;?>&amp;id=<?php echo $id;?>&amp;accion2=ok">
					<label>Titulo del documento:</label>
					<input class="form-control" type="text" id="info_title" name="info_title" value="<?php echo $elements[0]['titulo_info'];?>" />
					<span id="title-alert" class="alert-message"></span>
					<label>Canal del documento:</label>
					<select name="info_canal" id="info_canal" class="form-control">
					<option tp="1" value="todos" <?php if ($elements[0]['canal_info']=='todos'){ echo ' selected="selected" ';}?>>todos los canales</option>
					<?php ComboCanales($elements[0]['canal_info']); ?>
					</select>
					<label>Tipo de documento:</label>
					<select name="info_tipo" id="info_tipo" class="form-control">
					<?php
					$tipo_info = $info->getInfoTipos("");
					foreach($tipo_info as $tipo):
						echo '<option value="'.$tipo['id_tipo'].'">'.$tipo['nombre_info'].'</option>';    
					endforeach;
					?>
					</select>
					<label>Campaña de documento:</label>
					<select name="info_campana" id="info_campana" class="form-control">
					<?php
					$tipo_campana = $campaigns->getCampaigns("");
					foreach($tipo_campana as $campana):
						echo '<option value="'.$campana['id_campaign'].'" '.($campana['id_campaign']==$elements[0]['id_campaign'] ? 'selected="selected"' : '').'>'.$campana['name_campaign'].'</option>';    
					endforeach;
					?>
					</select>					
					<br />
					<div class="row">
						<div class="col-md-6">
							<label>Selecciona el documento:</label><br />
							<input name="info_file" id="info_file" type="file" class="btn btn-default" title="Seleccionar archivo" />
						</div>
						<div class="col-md-6">
						<?php
						if ($elements[0]['file_info']!=""){ 
							$nombre_archivo = $elements[0]['file_info'];
							$ext = strtoupper(substr($nombre_archivo, strrpos($nombre_archivo,".") + 1));
							$nombre_sinext=substr($nombre_archivo,0,(strlen($nombre_archivo)-strlen($ext))-1);
							$nombre_miniatura = "mini".$nombre_sinext.".jpeg";
						  	echo '<img style="width:100%;border:0" src="docs/info/'.$nombre_miniatura.'" alt="banner" />';
						}

						?>
						</div>
					</div>
					 
					<span id="file-alert" class="alert-message"></span>
					<br /><br />
					<input type="button" name="SubmitData" id="SubmitData" class="btn btn-primary pull-right" value="Guardar documentación" />
				</form>	
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Gestion de documentos</div>
			<div class="panel-body">
				<a href="?page=admin-infotopdf" class="comunidad-color">Ir a todos los documentos</a><br />
				<a href="?page=admin-infotopdf-doc&act=new" class="comunidad-color">Nuevo documento</a>
			</div>
		</div>
	</div>
</div>
<?php 
}
  

function insertData()
{
	$info = new infotopdf();
  $resultado=$info->insertInfo($_FILES['info_file'],$_POST['info_title'],$_POST['info_canal'],$_POST['info_tipo'],$_POST['info_campana']);
	if ($resultado=="") {
	OkMsg('Registro insertado correctamente.');
	$id=$info->SelectMaxReg("id_info","infotopdf","");
	return $id;
  }
  else{ErrorMsg($resultado);}
}

function UpdateData($id)
{
  $info = new infotopdf();
  if ($info->updateInfo($id,$_FILES['info_file'],$_POST['info_title'],$_POST['info_canal'],$_POST['info_tipo'],$_POST['info_campana'])) {
	OkMsg('Registro modificado correctamente.');}
  else
  {
	ErrorMsg('Error al modificar el documento.');
  }
}
?>