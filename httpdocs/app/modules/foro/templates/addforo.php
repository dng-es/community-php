<?php
/**
* Print HTML add tema foro
* @param  	Int   		$id_tema_parent		id_tema_parent new tema
* @param  	String 		$canal         		tema canal
* @param  	Boolean   	$show_canales  		show canales true/false
* @param  	String   	$descripcion_foro  	tema description
* @param  	Int   		$ocio  				used for news, blog, ...
* @return 	String							HTML panel
*/

templateload("cmbCanales", "users");

function PanelSubirTemaForo($id_tema_parent, $canal, $show_canales = false, $descripcion_foro = "", $ocio = 0, $id_area = 0){

	//INSERTAR TEMA
	$foro = new foro();
	if (isset($_POST['nombre-tema']) && $_POST['nombre-tema'] != ""){
		if ($_SESSION['user_canal'] != 'admin') $canal = $_SESSION['user_canal'];
		else $canal = $_POST['canal_tema'];
		if ($foro->InsertTema($_POST['id_tema_parent'],
							$_POST['nombre-tema'],
							$_POST['texto-descripcion'],
							"",
							$_SESSION['user_name'],
							$canal,0,1, '', $_POST['id_area'],0,"")){
			session::setFlashMessage('actions_message', strTranslate("Forum_created"), "alert alert-success");
		}
		else session::setFlashMessage('actions_message', strTranslate("Error_while_creating_forum"), "alert alert-danger");
		redirectURL($_SERVER['REQUEST_URI']);
	}
	
	$title_add = ($ocio == 1) ? "Nueva noticia" : strTranslate("Create_new_forum");
	$title_add_desc = ($ocio == 1) ? "Puedes insertar una nueva noticia. Para ello introduce su título y descripción." : strTranslate("Create_new_forum_label");
	$title_btn = ($ocio == 1) ? "Crear noticia" : strTranslate("Create_forum");
	$title_name = ($ocio == 1) ? "Título de la noticia:" : strTranslate("Title");
	$title_desc = ($ocio == 1) ? "Descripción de la noticia:" : strTranslate("Description");
	?>
	<script language="JavaScript" src="js/bootstrap-textarea.min.js"></script>
	<script language="JavaScript" src="<?php echo getAsset("foro");?>js/foro-subtemas.js"></script>
	<div id="banner-foros-form">
		<h4>
			<span class="fa-stack fa-sx">
				<i class="fa fa-circle fa-stack-2x"></i>
				<i class="fa fa-share-alt fa-stack-1x fa-inverse"></i>
			</span>
			<?php echo $title_add;?>
		</h4>
		<p><?php echo $title_add_desc;?></p>
		<form id="tema-form" name="tema-form" action="" method="post" enctype="multipart/form-data" role="form">
	<?php if ($show_canales): ?>
			<label for="canal_tema" class="sr-only">Canal del tema:</label>
			<select name="canal_tema" id="canal_tema" class="form-control">
			<?php ComboCanales();?>
			</select>
	<?php else: ?>
			<input type="hidden" name="id_tema_parent" id="id_tema_parent" value="<?php echo $id_tema_parent;?>"/>
			<input type="hidden" name="canal_tema" id="canal_tema" value="<?php echo $canal;?>"/>
			<input type="hidden" name="id_area" id="id_area" value="<?php echo $id_area;?>"/>
	<?php endif;?>	

	<?php if ($ocio==1): ?>
			<label for="imagen_contenido">Imágen (tamaño 730px X 80px):</label>
			<input type="file" id="imagen_contenido" name="imagen_contenido" class="inputFile form-control">
	<?php endif; ?>
			<label for="nombre-tema" class="sr-only"><?php echo $title_name;?></label>
			<input type="text" maxlength="100" id="nombre-tema" name="nombre-tema" class="form-control" placeholder="<?php e_strTranslate('Title');?>" title="<?php e_strTranslate("Required_field");?>">
			<label for="texto-descripcion" class="sr-only"><?php echo $title_desc;?></label>
			<textarea id="texto-descripcion" name="texto-descripcion" class="form-control" placeholder="<?php e_strTranslate('Description');?>" title="<?php e_strTranslate("Required_field");?>" rows="4"></textarea>
			<input type="hidden" value="<?php $ocio;?>" name="ocio" id="ocio" />
			<button type="submit" id="tema-submit" name="tema-submit" class="btn btn-primary btn-block"><?php echo $title_btn;?></button>
		</form>
	</div>
<?php } ?>