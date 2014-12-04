<?php

templateload("list","foro");
templateload("paginator","foro");
templateload("addforo","foro");
templateload("search","foro");

$foro = new foro();
$id_tema_parent="";
$canal="";
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Forums"), "ItemClass"=>"active"),
		));?>
		<p><?php echo strTranslate("Forums_title");?></p>
		
		<?php
		session::getFlashMessage( 'actions_message' ); 	
		$module_config = getModuleConfig("foro");

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
		$reg = $module_config['options']['forums_per_page'];
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
			ForoList($sub_tema);		
		endforeach;  
		ForoPaginator($pag,$reg,$total_reg,'foro-subtemas&id='.$id_tema_parent,'temas',$find_reg,$find_tipo,$marca);	 
		}?>

	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<?php
			//BUSCADOR
			ForoSearch($reg,'?page=foro-subtemas&id='.$id_tema_parent,$find_reg,$marca,$find_tipo);

			//BANNER CREAR TEMA
			if ($module_config['options']['allow_new']==true or $_SESSION['user_perfil']=='admin') PanelSubirTemaForo($id_tema_parent,$temas[0]['canal']);
			?>
		</div>
	</div>
</div>