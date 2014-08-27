<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

function ini_page_header ($ini_conf) {
	

?>
  <script>
	$(document).ready(function(){	
		$(".ui-modif-btn").click(function(){
			$("#form-login").submit();
		});	
	})
</script>        
<?php }
function ini_page_body ($ini_conf){
  //CONTROL NIVEL DE ACCESO
  $perfiles_autorizados = array("admin");
  session::AccessLevel($perfiles_autorizados);

  $foro = new foro(); 
  $users = new users();


  //VALIDAR CONTENIDOS
  if (isset($_REQUEST['act'])) { 	 
	if ($_REQUEST['act']=='foro_ok'){
	  $foro->cambiarEstado($_REQUEST['id'],1);
	  $users->sumarPuntos($_REQUEST['u'],PUNTOS_FORO,PUNTOS_FORO_MOTIVO);
	}
	elseif ($_REQUEST['act']=='tema_ko'){$foro->cambiarEstadoTema($_REQUEST['id'],0);}
	elseif ($_REQUEST['act']=='foro_ko'){
		$foro->cambiarEstado($_REQUEST['id'],2);
		$users->restarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
	}
	header("Location: ?page=admin-blog-foro&id=".$_REQUEST['idt']); 
  }

   if (isset($_POST['find_tipo'])) { 	 
	$foro->cambiarTipoTema($_POST['id_tema_tipo'],$_POST['find_tipo']);
	//header("Location: ?page=admin-validacion-foro"); 
  } 

  
	//EXPORT EXCEL - SHOW AND GENERATE
  if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
	  $foro = new foro(); 
	  $elements_exp=$foro->getComentariosExport(" AND c.id_tema=".$_REQUEST['id']." ");
	  $file_name='exported_file'.date("YmdGis");
	  ExportExcel('./docs/export/',$file_name,$elements_exp);}    
  
  
  if (isset($_POST['tipo_search']) and $_POST['tipo_search']!="") {$filtro_temas.=" AND tipo_tema LIKE '%".$_POST['tipo_search']."%' ";$find_tipo=$_POST['tipo_search'];}

  			
  
	$foro = new foro();
	$calculo = strtotime("-4 days");
	$fecha_ayer= date("Y-m-d", $calculo);
	$id_tema= $_REQUEST['id'];
	$pendientes = $foro->getComentarios(" AND c.estado=1 AND c.id_tema=".$id_tema." ORDER BY id_comentario DESC");

	echo '<div class="row row-top">';
	echo '<div class="col-md-9">';  
	echo '<h1>Comentarios en el Blog</h1>';
	echo '<a href="?page=admin-blog-new&act=edit&id='.$_REQUEST['id'].'">Ir a la entrada</a><br />';
		if (count($pendientes)==0){
			echo '<div class="alert alert-danger">No hay mensajes en la entrada</div>';
		}
		else{
		  echo '<table class="table table-striped">';
		  echo '<tr>';
		  echo '<th width="40px">&nbsp;</th>';
		  echo '<th>ID</th>';
		  echo '<th>Comentario</th>';
		  echo '<th>Autor</th>';
		  echo '<th>Fecha</th>';
		  echo '</tr>';
	  

		  foreach($pendientes as $element):
				echo '<tr>';
				echo '<td nowrap="nowrap">					
						<span class="fa fa-ban icon-table" title="Eliminar"
						    onClick="Confirma(\'¿Seguro que desea eliminar el comentario '.$element['id_comentario'].'?\',
							\'?page=admin-blog-foro&act=foro_ko&id='.$element['id_comentario'].'&idt='.$id_tema.'&u='.$element['user_comentario'].'\')">
						</span>			
					 </td>';					
				echo '<td>'.$element['id_comentario'].'</td>';
				echo '<td><em class="legend">'.$element['comentario'].'</em></td>';
				echo '<td>'.$element['user_comentario'].'</td>';
				echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_comentario'])).'</td>';		
				echo '<tr>';   
		  endforeach;
		  echo '</table><br />';	
		}?>
		</div>
		<?php menu::adminMenu();?>
	</div>
	<?php
}

function SearchTemas($tipo_tema)
{	
	echo '<form name="SearchTemas" id="SearchTemas" action="" method="post" role="form">';
	if ($marca_tipo==1){$marcado=' checked="checked" ';}
	else {$marcado='';}?>
	<select name="tipo_search" id="tipo_search" class="form-control">
	<option value="">---Todos---</option>
	<?php ComboTiposTemas($tipo_tema);?>
	</select>
	<br />
	<button type="submit" id="find-btn" class="btn btn-primary">buscar</button>
	</FORM>
<?php }
?>