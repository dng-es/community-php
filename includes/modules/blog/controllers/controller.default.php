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
			if ($foro->InsertTema(0,$_POST['nombre'],stripslashes($_POST['descripcion']),$_FILES['imagen-tema'],$_SESSION['user_name'],CANAL1,0,1,'',0,1,$_POST['etiquetas'])) {
				$id = connection::SelectMaxReg("id_tema","foro_temas"," AND ocio=1 ");		
				session::setFlashMessage( 'actions_message', "Registro insertado correctamente", "alert alert-success");
			}else{
				session::setFlashMessage( 'actions_message', "Error al insertar registro", "alert alert-danger");
			}
			redirectURL("?page=admin-blog-new&id=".$id);		
		}
	
	}

	public static function updateAction(){
		if (isset($_POST['id']) and $_POST['id']>0){
			$foro = new foro();
			if ($foro->updateTema($_POST['id'],$_POST['nombre'],stripslashes($_POST['descripcion']),$_POST['etiquetas'],$_FILES['imagen-tema'])) {
				session::setFlashMessage( 'actions_message', "Registro modificado correctamente", "alert alert-success");
			}	
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar registro", "alert alert-danger");
			}
			redirectURL("?page=admin-blog-new&id=".$_POST['id']);
		}
	}			
}
?>