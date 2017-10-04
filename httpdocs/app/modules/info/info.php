<?php
/**
* @Libreria de archivos descargables para el usuario. Depende del modulo campaigns
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.3.1
*
*/	
class infoCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("user-info-all", $_SESSION['user_name']));

		$module_config = getModuleConfig("info");
		$alerts_text = "";
		if ($module_config['options']['show_alarms']):
			$num_alerts = infoController::getAlerts();
			$alerts_text = ($num_alerts > 0 ? ' <span class="menu-alert" title="'.strTranslate("Notifications_content_new").'" id="contador-documentos-header">'.$num_alerts.'</span>' : "");
		endif;

		if ($session->checkPageViewPermission("user-info-all", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array(
				"LabelIcon" => "fa fa-file",
				"LabelItem" => strTranslate("Info_Documents").$alerts_text,
				"LabelUrl" => 'info-all',
				"LabelTarget" => '_self',
				"LabelPos" => $menu_order));
		}

		return $array_final;
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function adminMenu(){
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-info-doc",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Info_Documents"),
			"LabelItem" => strTranslate("Info_Documents_new"),
			"LabelUrl" => "admin-info-doc?act=new",
			"LabelPos" => 1,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-info",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Info_Documents"),
			"LabelItem" => strTranslate("Info_Documents_list"),
			"LabelUrl" => "admin-info",
			"LabelPos" => 2,
		)));

		return $elems;
	}

	public static function searchMain($string){
		$result = array();
		$info = new info();
		$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_info LIKE '%".$_SESSION['user_canal']."%' " : "");
		//buscar en documentos
		$request = $info->getInfo($filtro_canal." AND (MATCH(titulo_info) AGAINST ('".$string."'))");
		foreach ($request as $req):
			array_push($result, array(
				"title"=>$req['titulo_info'], 
				"description"=>$req['campana'], 
				"url"=>"info-all",
				"type" => strTranslate("Info_Documents"),
				"order" => 7
			));
		endforeach;	

		//buscar en campañas
		$campaigns = new campaigns();
		$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_campaign LIKE '%".$_SESSION['user_canal']."%' " : "");
		$request = $campaigns->getCampaigns($filtro_canal." AND (MATCH(name_campaign) AGAINST ('".$string."') OR MATCH(desc_campaign) AGAINST ('".$string."'))");
		foreach ($request as $req):
			array_push($result, array(
				"title"=>$req['name_campaign'], 
				"description"=>$req['desc_campaign'], 
				"url"=>"info-all",
				"type" => strTranslate("Info_Documents"),
				"order" => 7
			));
		endforeach;	

		if (strtolower($string) == strtolower(strTranslate("Info_Documents"))){
			array_push($result, array(
				"title"=>'<i class="fa fa-list"></i> '.strTranslate("Info_Documents"), 
				"description"=>strTranslate("Info_Documents_Text"), 
				"url"=>"info-all",
				"type" => strTranslate("Info_Documents"),
				"order" => 6
			));
		}

		return $result;
	}
}
?>