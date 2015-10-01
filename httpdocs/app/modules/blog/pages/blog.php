<?php
templateload("blog","blog");
templateload("comment","foro");
templateload("addcomment","blog");
templateload("tags","blog");

addJavascripts(array("js/jquery.jtextarea.js", 
					 getAsset("blog")."js/blog.js", 
					 getAsset("foro")."js/foro-comentario.js"));

$filtro_blog = ($_SESSION['user_canal']=='admin' ? "" : " AND (canal='".$_SESSION['user_canal']."' OR canal='todos') ");
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

		//OBTENCION DE LOS DATOS DEL FORO 
		$filtro_tema = "";
		if (isset($_REQUEST['id']) and $_REQUEST['id']>0){
			$id_tema=$_REQUEST['id'];
		}
		else{
			//SELECCION ULTIMO ID BLOG
			$filtro_blog = ($_SESSION['user_canal']=='admin' ? "" : " AND (canal='".$_SESSION['user_canal']."' OR canal='todos') ");
			$id_tema = connection::SelectMaxReg("id_tema", "foro_temas", $filtro_blog." AND ocio=1 AND id_tema_parent=0 AND activo=1 ");
		}
		if (isset($_REQUEST['f'])){$id_tema=$_REQUEST['f'];} 
		if (isset($id_tema) and $id_tema!=""){
			if ($_SESSION['user_perfil']!="admin" and $_SESSION['user_perfil']!="formador" and $_SESSION['user_perfil']!="foros") {
				$filtro_tema=" AND (canal='".$_SESSION['user_canal']."' OR   canal='admin') ";
				$filtro_comentarios=" AND c.id_tema=".$id_tema." ";
			}
			$filtro_tema .= " AND id_tema=".$id_tema." AND activo=1 AND ocio=1 ";
			$tema = $foro->getTemas($filtro_tema); 
		}

		echo '<div class="message-form" id="alertas-mensajes" style="display: none"></div>';

		if (isset($id_tema) and $id_tema!=""){

			//buscador
			if (isset($_POST['find_reg'])) {$filtro_comentarios=" AND c.id_tema=".$_POST['find_reg']." ";$find_reg=$_POST['find_reg'];}
			if (isset($id_tema)) {$filtro_comentarios=" AND c.id_tema=".$id_tema." ";$find_reg=$id_tema;} 
			if ($filtro_comentarios==""){$filtro_comentarios=" AND c.id_tema=0 ";}
			$filtro_comentarios .= " AND estado=1 ";
			 
			//paginador. Valor muy alto de $reg para que se muestren todos los comentarios
			$reg = 999999;
			if (isset($_GET["pag"]) and $_GET["pag"]!="") {$pag = $_GET["pag"];}
			if (!isset($pag)) { $inicio = 0; $pag = 1;}
			else { $inicio = ($pag - 1) * $reg;}
			$total_reg = connection::countReg("foro_comentarios c",$filtro_comentarios);

			//numero de visitas
			$num_visitas = connection::countReg("foro_visitas"," AND id_tema=".$id_tema." ");

			//enlaces de pagina anterior
			$anterior_disabled = "";
			$anterior = $foro->getTemas($filtro_blog." AND activo=1 AND ocio=1 AND id_tema>".$id_tema." ORDER BY id_tema ASC  LIMIT 1");
			if (count($anterior)!=1){$anterior_disabled = "disabled";$anterior_enlace = "#";}
			else{$anterior_enlace = "blog?id=".$anterior[0]['id_tema'];}

			//enlaces de pagina siguiente
			$siguiente_disabled = "";
			$siguiente = $foro->getTemas($filtro_blog." AND activo=1 AND ocio=1 AND id_tema<".$id_tema." ORDER BY id_tema DESC LIMIT 1");
			if (count($siguiente) != 1){$siguiente_disabled = "disabled"; $siguiente_enlace = "#";}
			else{$siguiente_enlace = 'blog?id='.$siguiente[0]['id_tema'];}

			?>
			<div class="panel panel-default panel-comunidad">
				<div class="panel-footer">
					<h4><a href="<?php echo $destino.'?id='.$sub_tema['id_tema'];?>"><?php echo $tema[0]['nombre'];?></a></h4>
					<span><?php echo getDateFormat($tema[0]['date_tema'], "LONG");?></span>
					<?php if ($module_config['options']['allow_comments']==true ):?>
					<span class="fa fa-comment" title="comentarios en el foro"></span>
					<span class="contador-foro-counter"><?php echo $total_reg;?></span> <?php echo strTranslate("Comments");?> 
					<?php endif;?>
					<span class="fa fa-eye" title="visitas al foro"></span> 
					<span class="contador-foro-counter"><?php echo $num_visitas;?></span> <?php echo strTranslate("Visits");?> 
					<?php showTags($tema[0]['tipo_tema']);?>
				</div>
				<div class="panel-body">
					<p><?php echo $tema[0]['descripcion'];?></p>
				</div>
			</div>
			<ul class="pager">
				<li class="previous <?php echo $anterior_disabled;?>"><a href="<?php echo $anterior_enlace;?>">&larr; <?php echo strTranslate("Previous_post");?></a></li>
				<li class="next <?php echo $siguiente_disabled ;?>"><a href="<?php echo $siguiente_enlace;?>"><?php echo strTranslate("Next_post");?> &rarr;</a></li>
			</ul>
			<?php
		}    


		if (count($tema)>0){	
			if ($module_config['options']['allow_comments']==true){ 
				//INSERTAR VISITA EN EL FORO/POST
				$foro->insertVisita($_SESSION['user_name'],$id_tema,0);
				
				//COMENTARIOS DEL FORO/POST
				$filtro_comentarios.= " AND id_comentario_id=0 ORDER BY date_comentario DESC";
				$comentarios_foro = $foro->getComentarios($filtro_comentarios.' LIMIT '.$inicio.','.$reg); 
				?>
				<div class="clearfix"></div>
				<div class="panel-interior">
					<label><?php echo strTranslate("Comment_this_post");?>:</label>
					<?php addForoComment($id_tema);?>
				</div>
				
				<div class="panel-container-foro">
					<?php foreach($comentarios_foro as $comentario_foro):
						commentForo($comentario_foro,"blog");
					endforeach;	?>
				</div>
				<br />
				
				<?php if ($total_reg==0): ?>
					<div class="alert alert-warning">Todavía no se han insertado comentarios en esta entrada.</div>
				<?php else: 
					Paginator($pag,$reg,$total_reg,'blog?id='.$id_tema,'comentarios',$find_reg,10,"selected-foro");
				endif;
			}

			//ENTRADAS SIMILARES
			echo '<h4>
				<span class="fa-stack fa-lg text-muted">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-bell fa-stack-1x fa-inverse"></i>
				</span>
				'.strTranslate("You_may_also_like").'</h4>
				<div class="row">';
			$filtro_etiquetas = "";
			$etiquetas = explode(",",$tema[0]['tipo_tema']);
			foreach($etiquetas as $etiqueta):
					$filtro_etiquetas .= " OR tipo_tema LIKE '%".$etiqueta."%' ";
			endforeach;
			$filtro_etiquetas = substr($filtro_etiquetas, 3);
			$filtro_etiquetas = " AND (".$filtro_etiquetas.") AND id_tema<>".$tema[0]['id_tema']." ";
			$elements = $foro->getTemas($filtro_blog." AND ocio=1 AND activo=1 ".$filtro_etiquetas." ORDER BY rand() DESC LIMIT 4 "); 
			foreach($elements as $element):
				echo '<div class="footer-section full-height">
						<a href="blog?id='.$element['id_tema'].'"><h4 class="ellipsis">'.$element['nombre'].'</h4></a>
						<p class="text-muted"><small>'.getDateFormat($element['date_tema'], "LONG").'</small></p>
						<a href="blog?id='.$element['id_tema'].'"><img src="images/foro/'.$element['imagen_tema'].'" alt="'.$element['nombre'].'" /></a><br />
						<p class="hidden-md hidden-lg"><br />'.blogController::get_resume(strip_tags($element['descripcion'])).'</p>
					</div>';
			endforeach; 
			echo '</div>';
		}?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php
			//BUSCADOR
			searchBlog();
			?>
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-folder fa-stack-1x fa-inverse"></i>
				</span>
				<?php echo strTranslate("Last_blog");?>
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
				<?php echo strTranslate("Archive");?>
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
				<?php echo strTranslate("Categories");?>
			</h4>
			<?php
			$elements = $foro->getCategorias($filtro_blog." AND ocio=1 ");
			categoriasBlog($elements);
			?>
		</div>
	</div>
</div>