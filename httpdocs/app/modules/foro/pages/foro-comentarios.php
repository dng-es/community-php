<?php
templateload("addcomment", "foro");
templateload("comment", "foro");

addJavascripts(array("js/jquery.jtextarea.js", 
					 getAsset("foro")."js/foro-comentario.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		
		session::getFlashMessage('actions_message');
		foroController::createRespuestaAction();
		foroController::votarAction();
		$module_config = getModuleConfig("foro");

		$foro = new foro();

		//OBTENCION DE LOS DATOS DEL FORO
		if (isset($_REQUEST['id'])) $id_tema = $_REQUEST['id'];
		if (isset($_REQUEST['f'])) $id_tema = $_REQUEST['f'];
		if (isset($id_tema) and $id_tema != ""){
			$filtro_tema = " AND id_tema=".$id_tema." AND activo=1 ";
			if ($_SESSION['user_canal'] != "admin") $filtro_tema .= " AND canal='".$_SESSION['user_canal']."' ";
			$tema = $foro->getTemas($filtro_tema); 
			
			//VOLVER ATRAS: SI ES UN FORO DE AREAS VOLVERA A LA PAGINA DE AREAS,
			//SI ES OTRO TIPO DE FORO VOLVERA A LA PAGINA DE SUBFOROS
			////VERIFICA ACCESO AL FORO
			if ($tema[0]['id_area'] <> 0) { 
				$volver = "areas_det?id=".$tema[0]['id_area'];
				if ($_SESSION['user_perfil'] == 'admin')  $acceso = true;
				else $acceso = (connection::countReg("na_areas_users", " AND id_area=".$tema[0]['id_area']." AND username_area='".$_SESSION['user_name']."' ") > 0 ? true : false);
			}
			else {
				$volver = "foro-subtemas?id=".$tema[0]['id_tema_parent'];
				$acceso = true;
			}

			if (!$acceso):?>
				<div class="alert alert-warning">acceso denegado</div>
				<?php die();
			endif;

			if (count($tema) > 0){
				//PAGINATOR
				$reg = $module_config['options']['comments_per_page'];
				$pag = 1;
				$inicio = 0;
				if (isset($_GET["pag"]) and $_GET["pag"] != "") {
					$pag = $_GET["pag"];
					$inicio = ($pag - 1) * $reg;
				}

				$filtro_comentarios = " AND c.id_tema=".$id_tema." AND estado=1 AND id_comentario_id=0";
				$total_reg = connection::countReg("foro_comentarios c", $filtro_comentarios);
				$total_reg_resp = connection::countReg("foro_comentarios c", " AND c.id_tema=".$id_tema." AND estado=1 ");
				$num_visitas = connection::countReg("foro_visitas", " AND id_tema=".$id_tema." ");
				$comentarios_foro = $foro->getComentarios($filtro_comentarios.' ORDER BY date_comentario DESC LIMIT '.$inicio.','.$reg); 
				
				menu::breadcrumb(array(
					array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
					array("ItemLabel"=>strTranslate("Forums"), "ItemClass"=>"active"),
				));
				?>
				<div class="panel pane-default">
					<div class="panel-body">
						<h2><?php echo $tema[0]['nombre'];?></h2>
						<p class="legend"><span class="fa fa-comment"></span> <?php echo $total_reg_resp.' '.strTranslate("Comments");?> <span class="fa fa-eye"></span> <?php echo $num_visitas.' '.strTranslate("Visits");?> <i class="fa fa-mail-reply"></i> <a href="<?php echo $volver;?>" title="<?php e_strTranslate("Go_back");?>"><?php e_strTranslate("Go_back");?></a></p>
						<p><?php echo $tema[0]['descripcion'];?></p>
						<div class="panel-container-foro">
							<?php foreach($comentarios_foro as $comentario_foro):
								commentForo($comentario_foro);
							endforeach;	?>
						</div>
						<br />
						<?php if ($total_reg == 0) echo '<div class="alert alert-warning">'.strTranslate("No_comments_yet").'</div>';
						else Paginator($pag, $reg, $total_reg, 'foro-comentarios', 'comentarios', $id_tema, 10, "selected-foro"); ?>
					</div>
				</div>
			<?php }
		} ?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-share-alt fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Insert_comment_forum");?>
			</h4>
			<p><?php e_strTranslate("Insert_comment_forum_label");?></p>
			<?php addForoComment($id_tema); 
			//INSERTAR VISITA EN EL FORO
			if (!isset($_POST['texto-comentario'])) $foro->insertVisita($_SESSION['user_name'], $id_tema, 0); ?>
		</div>
	</div>
</div>