<?php
class infotopdfController{
	public static function getItem(){
		if (isset($_GET['id'])){
			$info = new infotopdf();
			return $elements=self::getItemAction($_GET['id']);
		}
	}

	public static function getListAction($reg = 0, $filter = ""){
		$info = new infotopdf();
		$filtro = $filter." ORDER BY titulo_info";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = $info->countReg("info i",$filtro); 
		return array('items' => $info->getInfo($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $paginator_items['find_reg'],
					'total_reg' => $total_reg);
	}

	public function getItemAction($id){
		$info = new infotopdf();
		return $info->getInfo(" AND id_info=".$id);
	}	

	public static function createAction(){
		
	}

	public static function updateAction(){

	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') {
			$info = new infotopdf();
			if ($info->deleteInfo($_REQUEST['id'],$_REQUEST['d'])) {
				session::setFlashMessage( 'actions_message', "Registro eliminado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al eliminar el registro.", "alert alert-danger");
			}
			redirectURL("?page=admin-info");
		}
	}

	public function getHTMLtoPDF(){
		if (isset($_POST['id_info']) and $_POST['id_info']>0){
			$info = new infotopdf();
			global $ini_conf;
			$html_content = $info->getInfo(" AND id_info=".$_POST['id_info']);

			$user_direccion = "";
			if (isset($_POST['calle_direccion']) and $_POST['calle_direccion']!=""){ $user_direccion .= $_POST['calle_direccion'];}
			if (isset($_POST['postal_direccion']) and $_POST['postal_direccion']!=""){ $user_direccion .= "<br />".$_POST['postal_direccion'];}
			if (isset($_POST['poblacion_direccion']) and $_POST['poblacion_direccion']!=""){ $user_direccion .= " - ".$_POST['poblacion_direccion'];}
			if (isset($_POST['provincia_direccion']) and $_POST['provincia_direccion']!=""){ $user_direccion .= " - ".$_POST['provincia_direccion'];}
			if (isset($_POST['telefono_direccion']) and $_POST['telefono_direccion']!=""){ $user_direccion .= "<br />Tlf.:  ".$_POST['telefono_direccion'];}
			if (isset($_POST['web_direccion']) and $_POST['web_direccion']!=""){ $user_direccion .= "<br />".$_POST['web_direccion'];}
			if (isset($_POST['email_direccion']) and $_POST['email_direccion']!=""){ $user_direccion .= "<br />".$_POST['email_direccion'];}


			$content = $html_content[0]['cuerpo_info'];
			$content = str_replace($ini_conf['SiteUrl']."/", '', $content);
			$content = str_replace('[USER_DIRECCION]', $user_direccion, $content);
			$content = str_replace('[USER_EMPRESA]', $_SESSION['user_empresa'], $content);
			$content = str_replace('[USER_LOGO]', '<img src="images/usuarios/'.$_SESSION['user_foto'].'" />', $content);


			if (isset($_POST['claim_promocion'])){ $content = str_replace('[CLAIM_PROMOCION]', $_POST['claim_promocion'], $content);}
			if (isset($_POST['descuento_promocion'])){ $content = str_replace('[DESCUENTO_PROMOCION]', $_POST['descuento_promocion'], $content);}
			if (isset($_POST['date_promocion'])){ $content = str_replace('[DATE_PROMOCION]', $_POST['date_promocion'], $content);}

			HTMLtoPDF($content, $html_content[0]['tipo']);
		}
	    
	}	

	public static function adminMenu(){
		return array( array("LabelHeader" => 'Modules',
							"LabelSection" => "Documentación PDF",
							"LabelItem" => "Nuevo documento",
							"LabelUrl" => 'admin-infotopdf-doc&act=new',
							"LabelPos" => 1),
					  array("LabelHeader"=>'Modules',
							"LabelSection"=> "Documentación PDF",
							"LabelItem"=> "Listado de documentos",
							"LabelUrl"=>'admin-infotopdf',
							"LabelPos" => 2));	
	}	
}
?>