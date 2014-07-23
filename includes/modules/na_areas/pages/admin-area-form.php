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
function ini_page_header ($ini_conf) {
?>	
    <script language="JavaScript" src="<?php echo getAsset("na_areas");?>js/admin-area-form.js"></script>
    <script language="javascript" type="text/javascript">
      $(document).ready(function(){
        $(".area-detalle").wrapInner("<div class='area-detalle-out' />");
      });
    </script> 

<?php }
function ini_page_body ($ini_conf){
  //CONTROL NIVEL DE ACCESO
  $session = new session();
  $perfiles_autorizados = array("admin");
  $session->AccessLevel($perfiles_autorizados);
  $na_areas = new na_areas();

  $id_area=$_REQUEST['a'];
  $id_tarea=$_REQUEST['id'];

  //OBTENER DATOS DE LA TAREA
  $tarea=$na_areas->getTareas(" AND id_tarea=".$id_tarea." ");

  echo '<div id="page-info">Formulario de la tarea: '.$tarea[0]['tarea_titulo'].'</div>';
  echo '<div class="row inset row-top">';
  echo '  <div class="col-md-8">';

  
 //ELIMINAR PREGUNTA
 if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') { $na_areas->deletePregunta($_REQUEST['idp']);}

 //INSERTAR PREGUNTA
 if (isset($_REQUEST['act']) and $_REQUEST['act']=='new') { 
  if (trim($_POST['pregunta_texto'])){
    $na_areas->insertPregunta($id_tarea,$_POST['pregunta_texto'],$_POST['pregunta_tipo']);
    $id_pregunta=$na_areas->SelectMaxReg("id_pregunta","na_tareas_preguntas","");
    
    if ($_POST['pregunta_tipo']!='texto'){
      //INSERTAR PREGUNTA-RESPUESTA
      $num_repuestas=$_POST['contador-respuestas'];
      for ($i=1; $i <=$num_repuestas; $i++) { 
        $campo_respuesta="respuesta".$i;
        $valor = trim($_POST[$campo_respuesta]);
        $valor = str_replace("'", "´", $valor);
        $valor = str_replace('"', '´', $valor);
        if ($valor!=""){$na_areas->insertPreguntaRespuesta($id_pregunta,$valor);}
      }
    }
  }
}

  if (count($tarea)==1 and $tarea[0]['tipo']=='formulario'){FormularioTarea($id_tarea,$id_area,$tarea);}
  else{ErrorMsg("Error al cargar el formulario la tarea");}

  echo '</div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">Cursos de formación</div>
            <div class="panel-body">';      
  echo '      <a href="?page=admin-area&act=edit&id='.$id_area.'" class="comunidad-color">Volver a la gestión del curso</a>
            </div>
          </div>
        </div>
    </div>';
}

function FormularioTarea($id_tarea,$id_area,$tarea){
    $na_areas = new na_areas();
    $preguntas = $na_areas->getPreguntas(" AND id_tarea=".$id_tarea." "); 

    if (count($preguntas)==0){
      echo '<div class="tareas-row">El formulario no tiene preguntas, puede crear las preguntas a continuación.</div>';
    }
    else{
        //SHOW DATA
        echo '<table class="table">';
        echo '<tr">';
        echo '<th width="20px">&nbsp;</th>';
        echo '<th>&nbsp;Pregunta</th>';
        echo '<th>&nbsp;Tipo</th>';
        echo '</tr>';

        foreach($preguntas as $pregunta):
        echo '<tr>';
        echo '<td nowrap="nowrap">
            <span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar la pregunta?\',
              \'?page=admin-area-form&act=del&id='.$id_tarea.'&a='.$id_area.'&idp='.$pregunta['id_pregunta'].'\')" 
              title="Eliminar pregunta" />
            </span>
           </td>';
              
        echo '<td>'.$pregunta['pregunta_texto'].'</td>';
        echo '<td>'.$pregunta['pregunta_tipo'].'</td>';
        echo '</tr>';   
        endforeach;
        echo '</table>';
    }  
    //INSERTAR NUEVA PREGUNTA
    echo '<h3>Insertar nueva pregunta</h3>';

    echo '<div class="area-detalle">
    <form id="formData" name="formData" method="post" action="?page=admin-area-form&act=new&amp;id='.$id_tarea.'&amp;a='.$id_area.'">
    <table cellspacing="0" cellpadding="2px" class="Tam11">
      <tr><td valign="top" width="150px">Pregunta:</td><td>
      <input type="text" Size="40" id="pregunta_texto" name="pregunta_texto" value="" class="form-control" />
      <span id="pregunta-alert" class="alert-message alert alert-danger"></span>
      </td></tr>
      <tr><td valign="top">Tipo de pregunta:</td><td>
      <select id="pregunta_tipo" name="pregunta_tipo" class="form-control">
        <option selected="selected" value="texto">texto libre</option>
        <option value="unica"/>respuesta única</option>
        <option value="multiple">respuesta multiple</option>
      </select>
      <div id="container-respuestas">
          <a href="#" id="agregar-respuestas" class="btn btn-primary">nueva respuesta</a><br /><br />
          <input type="hidden" name="contador-respuestas" id="contador-respuestas" value="1" />
          <span id="textoRespuesta1" style="width:70px;display:block;clear:both">Respuesta1:</span>
          <input class="form-control" id="respuesta1" name="respuesta1" value=""/>
      </div>
      </td></tr>    
      <tr><td colspan="2">
        <a href="?page=areas_form&id='.$id_tarea.'" target="_blank" id="ver-formulario" class="btn btn-primary">ver formulario</a>
        <div id="SubmitData" name="SubmitData" class="btn btn-primary" style="float:right">agregar pregunta</div></td></tr>
    </table>
    </form>
    </div>';

}
?>