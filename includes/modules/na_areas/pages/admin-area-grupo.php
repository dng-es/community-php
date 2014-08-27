<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

function ini_page_header ($ini_conf) {?>

<?php
}
function ini_page_body ($ini_conf){
  //CONTROL NIVEL DE ACCESO
  $session = new session();
  $perfiles_autorizados = array("admin");
  $session->AccessLevel($perfiles_autorizados);
  	
  ShowData();
}

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////
function ShowData()
{
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

  echo '<div id="page-info">Asignación de usuarios al grupo</div>';
  echo '<div class="row inset row-top">';
  echo '  <div class="col-md-9">';
?>

<div class="row">
  <div class="col-md-6">
    <form id="formData" name="formData" method="post" action="">
    <input type="hidden" name="id_grupo_add" id="id_grupo_add" value="<?php echo $id_grupo;?>" />
    <h2>usuarios del area</h2>
    <input class="btn btn-primary btn-block" type="submit" value="Agregar usuario al grupo" />
    <select class="grupos-container-cmb form-control" size="15" name="user_add" id="user_add">
    <?php
    foreach($usuarios_area as $usuario_area):
      echo '<option value="'.$usuario_area['username_area'].'">'.$usuario_area['username_area'].'</option>';
    endforeach;
    ?>
    </select>
    </form>
  </div>

  <div class="col-md-6">
    <form id="formData" name="formData" method="post" action="">
    <input type="hidden" name="id_grupo_del" id="id_grupo_del" value="<?php echo $id_grupo;?>" />
    <h2>usuarios del grupo</h2>
    <input class="btn btn-primary btn-block" type="submit" value="Quitar usuario del grupo" />
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

<div class="col-md-3">
  <div class="panel panel-default">
    <div class="panel-heading">Gestión de areas</div>
    <div class="panel-body">
    <p><a class="orange-color" href="?page=admin-area&act=edit&id=<?php echo $id_area;?>">Volver al área</a></p>
    </div>
  </div>
</div>
</div>
<?php 
}
?>