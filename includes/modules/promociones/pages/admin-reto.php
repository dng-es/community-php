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
$menu_admin=1;
templateload("player","videos");

function ini_page_header ($ini_conf) {?>
  <script language="JavaScript" src="js/bootstrap.file-input.js"></script>
	<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="js/bootstrap-datepicker.es.js"></script>
  <script type="text/javascript" src="js/jwplayer/jwplayer.js"></script>
  <script type="text/javascript" src="<?php echo getAsset("promociones");?>js/admin-reto.js"></script>
	<LINK rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css" /> 
<?php }
function ini_page_body ($ini_conf){
  //CONTROL NIVEL DE ACCESO
  $session = new session();
  $perfiles_autorizados = array("admin");
  $session->AccessLevel($perfiles_autorizados);
  $promociones = new promociones();
  

  echo '<div id="page-info">Administración del reto</div>';
  echo '<div class="row inset row-top">
        <div class="col-md-9">'; 

  if (isset($_REQUEST['act'])) {$accion=$_REQUEST['act'];}
  else {$accion='edit';}
  if ($accion=='edit' and $_GET['accion2']=='ok'){ UpdateData();}
  elseif ($accion=='new'){ InsertData();$accion="edit";}
  elseif ($accion=='del_v'){ $promociones->deleteFile($_REQUEST['id'],$_REQUEST['n']);}
  elseif ($accion=='video_ok'){
		$promociones->insertPromocionVideo($_POST['id-promocion'],$_FILES['nombre-fichero'],$_POST['titulo-fichero'],$_POST['descripcion-fichero']);}

  
  $filtro=" AND active=1 ";
  if ($accion!='new_reto') {$elements=$promociones->getPromociones($filtro);}
  ShowData($elements,$accion);
}

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////
function ShowData($elements,$accion)
{
	echo '<h3>Estos son los datos del reto. Puedes modicarlos.</h3>';
?>


<form id="formData" name="formData" enctype="multipart/form-data" method="post" action="?page=admin-reto&act=<?php echo $accion;?>&amp;accion2=ok" role="form">
<input type="hidden" id="id_promocion" name="id_promocion" value="<?php echo $elements[0]['id_promocion'];?>" />
<table cellspacing="0" cellpadding="2px">
  <tr><td><label for="nombre-reto">Nombre reto:</label></td></tr>
  <tr><td>
    <input type="text" id="nombre-reto" name="nombre-reto" class="form-control"  value="<?php echo $elements[0]['nombre_promocion'];?>" />
    <span id="nombre-reto-alert" class="alert-message alert alert-danger"></span>
    <input type="checkbox" value="1" <?php if ( $elements[0]['galeria_videos']==1){echo 'checked="checked"';}?> name="videos-reto" id="videos-reto" /> Contiene videos
    <input type="checkbox" value="1" <?php if ( $elements[0]['galeria_fotos']==1){echo 'checked="checked"';}?>  name="fotos-reto" id="fotos-reto" /> Contiene fotos
  </td></tr>
  <tr><td><label for="cabecera-reto">Cabecera reto:</label></td></tr>
  <tr><td><textarea cols="40" rows="5" id="cabecera-reto" name="cabecera-reto"><?php echo $elements[0]['cabecera_promocion'];?></textarea>
  <script type="text/javascript">CKEDITOR.replace('cabecera-reto',{customConfig : 'config-admin.js'});</script>
  </td></tr>
	<tr><td><label for="descripcion-reto">Descripción reto:</label></td></tr>
  <tr><td><textarea cols="40" rows="5" id="descripcion-reto" name="descripcion-reto"><?php echo $elements[0]['texto_promocion'];?></textarea>
  <script type="text/javascript">CKEDITOR.replace('descripcion-reto',{customConfig : 'config-admin.js'});</script>
  </td></tr>  
  <tr><td><label for="">Imagen:</label></td></tr>
  <tr><td><input type="file" id="imagen-reto" name="imagen-reto" title="Seleccionar archivo" class="btn btn-default">
  <?php
  if ($elements[0]['imagen_promocion']!=""){ echo '<a href="images/banners/'.$elements[0]['imagen_promocion'].'" target="_blank">imagen actual</a>';}
  ?>
  </td></tr>
  <tr valign="top"><td><label for="date-comentarios">Fecha limite comentarios:</label></td></tr>
  <tr><td>

                <div id="datetimepicker1" class="input-group date">
                  <input data-format="yyyy/MM/dd" readonly type="text" id="date-comentarios" class="form-control" name="date-comentarios"></input>
                    <span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>

                <script>
                jQuery(document).ready(function(){
                  $("#datetimepicker1").datetimepicker({
                      language: "es-ES"
                    });
<?php
if ($elements[0]['date_comentarios']!=null){
  echo "              var fecha = '".date('D M d Y H:i:s O',strtotime($elements[0]['date_comentarios']))."';";
  echo'             $("#datetimepicker1").data("datetimepicker").setLocalDate(new Date (fecha));';
}
?>
              })
                </script>
        <span id="date-comentarios-alert" class="alert-message alert alert-danger"></span>
  </td></tr>
  <tr valign="top"><td><label for="date-fin-comentarios">Fecha limite votaciones:</label></td></tr>
  <tr><td>
        <div id="datetimepicker2" class="input-group date">
                  <input data-format="yyyy/MM/dd" readonly type="text" id="date-fin-comentarios" class="form-control" name="date-fin-comentarios"></input>
                    <span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
                <?php
?>

                <script>
                jQuery(document).ready(function(){
                  $("#datetimepicker2").datetimepicker({
                      language: "es-ES"
                    });
<?php

if ($elements[0]['date_fin_comentarios']!=null){
  echo "              var fecha2 = '".date('D M d Y H:i:s O',strtotime($elements[0]['date_fin_comentarios']))."';";
  echo'             $("#datetimepicker2").data("datetimepicker").setLocalDate(new Date (fecha2));';
}
?>
              })
                </script>
        <span id="date-fin-comentarios-alert" class="alert-message alert alert-danger"></span>
  </td></tr>
  <tr><td><button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary">Guardar reto</button></td></tr>
</table>
</form>	
<?php
if ($accion!='new_reto'){
  videosRetoAdmin($elements[0]['id_promocion']);
}
?>
</div>
<div class="col-md-3">
	<div class="panel panel-default">
		<div class="panel-heading">Administración del reto</div>
		<div class="panel-body">
					<p><a href="?page=admin-reto&act=new_reto">Crear nuevo reto</a></p>
					<p><a href="?page=admin">Volver a administración de la comunidad</a></p>
		</div>
	</div>
	
</div>
</div>
<?php 
}
function videosRetoAdmin($id_promocion){
  echo '
  		<h3>Estos son los videos del reto. Puedes eliminarlos o insertar nuevos videos.</h3>'; 
  $promociones = new promociones();
  $videos_reto = $promociones->getPromocionesVideos(" AND id_promocion=".$id_promocion." "); 
  
  insertVideo($id_promocion);
  
  foreach($videos_reto as $video_reto):
    echo '<div style="width: 200px; float: left; margin-right: 10px">';
	   playVideo("VideoReto".$video_reto['id_file'],PATH_VIDEOS.$video_reto['ruta_video'],200,150);
	echo '<center><a href="#" class="comunidad-color" onClick="Confirma(\'¿Seguro que desea eliminar el video '.$video_reto['nombre_video'].'?\',
		  \'?page=admin-reto&act=del_v&id='.$video_reto['id_file'].'&n='.$video_reto['ruta_video'].'\')" 
		  title="Eliminar" />Eliminar video</a></center>';
	echo '</div>';
  endforeach; 
}

