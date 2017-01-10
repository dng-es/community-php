<?php
templateload("blog","blog");
templateload("comment","foro");
templateload("addcomment","blog");
templateload("tags","blog");

addJavascripts(array("js/bootstrap-textarea.js", 
					 getAsset("blog")."js/blog.js", 
					 getAsset("foro")."js/foro-comentario.js"));

$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal LIKE '%".$_SESSION['user_canal']."%' " : "");
$filtro_blog = $filtro_canal." AND activo=1 ";
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Blog"), "ItemClass"=>"active"),
		));

		$foro = new foro();
		$module_config = getModuleConfig("blog");

		blogController::insertAlerts();
		session::getFlashMessage( 'actions_message' );
		foroController::createRespuestaAction();
		foroController::votarAction();
		$tema = blogController::getLastBlogAction($filtro_blog);
		$id_tema = $tema['id_tema'];


		echo '<div class="message-form" id="alertas-mensajes" style="display: none"></div>';

		if (isset($id_tema) and $id_tema != ""){
			//buscador
			if (isset($_POST['find_reg'])){
				$filtro_comentarios = " AND c.id_tema=".$_POST['find_reg']." ";
				$find_reg = $_POST['find_reg'];
			}
			if (isset($id_tema)){
				$filtro_comentarios = " AND c.id_tema=".$id_tema." ";
				$find_reg = $id_tema;
			} 
			if ($filtro_comentarios == "") $filtro_comentarios = " AND c.id_tema=0 ";
			$filtro_comentarios .= " AND estado=1 ";

			//paginador. Valor muy alto de $reg para que se muestren todos los comentarios
			$reg = 999999;
			if (isset($_GET["pag"]) and $_GET["pag"] != "") $pag = $_GET["pag"];
			if (!isset($pag)){
				$inicio = 0;
				$pag = 1;
			}
			else $inicio = ($pag - 1) * $reg;
			$total_reg = connection::countReg("foro_comentarios c", $filtro_comentarios);
			?>
			<div class="panel panel-default panel-blog">
				<div class="panel-body">
					<div class="panel-blog-header">
						<h2><?php echo $tema['nombre'];?></h2>
						<small class="text-muted">
							<span><?php echo ucfirst(getDateFormat($tema['date_tema'], "LONG"));?></span>
							<?php if ($module_config['options']['allow_comments'] == true ):?>
							<span class="fa fa-comment text-primary" title="comentarios en el foro"></span>
							<span class="contador-foro-counter"><?php echo $total_reg;?></span> <?php e_strTranslate("Comments");?> 
							<?php endif;?>
							<span class="fa fa-eye text-primary" title="visitas al foro"></span> 
							<span class="contador-foro-counter"><?php echo $tema['num_visitas'];?></span> <?php e_strTranslate("Visits");?> 
							<?php showTags($tema['tipo_tema']);?>
						</small>
					</div>
					<p><?php echo $tema['descripcion'];?></p>
				</div>
			</div>
			<ul class="pager">
				<?php previousPost($id_tema, $filtro_blog);?>
				<?php nextPost($id_tema, $filtro_blog);?>
			</ul>
			<?php
		}

		if ($id_tema > 0){
			//INSERTAR VISITA EN EL FORO/POST
			$foro->insertVisita($_SESSION['user_name'], $id_tema, 0);
			
			if ($module_config['options']['allow_comments'] == true){
				//COMENTARIOS DE LA ENTRADA
				$filtro_comentarios .= " AND id_comentario_id=0 ORDER BY date_comentario DESC";
				$comentarios_foro = $foro->getComentarios($filtro_comentarios.' LIMIT '.$inicio.','.$reg);
				?>
				<div class="clearfix"></div>
				<div class="panel-interior">
					<label><?php e_strTranslate("Comment_this_post");?>:</label>
					<?php addForoComment($id_tema);?>
				</div>
				
				<div class="panel-container-foro">
					<?php foreach($comentarios_foro as $comentario_foro):
						commentForo($comentario_foro, "blog");
					endforeach;?>
				</div>
				<br />
				
				<?php if ($total_reg == 0): ?>
					<div class="alert alert-warning">Todavía no se han insertado comentarios en esta entrada.</div>
				<?php else: 
					Paginator($pag, $reg, $total_reg, 'blog?id='.$id_tema, 'comentarios', $find_reg, 10, "selected-foro");
				endif;
			}

			//ENTRADAS SIMILARES
			$filtro_etiquetas = "";
			$etiquetas = explode(",", $tema['tipo_tema']);
			foreach($etiquetas as $etiqueta):
					$filtro_etiquetas .= " OR tipo_tema LIKE '%".$etiqueta."%' ";
			endforeach;
			$filtro_etiquetas = substr($filtro_etiquetas, 3);
			$filtro_etiquetas = " AND (".$filtro_etiquetas.") AND id_tema<>".$tema['id_tema']." ";
			$elements = $foro->getTemas($filtro_blog." AND ocio=1 AND activo=1 ".$filtro_etiquetas." ORDER BY rand() DESC LIMIT 4 "); 
			if (count($elements) > 0){
				echo '<h4>
					<span class="fa-stack fa-lg text-muted">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-bell fa-stack-1x fa-inverse"></i>
					</span>
					'.strTranslate("You_may_also_like").'</h4>
					<div class="row">';
				foreach($elements as $element):
					echo '<div class="footer-section full-height">
							<a href="blog?id='.$element['id_tema'].'"><h4 class="ellipsis">'.$element['nombre'].'</h4></a>
							<p class="text-muted"><small>'.getDateFormat($element['date_tema'], "LONG").'</small></p>
							<a href="blog?id='.$element['id_tema'].'"><img src="images/foro/'.$element['imagen_tema'].'" alt="'.$element['nombre'].'" /></a><br />
							<p class="hidden-md hidden-lg"><br />'.get_resume(strip_tags($element['descripcion'])).'</p>
						</div>';
				endforeach; 
				echo '</div>';
			}
		}?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior full-height">
			<?php
			//BUSCADOR
			searchBlog();
			?>
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-folder fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Last_blog");?>
			</h4>
			<?php 			
			$elements = $foro->getTemas($filtro_blog." AND ocio=1 AND activo=1 ORDER BY id_tema DESC LIMIT 3 ");
			entradasBlog($elements);
			?>
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-folder fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Archive");?>
			</h4>
			<?php
			$elements = $foro->getArchivoBlog($filtro_blog);
			archivoBlog($elements);
			?>
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-folder fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Categories");?>
			</h4>
			<?php
			$elements = $foro->getCategorias($filtro_blog." AND ocio=1 AND activo=1 ");
			categoriasBlog($elements);
			?>
		</div>
	</div>
</div>