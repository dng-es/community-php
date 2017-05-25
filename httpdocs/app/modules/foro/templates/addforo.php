<?php
/**
* Print HTML add tema foro
* @param  	Boolean   	$show_canales  		show canales true/false
* @param  	String   	$descripcion_foro  	tema description
* @param  	Int   		$ocio  				used for news, blog, ...
* @return 	String							HTML panel
*/

templateload("cmbCanales", "users");

function PanelSubirTemaForo($show_canales = false, $descripcion_foro = "", $ocio = 0, $id_area = 0){

	//INSERTAR TEMA
	$foro = new foro();
	if (isset($_POST['nombre-tema']) && $_POST['nombre-tema'] != ""){
		if (isset($_POST['canal_tema'])){
			$canal = sanitizeInput($_POST['canal_tema']);
			if (is_array($canal)) $canal = implode(",", $canal);
			$tema_admin = 1;
		}
		else{
			$canal = $_SESSION['user_canal'];
			$tema_admin = 0;
		}
		$id_tema_parent = (isset($_POST['id_tema_parent']) ? $_POST['id_tema_parent'] : 0);
		if ($foro->InsertTema($id_tema_parent,
							$_POST['nombre-tema'],
							$_POST['texto-descripcion'],
							"",
							$_SESSION['user_name'],
							$canal,0,1, '', $_POST['id_area'],0,"", $tema_admin)){
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
			<input type="hidden" name="id_area" id="id_area" value="<?php echo $id_area;?>"/>
	<?php if ($ocio==1): ?>
			<label for="imagen_contenido">Imágen (tamaño 730px X 80px):</label>
			<input type="file" id="imagen_contenido" name="imagen_contenido" class="inputFile form-control">
	<?php endif; ?>
			<label for="nombre-tema" class="sr-only"><?php echo $title_name;?></label>
			<input type="text" maxlength="100" id="nombre-tema" name="nombre-tema" class="form-control" placeholder="<?php e_strTranslate('Title');?>" title="<?php e_strTranslate("Required_field");?>">
			<label for="texto-descripcion" class="sr-only"><?php echo $title_desc;?></label>
			<textarea id="texto-descripcion" name="texto-descripcion" class="form-control" placeholder="<?php e_strTranslate('Description');?>" title="<?php e_strTranslate("Required_field");?>" rows="4"></textarea>
			<input type="hidden" value="<?php $ocio;?>" name="ocio" id="ocio" />
			<?php if ($show_canales): ?>
			<label for="canal_tema" class="sr-only">Canal del tema:</label>
			<select name="canal_tema[]" id="canal_tema" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" multiple data-actions-box="true" data-none-selected-text="<?php e_strTranslate("Choose_channel");?>" data-deselect-all-text="<?php e_strTranslate('deselect_all');?>"  data-select-all-text="<?php e_strTranslate('select_all');?>">
				<?php ComboCanales();?>
			</select>
			<?php endif;?>			
			<button type="submit" id="tema-submit" name="tema-submit" class="btn btn-primary btn-block"><?php echo $title_btn;?></button>
		</form>
	</div>
<?php } ?>