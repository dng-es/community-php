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
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Forums"), "ItemClass"=>"active"),
		));?>
		<p><?php echo strTranslate("Forums_title");?></p>
		
		<?php
		session::getFlashMessage( 'actions_message' ); 	
		$module_config = getModuleConfig("foro");

		if (isset($_REQUEST['id']) and $_REQUEST['id']>0){
			$id_tema_parent = $_REQUEST['id'];
		}
		else{
			//SELECCION DEL FORO
			$filtro_canal = ($_SESSION['user_canal']== 'admin' ? "" : " AND canal='".$_SESSION['user_canal']."' ");
			$id_tema_parent = connection::SelectMaxReg("id_tema", "foro_temas", " AND id_tema_parent=0 AND id_area=0 AND ocio=0 ".$filtro_canal);
		}
		//OBTENCION DE LOS TEMAS DEL FORO
		if (isset($id_tema_parent) and $id_tema_parent!=""){
			$filtro=" AND id_tema=".$id_tema_parent." AND activo=1 AND ocio=0 ";
			if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador' and $_SESSION['user_canal']!='foros'){$filtro.=" AND canal='".$_SESSION['user_canal']."' ";}
			$temas = $foro->getTemas($filtro); 
		}

		if (isset($id_tema_parent) and $id_tema_parent!=""){
		//OBTENER SUBTEMAS DE FORO
		$filtro_subtemas = " AND id_tema_parent=".$temas[0]['id_tema']." AND activo=1 AND ocio=0 "; 
		$reg = $module_config['options']['forums_per_page'];
		$marca = 0;
		$find_tipo = "";
		$find_reg = "";
		if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
		if (!isset($pag)) { $inicio = 0; $pag = 1;}
		else { $inicio = ($pag - 1) * $reg;}
		
		if (isset($_POST['find_reg']) and $_POST['find_reg'] != "") {
			$filtro_subtemas.=" AND (nombre LIKE  '%".$_POST['find_reg']."%') ";
			$find_reg=$_POST['find_reg'];
		}
		if (isset($_REQUEST['f']) and $_REQUEST['f']!="") {
			$filtro_subtemas.=" AND (nombre LIKE '%".$_REQUEST['f']."%') ";
			$find_reg=$_REQUEST['f'];
		}
		if (isset($_POST['find_tipo']) and $_POST['find_tipo'] != "") {
			$filtro_subtemas.=" AND tipo_tema LIKE '%".$_POST['find_tipo']."%' ";
			$find_tipo=$_POST['find_tipo'];
			$marca=1;
		}
		if (isset($_REQUEST['m']) and $_REQUEST['m']==1) {
			$filtro_subtemas.=" AND tipo_tema LIKE '%".$_REQUEST['t']."%' ";
			$find_tipo=$_REQUEST['t'];
			$marca=1;
		}

		$total_reg = connection::countReg("foro_temas", $filtro_subtemas);
		$sub_temas = $foro->getTemas($filtro_subtemas." ORDER BY id_tema DESC  LIMIT ".$inicio.",".$reg);
		foreach($sub_temas as $sub_tema):
			ForoList($sub_tema);		
		endforeach;  
		ForoPaginator($pag,$reg,$total_reg,'foro-subtemas?id='.$id_tema_parent,'temas',$find_reg,$find_tipo,$marca);	 
		}?>

	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php
			//BUSCADOR
			ForoSearch($reg,'foro-subtemas?id='.$id_tema_parent,$find_reg,$marca,$find_tipo);

			//BANNER CREAR TEMA
			if ($module_config['options']['allow_new']==true or $_SESSION['user_perfil']=='admin') PanelSubirTemaForo($id_tema_parent,$temas[0]['canal']);
			?>
		</div>
	</div>
</div>