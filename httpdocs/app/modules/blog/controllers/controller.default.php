<?php
class blogController{
	public static function getItemAction($id){
		$foro = new foro();
		return $foro->getTemas(" AND id_tema=".$id." ");
	}

	public static function createAction(){
		if (isset($_POST['id']) and $_POST['id']==0){
			$foro = new foro();
			$id = 0;
			if ($foro->InsertTema(0,$_POST['nombre'],stripslashes($_POST['descripcion']),$_FILES['imagen-tema'],$_SESSION['user_name'], $_POST['canal'],0,1,'',0,1,$_POST['etiquetas'])) {
				$id = connection::SelectMaxReg("id_tema","foro_temas"," AND ocio=1 ");		
				session::setFlashMessage( 'actions_message', "Registro insertado correctamente", "alert alert-success");
			}else{
				session::setFlashMessage( 'actions_message', "Error al insertar registro", "alert alert-danger");
			}
			redirectURL("admin-blog-new?id=".$id);		
		}
	
	}

	public static function updateAction(){
		if (isset($_POST['id']) and $_POST['id']>0){
			$foro = new foro();	
			$nombre = sanitizeInput($_POST['nombre']);
			$descripcion = sanitizeInput(stripslashes($_POST['descripcion']));
			if ($foro->updateTema($_POST['id'],$nombre,$descripcion,$_POST['etiquetas'],$_FILES['imagen-tema'])) {
				session::setFlashMessage( 'actions_message', "Registro modificado correctamente", "alert alert-success");
			}	
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar registro", "alert alert-danger");
			}
			redirectURL("admin-blog-new?id=".$_POST['id']);
		}
	}

	public static function get_resume($post){
		$resume_array = self::get_extended($post);
		if (strlen($resume_array['extended'])>0){
			$resume = $resume_array['main'];
		}
		else{
			$resume = strip_tags($post);
			if (strlen($resume)>400) {$resume = substr($resume,0,400)."...";}
		}
		return $resume;
	}

	/**
	 * WordPress - Get extended entry info (<!--more-->).
	 *
	 * There should not be any space after the second dash and before the word
	 * 'more'. There can be text or space(s) after the word 'more', but won't be
	 * referenced.
	 *
	 * The returned array has 'main', 'extended', and 'more_text' keys. Main has the text before
	 * the <code><!--more--></code>. The 'extended' key has the content after the
	 * <code><!--more--></code> comment. The 'more_text' key has the custom "Read More" text.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post Post content.
	 * @return array Post before ('main'), after ('extended'), and custom readmore ('more_text').
	 */
	public static function get_extended($post) {
		//Match the new style more links
		if ( preg_match('/<!--more(.*?)?-->/', $post, $matches) ) {
			list($main, $extended) = explode($matches[0], $post, 2);
			$more_text = $matches[1];
		} else {
			$main = $post;
			$extended = '';
			$more_text = '';
		}

		// ` leading and trailing whitespace
		$main = preg_replace('/^[\s]*(.*)[\s]*$/', '\\1', $main);
		$extended = preg_replace('/^[\s]*(.*)[\s]*$/', '\\1', $extended);
		$more_text = preg_replace('/^[\s]*(.*)[\s]*$/', '\\1', $more_text);

		return array( 'main' => $main, 'extended' => $extended, 'more_text' => $more_text );
	}	

	public static function insertAlerts(){
		$blog = new blog();
		$blog -> insertAlerts();
	}
	
	public static function getAlerts(){
		$blog = new blog();
		$filtro_canal = ($_SESSION['user_perfil'] == 'admin' ? "" : " AND canal='".$_SESSION['user_canal']."' ");
		$noLeidos = connection::countReg("foro_temas"," AND activo=1 AND ocio=1 ".$filtro_canal." AND id_tema NOT IN (SELECT id_tema FROM blog_alerts WHERE username_alert = '".$_SESSION['user_name']."')");
		return $noLeidos;
	}			
}
?>