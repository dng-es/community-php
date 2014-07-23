<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=1;
function ini_page_header ($ini_conf) {?>
		<script type="text/javascript" src="js/admin-huellas.js"></script>
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
?>
<div class="comunidad-panel">
<h1>asignación de huellas</h1>
<p class="TituloSecc2">puesdes asignar huellas a los usuarios, tambien puedes restarles huellas introducciendo un valor negativo. 
Para sumar o restar huellas intruduce el usuario (no nick), el número de huellas y el motivo de la asignación.</p><br />
<form id="formData" name="formData" method="post" action="">
<table cellspacing="0" cellpadding="2px">
    <tr><td valign="top"><span class="TituloSecc2">usuario:</span></td>
    <td>
      <input type="text" name="id_usuario" id="id_usuario" class="cuadroTexto" />
      <span id="id-usuario-alert" class="alert-message"></span>
    </td></tr>
    <tr>
	<td valign="top"><span class="TituloSecc2">huellas:</span></td>
    <td>
      <input size="6" type="text" name="num_huellas" id="num_huellas" class="cuadroTexto"  style="width:60px" />
      <span id="num-huellas-alert" class="alert-message"></span>
    </td></tr>
    <tr><td valign="top"><span class="TituloSecc2">motivo:</span></td>
    <td>
      <input type="text" name="motivo_huellas" id="motivo_huellas" class="cuadroTexto" />
      <span id="motivo-huellas-alert" class="alert-message"></span>
    </td></tr>    
  <tr><td><input type="button" id="SubmitData" name="SubmitData" class="BtnGuardarNaranja" value="" /></td></tr>
</table>
</form>
<div id="resultado-huellas"></div>
</div>
<?php 
}
?>