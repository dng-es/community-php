<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=0;
function ini_page_header ($ini_conf) {?>


<?php }
function ini_page_body ($ini_conf){
	templateload("list","foro");
	templateload("paginator","foro");
	templateload("addforo","foro");
	templateload("search","foro");
	
	$foro = new foro();
	$id_tema_parent="";
	$canal="";
	?>
	<div id="page-info"><?php echo strTranslate("Forums");?></div>
	<div class="row row-top">
		<div class="col-md-7 col-lg-8 inset">
			<p>Comparte con tus compañeros todas las dudas y temas que te interesen . Puedes participar de los temas ya propuestos o puedes crear uno nuevo.</p>

	<?php
	session::getFlashMessage( 'actions_message' ); 	

	$id_tema_parent = $_REQUEST['id'];
	//OBTENCION DE LOS TEMAS DEL FORO
	if (isset($id_tema_parent) and $id_tema_parent!=""){
		$filtro=" AND id_tema=".$id_tema_parent." AND activo=1 AND ocio=0 ";
		if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador' and $_SESSION['user_canal']!='foros'){$filtro.=" AND canal='".$_SESSION['user_canal']."' ";}
		$temas = $foro->getTemas($filtro); 
	}
	
  	if (isset($id_tema_parent) and $id_tema_parent!=""){
		//OBTENER SUBTEMAS DE FORO
		$filtro_subtemas = " AND t.id_tema_parent=".$temas[0]['id_tema']." AND t.activo=1 AND t.ocio=0 "; 
		$reg = 5;
		$marca = 0;
		$find_tipo = "";
		$find_reg = "";
		if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
		if (!isset($pag)) { $inicio = 0; $pag = 1;}
		else { $inicio = ($pag - 1) * $reg;}
		
		if (isset($_POST['find_reg']) and $_POST['find_reg'] != "") {
			$filtro_subtemas.=" AND (c.comentario LIKE '%".$_POST['find_reg']."%' OR t.nombre LIKE  '%".$_POST['find_reg']."%') ";
			$find_reg=$_POST['find_reg'];
		}
		if (isset($_REQUEST['f']) and $_REQUEST['f']!="") {
			$filtro_subtemas.=" AND (c.comentario LIKE '%".$_REQUEST['f']."%' OR t.nombre LIKE '%".$_REQUEST['f']."%') ";
			$find_reg=$_REQUEST['f'];
		}
		if (isset($_POST['find_tipo']) and $_POST['find_tipo'] != "") {
			$filtro_subtemas.=" AND t.tipo_tema LIKE '%".$_POST['find_tipo']."%' ";
			$find_tipo=$_POST['find_tipo'];
			$marca=1;
		}
		if (isset($_REQUEST['m']) and $_REQUEST['m']==1) {
			$filtro_subtemas.=" AND t.tipo_tema LIKE '%".$_REQUEST['t']."%' ";
			$find_tipo=$_REQUEST['t'];
			$marca=1;
		}

		$total_reg = $foro->getTemasComentarios($filtro_subtemas,'');
		$total_reg = count($total_reg);
		$sub_temas = $foro->getTemasComentarios($filtro_subtemas,' LIMIT '.$inicio.','.$reg);
		foreach($sub_temas as $sub_tema):
			echo '<div class="row">
					<div class="col-md-12">';
			ForoList($sub_tema);	  
			echo '	</div>
			 	</div>';			
		endforeach;  
		ForoPaginator($pag,$reg,$total_reg,'foro-subtemas&id='.$id_tema_parent,'temas',$find_reg,$find_tipo,$marca);	 
	}

	echo '	</div>
			<div class="col-md-5 col-lg-4 lateral">';

	//BUSCADOR
	ForoSearch($reg,'?page=foro-subtemas&id='.$id_tema_parent,$find_reg,$marca,$find_tipo);

	//BANNER CREAR TEMA
	PanelSubirTemaForo($id_tema_parent,$temas[0]['canal']);

	echo '	</div>
		</div>';
 
}

function SearchTemas($reg,$pag,$comentario,$marca_tipo,$tipo_tema)
{	
	?>
	<div class="panel-interior">
		<form action="<?php echo $pag.'&regs='.$reg;?>" method="post" role="form" class="form-inline">
			<div class="form-group">
				<label class="sr-only" for="find_reg">Introduce el nombre del foro a buscar</label>
				<input id="find_reg" name="find_reg" type="text" value="<?php echo $comentario;?>" class="form-control" placeholder="Búsqueda rápida" />
				<input type="hidden" name="registros_form" value="<?php echo $reg;?>" />
			</div>
 
	<?php if ($_SESSION['user_perfil']=='admin'):?>
			<div class="form-group">
				<select name="find_tipo" id="find_tipo" class="form-control">
				<option value="0">---Buscar por tema---</option>
				<?php ComboTiposTemas($tipo_tema);?>
				</select>
			</div>
	<?php endif; ?>
			<button type="submit" class="btn btn-primary" title="Buscar">Buscar</button>
		</form>
	</div>
<?php 	
}

function PaginatorTemas($pag,$reg,$total_reg,$pag_dest,$title,$find_reg="",$find_tipo="",$marcado=0,$num_paginas=10)
{
	$total_pag = ceil($total_reg / $reg);
	$reg_ini=(($pag-1)*$reg)+1;
	$reg_end=$pag*$reg;
	if ($reg_ini>$total_reg) {$reg_ini=$total_reg;}
	if ($reg_end>$total_reg) {$reg_end=$total_reg;}
	echo '<span class="pageslist">';
	//echo '<span class="messages"> '.$title.' '.$total_reg.' ('.$reg_ini.'-'.$reg_end.')</span>';
	if(($pag - 1) > 0) { echo '<a href="?page='.$pag_dest.'&pag=1&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">primero</a>';}
	else { echo '<span class="disabled">primero</span>';}
	
	
	$pagina_inicial=$pag-1;
	if ($pagina_inicial<=0){$pagina_inicial=1;}
	$pagina_final=$pagina_inicial+$num_paginas;
	
	if ($pag>1){
		echo '<a href="?page='.$pag_dest.'&pag='.($pag-1).'&regs='.$reg.'&f='.$find_reg.'">anterior</a>';}
	else { echo '<span class="disabled">anterior</span>';}
	
	
	for ($i=$pagina_inicial; $i<=$pagina_final; $i++){
		if($i<=$total_pag){
		  if ($pag == $i) { echo '<span  class="selected selected-foro">'.$pag.'</span>';}
		  else { echo '<a href="?page='.$pag_dest.'&pag='.$i.'&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">'.$i.'</a>';}
		}
	}
	
	if ($pag<$total_pag){
		echo '<a href="?page='.$pag_dest.'&pag='.($pag+1).'&regs='.$reg.'&f='.$find_reg.'">siguiente</a>';
	}
	else { echo '<span class="disabled">siguiente</span>';}
	
	if(($pag + 1)<=$total_pag) { echo '<a href="?page='.$pag_dest.'&pag='.$total_pag.'&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">&uacute;ltimo</a>';}
	else { echo '<span class="disabled">&uacute;ltimo</span>';}
	echo '</span>';
}
?>