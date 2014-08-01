<?php
class na_areasController{

	public static function RevisarFormAction(){
		$na_areas = new na_areas();
		$user_tarea=$_POST['user_rev'];
		$tarea_user = $_POST['id_tarea_rev'];
		$id_area = $_POST['id_area_rev'];
		$puntos = $_POST['puntos_rev'];
		if ($na_areas->RevisarTareaFormUser($user_tarea,$tarea_user,$puntos,$_SESSION['user_name'])){
			//sumar horas de vuelo si la puntuacion es mayor o igual que 7
			if ($puntos>=7){
				//obtener datos del area
				$area = $na_areas->getAreas(" AND id_area=".$id_area." ");
				$users = new users();
				$horas_vuelo = (count($area)>0 ? $area[0]['puntos']: 0 );
				$users->sumarHorasVuelo($user_tarea,$horas_vuelo,"Superación curso ID: ".$id_area);
			}
		}
		redirectURL($_SERVER['REQUEST_URI']);		
	}

	public static function FinalizacionDeleteAction(){
		$na_areas = new na_areas();
		$elements=$na_areas->deleteFinalizacionForm($_REQUEST['id'],$_REQUEST['ut']);
		redirectURL("?page=admin-area-revs&a=".$_REQUEST['a']."&id=".$_REQUEST['id']);	
	}

	public static function ExportFormUserAction(){
		$na_areas = new na_areas();
		$elements=$na_areas->getRespuestasUserAdmin(" AND p.id_tarea=".$_REQUEST['id']." and r.respuesta_user='".$_REQUEST['t']."' ");
		exportCsv($elements);
	}

	public static function ExportFormAllAction(){
		$na_areas = new na_areas();
		$elements=$na_areas->getFormulariosFinalizados(" AND id_tarea=".$_REQUEST['id']." ORDER BY user_tarea"); 
		$file_name='exported_file'.date("YmdGis");

		$final = array();
		foreach($elements as $element):
			//nombre del grupo
			$nombre_grupo='';
			if (count($grupos=$na_areas->getUsuarioGrupoTarea($_REQUEST['id'],$_REQUEST['a']," AND grupo_username='".$element['user_tarea']."' "))>0){
				 $nombre_grupo=$grupos[0]['grupo_nombre'];
			}	
			$element['nombre_grupo']=$nombre_grupo;

			//respuestas del usuario
			$respuestas = $na_areas -> getFormulariosFinalizadosRespuestas($element['id_tarea'],$element['user_tarea']);
			$i=1;
			foreach($respuestas as $respuesta):
				$pregunta_texto="pregunta".$i;
				$element[$pregunta_texto]=$respuesta['respuesta_valor'];
				$i++;
			endforeach;    
			array_push($final, $element);
		endforeach;
		exportCsv($final);
	}	

	public static function SaveFormAction(){
	    $na_areas = new na_areas();
	    $id_tarea = $_POST['id_tarea'];
	    $preguntas=$na_areas->getPreguntas(" AND id_tarea=".$id_tarea." ");
	    foreach($preguntas as $pregunta):

	      if($pregunta['pregunta_tipo']=='texto'){
	        $respuesta_valor=$_POST["respuesta_".$pregunta['id_pregunta']];
	      }
	      elseif($pregunta['pregunta_tipo']=='unica'){
	        $respuesta_valor="";
	        $respuesta_valor=$_POST["respuesta_".$pregunta['id_pregunta']];
	      }
	      elseif($pregunta['pregunta_tipo']=='multiple'){
	        $respuesta_valor="";
	        $respuestas_usuario=$na_areas->getRespuestas(" AND id_pregunta=".$pregunta['id_pregunta']." ");
	        foreach($respuestas_usuario as $respuesta_usuario):
	          $campo="respuesta_".$pregunta['id_pregunta']."_".$respuesta_usuario['id_respuesta'];  
	          if (isset($_POST[$campo]) and $_POST[$campo]!=''){$respuesta_valor.=$_POST[$campo]."|";}
	        endforeach;
	        $respuesta_valor=substr($respuesta_valor, 0,(strlen($respuesta_valor)-1));
	      }
	      
	      $respuesta_valor = str_replace("'", "´", $respuesta_valor);
	      $na_areas->insertRespuesta($pregunta['id_pregunta'],$_SESSION['user_name'],$respuesta_valor);
	    endforeach; 
	    session::setFlashMessage( 'actions_message', "Respuestas enviadas.", "alert alert-success");
	    redirectURL($_SERVER['REQUEST_URI']);
	}	

	public static function FinalizarFormAction($id_tarea){
		$na_areas = new na_areas();
		if($na_areas->insertFormulariosFinalizados($id_tarea,$_SESSION['user_name'])){
			session::setFlashMessage( 'actions_message', "Tarea finalizada correctamente. Próximamente podrás consultar la nota de tu evaluación.", "alert alert-success");
		} 
		else{ session::setFlashMessage( 'actions_message', "Se ha producido algún error al finalizar la tarea.", "alert alert-danger");}    
		redirectURL("?page=areas_form&id=".$id_tarea);
	}

	public static function adminMenu(){
		return array( array("LabelHeader" => 'Modules',
							"LabelSection" => strTranslate("Na_areas"),
							"LabelItem" => strTranslate("Na_areas_list"),
							"LabelUrl" => 'admin-areas',
							"LabelPos" => 2),
					  array("LabelHeader"=>'Modules',
							"LabelSection"=> strTranslate("Na_areas"),
							"LabelItem"=> strTranslate("Na_areas_new"),
							"LabelUrl"=>'admin-area&act=new',
							"LabelPos" => 1));	
	}

}
?>