function insertVideo($id_promocion){
echo '<form id="video-form" name="video-form" action="?page=admin-reto&act=video_ok" method="post" enctype="multipart/form-data" role="form">
	  <input type="hidden" name="id-promocion" id="id-promocion" value="'.$id_promocion.'" />
		 <table width="400" border="0" cellpadding="2" cellspacing="0">
			<tr valign="top">
				<td><label for="titulo-fichero">Título:</label></td>
				<td>
				  <input maxlength="250" name="titulo-fichero" id="titulo-fichero" type="text" class="form-control" value="'.$_POST['titulo-fichero'].'" />
				  <span id="titulo-video-alert" class="alert-message alert alert-danger"></span>
				</td>
			</tr>
			<tr valign="top">
				<td><label for="descripcion-fichero">Descripción:</label></td>
				<td><input maxlength="250" name="descripcion-fichero" id="descripcion-fichero" type="text" class="form-control" value="'.$_POST['descripcion-fichero'].'" /></td>
			</tr>			
			<tr valign="top">
				<td><label for="nombre-fichero">Fichero:</label></td>
				<td>
				  <input type="file" title="Seleccionar archivo" class="btn btn-default" name="nombre-fichero" id="nombre-fichero" />
				  <span id="fichero-video-alert" class="alert-message alert alert-danger"></span>
			</tr>
			<tr>
			  <td></td>
			  <td><input type="button" class="btn btn-primary" id="video-submit" name="video-submit" value="Insertar video" /></td>
			</tr>					
		 </table>
	  </form><br /><br />';	
}

function UpdateData()
{
	$promociones = new promociones();
	if ($promociones->updatePromocion($_POST['id_promocion'],
									 $_POST['nombre-reto'],
									 $_POST['cabecera-reto'],
									 $_POST['descripcion-reto'],
									 $_FILES['imagen-reto'],
									 $_POST['videos-reto'],
									 $_POST['fotos-reto'],
									 $_POST['date-comentarios'],
									 $_POST['date-fin-comentarios'])) {
			OkMsg("reto modificado correctamente.");}
}
function InsertData()
{
	$promociones = new promociones();
	if ($promociones->insertPromocion($_POST['nombre-reto'],
									 $_POST['cabecera-reto'],
									 $_POST['descripcion-reto'],
									 $_FILES['imagen-reto'],
									 $_POST['videos-reto'],
									 $_POST['fotos-reto'],
									 $_POST['date-comentarios'],
									 $_POST['date-fin-comentarios'])) {
			OkMsg("reto insertado correctamente.");}
}
?>