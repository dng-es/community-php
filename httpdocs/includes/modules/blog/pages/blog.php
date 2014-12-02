<?php
templateload("blog","blog");
templateload("comment","foro");
templateload("addcomment","blog");

addJavascripts(array("js/jquery.bettertip.pack.js", 
					 "js/jquery.jtextarea.js", 
					 getAsset("blog")."js/blog.js", 
					 getAsset("foro")."js/foro-comentario.js"));
?>

<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Blog"), "ItemClass"=>"active"),
		));

		$foro = new foro();
		$module_config = getModuleConfig("blog");						

		session::getFlashMessage( 'actions_message' );	
		foroController::createRespuestaAction();
		foroController::votarAction();		

		//OBTENCION DE LOS DATOS DEL FORO 
		$filtro_tema = "";
		if (isset($_REQUEST['id'])){$id_tema=$_REQUEST['id'];}
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

			//SHOW PAGINATOR
			//if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador') 
			//{ $filtro_comentarios .= " AND t.canal='".$_SESSION['user_canal']."' ";}
			if (isset($_POST['find_reg'])) {$filtro_comentarios=" AND c.id_tema=".$_POST['find_reg']." ";$find_reg=$_POST['find_reg'];}
			if (isset($id_tema)) {$filtro_comentarios=" AND c.id_tema=".$id_tema." ";$find_reg=$id_tema;} 

			if ($filtro_comentarios==""){$filtro_comentarios=" AND c.id_tema=0 ";}
			$filtro_comentarios .= " AND estado=1 ";
			 
			$reg = 10;
			if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
			if (!isset($pag)) { $inicio = 0; $pag = 1;}
			else { $inicio = ($pag - 1) * $reg;}

			$total_reg = connection::countReg("foro_comentarios c",$filtro_comentarios);
			$num_visitas = connection::countReg("foro_visitas"," AND id_tema=".$id_tema." ");

			echo '<h2>'.$tema[0]['nombre'].'</h2>
				<p class="legend">
					<span class="text-muted">'.getDateFormat($tema[0]['date_tema'], "LONG").'</span> ';

			if ($module_config['options']['allow_comments']==true ) echo '<span class="fa fa-comment"></span> '.$total_reg.' '.strTranslate("Comments").' ';

			echo ' <span class="fa fa-eye"></span> '.$num_visitas.' '.strTranslate("Visits").'</span>
				</p>
				'.$tema[0]['descripcion'];

			//enlaces de pagina siguiente y anterior
			$anterior_disabled="";
			$anterior = $foro->getTemas(" AND activo=1 AND ocio=1 AND id_tema>".$id_tema." ORDER BY id_tema ASC  LIMIT 1");
			if (count($anterior)!=1){$anterior_disabled = "disabled";$anterior_enlace="#";}
			else{$anterior_enlace = "?page=blog&id=".$anterior[0]['id_tema'];}

			$siguiente_disabled="";
			$siguiente = $foro->getTemas(" AND activo=1 AND ocio=1 AND id_tema<".$id_tema." ORDER BY id_tema DESC LIMIT 1");
			if (count($siguiente)!=1){$siguiente_disabled = "disabled";$siguiente_enlace="#";}
			else{$siguiente_enlace='?page=blog&id='.$siguiente[0]['id_tema'];}

			//enlaces de pagina siguiente y anterior
			echo '<hr />
				<ul class="pager">
					<li class="previous '.$anterior_disabled .'"><a href="'.$anterior_enlace.'">&larr; Entrada anterior</a></li>
					<li class="next '.$siguiente_disabled .'"><a href="'.$siguiente_enlace.'">Entrada siguiente &rarr;</a></li>
				</ul>
				<hr />';
		}    


		if (count($tema)>0){	
			//INSERTAR VISITA EN EL FORO
			$foro->insertVisita($_SESSION['user_name'],$id_tema,0);

			if ($module_config['options']['allow_comments']==true){
				//INSERTAR NUEVOS COMENTARIOS EN EL BLOG

				echo '<div class="clearfix"></div><div class="panel-interior">';
				echo '<br /><label>¿Qué piensas de este artículo? déjanos tu comentario</label>';
				addForoComment($id_tema);
				echo '</div>';
				
				echo '<div class="panel-container-foro">';
				$filtro_comentarios.= " ORDER BY date_comentario DESC";
				$comentarios_foro = $foro->getComentarios($filtro_comentarios.' LIMIT '.$inicio.','.$reg); 
				foreach($comentarios_foro as $comentario_foro):
					commentForo($comentario_foro,"blog");
				endforeach;	
				echo '</div><br />';
				
				if ($total_reg==0){ echo '<div class="alert alert-warning">Todavía no se han insertado comentarios en esta entrada.</div>';}
				else {Paginator($pag,$reg,$total_reg,'blog&id='.$id_tema,'comentarios',$find_reg,10,"selected-foro");}
			}

			//ENTRADAS SIMILARES
			echo '<h4>
				<span class="fa-stack fa-lg text-muted">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-bell fa-stack-1x fa-inverse"></i>
				</span>
				También te puede interesar</h4><hr />';
			$filtro_etiquetas = "";
			$etiquetas = explode(",",$tema[0]['tipo_tema']);
			foreach($etiquetas as $etiqueta):
					$filtro_etiquetas .= " OR tipo_tema LIKE '%".$etiqueta."%' ";
			endforeach;
			$filtro_etiquetas = substr($filtro_etiquetas, 3);
			$filtro_etiquetas = " AND (".$filtro_etiquetas.") AND id_tema<>".$tema[0]['id_tema']." ";
			$elements = $foro->getTemas(" AND ocio=1 AND activo=1 ".$filtro_etiquetas." ORDER BY rand() DESC LIMIT 4 "); 
			foreach($elements as $element):
				echo '<div class="col-md-3">
								<a href="?page=blog&id='.$element['id_tema'].'"><img style="width:100%" src="images/foro/'.$element['imagen_tema'].'" title="'.$element['nombre'].'" /></a><br />
						<h5>'.$element['nombre'].'</h5>
					</div>';
			endforeach; 
		}?>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
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
			$elements = $foro->getTemas(" AND ocio=1 AND activo=1 ORDER BY id_tema DESC LIMIT 3 "); 
			entradasBlog($elements);
			?>
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-folder fa-stack-1x fa-inverse"></i>
				</span>
				<?php echo strTranslate("Files");?>
			</h4>
			<?php
			$elements = $foro->getArchivoBlog();
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
			$elements = $foro->getCategorias(" AND ocio=1 ");
			categoriasBlog($elements);

			?>
		</div>
	</div>
</div>