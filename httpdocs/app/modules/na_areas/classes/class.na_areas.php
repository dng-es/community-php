<?php
class na_areas{
	/**
	 * Devuelve las areas de trabajo / cursos
	 * @param  string $filter Filtro SQL
	 * @return array         Array con los registros
	 */
	public function getAreas($filter = ""){
		$Sql = "SELECT * 
				FROM na_areas 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertArea($nombre, $descripcion, $canal, $puntos = 0, $limite_users = 0, $estado = 0, $registro = 0){
		$nombre = str_replace("'", "´", $nombre);
		$descripcion = str_replace("'", "´", $descripcion);
		$Sql = "INSERT INTO na_areas (area_nombre,area_descripcion,area_canal,puntos,limite_users,estado, registro) 
				VALUES 
				('".$nombre."','".$descripcion."','".$canal."',".$puntos.",".$limite_users.",".$estado.",".$registro.")";
		return connection::execute_query($Sql);
	}

	public function updateArea($id, $nombre, $descripcion, $canal, $puntos = 0, $limite_users = 0, $registro = 0){
		$Sql = "UPDATE na_areas SET 
				area_nombre='".$nombre."',
				area_descripcion='".$descripcion."', 
				area_canal='".$canal."', 
				puntos=".$puntos.", 
				limite_users=".$limite_users.", 
				registro=".$registro."  
				WHERE id_area=".$id;
		return connection::execute_query($Sql);
	}

	public function estadoArea($id, $estado = 0){
		$Sql = "UPDATE na_areas SET 
				estado=".$estado." 
				WHERE id_area=".$id;
		return connection::execute_query($Sql);
	}

	public function getAreasUsers($filter = ""){
		$Sql = "SELECT nu.*,u.* 
				FROM na_areas_users nu 
				LEFT JOIN users u ON u.username=nu.username_area 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertUserArea($id_area, $user_area){
		$Sql = "INSERT INTO na_areas_users (id_area,username_area) VALUES
		(".$id_area.",'".$user_area."')";
		return connection::execute_query($Sql);
	}

	public function deleteUsersArea($id_area){
		$Sql = "DELETE FROM na_areas_users 
				WHERE id_area=".$id_area." ";
		return connection::execute_query($Sql);
	}

	public function getGruposUsers($filter = ""){
		$Sql = "SELECT * 
				FROM na_areas_grupos 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertGrupoArea($id_area, $nombre){
		$Sql = "INSERT INTO na_areas_grupos (id_area,grupo_nombre) VALUES
		(".$id_area.",'".$nombre."')";
		return connection::execute_query($Sql);
	}

	public function getGruposUsersUsuarios($filter = ""){
		$Sql = "SELECT *  
			  FROM na_areas_grupos_users 
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertGrupoUser($id_grupo, $usuario){
		$Sql = "INSERT INTO na_areas_grupos_users (id_grupo,grupo_username) VALUES
		(".$id_grupo.",'".$usuario."')";
		return connection::execute_query($Sql);
	}

	public function deleteGrupoUser($id_grupo, $usuario){
		$Sql = "DELETE FROM na_areas_grupos_users 
				WHERE id_grupo=".$id_grupo." AND grupo_username='".$usuario."' ";
		return connection::execute_query($Sql);
	}

	public function getTareas($filter = ""){
		$Sql = "SELECT t.*,r.recompensa_name, r.recompensa_image 
				FROM na_tareas t 
				LEFT JOIN recompensas r ON r.id_recompensa=t.id_recompensa 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertTarea($id_area, $titulo, $descripcion, $tipo, $grupo, $usuario, $nombre_archivo, $id_recompensa){
		$Sql = "INSERT INTO na_tareas (id_area,tarea_titulo,tarea_descripcion,tipo,tarea_grupo,user_add,tarea_archivo, id_recompensa) VALUES
		(".$id_area.",'".$titulo."','".$descripcion."','".$tipo."',".$grupo.",'".$usuario."','".$nombre_archivo."',".$id_recompensa.")";
		return connection::execute_query($Sql);
	}

	public function updateTarea($id_tarea, $descripcion){
		$Sql = "UPDATE na_tareas SET 
				tarea_descripcion='".$descripcion."' 
				WHERE id_tarea=".$id_tarea." ";
		return connection::execute_query($Sql);
	}

	public function getGruposTareas($filter = ""){
		$Sql = "SELECT g.grupo_nombre,g.id_area,tg.* 
				FROM na_tareas_grupos tg 
				LEFT JOIN na_areas_grupos g ON g.id_grupo=tg.id_grupo 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertGrupoTarea($id_grupo, $id_tarea){	
		$Sql = "INSERT INTO na_tareas_grupos (id_grupo,id_tarea) VALUES
		(".$id_grupo.",".$id_tarea.")";
		return connection::execute_query($Sql);
	}

	public function deleteGrupoTarea($id_grupo, $id_tarea){
		$Sql = "DELETE FROM na_tareas_grupos 
				WHERE id_grupo=".$id_grupo." AND id_tarea=".$id_tarea." ";
		if (connection::execute_query($Sql)){ 
			$Sql = "INSERT INTO na_tareas_grupos_history (id_tarea,id_grupo,user_history) VALUES(".$id_tarea.",".$id_grupo.",'".$_SESSION['user_name']."')";
			connection::execute_query($Sql);
			return true;
		}
		else return false;
	}

	public function estadoTarea($id_tarea, $estado){
		$Sql = "UPDATE na_tareas SET 
				activa=".$estado." 
				WHERE id_tarea=".$id_tarea;
		return connection::execute_query($Sql);
	}

	public function estadoLinksTarea($id_tarea, $estado){
		$Sql = "UPDATE na_tareas SET 
				activa_links=".$estado." 
				WHERE id_tarea=".$id_tarea;
		return connection::execute_query($Sql);
	}

	public function getTareasDocumentos($filter = ""){
		$Sql = "SELECT * 
				FROM na_tareas_documentos 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertTareaDoc($id_tarea, $tipo, $nombre, $fichero, $enlace){
		if($tipo == 'fichero'){
			//fichero o mp3
			$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
			$nombre_archivo=NormalizeText($nombre_archivo);

			$tipo_archivo = $fichero['type'];
			$tamano_archivo = $fichero['size'];

			move_uploaded_file($fichero['tmp_name'], PATH_TAREAS.$nombre_archivo);
			$enlace=$nombre_archivo;
		}
		if($tipo == 'podcast'){
			//fichero o mp3
			$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
			$nombre_archivo=NormalizeText($nombre_archivo);

			$tipo_archivo = $fichero['type'];
			$tamano_archivo = $fichero['size'];

			move_uploaded_file($fichero['tmp_name'], "docs/audio/".$nombre_archivo);
			$enlace=$nombre_archivo;
		}
		elseif ($tipo == 'video'){
			//video
			$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
			$nombre_archivo = NormalizeText($nombre_archivo);
			$tipo_archivo = $fichero['type'];
			$tamano_archivo = $fichero['size'];

			move_uploaded_file($fichero['tmp_name'], PATH_VIDEOS.$nombre_archivo);
			$videos = new videos();
			if ($videos->convertirVideo($nombre_archivo,PATH_VIDEOS,PATH_VIDEOS)){
				unlink($nombre_archivo);
			}
			$enlace=$nombre_archivo.'.mp4';
		}

		$Sql = "INSERT INTO na_tareas_documentos (id_tarea,documento_tipo,documento_nombre,documento_file) VALUES
		(".$id_tarea.",'".$tipo."','".$nombre."','".$enlace."')";
		if (connection::execute_query($Sql)) return "Documentación agregada correctamente";
		else return "se ha producido algún error al agregar la documentación";
	}

	public function deleteTareaDoc($id){
		$Sql = "DELETE FROM na_tareas_documentos 
				WHERE id_documento=".$id." ";
		return connection::execute_query($Sql);
	}

	public function getUsersTareaGrupos($id_tarea, $usuario){
		$Sql = "SELECT * 
				FROM na_areas_grupos_users 
			  	WHERE id_grupo IN (SELECT id_grupo FROM na_tareas_grupos WHERE id_tarea=".$id_tarea.") 
			  AND grupo_username='".$usuario."' ";
		return connection::getSQL($Sql);
	}

	public function getTareasUser($filter = ""){
		$Sql = "SELECT * 
				FROM na_tareas_users 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertTareaUser($id_area, $id_tarea, $user_tarea, $fichero){
		//SUBIR FICHERO
		if (isset($fichero) && $fichero['name'] != ""){
			$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
			$nombre_archivo = NormalizeText($nombre_archivo);
			move_uploaded_file($fichero['tmp_name'], PATH_TAREAS.$nombre_archivo);
		}
		else $nombre_archivo = "";
		
		$Sql = "INSERT INTO na_tareas_users (id_area,id_tarea,user_tarea,file_tarea) VALUES
		(".$id_area.",".$id_tarea.",'".$user_tarea."','".$nombre_archivo."')";
		return connection::execute_query($Sql);
	}

	public function RevisarTareaUser($id, $usuario){
		$Sql = "UPDATE na_tareas_users SET
				revision=1,
				user_revision='".$usuario."',
				date_revision=NOW() 
				WHERE id_tarea_user=".$id;
		return connection::execute_query($Sql);
	}

	public function getPreguntas($filter = ""){
		$Sql = "SELECT * 
				FROM na_tareas_preguntas 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertPregunta($id_tarea, $pregunta_texto, $pregunta_tipo){
		$Sql = "INSERT INTO na_tareas_preguntas (id_tarea,pregunta_texto,pregunta_tipo) VALUES
		(".$id_tarea.",'".$pregunta_texto."','".$pregunta_tipo."')";
		if (connection::execute_query($Sql)) return "Pregunta insertada correctamente";
		else return "Se ha producido algún error al insertar la pregunta.";
	}

	public function deletePregunta($id){
		$Sql = "DELETE FROM na_tareas_preguntas 
				WHERE id_pregunta=".$id;
		if (connection::execute_query($Sql)){ 
			$Sql = "DELETE FROM na_tareas_respuestas 
					WHERE id_pregunta=".$id;
			connection::execute_query($Sql);
			return "Pregunta eliminada correctamente";}
		else return "Se ha producido algún error al eliminar la pregunta.";
	}

	public function insertPreguntaRespuesta($id_pregunta, $respuesta_texto, $correcta){
		$Sql = "INSERT INTO na_tareas_respuestas (id_pregunta,respuesta_texto,correcta) VALUES
		(".$id_pregunta.",'".$respuesta_texto."',".$correcta.")";
		if (connection::execute_query($Sql)) return "Respuesta insertada correctamente";
		else return "Se ha producido algún error al insertar la respuesta.";
	}

	public function getRespuestas($filter = ""){
		$Sql = "SELECT * 
				FROM na_tareas_respuestas 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getRespuestasUser($filter = ""){
		$Sql = "SELECT * 
				FROM na_tareas_respuestas_user 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getRespuestasUserAdmin($filter = ""){
		$Sql = "SELECT p.pregunta_texto AS Pregunta,r.respuesta_valor AS Respuesta 
				FROM na_tareas_preguntas p 
				LEFT JOIN na_tareas_respuestas_user r ON r.id_pregunta=p.id_pregunta 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertRespuesta($id_pregunta, $respuesta_user, $respuesta_valor){
		//verificar si ya existe una respuesta para hacer insert o update
		if (connection::countReg("na_tareas_respuestas_user", " AND id_pregunta=".$id_pregunta." AND respuesta_user='".$respuesta_user."' ")==0){
			$Sql = "INSERT INTO na_tareas_respuestas_user (id_pregunta,respuesta_user,respuesta_valor) VALUES
			(".$id_pregunta.",'".$respuesta_user."','".$respuesta_valor."')";
		}
		else{
			$Sql = "UPDATE na_tareas_respuestas_user SET 
					respuesta_valor='".$respuesta_valor."' 
					WHERE id_pregunta=".$id_pregunta." AND respuesta_user='".$respuesta_user."' ";
		}
		return connection::execute_query($Sql);
	}

	public function getFormulariosFinalizados($filter = ""){
		$Sql = "SELECT f.*,u.name AS name,u.nick AS nick 
				FROM na_tareas_formularios_finalizados f 
			  	LEFT JOIN users u ON u.username=f.user_tarea
			  	WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public static function getFormulariosFinalizadosUser($username){
		$Sql = "SELECT f.*,t.tarea_titulo, a.area_nombre 
				FROM na_tareas_formularios_finalizados f 
				LEFT JOIN na_tareas t ON t.id_tarea=f.id_tarea 
				LEFT JOIN na_areas a ON a.id_area=t.id_area 
				WHERE f.user_tarea='".$username."'";
		return connection::getSQL($Sql);
	}

	public static function getTareasFinalizadasUser($username){
		$Sql = "SELECT * FROM (
					SELECT id_tarea, user_tarea, date_finalizacion AS fecha_tarea, revision, puntos FROM na_tareas_formularios_finalizados
					WHERE user_tarea='".$username."' 
				UNION
					SELECT id_tarea, user_tarea, fecha_tarea, 0 AS revision, 0 AS puntos FROM na_tareas_users
					WHERE user_tarea='".$username."' GROUP BY id_tarea) AS tareas 
				LEFT JOIN na_tareas t ON t.id_tarea=tareas.id_tarea 
				LEFT JOIN na_areas a ON a.id_area=t.id_area";
		return connection::getSQL($Sql);
	}

	public function getFormulariosFinalizadosRespuestas($id_tarea, $usuario){
		$Sql = "SELECT ur.respuesta_valor 
				FROM na_tareas_respuestas_user ur 
				LEFT JOIN na_tareas_preguntas up ON up.id_pregunta=ur.id_pregunta 
				WHERE id_tarea=".$id_tarea." AND ur.respuesta_user='".$usuario."' 
				ORDER BY ur.id_pregunta ";
		return connection::getSQL($Sql);
	}

	public function insertFormulariosFinalizados($id_tarea, $user_tarea){
		$Sql = "INSERT INTO na_tareas_formularios_finalizados (id_tarea,user_tarea) VALUES
		(".$id_tarea.",'".$user_tarea."')";
		return connection::execute_query($Sql);
	}

	public function RevisarTareaFormUser($usuario, $id_tarea, $puntos, $revisor){
		$Sql = "UPDATE na_tareas_formularios_finalizados SET
				revision=1,
				puntos=".$puntos.",
				user_revision='".$revisor."',
				date_revision=NOW() 
				WHERE id_tarea=".$id_tarea." 
				AND user_tarea='".$usuario."' ";
		return connection::execute_query($Sql);
	}

	public function getUsuarioGrupoTarea($id_tarea, $id_area, $filter = ""){
		$Sql = "SELECT grupo_nombre 
				FROM na_areas_grupos_users u 
				LEFT JOIN na_areas_grupos g ON g.id_grupo=u.id_grupo
				LEFT JOIN na_tareas_grupos tg ON tg.id_grupo=u.id_grupo
				WHERE u.id_grupo IN (SELECT id_grupo FROM na_areas_grupos WHERE id_area=".$id_area.")
				AND g.id_area=".$id_area." AND tg.id_tarea=".$id_tarea.$filter;

		return connection::getSQL($Sql);
	}

	public function getTareasUserExport($id_tarea, $id_area){
		$Sql = "SELECT tu.* ,
					(SELECT g.grupo_nombre FROM na_areas_grupos_users u 
					LEFT JOIN na_areas_grupos g ON g.id_grupo=u.id_grupo
					LEFT JOIN na_tareas_grupos tg ON tg.id_grupo=u.id_grupo
					WHERE u.id_grupo IN (SELECT id_grupo FROM na_areas_grupos WHERE id_area=".$id_area.")
					AND g.id_area=".$id_area." AND tg.id_tarea=".$id_tarea." AND u.grupo_username=tu.user_tarea LIMIT 1) AS nombre_grupo 
				FROM na_tareas_users tu 
				WHERE tu.id_tarea=".$id_tarea;
		return connection::getSQL($Sql);
	}

	public function deleteFinalizacionForm($id_tarea, $user_tarea){
		//insertar historico
		$Sql = "INSERT INTO na_tareas_formularios_finalizados_history (id_tarea,user_tarea,date_finalizacion,revision,puntos,user_revision,date_revision,user_history)
				SELECT id_tarea,user_tarea,date_finalizacion,revision,puntos,user_revision,date_revision,'".$_SESSION['user_name']."' 
				FROM na_tareas_formularios_finalizados 
				WHERE id_tarea=".$id_tarea." AND user_tarea='".$user_tarea."'";
		if (connection::execute_query($Sql)){
			//borrar tarea
			$Sql="DELETE FROM na_tareas_formularios_finalizados 
				  WHERE id_tarea=".$id_tarea." AND user_tarea='".$user_tarea."'";
			connection::execute_query($Sql);
		}
		else return false;
	}
}
?>